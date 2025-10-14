<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use App\Models\Product;
use App\Models\Category;

class HomeController extends Controller
{
    public function index()
    {
        // Get featured products (you can customize this query)
        $fleeceProducts = Product::with(['category', 'images'])
            ->whereHas('category', function($query) {
                $query->where('name', 'LIKE', '%fleece%')
                      ->orWhere('name', 'LIKE', '%jacket%');
            })
            ->where('stock', '>', 0)
            ->take(4)
            ->get();

        // If no fleece products, get any 4 products
        if ($fleeceProducts->count() < 4) {
            $fleeceProducts = Product::with(['category', 'images'])
                ->where('stock', '>', 0)
                ->take(4)
                ->get();
        }

        // Get best sellers (products with most orders - for now just get latest)
        $bestSellers = Product::with(['category', 'images'])
            ->where('stock', '>', 0)
            ->latest()
            ->take(4)
            ->get();

        // Get all categories for navigation
        $categories = Category::whereNull('parent_id')
            ->with('children')
            ->get();

        return view('pages.home', compact('fleeceProducts', 'bestSellers', 'categories'));
    }
}