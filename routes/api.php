<?php
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Route;
use App\Models\Category;
use App\Models\Cart;
use App\Models\CartItem;
use Illuminate\Support\Facades\Auth;
use App\Models\Product;
use App\Models\Collection;

Route::get('/categories', function () {
    return Category::whereNull('parent_id')
        ->select('id', 'name', 'slug')
        ->orderBy('name')
        ->get();
});


// Cart endpoint (requires auth)
Route::middleware('auth:web')->get('/cart', function (Request $request) {
    try {
        $cart = Cart::with(['cartItems.product.images'])
            ->where('user_id', auth()->id())
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

// Update cart item quantity (NEW - requires auth)
Route::middleware('auth:web')->patch('/cart/{cartItem}', function(Request $request, CartItem $cartItem) {
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

        // Validate quantity
        $request->validate([
            'quantity' => 'required|integer|min:1|max:99'
        ]);

        // Check stock availability
        if ($request->quantity > $cartItem->product->stock) {
            return response()->json([
                'success' => false,
                'message' => 'Not enough stock available'
            ], 400);
        }

        // Update quantity
        $cartItem->quantity = $request->quantity;
        $cartItem->save();

        return response()->json([
            'success' => true,
            'message' => 'Quantity updated successfully'
        ]);
    } catch (\Exception $e) {
        \Log::error('Update cart item error: ' . $e->getMessage());
        return response()->json([
            'success' => false,
            'message' => $e->getMessage()
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
    $query = strtolower($request->query('query', ''));

    return Product::with('images')
        ->whereRaw('LOWER(name) LIKE ?', ["%{$query}%"])
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

Route::get('/collections', function () {
    return Collection::active()
        ->ordered()
        ->select('id', 'name', 'slug', 'description', 'image_url')
        ->withCount('products')
        ->get()
        ->map(function ($collection) {
            return [
                'id' => $collection->id,
                'name' => $collection->name,
                'slug' => $collection->slug,
                'description' => $collection->description,
                'image_url' => $collection->image_url ? asset('storage/' . $collection->image_url) : null,
                'product_count' => $collection->products_count,
            ];
        });
});

Route::get('/products', function (Request $request) {
    $query = Product::with(['images', 'category']);
    
    // Filter by category
    if ($request->has('category')) {
        $query->where('category_id', $request->category);
    }
    
    // Sorting
    switch ($request->sort) {
        case 'newest':
            $query->orderBy('created_at', 'desc');
            break;
        case 'price_low':
            $query->orderBy('price', 'asc');
            break;
        case 'price_high':
            $query->orderBy('price', 'desc');
            break;
        case 'name':
            $query->orderBy('name', 'asc');
            break;
        default:
            // Remove sort_order reference - just use created_at
            $query->orderBy('created_at', 'desc');
    }
    
    return $query->paginate(12);
});