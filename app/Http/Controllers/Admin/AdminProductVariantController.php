<?php

namespace App\Http\Controllers\Admin;

use App\Http\Controllers\Controller;
use App\Models\Product;
use App\Models\ProductVariant;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Storage;

class AdminProductVariantController extends Controller
{
    public function index(Product $product)
    {
        $variants = $product->variants()->get();
        
        return view('admin.products.variants.index', compact('product', 'variants'));
    }

    public function create(Product $product)
    {
        return view('admin.products.variants.create', compact('product'));
    }

    public function store(Request $request, Product $product)
    {
        $validated = $request->validate([
            'sku' => 'required|string|unique:product_variants,sku',
            'size' => 'nullable|string|max:50',
            'color' => 'nullable|string|max:50',
            'color_hex' => 'nullable|string|max:7',
            'price_adjustment' => 'nullable|numeric',
            'stock' => 'required|integer|min:0',
            'variant_image' => 'nullable|image|mimes:jpeg,png,jpg,gif|max:2048',
        ]);

        $validated['product_id'] = $product->id;
        
        // Handle image upload
        if ($request->hasFile('variant_image')) {
            $image = $request->file('variant_image');
            $imageName = time() . '_' . $image->getClientOriginalName();
            $imagePath = $image->storeAs('products/variants', $imageName, 'public');
            $validated['image_url'] = $imagePath;
        }
        
        ProductVariant::create($validated);

        return redirect()->route('admin.products.variants.index', $product)
                        ->with('success', 'Variant created successfully.');
    }

    public function edit(Product $product, ProductVariant $variant)
    {
        return view('admin.products.variants.edit', compact('product', 'variant'));
    }

    public function update(Request $request, Product $product, ProductVariant $variant)
    {
        $validated = $request->validate([
            'sku' => 'required|string|unique:product_variants,sku,' . $variant->id,
            'size' => 'nullable|string|max:50',
            'color' => 'nullable|string|max:50',
            'color_hex' => 'nullable|string|max:7',
            'price_adjustment' => 'nullable|numeric',
            'stock' => 'required|integer|min:0',
            'variant_image' => 'nullable|image|mimes:jpeg,png,jpg,gif|max:2048',
        ]);

        // Handle image upload
        if ($request->hasFile('variant_image')) {
            // Delete old image if exists
            if ($variant->image_url) {
                Storage::disk('public')->delete($variant->image_url);
            }
            
            $image = $request->file('variant_image');
            $imageName = time() . '_' . $image->getClientOriginalName();
            $imagePath = $image->storeAs('products/variants', $imageName, 'public');
            $validated['image_url'] = $imagePath;
        }

        $variant->update($validated);

        return redirect()->route('admin.products.variants.index', $product)
                        ->with('success', 'Variant updated successfully.');
    }

    public function destroy(Product $product, ProductVariant $variant)
    {
        // Delete variant image if exists
        if ($variant->image_url) {
            Storage::disk('public')->delete($variant->image_url);
        }
        
        $variant->delete();

        return redirect()->route('admin.products.variants.index', $product)
                        ->with('success', 'Variant deleted successfully.');
    }
}
