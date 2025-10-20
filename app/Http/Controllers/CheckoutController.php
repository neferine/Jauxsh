<?php

namespace App\Http\Controllers;

use App\Models\Cart;
use App\Models\Order;
use App\Models\OrderItem;
use App\Models\ShippingAddress;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\DB;
use Illuminate\Support\Facades\Log;

class CheckoutController extends Controller
{
    // Show checkout page
    public function show()
    {
        $user = Auth::user();
        $cart = Cart::where('user_id', $user->id)->with('cartItems.product')->first();
        
        if (!$cart || $cart->cartItems->isEmpty()) {
            return redirect()->route('cart.index')->with('error', 'Your cart is empty');
        }

        // Verify all products are still available and in stock
        foreach ($cart->cartItems as $item) {
            if (!$item->product) {
                $item->delete();
                return redirect()->route('cart.index')->with('error', 'Some products in your cart are no longer available');
            }
            
            if ($item->product->stock < $item->quantity) {
                return redirect()->route('cart.index')->with('error', "Insufficient stock for {$item->product->name}. Only {$item->product->stock} available.");
            }
        }

        $shippingAddresses = ShippingAddress::where('user_id', $user->id)->get();
        
        // Calculate total on server-side (never trust client)
        $cartTotal = $cart->cartItems->sum(function($item) {
            return $item->product->price * $item->quantity;
        });

        return view('checkout.index', [
            'cart' => $cart,
            'shippingAddresses' => $shippingAddresses,
            'cartTotal' => $cartTotal
        ]);
    }

    // Store new shipping address
    public function storeAddress(Request $request)
    {
        $validated = $request->validate([
            'address_line1' => 'required|string|max:255',
            'address_line2' => 'nullable|string|max:255',
            'city' => 'required|string|max:255',
            'postal_code' => 'required|string|max:20',
            'country' => 'required|string|max:255',
            'phone_number' => 'required|string|max:20|regex:/^[\d\s\+\-\(\)]+$/', // Phone validation
        ]);

        // Limit number of addresses per user (prevent abuse)
        $addressCount = ShippingAddress::where('user_id', Auth::id())->count();
        if ($addressCount >= 5) {
            return redirect()->back()->with('error', 'Maximum 5 addresses allowed per account');
        }

        ShippingAddress::create([
            'user_id' => Auth::id(),
            ...$validated
        ]);

        return redirect()->route('checkout')->with('success', 'Address added successfully');
    }

