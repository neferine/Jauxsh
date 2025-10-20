@extends('layouts.app')
@section('title', 'Shop by Category | Jauxsh')

@section('content')
<div class="w-full">
    <!-- Breadcrumb -->
    <div class="py-4 border-b border-gray-200">
        <div class="container mx-auto px-6 md:px-12 lg:px-20 max-w-7xl">
            <nav class="flex items-center space-x-2 text-xs font-cg uppercase tracking-wide">
                <a href="{{ route('home') }}" class="text-gray-600 hover:text-gray-900 transition-colors">Home</a>
                <span class="text-gray-400">/</span>
                <span class="text-gray-900 font-semibold">Categories</span>
            </nav>
        </div>
    </div>

    <!-- Page Header -->
    <div class="container mx-auto px-6 md:px-12 lg:px-20 max-w-7xl py-16">
        <div class="text-center mb-16">
            <h1 class="font-cg text-4xl md:text-6xl font-bold tracking-tight uppercase text-gray-900 mb-4">
                Shop by Category
            </h1>
            <p class="font-lora text-lg text-gray-600 max-w-2xl mx-auto">
                Explore our curated collections and find exactly what you're looking for
            </p>
        </div>

        <!-- Categories Grid -->
        @if($categories->count() > 0)
        <div class="grid grid-cols-1 sm:grid-cols-2 lg:grid-cols-3 gap-8">
            @foreach($categories as $category)
            <a href="{{ route('categories.show', $category->slug ?? $category->id) }}" 
               class="group bg-white rounded-sm border-2 border-gray-200 overflow-hidden hover:border-[#1D433F] hover:shadow-2xl transition-all duration-300">
                <!-- Category Image/Icon -->
                <div class="aspect-[4/3] bg-gradient-to-br from-[#1D433F] to-[#1FAC99] flex items-center justify-center relative overflow-hidden">
                    @if($category->image)
                    <img src="{{ asset('storage/' . $category->image) }}" 
                         alt="{{ $category->name }}" 
                         class="w-full h-full object-cover group-hover:scale-110 transition-transform duration-500">
                    @else
                    <div class="text-white">
                        <svg class="w-24 h-24 opacity-80 group-hover:opacity-100 transition-opacity" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                            <path stroke-linecap="round" stroke-linejoin="round" stroke-width="1.5" d="M7 7h.01M7 3h5c.512 0 1.024.195 1.414.586l7 7a2 2 0 010 2.828l-7 7a2 2 0 01-2.828 0l-7-7A1.994 1.994 0 013 12V7a4 4 0 014-4z"/>
                        </svg>
                    </div>
                    @endif
                    
                    <!-- Product Count Badge -->
                    <div class="absolute top-4 right-4 bg-white text-gray-900 px-4 py-2 rounded-full font-cg font-bold text-sm shadow-lg">
                        {{ $category->products_count }} {{ Str::plural('item', $category->products_count) }}
                    </div>
                </div>

                <!-- Category Info -->
                <div class="p-6">
                    <h2 class="font-cg text-2xl font-bold uppercase text-gray-900 mb-2 group-hover:text-[#1D433F] transition-colors">
                        {{ $category->name }}
                    </h2>
                    @if($category->description)
                    <p class="font-lora text-gray-600 text-sm mb-4 line-clamp-2">
                        {{ $category->description }}
                    </p>
                    @endif
                    <div class="flex items-center text-[#1FAC99] font-cg font-semibold text-sm uppercase group-hover:text-[#1D433F] transition-colors">
                        Shop Now
                        <svg class="w-4 h-4 ml-2 group-hover:translate-x-1 transition-transform" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                            <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M9 5l7 7-7 7"/>
                        </svg>
                    </div>
                </div>
            </a>
            @endforeach
        </div>
        @else
        <!-- No Categories -->
        <div class="text-center py-20">
            <svg class="mx-auto h-24 w-24 text-gray-300 mb-6" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M7 7h.01M7 3h5c.512 0 1.024.195 1.414.586l7 7a2 2 0 010 2.828l-7 7a2 2 0 01-2.828 0l-7-7A1.994 1.994 0 013 12V7a4 4 0 014-4z"/>
            </svg>
            <h3 class="font-cg text-2xl font-bold text-gray-900 uppercase mb-2">No Categories Available</h3>
            <p class="font-lora text-gray-600">
                Check back soon for new categories
            </p>
        </div>
        @endif
    </div>

    <!-- Call to Action -->
    <div class="bg-[#1D433F] py-16">
        <div class="container mx-auto px-6 md:px-12 lg:px-20 max-w-7xl text-center">
            <h2 class="font-cg text-3xl md:text-4xl font-bold uppercase text-white mb-4">
                Can't Find What You're Looking For?
            </h2>
            <p class="font-lora text-lg text-gray-300 mb-8 max-w-2xl mx-auto">
                Browse all our products or get in touch with our team for personalized recommendations
            </p>
            <div class="flex flex-col sm:flex-row gap-4 justify-center">
                <a href="{{ route('products.index') }}" 
                   class="px-8 py-4 bg-white text-[#1D433F] font-cg font-semibold rounded-sm hover:bg-gray-100 transition-all duration-300">
                    View All Products
                </a>
                <a href="{{ route('contact') }}" 
                   class="px-8 py-4 bg-[#1FAC99] text-white font-cg font-semibold rounded-sm hover:bg-opacity-90 transition-all duration-300">
                    Contact Us
                </a>
            </div>
        </div>
    </div>
</div>
@endsection