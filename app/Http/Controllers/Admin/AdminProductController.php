<?php

namespace App\Http\Controllers\Admin;

use App\Http\Controllers\Controller;
use App\Models\Product;
use App\Models\ProductImage;
use App\Models\Category;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Storage;
use Illuminate\Support\Facades\DB;

class AdminProductController extends Controller
{
    public function index()
    {
        $products = Product::with(['category', 'images'])
            ->latest()
            ->paginate(15);
            
        return view('admin.products.index', compact('products'));
    }
    
    public function create()
    {
        $categories = Category::all();
        return view('admin.products.create', compact('categories'));
    }
    
    public function store(Request $request)
    {
        $validated = $request->validate([
            'name' => ['required', 'string', 'max:255'],
            'description' => ['nullable', 'string'],
            'price' => ['required', 'numeric', 'min:0'],
            'stock' => ['required', 'integer', 'min:0'],
            'category_id' => ['required', 'exists:categories,id'],
            'images.*' => ['nullable', 'image', 'mimes:jpeg,png,jpg,gif', 'max:2048'],
        ]);
        
        DB::beginTransaction();
        
        try {
            $product = Product::create([
                'name' => $validated['name'],
                'description' => $validated['description'],
                'price' => $validated['price'],
                'stock' => $validated['stock'],
                'category_id' => $validated['category_id'],
            ]);
            
            // Handle multiple images
            if ($request->hasFile('images')) {
                foreach ($request->file('images') as $image) {
                    $imagePath = $image->store('products', 'public');
                    
                    ProductImage::create([
                        'product_id' => $product->id,
                        'image_url' => $imagePath,
                    ]);
                }
            }
            
            DB::commit();
            
            return redirect()->route('admin.products.index')
                ->with('success', 'Product created successfully!');
                
        } catch (\Exception $e) {
            DB::rollBack();
            return back()->with('error', 'Error creating product: ' . $e->getMessage());
        }
    }
    
    public function show(Product $product)
    {
        $product->load(['category', 'images']);
        return view('admin.products.show', compact('product'));
    }
    
    public function edit(Product $product)
    {
        $product->load('images');
        $categories = Category::all();
        return view('admin.products.edit', compact('product', 'categories'));
    }
    
    public function update(Request $request, Product $product)
    {
        $validated = $request->validate([
            'name' => ['required', 'string', 'max:255'],
            'description' => ['nullable', 'string'],
            'price' => ['required', 'numeric', 'min:0'],
            'stock' => ['required', 'integer', 'min:0'],
            'category_id' => ['required', 'exists:categories,id'],
            'images.*' => ['nullable', 'image', 'mimes:jpeg,png,jpg,gif', 'max:2048'],
            'delete_images' => ['nullable', 'array'],
            'delete_images.*' => ['exists:product_images,id'],
        ]);
        
        DB::beginTransaction();
        
        try {
            $product->update([
                'name' => $validated['name'],
                'description' => $validated['description'],
                'price' => $validated['price'],
                'stock' => $validated['stock'],
                'category_id' => $validated['category_id'],
            ]);
            
            // Delete selected images
            if ($request->has('delete_images')) {
                $imagesToDelete = ProductImage::whereIn('id', $request->delete_images)->get();
                
                foreach ($imagesToDelete as $image) {
                    Storage::disk('public')->delete($image->image_url);
                    $image->delete();
                }
            }
            
            // Add new images
            if ($request->hasFile('images')) {
                foreach ($request->file('images') as $image) {
                    $imagePath = $image->store('products', 'public');
                    
                    ProductImage::create([
                        'product_id' => $product->id,
                        'image_url' => $imagePath,
                    ]);
                }
            }
            
            DB::commit();
            
            return redirect()->route('admin.products.index')
                ->with('success', 'Product updated successfully!');
                
        } catch (\Exception $e) {
            DB::rollBack();
            return back()->with('error', 'Error updating product: ' . $e->getMessage());
        }
    }
    
    public function destroy(Product $product)
    {
        DB::beginTransaction();
        
        try {
            // Delete all product images from storage
            foreach ($product->images as $image) {
                Storage::disk('public')->delete($image->image_url);
            }
            
            $product->delete();
            
            DB::commit();
            
            return redirect()->route('admin.products.index')
                ->with('success', 'Product deleted successfully!');
                
        } catch (\Exception $e) {
            DB::rollBack();
            return back()->with('error', 'Error deleting product: ' . $e->getMessage());
        }
    }
}