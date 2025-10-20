@extends('layouts.admin')
@section('title', 'Products | Admin')
@section('page-title', 'Products')
@section('page-description', 'Manage your product inventory')

@section('content')
<div class="space-y-6">
    <!-- Header with Add Button -->
    <div class="flex justify-between items-center">
        <div>
            <h2 class="text-2xl font-bold text-[#1D433F] font-lora">All Products</h2>
            <p class="text-gray-600 font-cg mt-1">{{ $products->total() }} total products</p>
        </div>
        <a href="/admin/products/create" class="inline-flex items-center px-6 py-3 bg-[#1FAC99] text-white font-cg rounded-lg hover:bg-[#1D433F] transition-colors shadow-sm">
            <svg class="w-5 h-5 mr-2" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M12 6v6m0 0v6m0-6h6m-6 0H6"/>
            </svg>
            Add New Product
        </a>
    </div>

    <!-- Tab Navigation -->
    <div class="flex gap-4 border-b border-gray-200">
        <button onclick="switchTab('products')" id="tab-products" class="px-6 py-3 font-cg text-sm font-medium text-gray-900 border-b-2 border-[#1FAC99]">
            Products
        </button>
        <button onclick="switchTab('variants')" id="tab-variants" class="px-6 py-3 font-cg text-sm font-medium text-gray-500 border-b-2 border-transparent hover:text-gray-900 hover:border-gray-300">
            Manage Variants
        </button>
    </div>

    <!-- Products Tab -->
    <div id="products-tab" class="bg-white rounded-lg shadow-sm border border-gray-100 overflow-hidden">
        @if($products->count())
        <div class="overflow-x-auto">
            <table class="w-full">
                <thead class="bg-gray-50 border-b border-gray-200">
                    <tr class="text-left text-xs font-semibold text-gray-600 uppercase tracking-wider font-cg">
                        <th class="px-6 py-4">Product</th>
                        <th class="px-6 py-4">Category</th>
                        <th class="px-6 py-4">Price</th>
                        <th class="px-6 py-4">Stock</th>
                        <th class="px-6 py-4">Variants</th>
                        <th class="px-6 py-4">Created</th>
                        <th class="px-6 py-4 text-right">Actions</th>
                    </tr>
                </thead>
                <tbody class="divide-y divide-gray-100">
                    @foreach($products as $product)
                    <tr class="hover:bg-gray-50 transition-colors">
                        <td class="px-6 py-4">
                            <div class="flex items-center">
                                @if($product->images->count() > 0)
                                <img src="{{ asset('storage/' . $product->images->first()->image_url) }}" 
                                     alt="{{ $product->name }}" 
                                     class="w-12 h-12 rounded-lg object-cover mr-4">
                                @else
                                <div class="w-12 h-12 bg-gray-200 rounded-lg flex items-center justify-center mr-4">
                                    <svg class="w-6 h-6 text-gray-400" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                                        <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M4 16l4.586-4.586a2 2 0 012.828 0L16 16m-2-2l1.586-1.586a2 2 0 012.828 0L20 14m-6-6h.01M6 20h12a2 2 0 002-2V6a2 2 0 00-2-2H6a2 2 0 00-2 2v12a2 2 0 002 2z"/>
                                    </svg>
                                </div>
                                @endif
                                <div>
                                    <div class="text-sm font-medium text-gray-900 font-cg">{{ $product->name }}</div>
                                    <div class="text-xs text-gray-500 font-cg">ID: #{{ $product->id }}</div>
                                </div>
                            </div>
                        </td>
                        <td class="px-6 py-4">
                            <span class="inline-flex items-center px-3 py-1 rounded-full text-xs font-medium bg-[#d8e8e7] text-[#1D433F] font-cg">
                                {{ $product->category->name ?? 'N/A' }}
                            </span>
                        </td>
                        <td class="px-6 py-4 text-sm font-medium text-gray-900 font-cg">
                            ₱{{ number_format($product->price, 2) }}
                        </td>
                        <td class="px-6 py-4">
                            @php
                                $totalStock = $product->variants->sum('stock');
                            @endphp
                            @if($totalStock > 10)
                            <span class="inline-flex items-center px-3 py-1 rounded-full text-xs font-medium bg-green-100 text-green-800 font-cg">
                                {{ $totalStock }} in stock
                            </span>
                            @elseif($totalStock > 0)
                            <span class="inline-flex items-center px-3 py-1 rounded-full text-xs font-medium bg-yellow-100 text-yellow-800 font-cg">
                                {{ $totalStock }} low stock
                            </span>
                            @else
                            <span class="inline-flex items-center px-3 py-1 rounded-full text-xs font-medium bg-red-100 text-red-800 font-cg">
                                Out of stock
                            </span>
                            @endif
                        </td>
                        <td class="px-6 py-4">
                            <span class="inline-flex items-center px-3 py-1 rounded-full text-xs font-medium bg-blue-100 text-blue-800 font-cg">
                                {{ $product->variants->count() }} variants
                            </span>
                        </td>
                        <td class="px-6 py-4 text-sm text-gray-500 font-cg">
                            {{ $product->created_at->format('M d, Y') }}
                        </td>
                        <td class="px-6 py-4 text-right">
                            <div class="flex items-center justify-end space-x-3">
                                <a href="/admin/products/{{ $product->id }}/variants" 
                                   class="text-blue-600 hover:text-blue-800 font-cg text-sm hover:underline">
                                    Variants
                                </a>
                                <a href="/admin/products/{{ $product->id }}/edit" 
                                   class="text-[#1FAC99] hover:text-[#1D433F] font-cg text-sm hover:underline">
                                    Edit
                                </a>
                                <form action="/admin/products/{{ $product->id }}" method="POST" 
                                      onsubmit="return confirm('Are you sure you want to delete this product?')" 
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

        <!-- Pagination -->
        <div class="px-6 py-4 border-t border-gray-100">
            {{ $products->links() }}
        </div>
        @else
        <div class="px-6 py-12 text-center">
            <svg class="mx-auto h-12 w-12 text-gray-400" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M20 7l-8-4-8 4m16 0l-8 4m8-4v10l-8 4m0-10L4 7m8 4v10M4 7v10l8 4"/>
            </svg>
            <h3 class="mt-4 text-lg font-medium text-gray-900 font-lora">No products yet</h3>
            <p class="mt-2 text-sm text-gray-500 font-cg">Get started by creating your first product.</p>
            <div class="mt-6">
                <a href="/admin/products/create" class="inline-flex items-center px-4 py-2 bg-[#1FAC99] text-white font-cg rounded-lg hover:bg-[#1D433F] transition-colors">
                    <svg class="w-5 h-5 mr-2" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                        <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M12 6v6m0 0v6m0-6h6m-6 0H6"/>
                    </svg>
                    Add Product
                </a>
            </div>
        </div>
        @endif
    </div>

    <!-- Variants Tab -->
    <div id="variants-tab" class="hidden bg-white rounded-lg shadow-sm border border-gray-100 overflow-hidden">
        @if($products->count())
        <div class="p-6">
            <div class="space-y-8">
                @foreach($products as $product)
                    @if($product->variants->count() > 0)
                    <div class="border-b border-gray-200 pb-8 last:border-b-0">
                        <div class="flex justify-between items-start mb-4">
                            <div>
                                <h3 class="text-lg font-semibold text-gray-900 font-cg">{{ $product->name }}</h3>
                                <p class="text-sm text-gray-500 font-cg">{{ $product->variants->count() }} variant(s)</p>
                            </div>
                            <a href="/admin/products/{{ $product->id }}/variants" 
                               class="px-4 py-2 bg-blue-600 text-white text-sm font-cg rounded-lg hover:bg-blue-700 transition-colors">
                                Manage All
                            </a>
                        </div>

                        <div class="overflow-x-auto">
                            <table class="w-full text-sm">
                                <thead>
                                    <tr class="border-b border-gray-200">
                                        <th class="text-left px-4 py-2 font-cg font-semibold text-gray-700">SKU</th>
                                        <th class="text-left px-4 py-2 font-cg font-semibold text-gray-700">Size</th>
                                        <th class="text-left px-4 py-2 font-cg font-semibold text-gray-700">Color</th>
                                        <th class="text-left px-4 py-2 font-cg font-semibold text-gray-700">Stock</th>
                                        <th class="text-left px-4 py-2 font-cg font-semibold text-gray-700">Price Adj.</th>
                                        <th class="text-left px-4 py-2 font-cg font-semibold text-gray-700">Action</th>
                                    </tr>
                                </thead>
                                <tbody class="divide-y divide-gray-100">
                                    @foreach($product->variants as $variant)
                                    <tr class="hover:bg-gray-50">
                                        <td class="px-4 py-3 font-cg text-gray-900">{{ $variant->sku }}</td>
                                        <td class="px-4 py-3 font-cg text-gray-700">{{ $variant->size ?? '-' }}</td>
                                        <td class="px-4 py-3 font-cg">
                                            <div class="flex items-center gap-2">
                                                @if($variant->color_hex)
                                                <div class="w-4 h-4 rounded border border-gray-300" style="background-color: {{ $variant->color_hex }};"></div>
                                                @endif
                                                <span class="text-gray-700">{{ $variant->color ?? '-' }}</span>
                                            </div>
                                        </td>
                                        <td class="px-4 py-3 font-cg">
                                            @if($variant->stock > 10)
                                            <span class="inline-flex items-center px-2 py-1 rounded text-xs font-medium bg-green-100 text-green-800">{{ $variant->stock }}</span>
                                            @elseif($variant->stock > 0)
                                            <span class="inline-flex items-center px-2 py-1 rounded text-xs font-medium bg-yellow-100 text-yellow-800">{{ $variant->stock }}</span>
                                            @else
                                            <span class="inline-flex items-center px-2 py-1 rounded text-xs font-medium bg-red-100 text-red-800">{{ $variant->stock }}</span>
                                            @endif
                                        </td>
                                        <td class="px-4 py-3 font-cg text-gray-900">
                                            @if($variant->price_adjustment > 0)
                                            <span class="text-green-600">+₱{{ number_format($variant->price_adjustment, 2) }}</span>
                                            @elseif($variant->price_adjustment < 0)
                                            <span class="text-red-600">-₱{{ number_format(abs($variant->price_adjustment), 2) }}</span>
                                            @else
                                            <span class="text-gray-500">No adjustment</span>
                                            @endif
                                        </td>
                                        <td class="px-4 py-3">
                                            <a href="/admin/products/{{ $product->id }}/variants/{{ $variant->id }}/edit" 
                                               class="text-[#1FAC99] hover:text-[#1D433F] font-cg text-xs hover:underline">
                                                Edit
                                            </a>
                                        </td>
                                    </tr>
                                    @endforeach
                                </tbody>
                            </table>
                        </div>
                    </div>
                    @endif
                @endforeach
            </div>
        </div>
        @else
        <div class="px-6 py-12 text-center">
            <p class="text-gray-500 font-cg">No products with variants yet.</p>
        </div>
        @endif
    </div>
</div>

@push('scripts')
<script>
function switchTab(tab) {
    // Hide all tabs
    document.getElementById('products-tab').classList.add('hidden');
    document.getElementById('variants-tab').classList.add('hidden');
    
    // Remove active state from all buttons
    document.getElementById('tab-products').classList.remove('border-[#1FAC99]', 'text-gray-900');
    document.getElementById('tab-products').classList.add('border-transparent', 'text-gray-500');
    document.getElementById('tab-variants').classList.remove('border-[#1FAC99]', 'text-gray-900');
    document.getElementById('tab-variants').classList.add('border-transparent', 'text-gray-500');
    
    // Show selected tab
    if (tab === 'products') {
        document.getElementById('products-tab').classList.remove('hidden');
        document.getElementById('tab-products').classList.remove('border-transparent', 'text-gray-500');
        document.getElementById('tab-products').classList.add('border-[#1FAC99]', 'text-gray-900');
    } else {
        document.getElementById('variants-tab').classList.remove('hidden');
        document.getElementById('tab-variants').classList.remove('border-transparent', 'text-gray-500');
        document.getElementById('tab-variants').classList.add('border-[#1FAC99]', 'text-gray-900');
    }
}
</script>
@endpush
@endsection