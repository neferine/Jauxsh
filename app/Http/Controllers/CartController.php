<?php

namespace App\Http\Controllers;

use App\Models\Cart;
use App\Models\CartItem;
use App\Models\Product;
use App\Models\ProductVariant;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;

class CartController extends Controller
{
    public function index()
    {
        $cart = $this->getOrCreateCart();
        $cartItems = $cart->cartItems()
                        ->with(['product.images', 'variant'])
                        ->get();

        // Compute subtotal (per item * quantity)
        $total = $cartItems->sum(function ($item) {
            $price = $item->variant ? $item->variant->price : $item->product->price;
            return $price * $item->quantity;
        });

        return view('pages.cart.index', compact('cart', 'cartItems', 'total'));
    }

    public function add(Request $request)
    {
        $validated = $request->validate([
            'product_id' => 'required|exists:products,id',
            'product_variant_id' => 'nullable|exists:product_variants,id',
            'quantity' => 'required|integer|min:1',
        ]);

        $product = Product::findOrFail($validated['product_id']);
        
        // If variant is specified, validate it belongs to the product
        if (isset($validated['product_variant_id'])) {
            $variant = ProductVariant::where('id', $validated['product_variant_id'])
                                    ->where('product_id', $product->id)
                                    ->firstOrFail();
            
            // Check variant stock
            if ($variant->stock < $validated['quantity']) {
                return back()->with('error', 'Insufficient stock for this variant.');
            }
        } else {
            // Check base product stock (no variants)
            if ($product->stock < $validated['quantity']) {
                return back()->with('error', 'Insufficient stock.');
            }
        }

        $cart = $this->getOrCreateCart();

        // Check if item already exists in cart
        $cartItem = $cart->cartItems()
                        ->where('product_id', $validated['product_id'])
                        ->where('product_variant_id', $validated['product_variant_id'] ?? null)
                        ->first();

        if ($cartItem) {
            // Update quantity
            $newQuantity = $cartItem->quantity + $validated['quantity'];
            
            // Validate new quantity against stock
            $maxStock = isset($variant) ? $variant->stock : $product->stock;
            if ($newQuantity > $maxStock) {
                return back()->with('error', 'Cannot add more items than available in stock.');
            }
            
            $cartItem->update(['quantity' => $newQuantity]);
        } else {
            // Create new cart item
            $cart->cartItems()->create([
                'product_id' => $validated['product_id'],
                'product_variant_id' => $validated['product_variant_id'] ?? null,
                'quantity' => $validated['quantity'],
            ]);
        }

        return back()->with('success', 'Product added to cart!');
    }

    public function update(Request $request, CartItem $cartItem)
    {
        // Ensure the cart item belongs to the user
        if ($cartItem->cart->user_id !== Auth::id()) {
            abort(403);
        }

        $validated = $request->validate([
            'quantity' => 'required|integer|min:1',
        ]);

        // Check stock availability
        $maxStock = $cartItem->variant 
                    ? $cartItem->variant->stock 
                    : $cartItem->product->stock;

        if ($validated['quantity'] > $maxStock) {
            return back()->with('error', 'Quantity exceeds available stock.');
        }

        $cartItem->update($validated);

        return back()->with('success', 'Cart updated successfully.');
    }

    public function remove(CartItem $cartItem)
    {
        // Ensure the cart item belongs to the user
        if ($cartItem->cart->user_id !== Auth::id()) {
            abort(403);
        }

        $cartItem->delete();

        return back()->with('success', 'Item removed from cart.');
    }

    public function clear()
    {
        $cart = $this->getOrCreateCart();
        $cart->cartItems()->delete();

        return back()->with('success', 'Cart cleared.');
    }

    // Helper method
    private function getOrCreateCart()
    {
        return Cart::firstOrCreate(['user_id' => Auth::id()]);
    }
}
