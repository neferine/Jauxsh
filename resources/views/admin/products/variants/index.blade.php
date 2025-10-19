@extends('layouts.admin')

@section('title', 'Variants - ' . $product->name)

@section('content')
<div class="container mx-auto px-6 py-8">
    <div class="mb-6">
        <a href="{{ route('admin.products.index') }}" 
           class="text-gray-600 hover:text-gray-900 flex items-center gap-2">
            <svg class="w-5 h-5" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M15 19l-7-7 7-7"/>
            </svg>
            Back to Products
        </a>
    </div>

    <div class="bg-white rounded-lg shadow-md p-8 mb-6">
        <div class="flex justify-between items-start mb-6">
            <div>
                <h1 class="text-3xl font-bold text-gray-900 mb-2">Product Variants</h1>
                <p class="text-gray-600">
                    Product: <strong>{{ $product->name }}</strong> | 
                    Base Price: <strong>${{ number_format($product->price, 2) }}</strong>
                </p>
            </div>
            <a href="{{ route('admin.products.variants.create', $product) }}" 
               class="px-6 py-3 bg-gray-900 text-white rounded-lg hover:bg-gray-800 transition-colors flex items-center gap-2">
                <svg class="w-5 h-5" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                    <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M12 4v16m8-8H4"/>
                </svg>
                Add Variant
            </a>
        </div>

        @if(session('success'))
        <div class="mb-6 p-4 bg-green-100 text-green-700 rounded-lg">
            {{ session('success') }}
        </div>
        @endif

        @if($variants->count() > 0)
        <div class="overflow-x-auto">
            <table class="w-full">
                <thead class="bg-gray-50 border-b border-gray-200">
                    <tr>
                        <th class="px-6 py-3 text-left text-xs font-medium text-gray-500 uppercase tracking-wider">Preview</th>
                        <th class="px-6 py-3 text-left text-xs font-medium text-gray-500 uppercase tracking-wider">SKU</th>
                        <th class="px-6 py-3 text-left text-xs font-medium text-gray-500 uppercase tracking-wider">Color</th>
                        <th class="px-6 py-3 text-left text-xs font-medium text-gray-500 uppercase tracking-wider">Size</th>
                        <th class="px-6 py-3 text-left text-xs font-medium text-gray-500 uppercase tracking-wider">Price</th>
                        <th class="px-6 py-3 text-left text-xs font-medium text-gray-500 uppercase tracking-wider">Stock</th>
                        <th class="px-6 py-3 text-left text-xs font-medium text-gray-500 uppercase tracking-wider">Actions</th>
                    </tr>
                </thead>
                <tbody class="bg-white divide-y divide-gray-200">
                    @foreach($variants as $variant)
                    <tr class="hover:bg-gray-50">
                        <td class="px-6 py-4 whitespace-nowrap">
                            @if($variant->image_url)
                            <img src="{{ asset('storage/' . $variant->image_url) }}" 
                                 alt="{{ $variant->display_name }}"
                                 class="w-16 h-16 object-cover rounded border border-gray-200">
                            @elseif($variant->color_hex)
                            <div class="w-16 h-16 rounded border-2 border-gray-300"
                                 style="background-color: {{ $variant->color_hex }}"
                                 title="{{ $variant->color }}"></div>
                            @else
                            <div class="w-16 h-16 rounded bg-gray-100 flex items-center justify-center">
                                <svg class="w-8 h-8 text-gray-400" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                                    <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M4 16l4.586-4.586a2 2 0 012.828 0L16 16m-2-2l1.586-1.586a2 2 0 012.828 0L20 14m-6-6h.01M6 20h12a2 2 0 002-2V6a2 2 0 00-2-2H6a2 2 0 00-2 2v12a2 2 0 002 2z"/>
                                </svg>
                            </div>
                            @endif
                        </td>
                        <td class="px-6 py-4 whitespace-nowrap">
                            <span class="text-sm font-mono text-gray-900">{{ $variant->sku }}</span>
                        </td>
                        <td class="px-6 py-4 whitespace-nowrap">
                            @if($variant->color)
                            <div class="flex items-center gap-2">
                                @if($variant->color_hex)
                                <span class="w-6 h-6 rounded-full border border-gray-300 inline-block"
                                      style="background-color: {{ $variant->color_hex }}"></span>
                                @endif
                                <span class="text-sm text-gray-900">{{ $variant->color }}</span>
                            </div>
                            @else
                            <span class="text-sm text-gray-400">N/A</span>
                            @endif
                        </td>
                        <td class="px-6 py-4 whitespace-nowrap">
                            @if($variant->size)
                            <span class="px-3 py-1 bg-gray-100 text-gray-900 text-sm font-semibold rounded">
                                {{ $variant->size }}
                            </span>
                            @else
                            <span class="text-sm text-gray-400">N/A</span>
                            @endif
                        </td>
                        <td class="px-6 py-4 whitespace-nowrap">
                            <div class="text-sm">
                                <div class="font-semibold text-gray-900">
                                    ${{ number_format($variant->final_price, 2) }}
                                </div>
                                @if($variant->price_adjustment != 0)
                                <div class="text-xs {{ $variant->price_adjustment > 0 ? 'text-red-600' : 'text-green-600' }}">
                                    {{ $variant->price_adjustment > 0 ? '+' : '' }}${{ number_format($variant->price_adjustment, 2) }}
                                </div>
                                @endif
                            </div>
                        </td>
                        <td class="px-6 py-4 whitespace-nowrap">
                            <span class="px-3 py-1 text-sm rounded-full
                                @if($variant->stock > 10) bg-green-100 text-green-800
                                @elseif($variant->stock > 0) bg-yellow-100 text-yellow-800
                                @else bg-red-100 text-red-800
                                @endif">
                                {{ $variant->stock }} in stock
                            </span>
                        </td>
                        <td class="px-6 py-4 whitespace-nowrap text-sm">
                            <div class="flex items-center gap-2">
                                <a href="{{ route('admin.products.variants.edit', [$product, $variant]) }}" 
                                   class="text-blue-600 hover:text-blue-800">
                                    <svg class="w-5 h-5" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                                        <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M11 5H6a2 2 0 00-2 2v11a2 2 0 002 2h11a2 2 0 002-2v-5m-1.414-9.414a2 2 0 112.828 2.828L11.828 15H9v-2.828l8.586-8.586z"/>
                                    </svg>
                                </a>
                                <form action="{{ route('admin.products.variants.destroy', [$product, $variant]) }}" 
                                      method="POST" 
                                      onsubmit="return confirm('Are you sure you want to delete this variant?')">
                                    @csrf
                                    @method('DELETE')
                                    <button type="submit" class="text-red-600 hover:text-red-800">
                                        <svg class="w-5 h-5" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                                            <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M19 7l-.867 12.142A2 2 0 0116.138 21H7.862a2 2 0 01-1.995-1.858L5 7m5 4v6m4-6v6m1-10V4a1 1 0 00-1-1h-4a1 1 0 00-1 1v3M4 7h16"/>
                                        </svg>
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
        <div class="mt-6 pt-6 border-t border-gray-200 grid grid-cols-3 gap-4">
            <div class="text-center">
                <div class="text-2xl font-bold text-gray-900">{{ $variants->count() }}</div>
                <div class="text-sm text-gray-600">Total Variants</div>
            </div>
            <div class="text-center">
                <div class="text-2xl font-bold text-gray-900">{{ $variants->sum('stock') }}</div>
                <div class="text-sm text-gray-600">Total Stock</div>
            </div>
            <div class="text-center">
                <div class="text-2xl font-bold text-gray-900">{{ $variants->unique('color')->count() }}</div>
                <div class="text-sm text-gray-600">Colors Available</div>
            </div>
        </div>

        @else
        <div class="text-center py-12">
            <svg class="mx-auto w-16 h-16 text-gray-400 mb-4" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M20 7l-8-4-8 4m16 0l-8 4m8-4v10l-8 4m0-10L4 7m8 4v10M4 7v10l8 4"/>
            </svg>
            <h3 class="text-lg font-medium text-gray-900 mb-2">No variants yet</h3>
            <p class="text-gray-600 mb-4">Start by adding colors and sizes for this product</p>
            <a href="{{ route('admin.products.variants.create', $product) }}" 
               class="inline-flex items-center gap-2 px-6 py-3 bg-gray-900 text-white rounded-lg hover:bg-gray-800 transition-colors">
                <svg class="w-5 h-5" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                    <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M12 4v16m8-8H4"/>
                </svg>
                Add First Variant
            </a>
        </div>
        @endif
    </div>

    <!-- Quick Add Multiple Variants -->
    <div class="bg-blue-50 border border-blue-200 rounded-lg p-6">
        <h3 class="text-lg font-semibold text-blue-900 mb-2">💡 Pro Tip: Bulk Add Variants</h3>
        <p class="text-blue-800 text-sm">
            If you need to add multiple color/size combinations quickly, you can use the bulk variant creator 
            or create a seeder to populate variants programmatically.
        </p>
    </div>
</div>
@endsection