    // Process checkout
    public function process(Request $request)
    {
        $user = Auth::user();
        
        // Check if user is using existing address or creating new one
        $hasExistingAddresses = ShippingAddress::where('user_id', $user->id)->exists();
        
        if ($hasExistingAddresses) {
            // Validate existing address selection
            $validated = $request->validate([
                'shipping_address_id' => 'required|exists:shipping_addresses,id',
                'payment_method' => 'required|in:credit_card,debit_card,paypal,bank_transfer,cod',
            ]);
            
            $shippingAddressId = $validated['shipping_address_id'];
        } else {
            // Validate and create new address
            $validated = $request->validate([
                'address_line1' => 'required|string|max:255',
                'address_line2' => 'nullable|string|max:255',
                'city' => 'required|string|max:255',
                'postal_code' => 'required|string|max:20',
                'country' => 'required|string|max:255',
                'phone_number' => 'required|string|max:20|regex:/^[\d\s\+\-\(\)]+$/',
                'payment_method' => 'required|in:credit_card,debit_card,paypal,bank_transfer,cod',
            ]);
            
            // Create new shipping address
            $newAddress = ShippingAddress::create([
                'user_id' => $user->id,
                'address_line1' => $validated['address_line1'],
                'address_line2' => $validated['address_line2'] ?? null,
                'city' => $validated['city'],
                'postal_code' => $validated['postal_code'],
                'country' => $validated['country'],
                'phone_number' => $validated['phone_number'],
            ]);
            
            $shippingAddressId = $newAddress->id;
        }

        $cart = Cart::where('user_id', $user->id)
            ->with('cartItems.product')
            ->lockForUpdate() // Lock cart to prevent race conditions
            ->first();

        if (!$cart || $cart->cartItems->isEmpty()) {
            return redirect()->route('cart.index')->with('error', 'Your cart is empty');
        }

        // Verify shipping address belongs to user (SECURITY: Prevent address hijacking)
        $shippingAddress = ShippingAddress::where('id', $shippingAddressId)
            ->where('user_id', $user->id)
            ->first();

        if (!$shippingAddress) {
            Log::warning('Unauthorized shipping address access attempt', [
                'user_id' => $user->id,
                'address_id' => $shippingAddressId
            ]);
            return redirect()->back()->with('error', 'Invalid shipping address');
        }

        try {
            DB::beginTransaction();

            // SECURITY: Verify stock availability AGAIN (prevent overselling)
            foreach ($cart->cartItems as $item) {
                if (!$item->product) {
                    throw new \Exception("Product no longer available");
                }
                
                if ($item->product->stock < $item->quantity) {
                    throw new \Exception("Insufficient stock for {$item->product->name}. Only {$item->product->stock} available.");
                }
            }

            // SECURITY: Calculate total on server-side (never trust client-side calculations)
            $calculatedTotal = 0;
            foreach ($cart->cartItems as $item) {
                $itemTotal = $item->product->price * $item->quantity;
                $calculatedTotal += $itemTotal;
            }

            // Optional: Add minimum order amount validation
            if ($calculatedTotal < 0.01) {
                throw new \Exception("Invalid order amount");
            }

            // Optional: Add maximum order amount (prevent fraud)
            if ($calculatedTotal > 1000000) {
                Log::warning('Suspicious large order attempt', [
                    'user_id' => $user->id,
                    'amount' => $calculatedTotal
                ]);
                throw new \Exception("Order amount exceeds maximum limit. Please contact support.");
            }

            // Create order with server-calculated total
            $order = Order::create([
                'user_id' => $user->id,
                'order_date' => now(),
                'status' => 'pending',
                'total_amount' => $calculatedTotal, // Use server calculation
            ]);

            // Create order items and update stock
            foreach ($cart->cartItems as $item) {
                // Lock product row for update to prevent race conditions
                $product = $item->product->lockForUpdate()->find($item->product->id);
                
                // Double-check stock again
                if ($product->stock < $item->quantity) {
                    throw new \Exception("Insufficient stock for {$product->name}");
                }

                OrderItem::create([
                    'order_id' => $order->id,
                    'product_id' => $item->product_id,
                    'quantity' => $item->quantity,
                    'price' => $product->price, // Use current product price
                ]);

                // Reduce stock
                $product->decrement('stock', $item->quantity);
            }

            // Clear cart
            $cart->cartItems()->delete();

            DB::commit();

            // Log successful order
            Log::info('Order created successfully', [
                'order_id' => $order->id,
                'user_id' => $user->id,
                'total' => $calculatedTotal
            ]);

            return redirect()->route('order.confirmation', $order->id)
                ->with('success', 'Order placed successfully!');

        } catch (\Exception $e) {
            DB::rollBack();
            
            // Log the error
            Log::error('Checkout error', [
                'user_id' => $user->id,
                'error' => $e->getMessage(),
                'trace' => $e->getTraceAsString()
            ]);

            return redirect()->back()->with('error', $e->getMessage());
        }
    }

    // Show order confirmation
    public function confirmation($orderId)
    {
        $order = Order::with('items.product', 'user')->findOrFail($orderId);

        // SECURITY: Verify order belongs to authenticated user
        if ($order->user_id !== Auth::id()) {
            Log::warning('Unauthorized order access attempt', [
                'user_id' => Auth::id(),
                'order_id' => $orderId,
                'order_owner' => $order->user_id
            ]);
            abort(403, 'Unauthorized access to order');
        }

        return view('order.confirmation', ['order' => $order]);
    }
}