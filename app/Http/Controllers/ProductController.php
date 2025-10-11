<?php

namespace App\Http\Controllers;

use App\Models\Product;
use App\Models\Category;
use Illuminate\Http\Request;

class ProductController extends Controller
{
    public function home()
    {
        $featuredProducts = Product::with(['category', 'images'])
            ->where('stock', '>', 0)
            ->latest()
            ->take(8)
            ->get();
            
        $categories = Category::whereNull('parent_id')->get();
            
        return view('pages.home', compact('featuredProducts', 'categories'));
    }
    
    public function index(Request $request)
    {
        $query = Product::with(['category', 'images'])->where('stock', '>', 0);
        
        // Search functionality
        if ($request->has('search')) {
            $query->where('name', 'like', '%' . $request->search . '%')
                  ->orWhere('description', 'like', '%' . $request->search . '%');
        }
        
        // Category filter
        if ($request->has('category')) {
            $query->where('category_id', $request->category);
        }
        
        // Price range filter
        if ($request->has('min_price')) {
            $query->where('price', '>=', $request->min_price);
        }
        if ($request->has('max_price')) {
            $query->where('price', '<=', $request->max_price);
        }
        
        // Sorting
        $sortBy = $request->get('sort', 'created_at');
        $sortOrder = $request->get('order', 'desc');
        $query->orderBy($sortBy, $sortOrder);
        
        $products = $query->paginate(12);
        $categories = Category::all();
        
        return view('pages.products.index', compact('products', 'categories'));
    }
    
    public function show($id)
    {
        $product = Product::with(['category', 'images'])->findOrFail($id);
        
        $relatedProducts = Product::with('images')
            ->where('category_id', $product->category_id)
            ->where('id', '!=', $id)
            ->where('stock', '>', 0)
            ->take(4)
            ->get();
            
        return view('pages.products.show', compact('product', 'relatedProducts'));
    }
}