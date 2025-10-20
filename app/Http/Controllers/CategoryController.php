<?php

namespace App\Http\Controllers;

use App\Models\Category;
use App\Models\Product;
use Illuminate\Http\Request;

class CategoryController extends Controller
{
    /**
     * Display products by category
     */
    public function show($slug, Request $request)
{
    // Determine if it's an ID or a slug
    $categoryQuery = Category::query();

    if (is_numeric($slug)) {
        $categoryQuery->where('id', $slug);
    } else {
        $categoryQuery->where('slug', $slug);
    }

    $category = $categoryQuery->firstOrFail();

    // Get all categories for the filter dropdown
    $allCategories = Category::orderBy('name')->get();

    // Query products in this category
    $query = Product::where('category_id', $category->id);

    // --- filters (search, price, stock, sort) stay the same ---
    if ($request->has('search') && $request->search != '') {
        $search = $request->search;
        $query->where(function($q) use ($search) {
            $q->where('name', 'like', "%{$search}%")
              ->orWhere('description', 'like', "%{$search}%");
        });
    }

    if ($request->has('min_price') && $request->min_price != '') {
        $query->where('price', '>=', $request->min_price);
    }

    if ($request->has('max_price') && $request->max_price != '') {
        $query->where('price', '<=', $request->max_price);
    }

    if ($request->has('stock') && $request->stock != '') {
        if ($request->stock == 'in_stock') {
            $query->where('stock', '>', 0);
        } elseif ($request->stock == 'out_of_stock') {
            $query->where('stock', '<=', 0);
        }
    }

    // Sorting
    $sortBy = $request->get('sort', 'name');
    $sortOrder = $request->get('order', 'asc');

    switch ($sortBy) {
        case 'price_low':
            $query->orderBy('price', 'asc');
            break;
        case 'price_high':
            $query->orderBy('price', 'desc');
            break;
        case 'newest':
            $query->orderBy('created_at', 'desc');
            break;
        case 'oldest':
            $query->orderBy('created_at', 'asc');
            break;
        default:
            $query->orderBy('name', $sortOrder);
            break;
    }

    // Paginate and count
    $products = $query->with(['images', 'category'])
                      ->paginate(12)
                      ->appends($request->except('page'));

    $productCount = $query->count();

    return view('pages.categories.show', compact('category', 'products', 'allCategories', 'productCount'));
}


    /**
     * Display all categories
     */
    public function index()
    {
        $categories = Category::withCount('products')
                             ->orderBy('name')
                             ->get();

        return view('pages.categories.index', compact('categories'));
    }
    protected static function boot()
    {
        parent::boot();

        static::saving(function ($category) {
            if (empty($category->slug)) {
                $category->slug = \Illuminate\Support\Str::slug($category->name);
            }
        });
    }

}