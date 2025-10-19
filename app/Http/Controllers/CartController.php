<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use App\Models\Cart;
use App\Models\Product;
use App\Models\CartItem;
use Illuminate\Support\Facades\Auth;

class CartController extends Controller
{
    // Remove the constructor - middleware is already applied in routes
    
    public function index()
    {
        $cart = Cart::with(['cartItems.product.images'])
            ->firstOrCreate(['user_id' => Auth::id()]);
            
        $total = $cart->cartItems->sum(function($item) {
            return $item->quantity * $item->product->price;
        });
        
        return view('pages.cart.index', compact('cart', 'total'));
    }
    
    public function add(Request $request)
    {
        $request->validate([
            'product_id' => 'required|exists:products,id',
            'quantity' => 'required|integer|min:1',
        ]);
        
        $product = Product::findOrFail($request->product_id);
        
        // Check if product has enough stock
        if ($product->stock < $request->quantity) {
            return back()->with('error', 'Not enough stock available.');
        }
        
        // Get or create cart for authenticated user
        $cart = Cart::firstOrCreate(['user_id' => Auth::id()]);
        
        // Check if product already in cart
        $cartItem = CartItem::where('cart_id', $cart->id)
            ->where('product_id', $product->id)
            ->first();
            
        if ($cartItem) {
            // Update quantity if item exists
            $newQuantity = $cartItem->quantity + $request->quantity;
            
            // Check stock again for new quantity
            if ($product->stock < $newQuantity) {
                return back()->with('error', 'Not enough stock available.');
            }
            
            $cartItem->update(['quantity' => $newQuantity]);
        } else {
            // Create new cart item
            CartItem::create([
                'cart_id' => $cart->id,
                'product_id' => $product->id,
                'quantity' => $request->quantity,
            ]);
        }
        
        return redirect()->route('pages.cart.index')->with('success', 'Product added to cart!');
    }
    
    public function update(Request $request, CartItem $cartItem)
    {
        // Ensure cart item belongs to current user
        if ($cartItem->cart->user_id !== Auth::id()) {
            abort(403);
        }
        
        $request->validate([
            'quantity' => 'required|integer|min:1',
        ]);
        
        // Check stock availability
        if ($cartItem->product->stock < $request->quantity) {
            return back()->with('error', 'Not enough stock available.');
        }
        
        $cartItem->update(['quantity' => $request->quantity]);
        
        return back()->with('success', 'Cart updated successfully!');
    }
    
    public function remove(CartItem $cartItem)
    {
        // Ensure cart item belongs to current user
        if ($cartItem->cart->user_id !== Auth::id()) {
            abort(403);
        }
        
        $cartItem->delete();
        
        return back()->with('success', 'Item removed from cart!');
    }
    
    public function clear()
    {
        $cart = Cart::where('user_id', Auth::id())->first();
        
        if ($cart) {
            $cart->cartItems()->delete();
        }
        
        return back()->with('success', 'Cart cleared successfully!');
    }
}