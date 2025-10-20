@extends('layouts.app')
@section('title', $category->name . ' | Jauxsh')

@section('content')
<div class="w-full">
    <!-- Breadcrumb -->
    <div class="py-4 border-b border-gray-200">
        <div class="container mx-auto px-6 md:px-12 lg:px-20 max-w-7xl">
            <nav class="flex items-center space-x-2 text-xs font-cg uppercase tracking-wide">
                <a href="{{ route('home') }}" class="text-gray-600 hover:text-gray-900 transition-colors">Home</a>
                <span class="text-gray-400">/</span>
                <a href="{{ route('shop.index') }}" class="text-gray-600 hover:text-gray-900 transition-colors">Shop</a>
                <span class="text-gray-400">/</span>
                <span class="text-gray-900 font-semibold">{{ $category->name }}</span>
            </nav>
        </div>
    </div>

    <!-- Category Header -->
    <div class="container mx-auto px-6 md:px-12 lg:px-20 max-w-7xl py-12">
        <div class="text-center mb-12">
            <h1 class="font-cg text-4xl md:text-5xl font-bold tracking-tight uppercase text-gray-900 mb-4">
                {{ $category->name }}
            </h1>
            @if($category->description)
            <p class="font-lora text-lg text-gray-600 max-w-2xl mx-auto">
                {{ $category->description }}
            </p>
            @endif
            <p class="font-cg text-sm text-gray-500 mt-4 uppercase tracking-wider">
                {{ $productCount }} {{ Str::plural('Product', $productCount) }} Found
            </p>
        </div>

        <!-- Filters and Sort Section -->
        <div class=" rounded-sm border border-gray-200 p-6 mb-8">
            <form method="GET" action="{{ route('categories.show', $category->slug ?? $category->id) }}" class="space-y-6">
                <!-- Top Row: Search and Category -->
                <div class="grid grid-cols-1 md:grid-cols-2 gap-4">
                    <!-- Search -->
                    <div>
                        <label class="block text-xs font-bold uppercase tracking-widest text-gray-900 mb-2 font-cg">
                            Search Products
                        </label>
                        <input type="text" 
                               name="search" 
                               value="{{ request('search') }}"
                               placeholder="Search in {{ $category->name }}..."
                               class="w-full px-4 py-2.5 border border-gray-300 rounded-sm focus:ring-2 focus:ring-[#1D433F] focus:border-transparent font-lora">
                    </div>

                    <!-- Category Switch -->
                    <div>
                        <label class="block text-xs font-bold uppercase tracking-widest text-gray-900 mb-2 font-cg">
                            Browse Category
                        </label>
                        <select onchange="window.location.href=this.value" 
                                class="w-full px-4 py-2.5 border border-gray-300 rounded-sm focus:ring-2 focus:ring-[#1D433F] focus:border-transparent font-lora">
                            @foreach($allCategories as $cat)
                            <option value="{{ route('categories.show', $cat->slug ?? $cat->id) }}" 
                                    {{ $cat->id == $category->id ? 'selected' : '' }}>
                                {{ $cat->name }}
                            </option>
                            @endforeach
                        </select>
                    </div>
                </div>

                <!-- Second Row: Price Range and Stock -->
                <div class="grid grid-cols-1 md:grid-cols-3 gap-4">
                    <!-- Min Price -->
                    <div>
                        <label class="block text-xs font-bold uppercase tracking-widest text-gray-900 mb-2 font-cg">
                            Min Price
                        </label>
                        <input type="number" 
                               name="min_price" 
                               value="{{ request('min_price') }}"
                               placeholder="₱0"
                               min="0"
                               step="0.01"
                               class="w-full px-4 py-2.5 border border-gray-300 rounded-sm focus:ring-2 focus:ring-[#1D433F] focus:border-transparent font-lora">
                    </div>

                    <!-- Max Price -->
                    <div>
                        <label class="block text-xs font-bold uppercase tracking-widest text-gray-900 mb-2 font-cg">
                            Max Price
                        </label>
                        <input type="number" 
                               name="max_price" 
                               value="{{ request('max_price') }}"
                               placeholder="₱10000"
                               min="0"
                               step="0.01"
                               class="w-full px-4 py-2.5 border border-gray-300 rounded-sm focus:ring-2 focus:ring-[#1D433F] focus:border-transparent font-lora">
                    </div>

                    <!-- Stock Filter -->
                    <div>
                        <label class="block text-xs font-bold uppercase tracking-widest text-gray-900 mb-2 font-cg">
                            Availability
                        </label>
                        <select name="stock" 
                                class="w-full px-4 py-2.5 border border-gray-300 rounded-sm focus:ring-2 focus:ring-[#1D433F] focus:border-transparent font-lora">
                            <option value="">All Products</option>
                            <option value="in_stock" {{ request('stock') == 'in_stock' ? 'selected' : '' }}>In Stock</option>
                            <option value="out_of_stock" {{ request('stock') == 'out_of_stock' ? 'selected' : '' }}>Out of Stock</option>
                        </select>
                    </div>
                </div>

                <!-- Third Row: Sort and Buttons -->
                <div class="flex flex-col md:flex-row gap-4 items-end">
                    <!-- Sort By -->
                    <div class="flex-1">
                        <label class="block text-xs font-bold uppercase tracking-widest text-gray-900 mb-2 font-cg">
                            Sort By
                        </label>
                        <select name="sort" 
                                class="w-full px-4 py-2.5 border border-gray-300 rounded-sm focus:ring-2 focus:ring-[#1D433F] focus:border-transparent font-lora">
                            <option value="name" {{ request('sort') == 'name' ? 'selected' : '' }}>Name (A-Z)</option>
                            <option value="price_low" {{ request('sort') == 'price_low' ? 'selected' : '' }}>Price: Low to High</option>
                            <option value="price_high" {{ request('sort') == 'price_high' ? 'selected' : '' }}>Price: High to Low</option>
                            <option value="newest" {{ request('sort') == 'newest' ? 'selected' : '' }}>Newest First</option>
                            <option value="oldest" {{ request('sort') == 'oldest' ? 'selected' : '' }}>Oldest First</option>
                        </select>
                    </div>

                    <!-- Action Buttons -->
                    <div class="flex gap-3">
                        <button type="submit" 
                                class="px-6 py-2.5 bg-gray-900 text-white font-cg font-semibold rounded-sm hover:bg-[#1D433F] transition-all duration-300">
                            Apply Filters
                        </button>
                        <a href="{{ route('categories.show', $category->slug ?? $category->id) }}" 
                           class="px-6 py-2.5 bg-white border-2 border-gray-300 text-gray-700 font-cg font-semibold rounded-sm hover:bg-gray-50 transition-all duration-300">
                            Clear All
                        </a>
                    </div>
                </div>
            </form>
        </div>

        <!-- Products Grid -->
        @if($products->count() > 0)
        <div class="grid grid-cols-1 sm:grid-cols-2 lg:grid-cols-3 xl:grid-cols-4 gap-6 mb-12">
            @foreach($products as $product)
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
                    <div class="w-full h-full flex items-center justify-center bg-gray-100">
                        <svg class="w-20 h-20 text-gray-300" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                            <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M4 16l4.586-4.586a2 2 0 012.828 0L16 16m-2-2l1.586-1.586a2 2 0 012.828 0L20 14m-6-6h.01M6 20h12a2 2 0 002-2V6a2 2 0 00-2-2H6a2 2 0 00-2 2v12a2 2 0 002 2z"/>
                        </svg>
                    </div>
                    @endif

                    <!-- Stock Badge -->
                    @if($product->has_variants)
                        <div class="absolute top-3 right-3 bg-[#1FAC99] text-white text-xs font-semibold font-cg px-3 py-1 rounded-full">
                            Available
                        </div>
                    @else
                        @if($product->stock <= 0)
                        <div class="absolute top-3 right-3 bg-red-600 text-white text-xs font-semibold font-cg px-3 py-1 rounded-full">
                            Out of Stock
                        </div>
                        @elseif($product->stock <= 10)
                        <div class="absolute top-3 right-3 bg-yellow-500 text-white text-xs font-semibold font-cg px-3 py-1 rounded-full">
                            Low Stock
                        </div>
                        @endif
                    @endif
                </div>

                <!-- Product Info -->
                <div class="p-4">
                    <h3 class="font-lora text-base text-gray-900 mb-2 group-hover:text-[#1D433F] transition-colors line-clamp-2 font-medium min-h-[3rem]">
                        {{ $product->name }}
                    </h3>
                    <div class="flex items-center justify-between">
                        <p class="font-lora text-xl font-semibold text-gray-900">
                            ₱{{ number_format($product->price, 2) }}
                        </p>
                        @if(!$product->has_variants && $product->stock > 0)
                        <span class="text-xs text-green-600 font-cg font-semibold">In Stock</span>
                        @endif
                    </div>
                </div>
            </a>
            @endforeach
        </div>

        <!-- Pagination -->
        @if($products->hasPages())
        <div class="flex justify-center">
            {{ $products->links() }}
        </div>
        @endif

        @else
        <!-- No Products Found -->
        <div class="text-center py-20">
            <svg class="mx-auto h-24 w-24 text-gray-300 mb-6" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M20 13V6a2 2 0 00-2-2H6a2 2 0 00-2 2v7m16 0v5a2 2 0 01-2 2H6a2 2 0 01-2-2v-5m16 0h-2.586a1 1 0 00-.707.293l-2.414 2.414a1 1 0 01-.707.293h-3.172a1 1 0 01-.707-.293l-2.414-2.414A1 1 0 006.586 13H4"/>
            </svg>
            <h3 class="font-cg text-2xl font-bold text-gray-900 uppercase mb-2">No Products Found</h3>
            <p class="font-lora text-gray-600 mb-6">
                Try adjusting your filters or browse other categories
            </p>
            <a href="{{ route('categories.show', $category->slug ?? $category->id) }}" 
               class="inline-block px-8 py-3 bg-gray-900 text-white font-cg font-semibold rounded-sm hover:bg-[#1D433F] transition-all duration-300">
                Clear Filters
            </a>
        </div>
        @endif
    </div>

    <!-- Other Categories Section -->
    @if($allCategories->count() > 1)
    <div class=" py-16 border-t border-gray-200">
        <div class="container mx-auto px-6 md:px-12 lg:px-20 max-w-7xl">
            <h2 class="font-cg text-3xl md:text-4xl font-bold tracking-tight uppercase text-gray-900 mb-10 text-center">
                Browse Other Categories
            </h2>
            <div class="grid grid-cols-2 md:grid-cols-3 lg:grid-cols-4 gap-4">
                @foreach($allCategories as $cat)
                    @if($cat->id != $category->id)
                    <a href="{{ route('categories.show', $cat->slug ?? $cat->id) }}" 
                       class="bg-white p-6 rounded-sm border border-gray-200 hover:border-[#1D433F] hover:shadow-lg transition-all duration-300 text-center group">
                        <h3 class="font-cg font-bold text-lg uppercase text-gray-900 group-hover:text-[#1D433F] transition-colors">
                            {{ $cat->name }}
                        </h3>
                        <p class="font-lora text-sm text-gray-600 mt-2">
                            {{ $cat->products_count ?? 0 }} products
                        </p>
                    </a>
                    @endif
                @endforeach
            </div>
        </div>
    </div>
    @endif
</div>
@endsection