@extends('layouts.app')
@section('title', 'Jauxsh')

@section('content')
<div class="w-full">
    <!-- Hero Section -->
    <div class="container mx-auto px-6 md:px-12 lg:px-20 max-w-7xl pt-32 pb-16">
        <!-- Hero Image -->
        <div class="relative w-full h-[500px] md:h-[650px] overflow-hidden rounded-sm shadow-2xl mb-10">
            <img id="heroImage" 
                 src="{{ asset('images/hero/hero1.png') }}" 
                 alt="Hero Image"
                 class="w-full h-full object-cover object-center transition-opacity duration-500"
                 loading="lazy" >

            <!-- Minimalist Controls Overlay (Bottom Left) -->
            <div class="absolute bottom-6 left-6 flex items-center gap-3 bg-black/20 backdrop-blur-sm px-4 py-2.5 rounded-full">
                <!-- Dots Indicator -->
                <div class="flex gap-1.5" id="dotsContainer"></div>

                <!-- Divider -->
                <div class="w-px h-4 bg-white/30"></div>

                <!-- Navigation Arrows -->
                <button onclick="previousSlide()" 
                        class="hero-control-btn w-8 h-8 flex items-center justify-center text-white hover:bg-white/20 rounded-full transition-all duration-300">
                    <svg class="w-4 h-4" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                        <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M15 19l-7-7 7-7"/>
                    </svg>
                </button>
                <button onclick="nextSlide()" 
                        class="hero-control-btn w-8 h-8 flex items-center justify-center text-white hover:bg-white/20 rounded-full transition-all duration-300">
                    <svg class="w-4 h-4" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                        <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M9 5l7 7-7 7"/>
                    </svg>
                </button>

                <!-- Divider -->
                <div class="w-px h-4 bg-white/30"></div>

                <!-- Play/Pause -->
                <button onclick="toggleAutoplay()" 
                        id="playPauseBtn"
                        class="hero-control-btn w-8 h-8 flex items-center justify-center text-white hover:bg-white/20 rounded-full transition-all duration-300">
                    <svg id="pauseIcon" class="w-3.5 h-3.5" fill="currentColor" viewBox="0 0 24 24">
                        <path d="M6 4h4v16H6V4zm8 0h4v16h-4V4z"/>
                    </svg>
                    <svg id="playIcon" class="w-3.5 h-3.5 hidden" fill="currentColor" viewBox="0 0 24 24">
                        <path d="M8 5v14l11-7z"/>
                    </svg>
                </button>
            </div>

            <!-- Shop Button (Bottom Right) -->
            <div class="absolute bottom-6 right-6">
                <a id="shopBtn" href="/shop/jackets" class="shop-cta-btn inline-block px-8 py-2.5 font-lora text-sm text-white bg-black/20 backdrop-blur-sm border border-white/50 rounded-full hover:bg-white hover:text-gray-900 transition-all duration-300">
                    Shop Jackets →
                </a>
            </div>
        </div>
       
        <!-- Hero Title & Description -->
        <div class="max-w-3xl">
            <h1 id="heroTitle" class="font-cg text-5xl md:text-6xl lg:text-7xl font-bold tracking-tight uppercase text-gray-900 mb-6 transition-opacity duration-500">
                Fleece Friends
            </h1>
            
            <p id="heroDescription" class="text-gray-600 text-base md:text-lg leading-relaxed transition-opacity duration-500 font-lora">
                Sweatshirts naturally require the perfect pair of sweatpants to achieve maximum comfort.
                Add any sweatshirt and sweatpants to your cart and 
                <span class="font-semibold text-gray-900">save 10%</span>!
            </p>
        </div>
    </div>

    <!-- Handsome Made Fleece Section -->
    <div class="bg-neutral-50 py-20">
        <div class="container mx-auto px-6 md:px-12 lg:px-20 max-w-7xl">
            <div class="flex justify-between items-center mb-12">
                <h2 class="font-cg text-3xl md:text-4xl font-bold tracking-tight uppercase text-gray-900">
                    Handsome Made Fleece
                </h2>
                <a href="/shop" class="inline-block px-8 py-2 font-lora text-sm text-gray-900 border-2 border-gray-900 rounded-full hover:bg-gray-900 hover:text-white transition-all duration-300">
                    View all
                </a>
            </div>

            <!-- Product Grid -->
            <div class="grid grid-cols-1 sm:grid-cols-2 lg:grid-cols-4 gap-8">
                @forelse($fleeceProducts as $product)
                <a href="/products/{{ $product->id }}" class="bg-white rounded-sm shadow-sm overflow-hidden group cursor-pointer hover:shadow-lg transition-shadow duration-300">
                    <div class="aspect-square bg-gray-200 overflow-hidden">
                        @if($product->images->count() > 0)
                        <img src="{{ asset('storage/' . $product->images->first()->image_url) }}" 
                             loading="lazy" 
                             alt="{{ $product->name }}" 
                             class="w-full h-full object-cover group-hover:scale-105 transition-transform duration-500">
                        @else
                        <div class="w-full h-full flex items-center justify-center bg-gray-100">
                            <svg class="w-16 h-16 text-gray-300" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                                <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M4 16l4.586-4.586a2 2 0 012.828 0L16 16m-2-2l1.586-1.586a2 2 0 012.828 0L20 14m-6-6h.01M6 20h12a2 2 0 002-2V6a2 2 0 00-2-2H6a2 2 0 00-2 2v12a2 2 0 002 2z"/>
                            </svg>
                        </div>
                        @endif
                    </div>
                    <div class="p-4">
                        <h3 class="font-lora text-base text-gray-900 mb-1 truncate">{{ $product->name }}</h3>
                        <div class="flex items-center justify-between">
                            <p class="font-lora text-sm font-medium text-gray-900">${{ number_format($product->price, 2) }}</p>
                            @if($product->stock <= 0)
                            <span class="text-xs text-red-600 font-cg">Out of stock</span>
                            @elseif($product->stock <= 10)
                            <span class="text-xs text-yellow-600 font-cg">Low stock</span>
                            @endif
                        </div>
                        @if($product->category)
                        <p class="text-xs text-gray-500 font-cg mt-1">{{ $product->category->name }}</p>
                        @endif
                    </div>
                </a>
                @empty
                <div class="col-span-full text-center py-12">
                    <svg class="mx-auto h-12 w-12 text-gray-400" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                        <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M20 7l-8-4-8 4m16 0l-8 4m8-4v10l-8 4m0-10L4 7m8 4v10M4 7v10l8 4"/>
                    </svg>
                    <h3 class="mt-4 text-lg font-medium text-gray-900 font-lora">No products available yet</h3>
                    <p class="mt-2 text-sm text-gray-500 font-cg">Check back soon for new arrivals!</p>
                </div>
                @endforelse
            </div>
        </div>
    </div>

    <!-- Best Sellers Section -->
    <div class="py-20">
        <div class="container mx-auto px-6 md:px-12 lg:px-20 max-w-7xl">
            <div class="flex justify-between items-center mb-12">
                <h2 class="font-cg text-3xl md:text-4xl font-bold tracking-tight uppercase text-gray-900">
                    Best Sellers
                </h2>
                <a href="/shop" class="inline-block px-8 py-2 font-lora text-sm text-gray-900 border-2 border-gray-900 rounded-full hover:bg-gray-900 hover:text-white transition-all duration-300">
                    View all
                </a>
            </div>

            <!-- Product Grid -->
            <div class="grid grid-cols-1 sm:grid-cols-2 lg:grid-cols-4 gap-8">
                @forelse($bestSellers as $product)
                <a href="/products/{{ $product->id }}" class="bg-white rounded-sm shadow-sm overflow-hidden group cursor-pointer hover:shadow-lg transition-shadow duration-300">
                    <div class="aspect-square bg-gray-200 overflow-hidden">
                        @if($product->images->count() > 0)
                        <img src="{{ asset('storage/' . $product->images->first()->image_url) }}" 
                             loading="lazy" 
                             alt="{{ $product->name }}" 
                             class="w-full h-full object-cover group-hover:scale-105 transition-transform duration-500">
                        @else
                        <div class="w-full h-full flex items-center justify-center bg-gray-100">
                            <svg class="w-16 h-16 text-gray-300" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                                <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M4 16l4.586-4.586a2 2 0 012.828 0L16 16m-2-2l1.586-1.586a2 2 0 012.828 0L20 14m-6-6h.01M6 20h12a2 2 0 002-2V6a2 2 0 00-2-2H6a2 2 0 00-2 2v12a2 2 0 002 2z"/>
                            </svg>
                        </div>
                        @endif
                    </div>
                    <div class="p-4">
                        <h3 class="font-lora text-base text-gray-900 mb-1 truncate">{{ $product->name }}</h3>
                        <div class="flex items-center justify-between">
                            <p class="font-lora text-sm font-medium text-gray-900">${{ number_format($product->price, 2) }}</p>
                            @if($product->stock <= 0)
                            <span class="text-xs text-red-600 font-cg">Out of stock</span>
                            @elseif($product->stock <= 10)
                            <span class="text-xs text-yellow-600 font-cg">Low stock</span>
                            @endif
                        </div>
                        @if($product->category)
                        <p class="text-xs text-gray-500 font-cg mt-1">{{ $product->category->name }}</p>
                        @endif
                    </div>
                </a>
                @empty
                <div class="col-span-full text-center py-12">
                    <svg class="mx-auto h-12 w-12 text-gray-400" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                        <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M20 7l-8-4-8 4m16 0l-8 4m8-4v10l-8 4m0-10L4 7m8 4v10M4 7v10l8 4"/>
                    </svg>
                    <h3 class="mt-4 text-lg font-medium text-gray-900 font-lora">No products available yet</h3>
                    <p class="mt-2 text-sm text-gray-500 font-cg">Check back soon for new arrivals!</p>
                </div>
                @endforelse
            </div>
        </div>
    </div>
