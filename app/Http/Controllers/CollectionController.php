<?php

namespace App\Http\Controllers;

use App\Models\Collection;
use Illuminate\Http\Request;

// ============================================
// Public Collection Controller
// ============================================
class CollectionController extends Controller
{
    public function index()
    {
        $collections = Collection::active()
                                 ->ordered()
                                 ->withCount('products')
                                 ->get();
        
        return view('collections.index', compact('collections'));
    }

    public function show(Collection $collection)
    {
        if (!$collection->is_active) {
            abort(404);
        }

        $products = $collection->products()
                              ->with(['images', 'variants'])
                              ->paginate(12);
        
        return view('collections.show', compact('collection', 'products'));
    }
}