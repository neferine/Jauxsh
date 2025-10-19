
@extends('layouts.app')

@section('title', $collection->name)

@section('content')
<div class="max-w-7xl mx-auto py-12">
    
    <!-- Collection Header -->
    <div class="mb-12">
        @if($collection->image_url)
        <div class="relative h-64 md:h-96 rounded-2xl overflow-hidden mb-8">
            <img src="{{ asset('storage/' . $collection->image_url) }}" 
                 alt="{{ $collection->name }}"
                 class="w-full h-full object-cover">
            <div class="absolute inset-0 bg-gradient-to-t from-black/70 via-black/30 to-transparent"></div>
            <div class="absolute bottom-0 left-0 right-0 p-8 text-white">
                <h1 class="text-4xl md:text-5xl font-bold font-pf mb-3">
                    {{ $collection->name }}
                </h1>
                @if($collection->description)
                <p class="text-lg max-w-3xl">
                    {{ $collection->description }}
                </p>
                @endif
            </div>
        </div>
        @else
        <div class="text-center mb-8">
            <h1 class="text-4xl md:text-5xl font-bold text-gray-900 font-pf mb-3">
                {{ $collection->name }}
            </h1>
            @if($collection->description)
            <p class="text-gray-600 text-lg max-w-3xl mx-auto">
                {{ $collection->description }}
            </p>
            @endif
        </div>
        @endif

        <div class="flex items-center justify-between">
            <p class="text-gray-600">
                {{ $products->total() }} {{ Str::plural('product', $products->total()) }}
            </p>
        </div>
    </div>

    <!-- Products Grid -->
    <div class="grid grid-cols-2 md:grid-cols-3 lg:grid-cols-4 gap-6">
        @forelse($products as $product)
        <div class="group">
            <a href="{{ route('products.show', $product->id) }}" 
               class="block">
                
                <!-- Product Image -->
                <div class="aspect-square bg-gray-100 rounded-lg overflow-hidden mb-3">
                    @if($product->primary_image)
                        <img src="{{ $product->primary_image->url }}" 
                             alt="{{ $product->name }}"
                             class="w-full h-full object-cover group-hover:scale-110 transition-transform duration-300">
                    @else
                        <div class="w-full h-full flex items-center justify-center text-gray-400">
                            No Image
                        </div>
                    @endif
                </div>

                <!-- Product Info -->
                <div>
                    <h3 class="font-semibold text-gray-900 group-hover:text-[#4d9b91] transition-colors line-clamp-2">
                        {{ $product->name }}
                    </h3>
                    <p class="text-[#4d9b91] font-bold mt-1">
                        ₱{{ number_format($product->price, 2) }}
                    </p>

                    <!-- Available colors -->
                    @if($product->has_variants && $product->available_colors->isNotEmpty())
                    <div class="flex gap-1 mt-2">
                        @foreach($product->available_colors->take(5) as $color)
                        <span class="w-4 h-4 rounded-full border border-gray-300" 
                              style="background-color: {{ $color->color_hex ?? '#ccc' }}"
                              title="{{ $color->color }}"></span>
                        @endforeach
                        @if($product->available_colors->count() > 5)
                        <span class="text-xs text-gray-500 ml-1">+{{ $product->available_colors->count() - 5 }}</span>
                        @endif
                    </div>
                    @endif
                </div>
            </a>
        </div>
        @empty
        <div class="col-span-full text-center py-12">
            <p class="text-gray-500 text-lg">No products in this collection yet.</p>
        </div>
        @endforelse
    </div>

    <!-- Pagination -->
    @if($products->hasPages())
    <div class="mt-12">
        {{ $products->links() }}
    </div>
    @endif
</div>
@endsection