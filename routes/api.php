<?php
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Route;
use App\Models\Category;
use App\Models\Cart;
use App\Models\CartItem;
use Illuminate\Support\Facades\Auth;
use App\Models\Product;

// Categories endpoint
Route::get('/categories', function () {
    return Category::whereNull('parent_id')
        ->select('id', 'name')
        ->get();
});

// Cart endpoint (requires auth)
Route::middleware('auth:web')->get('/cart', function (Request $request) {
    try {
        // Check if user is actually authenticated
        if (!Auth::check()) {
            return response()->json([
                'items' => [],
                'total' => 0,
                'authenticated' => false
            ], 401);
        }

        $cart = Cart::with(['cartItems.product.images'])
            ->where('user_id', Auth::id())
            ->first();
       
        if (!$cart || $cart->cartItems->isEmpty()) {
            return response()->json([
                'items' => [],
                'total' => 0,
                'authenticated' => true
            ]);
        }
       
        $items = $cart->cartItems->map(function($item) {
            return [
                'id' => $item->id,
                'quantity' => $item->quantity,
                'product' => [
                    'id' => $item->product->id,
                    'name' => $item->product->name,
                    'price' => $item->product->price,
                    'images' => $item->product->images->map(function($image) {
                        return [
                            'image_url' => $image->image_url
                        ];
                    })->toArray()
                ]
            ];
        });
       
        $total = $cart->cartItems->sum(function($item) {
            return $item->quantity * $item->product->price;
        });
       
        return response()->json([
            'items' => $items,
            'total' => $total,
            'authenticated' => true
        ]);
    } catch (\Exception $e) {
        \Log::error('Cart endpoint error: ' . $e->getMessage());
        return response()->json([
            'items' => [],
            'total' => 0,
            'error' => $e->getMessage()
        ], 500);
    }
});

// Remove item from cart (requires auth)
Route::middleware('auth:web')->delete('/cart/{cartItem}', function(CartItem $cartItem) {
    try {
        if (!Auth::check()) {
            return response()->json([
                'success' => false,
                'message' => 'Unauthorized'
            ], 401);
        }

        // Ensure user owns this cart item
        if ($cartItem->cart->user_id !== Auth::id()) {
            return response()->json([
                'success' => false,
                'message' => 'Unauthorized'
            ], 403);
        }
       
        $cartItem->delete();
       
        return response()->json(['success' => true]);
    } catch (\Exception $e) {
        \Log::error('Delete cart item error: ' . $e->getMessage());
        return response()->json([
            'success' => false,
            'message' => $e->getMessage()
        ], 500);
    }
});

// Set currency endpoint (optional - stores in session)
Route::post('/set-currency', function (Request $request) {
    session(['currency' => $request->input('currency')]);
    return response()->json(['success' => true]);
});

// Search endpoint
Route::get('/search', function (Request $request) {
    $query = $request->query('query', '');
   
    return Product::with('images')
        ->where('name', 'like', "%{$query}%")
        ->limit(8)
        ->get()
        ->map(function ($product) {
            return [
                'id'    => $product->id,
                'name'  => $product->name,
                'price' => $product->price,
                'image' => $product->images->first()?->image_url
                    ? asset('storage/' . $product->images->first()->image_url)
                    : null,
            ];
        });
});