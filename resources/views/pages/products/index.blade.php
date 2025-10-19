@extends('layouts.app')
@section('title', 'Shop | Jauxsh')

@section('content')
<div class="w-full pt-20">
    <!-- Header Section -->
    <div class=" py-16 ">
        <div class="container mx-auto px-6 md:px-12 lg:px-20 max-w-7xl">
            <h1 class="font-cg text-5xl md:text-6xl font-bold tracking-tight uppercase text-gray-900 mb-4">
                Shop
            </h1>
            <p class="text-gray-600 text-lg font-lora max-w-2xl">
                Discover our collection of handcrafted apparel. Each piece is designed with care and built to last.
            </p>
        </div>
    </div>

    <!-- Main Content -->
    <div class="container mx-auto px-6 md:px-12 lg:px-20 max-w-7xl py-12">
        <div class="flex flex-col lg:flex-row gap-8">
            <!-- Sidebar Filters -->
            <aside class="lg:w-64 flex-shrink-0">
                <div class="rounded-sm border border-gray-200 p-6 sticky top-6">
                    <!-- Categories Filter -->
                    <div class="mb-8">
                        <h3 class="font-cg text-sm font-bold uppercase tracking-wider text-gray-900 mb-4">
                            Categories
                        </h3>
                        <form method="GET" action="{{ route('products.index') }}" id="filterForm">
                            <div class="space-y-3">
                                <label class="flex items-center cursor-pointer group">
                                    <input type="radio" name="category" value="" 
                                           {{ request('category') == '' ? 'checked' : '' }}
                                           onchange="document.getElementById('filterForm').submit()"
                                           class="w-4 h-4 text-gray-900 border-gray-300 focus:ring-gray-900">
                                    <span class="ml-3 text-sm font-lora text-gray-700 group-hover:text-gray-900">All Products</span>
                                </label>
                                @foreach($categories as $category)
                                <label class="flex items-center cursor-pointer group">
                                    <input type="radio" name="category" value="{{ $category->id }}" 
                                           {{ request('category') == $category->id ? 'checked' : '' }}
                                           onchange="document.getElementById('filterForm').submit()"
                                           class="w-4 h-4 text-gray-900 border-gray-300 focus:ring-gray-900">
                                    <span class="ml-3 text-sm font-lora text-gray-700 group-hover:text-gray-900">{{ $category->name }}</span>
                                </label>
                                @endforeach
                            </div>
                        </form>
                    </div>

                    <!-- Price Filter -->
                    <div class="mb-8 pt-8 border-t border-gray-200">
                        <h3 class="font-cg text-sm font-bold uppercase tracking-wider text-gray-900 mb-4">
                            Price Range
                        </h3>
                        <form method="GET" action="{{ route('products.index') }}">
                            <input type="hidden" name="category" value="{{ request('category') }}">
                            <div class="space-y-3">
                                <label class="flex items-center cursor-pointer group">
                                    <input type="radio" name="price" value="" 
                                           {{ request('price') == '' ? 'checked' : '' }}
                                           onchange="this.form.submit()"
                                           class="w-4 h-4 text-gray-900 border-gray-300 focus:ring-gray-900">
                                    <span class="ml-3 text-sm font-lora text-gray-700 group-hover:text-gray-900">All Prices</span>
                                </label>
                                <label class="flex items-center cursor-pointer group">
                                    <input type="radio" name="price" value="0-50" 
                                           {{ request('price') == '0-50' ? 'checked' : '' }}
                                           onchange="this.form.submit()"
                                           class="w-4 h-4 text-gray-900 border-gray-300 focus:ring-gray-900">
                                    <span class="ml-3 text-sm font-lora text-gray-700 group-hover:text-gray-900">Under $50</span>
                                </label>
                                <label class="flex items-center cursor-pointer group">
                                    <input type="radio" name="price" value="50-100" 
                                           {{ request('price') == '50-100' ? 'checked' : '' }}
                                           onchange="this.form.submit()"
                                           class="w-4 h-4 text-gray-900 border-gray-300 focus:ring-gray-900">
                                    <span class="ml-3 text-sm font-lora text-gray-700 group-hover:text-gray-900">$50 - $100</span>
                                </label>
                                <label class="flex items-center cursor-pointer group">
                                    <input type="radio" name="price" value="100-150" 
                                           {{ request('price') == '100-150' ? 'checked' : '' }}
                                           onchange="this.form.submit()"
                                           class="w-4 h-4 text-gray-900 border-gray-300 focus:ring-gray-900">
                                    <span class="ml-3 text-sm font-lora text-gray-700 group-hover:text-gray-900">$100 - $150</span>
                                </label>
                                <label class="flex items-center cursor-pointer group">
                                    <input type="radio" name="price" value="150+" 
                                           {{ request('price') == '150+' ? 'checked' : '' }}
                                           onchange="this.form.submit()"
                                           class="w-4 h-4 text-gray-900 border-gray-300 focus:ring-gray-900">
                                    <span class="ml-3 text-sm font-lora text-gray-700 group-hover:text-gray-900">$150+</span>
                                </label>
                            </div>
                        </form>
                    </div>

                    <!-- Availability Filter -->
                    <div class="pt-8 border-t border-gray-200">
                        <h3 class="font-cg text-sm font-bold uppercase tracking-wider text-gray-900 mb-4">
                            Availability
                        </h3>
                        <form method="GET" action="{{ route('products.index') }}">
                            <input type="hidden" name="category" value="{{ request('category') }}">
                            <input type="hidden" name="price" value="{{ request('price') }}">
                            <label class="flex items-center cursor-pointer group">
                                <input type="checkbox" name="in_stock" value="1" 
                                       {{ request('in_stock') ? 'checked' : '' }}
                                       onchange="this.form.submit()"
                                       class="w-4 h-4 text-gray-900 border-gray-300 rounded focus:ring-gray-900">
                                <span class="ml-3 text-sm font-lora text-gray-700 group-hover:text-gray-900">In Stock Only</span>
                            </label>
                        </form>
                    </div>
                </div>
            </aside>

            <!-- Products Grid -->
            <div class="flex-1">
                <!-- Sort & Results Header -->
                <div class="flex items-center justify-between mb-8">
                    <p class="text-sm text-gray-600 font-cg">
                        <span class="font-semibold text-gray-900">{{ $products->total() }}</span> products found
                    </p>
                    <form method="GET" action="{{ route('products.index') }}" class="flex items-center gap-2">
                        <input type="hidden" name="category" value="{{ request('category') }}">
                        <input type="hidden" name="price" value="{{ request('price') }}">
                        <input type="hidden" name="in_stock" value="{{ request('in_stock') }}">
                        <label class="text-sm text-gray-600 font-cg">Sort by:</label>
                        <select name="sort" onchange="this.form.submit()" 
                                class="text-sm border-gray-300 rounded-md font-lora focus:ring-gray-900 focus:border-gray-900">
                            <option value="newest" {{ request('sort') == 'newest' ? 'selected' : '' }}>Newest</option>
                            <option value="price_low" {{ request('sort') == 'price_low' ? 'selected' : '' }}>Price: Low to High</option>
                            <option value="price_high" {{ request('sort') == 'price_high' ? 'selected' : '' }}>Price: High to Low</option>
                            <option value="name" {{ request('sort') == 'name' ? 'selected' : '' }}>Name: A-Z</option>
                        </select>
                    </form>
                </div>

                <!-- Product Grid -->
                <div class="grid grid-cols-1 sm:grid-cols-2 lg:grid-cols-3 gap-6 mb-12">
                    @forelse($products as $product)
                    <a href="{{ route('products.show', $product->id) }}" 
                       class="bg-white rounded-sm border border-gray-200 overflow-hidden group cursor-pointer hover:shadow-xl hover:border-gray-300 transition-all duration-300">
                        <!-- Product Image -->
                        <div class="aspect-square bg-gray-100 overflow-hidden relative">
                            @if($product->images->count() > 0)
                            <img src="{{ asset('storage/' . $product->images->first()->image_url) }}" 
                                 loading="lazy" 
                                 alt="{{ $product->name }}" 
                                 class="w-full h-full object-cover group-hover:scale-105 transition-transform duration-500">
                            @else
                            <div class="w-full h-full flex items-center justify-center">
                                <svg class="w-20 h-20 text-gray-300" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                                    <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M4 16l4.586-4.586a2 2 0 012.828 0L16 16m-2-2l1.586-1.586a2 2 0 012.828 0L20 14m-6-6h.01M6 20h12a2 2 0 002-2V6a2 2 0 00-2-2H6a2 2 0 00-2 2v12a2 2 0 002 2z"/>
                                </svg>
                            </div>
                            @endif
                            
                            <!-- Stock Badge -->
                            @if($product->stock <= 0)
                            <div class="absolute top-3 right-3 bg-red-600 text-white text-xs font-cg px-3 py-1 rounded-full">
                                Out of Stock
                            </div>
                            @elseif($product->stock <= 10)
                            <div class="absolute top-3 right-3 bg-yellow-500 text-white text-xs font-cg px-3 py-1 rounded-full">
                                Low Stock
                            </div>
                            @endif
                        </div>
                        
                        <!-- Product Info -->
                        <div class="p-5">
                            @if($product->category)
                            <p class="text-xs text-gray-500 font-cg uppercase tracking-wider mb-2">
                                {{ $product->category->name }}
                            </p>
                            @endif
                            <h3 class="font-lora text-base text-gray-900 mb-2 group-hover:text-gray-600 transition-colors line-clamp-2">
                                {{ $product->name }}
                            </h3>
                            <div class="flex items-center justify-between">
                               <p class="font-lora text-lg font-semibold text-gray-900 price-display" data-original-price="{{ $product->price }}">
                                    ${{ number_format($product->price, 2) }}
                                </p>
                                <span class="text-xs text-gray-500 font-cg">
                                    {{ $product->stock }} in stock
                                </span>
                            </div>
                        </div>
                    </a>
                    @empty
                    <div class="col-span-full text-center py-20">
                        <svg class="mx-auto h-16 w-16 text-gray-300 mb-4" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                            <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M20 13V6a2 2 0 00-2-2H6a2 2 0 00-2 2v7m16 0v5a2 2 0 01-2 2H6a2 2 0 01-2-2v-5m16 0h-2.586a1 1 0 00-.707.293l-2.414 2.414a1 1 0 01-.707.293h-3.172a1 1 0 01-.707-.293l-2.414-2.414A1 1 0 006.586 13H4"/>
                        </svg>
                        <h3 class="text-xl font-medium text-gray-900 font-lora mb-2">No products found</h3>
                        <p class="text-gray-500 font-cg mb-6">Try adjusting your filters or search criteria</p>
                        <a href="{{ route('products.index') }}" 
                           class="inline-block px-6 py-2 font-lora text-sm text-gray-900 border-2 border-gray-900 rounded-full hover:bg-gray-900 hover:text-white transition-all duration-300">
                            Clear Filters
                        </a>
                    </div>
                    @endforelse
                </div>

                <!-- Pagination -->
                @if($products->hasPages())
                <div class="flex justify-center">
                    {{ $products->appends(request()->query())->links() }}
                </div>
                @endif
            </div>
        </div>
    </div>
</div>
@endsection