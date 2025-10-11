<?php

namespace App\Http\Controllers;

use App\Models\Cart;
use App\Models\CartItem;
use App\Models\Product;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;

class CartController extends Controller
{
    public function __construct()
    {
        $this->middleware('auth');
    }
    
    public function index()
    {
        $cart = Cart::with(['cartItems.product.images'])
            ->firstOrCreate(['user_id' => Auth::id()]);
            
        $total = $cart->cartItems->sum(function($item) {
            return $item->quantity * $item->product->price;
        });
        
        return view('pages.cart', compact('cart', 'total'));
    }
    
    public function add(Request $request)
    {
        $validated = $request->validate([
            'product_id' => ['required', 'exists:products,id'],
            'quantity' => ['required', 'integer', 'min:1'],
        ]);
        
        $product = Product::findOrFail($validated['product_id']);
        
        if ($product->stock < $validated['quantity']) {
            return back()->with('error', 'Not enough stock available.');
        }
        
        // Get or create cart for user
        $cart = Cart::firstOrCreate(['user_id' => Auth::id()]);
        
        // Check if product already in cart
        $cartItem = CartItem::where('cart_id', $cart->id)
            ->where('product_id', $product->id)
            ->first();
            
        if ($cartItem) {
            $newQuantity = $cartItem->quantity + $validated['quantity'];
            
            if ($product->stock < $newQuantity) {
                return back()->with('error', 'Not enough stock available.');
            }
            
            $cartItem->update(['quantity' => $newQuantity]);
        } else {
            CartItem::create([
                'cart_id' => $cart->id,
                'product_id' => $product->id,
                'quantity' => $validated['quantity'],
            ]);
        }
        
        return back()->with('success', 'Product added to cart!');
    }
    
    public function update(Request $request, $cartItemId)
    {
        $validated = $request->validate([
            'quantity' => ['required', 'integer', 'min:0'],
        ]);
        
        $cartItem = CartItem::findOrFail($cartItemId);
        
        // Verify cart belongs to authenticated user
        if ($cartItem->cart->user_id !== Auth::id()) {
            abort(403);
        }
        
        if ($validated['quantity'] == 0) {
            $cartItem->delete();
            return back()->with('success', 'Item removed from cart!');
        }
        
        // Check stock
        if ($cartItem->product->stock < $validated['quantity']) {
            return back()->with('error', 'Not enough stock available.');
        }
        
        $cartItem->update(['quantity' => $validated['quantity']]);
        
        return back()->with('success', 'Cart updated!');
    }
    
    public function remove($cartItemId)
    {
        $cartItem = CartItem::findOrFail($cartItemId);
        
        // Verify cart belongs to authenticated user
        if ($cartItem->cart->user_id !== Auth::id()) {
            abort(403);
        }
        
        $cartItem->delete();
        
        return back()->with('success', 'Product removed from cart!');
    }
    
    public function clear()
    {
        $cart = Cart::where('user_id', Auth::id())->first();
        
        if ($cart) {
            $cart->cartItems()->delete();
        }
        
        return back()->with('success', 'Cart cleared!');
    }
}