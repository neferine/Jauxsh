@extends('layouts.admin')

@section('title', 'Variants - ' . $product->name)
@section('page-title', 'Product Variants')
@section('page-description', 'Manage variants for ' . $product->name)

@section('content')
<div class="space-y-6">
    <!-- Header -->
    <div class="flex justify-between items-start">
        <div>
            <div class="flex items-center gap-3 mb-3">
                <a href="/admin/products" class="text-[#1FAC99] hover:text-[#1D433F] font-cg text-sm">
                    ← Back to Products
                </a>
            </div>
            <h2 class="text-2xl font-bold text-[#1D433F] font-lora">{{ $product->name }}</h2>
            <p class="text-gray-600 font-cg mt-1">
                Base Price: <span class="font-semibold text-gray-900">${{ number_format($product->price, 2) }}</span>
                | Category: <span class="font-semibold text-gray-900">{{ $product->category->name ?? 'N/A' }}</span>
            </p>
        </div>
        <a href="/admin/products/{{ $product->id }}/variants/create" 
           class="inline-flex items-center px-6 py-3 bg-[#1FAC99] text-white font-cg rounded-lg hover:bg-[#1D433F] transition-colors shadow-sm">
            <svg class="w-5 h-5 mr-2" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M12 6v6m0 0v6m0-6h6m-6 0H6"/>
            </svg>
            Add Variant
        </a>
    </div>

    @if(session('success'))
    <div class="p-4 bg-green-50 border border-green-200 rounded-lg">
        <p class="text-green-800 font-cg text-sm">{{ session('success') }}</p>
    </div>
    @endif

    <!-- Variants Table -->
    <div class="bg-white rounded-lg shadow-sm border border-gray-100 overflow-hidden">
        @if($variants->count() > 0)
        <div class="overflow-x-auto">
            <table class="w-full">
                <thead class="bg-gray-50 border-b border-gray-200">
                    <tr class="text-left text-xs font-semibold text-gray-600 uppercase tracking-wider font-cg">
                        <th class="px-6 py-4">Preview</th>
                        <th class="px-6 py-4">SKU</th>
                        <th class="px-6 py-4">Size</th>
                        <th class="px-6 py-4">Color</th>
                        <th class="px-6 py-4">Price</th>
                        <th class="px-6 py-4">Stock</th>
                        <th class="px-6 py-4 text-right">Actions</th>
                    </tr>
                </thead>
                <tbody class="divide-y divide-gray-100">
                    @foreach($variants as $variant)
                    <tr class="hover:bg-gray-50 transition-colors">
                        <!-- Preview -->
                        <td class="px-6 py-4">
                            @if($variant->image_url)
                            <img src="{{ asset('storage/' . $variant->image_url) }}" 
                                 alt="{{ $variant->color }}"
                                 class="w-12 h-12 rounded-lg object-cover border border-gray-200">
                            @elseif($variant->color_hex)
                            <div class="w-12 h-12 rounded-lg border-2 border-gray-300 shadow-sm"
                                 style="background-color: {{ $variant->color_hex }}"
                                 title="{{ $variant->color }}"></div>
                            @else
                            <div class="w-12 h-12 rounded-lg bg-gray-100 border border-gray-200 flex items-center justify-center">
                                <svg class="w-6 h-6 text-gray-400" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                                    <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M4 16l4.586-4.586a2 2 0 012.828 0L16 16m-2-2l1.586-1.586a2 2 0 012.828 0L20 14m-6-6h.01M6 20h12a2 2 0 002-2V6a2 2 0 00-2-2H6a2 2 0 00-2 2v12a2 2 0 002 2z"/>
                                </svg>
                            </div>
                            @endif
                        </td>

                        <!-- SKU -->
                        <td class="px-6 py-4">
                            <div class="text-sm font-mono text-gray-900 font-cg">{{ $variant->sku }}</div>
                        </td>

                        <!-- Size -->
                        <td class="px-6 py-4">
                            @if($variant->size)
                            <span class="inline-flex items-center px-3 py-1 rounded-full text-xs font-medium bg-[#d8e8e7] text-[#1D433F] font-cg">
                                {{ $variant->size }}
                            </span>
                            @else
                            <span class="text-xs text-gray-400 font-cg">N/A</span>
                            @endif
                        </td>

                        <!-- Color -->
                        <td class="px-6 py-4">
                            @if($variant->color)
                            <div class="flex items-center gap-2">
                                @if($variant->color_hex)
                                <span class="w-5 h-5 rounded-full border-2 border-gray-300 shadow-sm inline-block"
                                      style="background-color: {{ $variant->color_hex }}"></span>
                                @endif
                                <span class="text-sm text-gray-900 font-cg">{{ $variant->color }}</span>
                            </div>
                            @else
                            <span class="text-xs text-gray-400 font-cg">N/A</span>
                            @endif
                        </td>

                        <!-- Price -->
                        <td class="px-6 py-4">
                            <div class="text-sm font-cg">
                                <div class="font-semibold text-gray-900">
                                    ${{ number_format($product->price + $variant->price_adjustment, 2) }}
                                </div>
                                @if($variant->price_adjustment != 0)
                                <div class="text-xs {{ $variant->price_adjustment > 0 ? 'text-red-600' : 'text-green-600' }} font-cg">
                                    {{ $variant->price_adjustment > 0 ? '+' : '' }}${{ number_format($variant->price_adjustment, 2) }}
                                </div>
                                @endif
                            </div>
                        </td>

                        <!-- Stock -->
                        <td class="px-6 py-4">
                            @if($variant->stock > 10)
                            <span class="inline-flex items-center px-3 py-1 rounded-full text-xs font-medium bg-green-100 text-green-800 font-cg">
                                {{ $variant->stock }} in stock
                            </span>
                            @elseif($variant->stock > 0)
                            <span class="inline-flex items-center px-3 py-1 rounded-full text-xs font-medium bg-yellow-100 text-yellow-800 font-cg">
                                {{ $variant->stock }} low stock
                            </span>
                            @else
                            <span class="inline-flex items-center px-3 py-1 rounded-full text-xs font-medium bg-red-100 text-red-800 font-cg">
                                Out of stock
                            </span>
                            @endif
                        </td>

                        <!-- Actions -->
                        <td class="px-6 py-4 text-right">
                            <div class="flex items-center justify-end space-x-3">
                                <a href="/admin/products/{{ $product->id }}/variants/{{ $variant->id }}/edit" 
                                   class="text-[#1FAC99] hover:text-[#1D433F] font-cg text-sm hover:underline">
                                    Edit
                                </a>
                                <form action="/admin/products/{{ $product->id }}/variants/{{ $variant->id }}" 
                                      method="POST" 
                                      onsubmit="return confirm('Are you sure you want to delete this variant?')" 
                                      class="inline">
                                    @csrf
                                    @method('DELETE')
                                    <button type="submit" class="text-red-600 hover:text-red-800 font-cg text-sm hover:underline">
                                        Delete
                                    </button>
                                </form>
                            </div>
                        </td>
                    </tr>
                    @endforeach
                </tbody>
            </table>
        </div>

        <!-- Summary Stats -->
        <div class="px-6 py-4 bg-gray-50 border-t border-gray-200 grid grid-cols-3 gap-6">
            <div>
                <div class="text-2xl font-bold text-[#1D433F] font-lora">{{ $variants->count() }}</div>
                <p class="text-sm text-gray-600 font-cg">Total Variants</p>
            </div>
            <div>
                <div class="text-2xl font-bold text-[#1D433F] font-lora">{{ $variants->sum('stock') }}</div>
                <p class="text-sm text-gray-600 font-cg">Total Stock</p>
            </div>
            <div>
                <div class="text-2xl font-bold text-[#1D433F] font-lora">{{ $variants->unique('color')->count() }}</div>
                <p class="text-sm text-gray-600 font-cg">Colors Available</p>
            </div>
        </div>

        @else
        <div class="px-6 py-12 text-center">
            <svg class="mx-auto h-12 w-12 text-gray-400 mb-4" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M20 7l-8-4-8 4m16 0l-8 4m8-4v10l-8 4m0-10L4 7m8 4v10M4 7v10l8 4"/>
            </svg>
            <h3 class="mt-4 text-lg font-medium text-gray-900 font-lora">No variants yet</h3>
            <p class="mt-2 text-sm text-gray-500 font-cg mb-6">Start by adding colors and sizes for this product</p>
            <a href="/admin/products/{{ $product->id }}/variants/create" 
               class="inline-flex items-center px-6 py-3 bg-[#1FAC99] text-white font-cg rounded-lg hover:bg-[#1D433F] transition-colors shadow-sm">
                <svg class="w-5 h-5 mr-2" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                    <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M12 6v6m0 0v6m0-6h6m-6 0H6"/>
                </svg>
                Add First Variant
            </a>
        </div>
        @endif
    </div>
</div>
@endsection