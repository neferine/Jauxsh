<?php

namespace App\Http\Controllers;

use App\Models\Cart;
use App\Models\Order;
use App\Models\OrderItem;
use App\Models\ShippingAddress;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\DB;

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

        $shippingAddresses = ShippingAddress::where('user_id', $user->id)->get();
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
            'phone_number' => 'required|string|max:20',
        ]);

        ShippingAddress::create([
            'user_id' => Auth::id(),
            ...$validated
        ]);

        return redirect()->route('checkout')->with('success', 'Address added successfully');
    }

    // Process checkout
    public function process(Request $request)
    {
        $validated = $request->validate([
            'shipping_address_id' => 'required|exists:shipping_addresses,id',
            'payment_method' => 'required|in:credit_card,debit_card,paypal,bank_transfer',
        ]);

        $user = Auth::user();
        $cart = Cart::where('user_id', $user->id)->with('cartItems.product')->first();

        if (!$cart || $cart->cartItems->isEmpty()) {
            return redirect()->route('cart.index')->with('error', 'Your cart is empty');
        }

        // Verify shipping address belongs to user
        $shippingAddress = ShippingAddress::where('id', $validated['shipping_address_id'])
            ->where('user_id', $user->id)
            ->first();

        if (!$shippingAddress) {
            return redirect()->back()->with('error', 'Invalid shipping address');
        }

        try {
            DB::beginTransaction();

            // Calculate total
            $totalAmount = $cart->cartItems->sum(function($item) {
                return $item->product->price * $item->quantity;
            });

            // Create order
            $order = Order::create([
                'user_id' => $user->id,
                'order_date' => now(),
                'status' => 'pending',
                'total_amount' => $totalAmount,
            ]);

            // Create order items
            foreach ($cart->cartItems as $item) {
                OrderItem::create([
                    'order_id' => $order->id,
                    'product_id' => $item->product_id,
                    'quantity' => $item->quantity,
                    'price' => $item->product->price,
                ]);

                // Reduce stock
                $item->product->decrement('stock', $item->quantity);
            }

            // Clear cart
            $cart->cartItems()->delete();

            DB::commit();

            return redirect()->route('order.confirmation', $order->id)
                ->with('success', 'Order placed successfully!');

        } catch (\Exception $e) {
            DB::rollBack();
            return redirect()->back()->with('error', 'An error occurred during checkout');
        }
    }

    // Show order confirmation
    public function confirmation($orderId)
    {
        $order = Order::with('items.product', 'user')->findOrFail($orderId);

        if ($order->user_id !== Auth::id()) {
            abort(403);
        }

        return view('order.confirmation', ['order' => $order]);
    }
}