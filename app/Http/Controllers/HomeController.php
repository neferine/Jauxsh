<?php
namespace App\Http\Controllers;

use Illuminate\Http\Request;
use App\Models\Product;
use App\Models\Category;
use App\Models\Collection;

class HomeController extends Controller
{
    public function index()
    {
        // Get active collections for hero slider (ordered by sort_order)
        $heroCollections = Collection::where('is_active', true)
            ->orderBy('sort_order')
            ->get();

        // Get featured products for sections below
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

        // Get best sellers
        $bestSellers = Product::with(['category', 'images'])
            ->where('stock', '>', 0)
            ->latest()
            ->take(4)
            ->get();

        // Get all categories for navigation
        $categories = Category::whereNull('parent_id')
            ->with('children')
            ->get();

        return view('pages.home', compact('heroCollections', 'fleeceProducts', 'bestSellers', 'categories'));
    }
}