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
    public function __construct()
    {
        $this->middleware('auth');
    }
    
    public function index()
    {
        $cart = Cart::with(['cartItems.product.images'])
            ->where('user_id', Auth::id())
            ->first();
            
        if (!$cart || $cart->cartItems->isEmpty()) {
            return redirect()->route('products.index')->with('error', 'Your cart is empty.');
        }
        
        // Validate stock for all items
        foreach ($cart->cartItems as $item) {
            if ($item->product->stock < $item->quantity) {
                return redirect()->route('cart.index')
                    ->with('error', "Not enough stock for {$item->product->name}");
            }
        }
        
        $total = $cart->cartItems->sum(function($item) {
            return $item->quantity * $item->product->price;
        });
        
        $shippingAddresses = ShippingAddress::where('user_id', Auth::id())->get();
        
        return view('pages.checkout', compact('cart', 'total', 'shippingAddresses'));
    }
    
    public function store(Request $request)
    {
        $validated = $request->validate([
            'shipping_address_id' => ['nullable', 'exists:shipping_addresses,id'],
            'address_line1' => ['required_without:shipping_address_id', 'string', 'max:255'],
            'address_line2' => ['nullable', 'string', 'max:255'],
            'city' => ['required_without:shipping_address_id', 'string', 'max:100'],
            'postal_code' => ['required_without:shipping_address_id', 'string', 'max:20'],
            'country' => ['required_without:shipping_address_id', 'string', 'max:100'],
            'phone_number' => ['required_without:shipping_address_id', 'string', 'max:20'],
            'save_address' => ['boolean'],
        ]);
        
        $cart = Cart::with('cartItems.product')
            ->where('user_id', Auth::id())
            ->first();
            
        if (!$cart || $cart->cartItems->isEmpty()) {
            return redirect()->route('products.index')->with('error', 'Your cart is empty.');
        }
        
        DB::beginTransaction();
        
        try {
            // Save shipping address if requested
            if ($request->boolean('save_address') && !$request->has('shipping_address_id')) {
                ShippingAddress::create([
                    'user_id' => Auth::id(),
                    'address_line1' => $validated['address_line1'],
                    'address_line2' => $validated['address_line2'] ?? null,
                    'city' => $validated['city'],
                    'postal_code' => $validated['postal_code'],
                    'country' => $validated['country'],
                    'phone_number' => $validated['phone_number'],
                ]);
            }
            
            $total = 0;
            
            // Validate stock and calculate total
            foreach ($cart->cartItems as $item) {
                $product = $item->product->lockForUpdate()->find($item->product->id);
                
                if ($product->stock < $item->quantity) {
                    throw new \Exception("Not enough stock for {$product->name}");
                }
                
                $total += $item->quantity * $product->price;
            }
            
            // Create order
            $order = Order::create([
                'user_id' => Auth::id(),
                'order_date' => now(),
                'status' => 'pending',
                'total_amount' => $total,
            ]);
            
            // Create order items and update stock
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
            
            return redirect()->route('orders.show', $order->id)
                ->with('success', 'Order placed successfully!');
            
        } catch (\Exception $e) {
            DB::rollBack();
            return back()->with('error', $e->getMessage());
        }
    }
}