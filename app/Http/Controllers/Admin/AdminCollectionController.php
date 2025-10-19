<?php
namespace App\Http\Controllers\Admin;

use App\Http\Controllers\Controller;
use App\Models\Collection;
use App\Models\Product;
use Illuminate\Http\Request;
use Illuminate\Support\Str;
use Illuminate\Support\Facades\Storage;

class AdminCollectionController extends Controller
{
    public function index()
    {
        $collections = Collection::withCount('products')
            ->orderBy('sort_order')
            ->paginate(15);
        
        return view('admin.collections.index', compact('collections'));
    }

    public function create()
    {
        return view('admin.collections.create');
    }

    public function store(Request $request)
    {
        $validated = $request->validate([
            'name' => 'required|string|max:255',
            'description' => 'nullable|string',
            'image_url' => 'nullable|image|mimes:jpeg,png,jpg,gif,webp|max:10240',
            'is_active' => 'nullable|boolean',
            'sort_order' => 'nullable|integer',
        ]);

        // Auto-generate slug from name
        $validated['slug'] = Str::slug($validated['name']);
        
        // Ensure slug is unique
        $originalSlug = $validated['slug'];
        $count = 1;
        while (Collection::where('slug', $validated['slug'])->exists()) {
            $validated['slug'] = $originalSlug . '-' . $count;
            $count++;
        }

        // Handle image upload
        if ($request->hasFile('image_url')) {
            $validated['image_url'] = $request->file('image_url')->store('collections', 'public');
        } else {
            unset($validated['image_url']);
        }

        // Handle is_active checkbox
        $validated['is_active'] = $request->has('is_active') ? true : false;
        
        // Set default sort_order if not provided
        if (!isset($validated['sort_order'])) {
            $validated['sort_order'] = 0;
        }

        $collection = Collection::create($validated);

        return redirect()->route('admin.collections.index')
            ->with('success', 'Collection created successfully.');
    }

    public function show(Collection $collection)
    {
        $collection->load('products');
        return view('admin.collections.show', compact('collection'));
    }

    public function edit(Collection $collection)
    {
        $products = Product::orderBy('name')->get();
        $collectionProducts = $collection->products()->pluck('products.id')->toArray();
        
        return view('admin.collections.edit', compact('collection', 'products', 'collectionProducts'));
    }

    public function update(Request $request, Collection $collection)
    {
        $validated = $request->validate([
            'name' => 'required|string|max:255',
            'description' => 'nullable|string',
            'image_url' => 'nullable|image|mimes:jpeg,png,jpg,gif,webp|max:10240',
            'is_active' => 'nullable|boolean',
            'sort_order' => 'nullable|integer',
        ]);

        // Auto-generate slug from name if name changed
        if ($validated['name'] !== $collection->name) {
            $validated['slug'] = Str::slug($validated['name']);
            
            // Ensure slug is unique (excluding current collection)
            $originalSlug = $validated['slug'];
            $count = 1;
            while (Collection::where('slug', $validated['slug'])->where('id', '!=', $collection->id)->exists()) {
                $validated['slug'] = $originalSlug . '-' . $count;
                $count++;
            }
        }

        // Handle image upload
        if ($request->hasFile('image_url')) {
            // Delete old image if exists
            if ($collection->image_url && Storage::disk('public')->exists($collection->image_url)) {
                Storage::disk('public')->delete($collection->image_url);
            }
            
            $validated['image_url'] = $request->file('image_url')->store('collections', 'public');
        } else {
            // Keep existing image if no new file uploaded
            unset($validated['image_url']);
        }

        // Handle is_active checkbox
        $validated['is_active'] = $request->has('is_active') ? true : false;

        $collection->update($validated);

        return redirect()->route('admin.collections.index')
            ->with('success', 'Collection updated successfully.');
    }

    public function destroy(Collection $collection)
    {
        // Delete image if exists
        if ($collection->image_url && Storage::disk('public')->exists($collection->image_url)) {
            Storage::disk('public')->delete($collection->image_url);
        }

        $collection->delete();

        return redirect()->route('admin.collections.index')
            ->with('success', 'Collection deleted successfully.');
    }

    // Attach product to collection
    public function attachProduct(Request $request, Collection $collection)
    {
        $request->validate([
            'product_id' => 'required|exists:products,id',
            'sort_order' => 'nullable|integer',
        ]);

        if (!$collection->products()->where('product_id', $request->product_id)->exists()) {
            $collection->products()->attach($request->product_id, [
                'sort_order' => $request->sort_order ?? 0
            ]);
        }

        return back()->with('success', 'Product added to collection.');
    }

    // Detach product from collection
    public function detachProduct(Collection $collection, Product $product)
    {
        $collection->products()->detach($product->id);
        
        return back()->with('success', 'Product removed from collection.');
    }
}