<?php

namespace App\Http\Controllers;

use App\Models\Product;
use App\Models\Category;
use Illuminate\Http\Request;

class ProductController extends Controller
{
    public function index(Request $request)
    {
        $query = Product::with(['images', 'category', 'variants']);

        // Filter by category
        if ($request->has('category')) {
            $query->whereHas('category', function($q) use ($request) {
                $q->where('slug', $request->category)
                  ->orWhere('id', $request->category);
            });
        }

        // Filter by collection
        if ($request->has('collection')) {
            $query->whereHas('collections', function($q) use ($request) {
                $q->where('slug', $request->collection)
                  ->orWhere('id', $request->collection);
            });
        }

        // Search
        if ($request->has('search')) {
            $search = $request->search;
            $query->where(function($q) use ($search) {
                $q->where('name', 'like', "%{$search}%")
                  ->orWhere('description', 'like', "%{$search}%");
            });
        }

        // Sorting
        $sort = $request->get('sort', 'newest');
        switch ($sort) {
            case 'price_asc':
                $query->orderBy('price', 'asc');
                break;
            case 'price_desc':
                $query->orderBy('price', 'desc');
                break;
            case 'name':
                $query->orderBy('name', 'asc');
                break;
            case 'newest':
            default:
                $query->orderBy('created_at', 'desc');
                break;
        }

        $products = $query->paginate(12);
        $categories = Category::whereNull('parent_id')->with('children')->get();

        return view('pages.products.index', compact('products', 'categories'));
    }

    public function show($id)
    {
        $product = Product::with([
            'images', 
            'category', 
            'variants' => function($query) {
                $query->where('stock', '>', 0); // Only show in-stock variants
            },
            'collections'
        ])->findOrFail($id);

        // Get available colors and sizes
        $availableColors = $product->available_colors;
        $availableSizes = $product->available_sizes;

        // Get related products (same category, excluding current product)
        $relatedProducts = Product::with(['images', 'category'])
            ->where('category_id', $product->category_id)
            ->where('id', '!=', $product->id)
            ->where('stock', '>', 0) // Only show in-stock products
            ->inRandomOrder()
            ->limit(4)
            ->get();

        return view('pages.products.show', compact(
            'product', 
            'availableColors', 
            'availableSizes',
            'relatedProducts'
        ));
    }
}