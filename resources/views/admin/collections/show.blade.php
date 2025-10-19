@extends('layouts.admin')
@section('title', 'View Collection | Admin')
@section('page-title', 'Collection Details')

@section('content')
<div class="min-h-screen">
    <!-- Header with Breadcrumb -->
    <div class="mb-8">
        <div class="flex items-center text-sm text-gray-500 font-cg mb-4">
            <a href="{{ route('admin.collections.index') }}" class="hover:text-[#1FAC99] transition">Collections</a>
            <svg class="w-4 h-4 mx-2" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M9 5l7 7-7 7"/>
            </svg>
            <span class="text-[#1D433F] font-medium">{{ $collection->name }}</span>
        </div>
        
        <div class="flex items-center justify-between">
            <div class="flex items-center space-x-4">
                <div>
                    <h1 class="text-3xl font-lora font-bold text-[#1D433F] mb-2">
                        {{ $collection->name }}
                    </h1>
                    <p class="text-gray-600 font-cg">View collection details and associated products</p>
                </div>
                
                <!-- Status Badge -->
                @if($collection->is_active)
                    <span class="px-3 py-1.5 bg-green-100 text-green-800 text-xs font-semibold rounded-full">
                        Active
                    </span>
                @else
                    <span class="px-3 py-1.5 bg-gray-100 text-gray-800 text-xs font-semibold rounded-full">
                        Inactive
                    </span>
                @endif
            </div>
            
            <div class="flex items-center space-x-3">
                <a href="{{ route('admin.collections.edit', $collection->id) }}"
                   class="inline-flex items-center px-4 py-2.5 bg-gradient-to-br from-[#1FAC99] to-[#1D433F] text-white rounded-lg font-cg shadow-md hover:shadow-lg transition-all">
                    <svg class="w-4 h-4 mr-2" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                        <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M11 5H6a2 2 0 00-2 2v11a2 2 0 002 2h11a2 2 0 002-2v-5m-1.414-9.414a2 2 0 112.828 2.828L11.828 15H9v-2.828l8.586-8.586z"/>
                    </svg>
                    Edit Collection
                </a>
                <a href="{{ route('admin.collections.index') }}"
                   class="inline-flex items-center px-4 py-2.5 bg-white border-2 border-gray-200 text-gray-700 rounded-lg font-cg hover:border-gray-300 hover:shadow-sm transition-all">
                    <svg class="w-4 h-4 mr-2" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                        <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M10 19l-7-7m0 0l7-7m-7 7h18"/>
                    </svg>
                    Back
                </a>
            </div>
        </div>
    </div>

    <div class="grid grid-cols-1 lg:grid-cols-3 gap-6">
        <!-- Main Content -->
        <div class="lg:col-span-2 space-y-6">
            <!-- Collection Overview Card -->
            <div class="bg-white rounded-lg shadow-sm border border-gray-100 overflow-hidden">
                <div class="px-6 py-4 border-b border-gray-100 bg-gradient-to-r from-gray-50 to-white">
                    <h2 class="text-lg font-semibold text-[#1D433F] font-lora">Collection Overview</h2>
                </div>
                
                <div class="p-6">
                    <div class="flex flex-col md:flex-row gap-6">
                        <!-- Image -->
                        <div class="flex-shrink-0">
                            @if($collection->image_url)
                                <img src="{{ asset('storage/' . $collection->image_url) }}" 
                                     alt="{{ $collection->name }}" 
                                     class="w-full md:w-64 h-64 object-cover rounded-lg border-2 border-gray-200 shadow-sm">
                            @else
                                <div class="w-full md:w-64 h-64 rounded-lg bg-gradient-to-br from-[#d8e8e7] to-[#1FAC99]/20 flex items-center justify-center">
                                    <div class="text-center">
                                        <div class="text-6xl font-bold text-[#1FAC99] mb-2">
                                            {{ substr($collection->name, 0, 1) }}
                                        </div>
                                        <p class="text-sm text-gray-600 font-cg">No Image</p>
                                    </div>
                                </div>
                            @endif
                        </div>

                        <!-- Details -->
                        <div class="flex-1">
                            <h3 class="text-xl font-lora font-bold text-[#1D433F] mb-3">
                                {{ $collection->name }}
                            </h3>
                            
                            @if($collection->description)
                                <div class="mb-4">
                                    <p class="text-gray-600 font-cg leading-relaxed">
                                        {{ $collection->description }}
                                    </p>
                                </div>
                            @else
                                <div class="mb-4">
                                    <p class="text-gray-400 italic font-cg">
                                        No description provided
                                    </p>
                                </div>
                            @endif

                            <!-- Quick Stats -->
                            <div class="grid grid-cols-2 gap-4 mt-6">
                                <div class="bg-[#d8e8e7] rounded-lg p-4">
                                    <div class="flex items-center justify-between">
                                        <div>
                                            <p class="text-xs text-gray-600 font-cg mb-1">Total Products</p>
                                            <p class="text-2xl font-bold text-[#1D433F] font-lora">
                                                {{ $collection->products->count() }}
                                            </p>
                                        </div>
                                        <svg class="w-8 h-8 text-[#1FAC99]" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                                            <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M20 7l-8-4-8 4m16 0l-8 4m8-4v10l-8 4m0-10L4 7m8 4v10M4 7v10l8 4"/>
                                        </svg>
                                    </div>
                                </div>
                                
                                <div class="bg-blue-50 rounded-lg p-4">
                                    <div class="flex items-center justify-between">
                                        <div>
                                            <p class="text-xs text-gray-600 font-cg mb-1">Sort Order</p>
                                            <p class="text-2xl font-bold text-[#1D433F] font-lora">
                                                {{ $collection->sort_order ?? 0 }}
                                            </p>
                                        </div>
                                        <svg class="w-8 h-8 text-blue-500" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                                            <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M7 16V4m0 0L3 8m4-4l4 4m6 0v12m0 0l4-4m-4 4l-4-4"/>
                                        </svg>
                                    </div>
                                </div>
                            </div>
                        </div>
                    </div>
                </div>
            </div>

            <!-- Products in Collection Card -->
            <div class="bg-white rounded-lg shadow-sm border border-gray-100 overflow-hidden">
                <div class="px-6 py-4 border-b border-gray-100 flex items-center justify-between bg-gradient-to-r from-gray-50 to-white">
                    <div>
                        <h2 class="text-lg font-semibold text-[#1D433F] font-lora">Products in Collection</h2>
                        <p class="text-sm text-gray-500 font-cg mt-1">{{ $collection->products->count() }} product(s) found</p>
                    </div>
                    <a href="{{ route('admin.collections.edit', $collection->id) }}" 
                       class="inline-flex items-center text-sm px-4 py-2 bg-[#1FAC99] text-white rounded-lg font-cg hover:bg-[#1D433F] transition">
                        <svg class="w-4 h-4 mr-2" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                            <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M12 6v6m0 0v6m0-6h6m-6 0H6"/>
                        </svg>
                        Add Products
                    </a>
                </div>

                @if($collection->products->count())
                    <div class="divide-y divide-gray-100">
                        @foreach($collection->products->sortBy('pivot.sort_order') as $product)
                            <div class="px-6 py-4 hover:bg-gray-50 transition-colors">
                                <div class="flex items-center justify-between">
                                    <div class="flex items-center space-x-4 flex-1">
                                        <!-- Product Image/Icon -->
                                        @if($product->images->first())
                                            <img src="{{ asset('storage/' . $product->images->first()->image_path) }}" 
                                                 alt="{{ $product->name }}"
                                                 class="w-16 h-16 object-cover rounded-lg border">
                                        @else
                                            <div class="w-16 h-16 bg-gray-100 rounded-lg flex items-center justify-center">
                                                <svg class="w-8 h-8 text-gray-400" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                                                    <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M20 7l-8-4-8 4m16 0l-8 4m8-4v10l-8 4m0-10L4 7m8 4v10M4 7v10l8 4"/>
                                                </svg>
                                            </div>
                                        @endif

                                        <!-- Product Info -->
                                        <div class="flex-1 min-w-0">
                                            <h4 class="text-sm font-semibold text-gray-900 font-cg truncate">
                                                {{ $product->name }}
                                            </h4>
                                            <div class="flex items-center mt-1 text-sm text-gray-500 font-cg space-x-4">
                                                <span>
                                                    @if($product->price)
                                                        ${{ number_format($product->price, 2) }}
                                                    @else
                                                        Price not set
                                                    @endif
                                                </span>
                                                <span class="flex items-center">
                                                    <svg class="w-4 h-4 mr-1" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                                                        <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M7 16V4m0 0L3 8m4-4l4 4m6 0v12m0 0l4-4m-4 4l-4-4"/>
                                                    </svg>
                                                    Sort: {{ $product->pivot->sort_order }}
                                                </span>
                                            </div>
                                        </div>
                                    </div>

                                    <!-- Actions -->
                                    <div class="flex items-center space-x-2">
                                        <a href="{{ route('admin.products.show', $product->id) }}" 
                                           class="inline-flex items-center px-3 py-1.5 text-sm bg-[#1FAC99]/10 text-[#1D433F] rounded-md hover:bg-[#1FAC99]/20 transition font-cg">
                                            View Product
                                            <svg class="w-4 h-4 ml-1" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                                                <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M9 5l7 7-7 7"/>
                                            </svg>
                                        </a>
                                    </div>
                                </div>
                            </div>
                        @endforeach
                    </div>
                @else
                    <div class="px-6 py-12 text-center">
                        <svg class="mx-auto h-16 w-16 text-gray-400" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                            <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M20 7l-8-4-8 4m16 0l-8 4m8-4v10l-8 4m0-10L4 7m8 4v10M4 7v10l8 4"/>
                        </svg>
                        <h3 class="mt-4 text-sm font-semibold text-gray-900 font-cg">No products yet</h3>
                        <p class="mt-2 text-sm text-gray-500 font-cg">Add products to this collection to get started.</p>
                        <div class="mt-6">
                            <a href="{{ route('admin.collections.edit', $collection->id) }}"
                               class="inline-flex items-center px-4 py-2 bg-[#1FAC99] text-white text-sm rounded-lg font-cg hover:bg-[#1D433F] transition">
                                <svg class="w-5 h-5 mr-2" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                                    <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M12 6v6m0 0v6m0-6h6m-6 0H6"/>
                                </svg>
                                Add Products
                            </a>
                        </div>
                    </div>
                @endif
            </div>
        </div>

        <!-- Sidebar -->
        <div class="space-y-6">
            <!-- Metadata Card -->
            <div class="bg-white rounded-lg shadow-sm border border-gray-100 overflow-hidden">
                <div class="px-6 py-4 border-b border-gray-100 bg-gradient-to-r from-gray-50 to-white">
                    <h3 class="text-lg font-semibold text-[#1D433F] font-lora">Information</h3>
                </div>
                <div class="p-6 space-y-4">
                    <div>
                        <p class="text-xs font-semibold text-gray-500 uppercase tracking-wider font-cg mb-1">Status</p>
                        <p class="text-sm font-medium text-gray-900 font-cg">
                            @if($collection->is_active)
                                <span class="inline-flex items-center px-2.5 py-1 bg-green-100 text-green-800 text-xs font-semibold rounded-full">
                                    <svg class="w-3 h-3 mr-1" fill="currentColor" viewBox="0 0 20 20">
                                        <path fill-rule="evenodd" d="M10 18a8 8 0 100-16 8 8 0 000 16zm3.707-9.293a1 1 0 00-1.414-1.414L9 10.586 7.707 9.293a1 1 0 00-1.414 1.414l2 2a1 1 0 001.414 0l4-4z" clip-rule="evenodd"/>
                                    </svg>
                                    Active
                                </span>
                            @else
                                <span class="inline-flex items-center px-2.5 py-1 bg-gray-100 text-gray-800 text-xs font-semibold rounded-full">
                                    <svg class="w-3 h-3 mr-1" fill="currentColor" viewBox="0 0 20 20">
                                        <path fill-rule="evenodd" d="M10 18a8 8 0 100-16 8 8 0 000 16zM8.707 7.293a1 1 0 00-1.414 1.414L8.586 10l-1.293 1.293a1 1 0 101.414 1.414L10 11.414l1.293 1.293a1 1 0 001.414-1.414L11.414 10l1.293-1.293a1 1 0 00-1.414-1.414L10 8.586 8.707 7.293z" clip-rule="evenodd"/>
                                    </svg>
                                    Inactive
                                </span>
                            @endif
                        </p>
                    </div>

                    <div class="border-t border-gray-100 pt-4">
                        <p class="text-xs font-semibold text-gray-500 uppercase tracking-wider font-cg mb-1">Created</p>
                        <p class="text-sm text-gray-900 font-cg">{{ $collection->created_at->format('M d, Y h:i A') }}</p>
                    </div>

                    <div class="border-t border-gray-100 pt-4">
                        <p class="text-xs font-semibold text-gray-500 uppercase tracking-wider font-cg mb-1">Last Updated</p>
                        <p class="text-sm text-gray-900 font-cg">{{ $collection->updated_at->format('M d, Y h:i A') }}</p>
                    </div>

                    <div class="border-t border-gray-100 pt-4">
                        <p class="text-xs font-semibold text-gray-500 uppercase tracking-wider font-cg mb-1">Display Order</p>
                        <p class="text-sm text-gray-900 font-cg">{{ $collection->sort_order ?? 'Not set' }}</p>
                    </div>

                    <div class="border-t border-gray-100 pt-4">
                        <p class="text-xs font-semibold text-gray-500 uppercase tracking-wider font-cg mb-1">URL Slug</p>
                        <p class="text-sm text-gray-900 font-cg font-mono bg-gray-50 px-2 py-1 rounded">{{ $collection->slug }}</p>
                    </div>
                </div>
            </div>

            <!-- Quick Actions Card -->
            <div class="bg-white rounded-lg shadow-sm border border-gray-100 overflow-hidden">
                <div class="px-6 py-4 border-b border-gray-100 bg-gradient-to-r from-gray-50 to-white">
                    <h3 class="text-lg font-semibold text-[#1D433F] font-lora">Quick Actions</h3>
                </div>
                <div class="p-4 space-y-2">
                    <a href="{{ route('admin.collections.edit', $collection->id) }}"
                       class="flex items-center w-full px-4 py-3 text-sm text-gray-700 bg-gray-50 rounded-lg hover:bg-gray-100 transition font-cg">
                        <svg class="w-5 h-5 mr-3 text-[#1FAC99]" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                            <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M11 5H6a2 2 0 00-2 2v11a2 2 0 002 2h11a2 2 0 002-2v-5m-1.414-9.414a2 2 0 112.828 2.828L11.828 15H9v-2.828l8.586-8.586z"/>
                        </svg>
                        Edit Collection
                    </a>
                    
                    <a href="{{ route('admin.products.create') }}"
                       class="flex items-center w-full px-4 py-3 text-sm text-gray-700 bg-gray-50 rounded-lg hover:bg-gray-100 transition font-cg">
                        <svg class="w-5 h-5 mr-3 text-[#1FAC99]" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                            <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M12 6v6m0 0v6m0-6h6m-6 0H6"/>
                        </svg>
                        Add New Product
                    </a>

                    <a href="{{ route('admin.collections.index') }}"
                       class="flex items-center w-full px-4 py-3 text-sm text-gray-700 bg-gray-50 rounded-lg hover:bg-gray-100 transition font-cg">
                        <svg class="w-5 h-5 mr-3 text-[#1FAC99]" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                            <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M19 11H5m14 0a2 2 0 012 2v6a2 2 0 01-2 2H5a2 2 0 01-2-2v-6a2 2 0 012-2m14 0V9a2 2 0 00-2-2M5 11V9a2 2 0 012-2m0 0V5a2 2 0 012-2h6a2 2 0 012 2v2M7 7h10"/>
                        </svg>
                        All Collections
                    </a>

                    <form action="{{ route('admin.collections.destroy', $collection->id) }}" method="POST" 
                          onsubmit="return confirm('Are you sure you want to delete this collection?');"
                          class="w-full">
                        @csrf
                        @method('DELETE')
                        <button type="submit"
                                class="flex items-center w-full px-4 py-3 text-sm text-red-700 bg-red-50 rounded-lg hover:bg-red-100 transition font-cg">
                            <svg class="w-5 h-5 mr-3" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                                <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M19 7l-.867 12.142A2 2 0 0116.138 21H7.862a2 2 0 01-1.995-1.858L5 7m5 4v6m4-6v6m1-10V4a1 1 0 00-1-1h-4a1 1 0 00-1 1v3M4 7h16"/>
                            </svg>
                            Delete Collection
                        </button>
                    </form>
                </div>
            </div>
        </div>
    </div>
</div>
@endsection