</div>
@endsection

@push('scripts')
<script>
    const heroData = [
        {
            image: "{{ asset('images/hero/hero1.png') }}",
            title: "Fleece Friends",
            description: "Sweatshirts naturally require the perfect pair of sweatpants to achieve maximum comfort. Add any sweatshirt and sweatpants to your cart and <span class='font-semibold text-gray-900'>save 10%</span>!",
            shopLink: "/shop",
            shopText: "Shop Now →"
        },
        {
            image: "{{ asset('images/hero/hero2.png') }}",
            title: "Summer Collection",
            description: "Discover our latest summer styles with breathable fabrics and vibrant colors. Perfect for warm weather adventures. <span class='font-semibold text-gray-900'>Shop now</span>!",
            shopLink: "/shop",
            shopText: "Shop Summer →"
        },
        {
            image: "{{ asset('images/hero/hero3.png') }}",
            title: "Winter Warmth",
            description: "Bundle up in style with our cozy winter collection. Premium materials meet modern design. <span class='font-semibold text-gray-900'>Save 15% on bundles</span>!",
            shopLink: "/shop",
            shopText: "Shop Winter →"
        }
    ];

    let currentSlide = 0;
    let autoplayInterval = null;
    let isAutoplayActive = true;

    function initializeDots() {
        const container = document.getElementById('dotsContainer');
        container.innerHTML = '';
        
        heroData.forEach((_, index) => {
            const dot = document.createElement('button');
            dot.onclick = () => goToSlide(index);
            dot.className = index === 0 
                ? 'bg-white w-6 h-1.5 rounded-full transition-all duration-300' 
                : 'bg-white/40 w-1.5 h-1.5 rounded-full transition-all duration-300';
            container.appendChild(dot);
        });
    }

    function updateDots() {
        const dots = document.querySelectorAll('#dotsContainer button');
        dots.forEach((dot, index) => {
            dot.className = index === currentSlide
                ? 'bg-white w-6 h-1.5 rounded-full transition-all duration-300'
                : 'bg-white/40 w-1.5 h-1.5 rounded-full transition-all duration-300';
        });
    }

    function updateSlide(index) {
        const image = document.getElementById('heroImage');
        const title = document.getElementById('heroTitle');
        const description = document.getElementById('heroDescription');
        const shopBtn = document.getElementById('shopBtn');

        image.style.opacity = '0';
        title.style.opacity = '0';
        description.style.opacity = '0';
        shopBtn.style.opacity = '0';

        setTimeout(() => {
            image.src = heroData[index].image;
            title.textContent = heroData[index].title;
            description.innerHTML = heroData[index].description;
            shopBtn.href = heroData[index].shopLink;
            shopBtn.textContent = heroData[index].shopText;

            image.style.opacity = '1';
            title.style.opacity = '1';
            description.style.opacity = '1';
            shopBtn.style.opacity = '1';

            currentSlide = index;
            updateDots();
        }, 300);
    }

    function nextSlide() {
        updateSlide((currentSlide + 1) % heroData.length);
        resetAutoplay();
    }

    function previousSlide() {
        updateSlide((currentSlide - 1 + heroData.length) % heroData.length);
        resetAutoplay();
    }

    function goToSlide(index) {
        updateSlide(index);
        resetAutoplay();
    }

    function startAutoplay() {
        if (autoplayInterval) clearInterval(autoplayInterval);
        autoplayInterval = setInterval(nextSlide, 5000);
        isAutoplayActive = true;
        updatePlayPauseIcon();
    }

    function stopAutoplay() {
        if (autoplayInterval) clearInterval(autoplayInterval);
        isAutoplayActive = false;
        updatePlayPauseIcon();
    }

    function toggleAutoplay() {
        isAutoplayActive ? stopAutoplay() : startAutoplay();
    }

    function resetAutoplay() {
        if (isAutoplayActive) startAutoplay();
    }

    function updatePlayPauseIcon() {
        document.getElementById('pauseIcon').classList.toggle('hidden', !isAutoplayActive);
        document.getElementById('playIcon').classList.toggle('hidden', isAutoplayActive);
    }

    document.addEventListener('DOMContentLoaded', () => {
        initializeDots();
        startAutoplay();
    });
</script>

<style>
    .shop-cta-btn {
        backdrop-filter: blur(8px);
    }
</style>
@endpush