@extends('layouts.app')

@section('title', 'Collections')

@section('content')
<div class="max-w-7xl mx-auto py-12">
    <div class="text-center mb-12">
        <h1 class="text-4xl md:text-5xl font-bold text-gray-900 font-pf mb-4">
            Our Collections
        </h1>
        <p class="text-gray-600 max-w-2xl mx-auto">
            Explore our curated collections of premium clothing
        </p>
    </div>

    <div class="grid grid-cols-1 md:grid-cols-2 lg:grid-cols-3 gap-8">
        @forelse($collections as $collection)
        <a href="{{ route('collections.show', $collection->slug) }}" 
           class="group relative overflow-hidden rounded-2xl bg-white shadow-lg hover:shadow-2xl transition-all duration-300">
            
            <!-- Collection Image -->
            <div class="aspect-[4/3] overflow-hidden bg-gray-100">
                @if($collection->image_url)
                    <img src="{{ asset('storage/' . $collection->image_url) }}" 
                         alt="{{ $collection->name }}"
                         class="w-full h-full object-cover group-hover:scale-110 transition-transform duration-500">
                @else
                    <div class="w-full h-full flex items-center justify-center bg-gradient-to-br from-[#4d9b91] to-[#3d8b81]">
                        <span class="text-white text-4xl font-bold">{{ substr($collection->name, 0, 1) }}</span>
                    </div>
                @endif
                
                <!-- Overlay -->
                <div class="absolute inset-0 bg-gradient-to-t from-black/60 via-black/20 to-transparent opacity-0 group-hover:opacity-100 transition-opacity duration-300"></div>
            </div>

            <!-- Collection Info -->
            <div class="p-6">
                <h3 class="text-2xl font-bold text-gray-900 font-pf group-hover:text-[#4d9b91] transition-colors">
                    {{ $collection->name }}
                </h3>
                
                @if($collection->description)
                <p class="text-gray-600 mt-2 line-clamp-2">
                    {{ $collection->description }}
                </p>
                @endif

                <div class="flex items-center justify-between mt-4">
                    <span class="text-sm text-gray-500">
                        {{ $collection->products_count }} {{ Str::plural('item', $collection->products_count) }}
                    </span>
                    <span class="text-[#4d9b91] font-semibold group-hover:translate-x-2 transition-transform">
                        Explore →
                    </span>
                </div>
            </div>
        </a>
        @empty
        <div class="col-span-full text-center py-12">
            <p class="text-gray-500 text-lg">No collections available at the moment.</p>
        </div>
        @endforelse
    </div>
</div>
@endsection
