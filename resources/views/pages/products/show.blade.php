@extends('layouts.app')
@section('title', $product->name . ' | Jauxsh')

@section('content')
<div class="w-full">
    <!-- Breadcrumb -->
    <div class="py-4">
        <div class="container mx-auto px-6 md:px-12 lg:px-20 max-w-7xl">
            <nav class="flex items-center space-x-2 text-sm font-cg">
                <a href="{{ route('home') }}" class="text-gray-500 hover:text-gray-900 transition-colors">Home</a>
                <svg class="w-4 h-4 text-gray-400" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                    <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M9 5l7 7-7 7"/>
                </svg>
                <a href="{{ route('products.index') }}" class="text-gray-500 hover:text-gray-900 transition-colors">Shop</a>
                @if($product->category)
                <svg class="w-4 h-4 text-gray-400" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                    <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M9 5l7 7-7 7"/>
                </svg>
                <span class="text-gray-500">{{ $product->category->name }}</span>
                @endif
                <svg class="w-4 h-4 text-gray-400" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                    <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M9 5l7 7-7 7"/>
                </svg>
                <span class="text-gray-900 font-medium">{{ $product->name }}</span>
            </nav>
        </div>
    </div>

    <!-- Product Details -->
    <div class="container mx-auto px-6 md:px-12 lg:px-20 max-w-7xl py-12">
        <div class="grid grid-cols-1 lg:grid-cols-2 gap-12 lg:gap-16">
            <!-- Image Gallery -->
            <div class="space-y-4">
                <!-- Main Image -->
                <div class="aspect-square bg-gray-100 rounded-sm overflow-hidden border border-gray-200 relative">
                    @if($product->images->count() > 0)
                    <img id="mainImage" 
                         src="{{ asset('storage/' . $product->images->first()->image_url) }}" 
                         alt="{{ $product->name }}"
                         class="w-full h-full object-cover">
                    @else
                    <div class="w-full h-full flex items-center justify-center">
                        <svg class="w-24 h-24 text-gray-300" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                            <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M4 16l4.586-4.586a2 2 0 012.828 0L16 16m-2-2l1.586-1.586a2 2 0 012.828 0L20 14m-6-6h.01M6 20h12a2 2 0 002-2V6a2 2 0 00-2-2H6a2 2 0 00-2 2v12a2 2 0 002 2z"/>
                        </svg>
                    </div>
                    @endif

                    <!-- Stock Badge -->
                    @if($product->has_variants)
                        <div id="variantStockBadge" class="absolute top-4 right-4"></div>
                    @else
                        @if($product->stock <= 0)
                        <div class="absolute top-4 right-4 bg-red-600 text-white text-xs font-cg px-4 py-2 rounded-full">
                            Out of Stock
                        </div>
                        @elseif($product->stock <= 10)
                        <div class="absolute top-4 right-4 bg-yellow-500 text-white text-xs font-cg px-4 py-2 rounded-full">
                            Only {{ $product->stock }} Left
                        </div>
                        @endif
                    @endif
                </div>

                <!-- Thumbnail Gallery -->
                @if($product->images->count() > 1)
                <div class="grid grid-cols-4 gap-3">
                    @foreach($product->images as $image)
                    <button onclick="changeImage('{{ asset('storage/' . $image->image_url) }}')"
                            class="aspect-square bg-gray-100 rounded-sm overflow-hidden border-2 border-gray-200 hover:border-gray-900 transition-colors cursor-pointer">
                        <img src="{{ asset('storage/' . $image->image_url) }}" 
                             alt="{{ $product->name }}"
                             class="w-full h-full object-cover">
                    </button>
                    @endforeach
                </div>
                @endif
            </div>

            <!-- Product Information -->
            <div>
                @if($product->category)
                <p class="text-sm text-gray-500 font-cg uppercase tracking-wider mb-3">
                    {{ $product->category->name }}
                </p>
                @endif

                <h1 class="font-cg text-4xl md:text-5xl font-bold tracking-tight uppercase text-gray-900 mb-4">
                    {{ $product->name }}
                </h1>

                <div class="flex items-baseline gap-4 mb-6">
                    <p class="font-lora text-lg font-semibold text-gray-900" id="productPrice" data-base-price="{{ $product->price }}">
                        ${{ number_format($product->price, 2) }}
                    </p>
                    @if(!$product->has_variants)
                        @if($product->stock > 0)
                        <p class="text-sm text-green-600 font-cg">
                            ✓ In Stock ({{ $product->stock }} available)
                        </p>
                        @else
                        <p class="text-sm text-red-600 font-cg">
                            ✗ Out of Stock
                        </p>
                        @endif
                    @else
                        <p id="stockStatus" class="text-sm font-cg"></p>
                    @endif
                </div>

                <!-- Description -->
                <div class="mb-8 pb-8 border-b border-gray-200">
                    <h3 class="font-cg text-sm font-bold uppercase tracking-wider text-gray-900 mb-3">
                        Description
                    </h3>
                    <p class="text-gray-600 font-lora leading-relaxed">
                        {{ $product->description ?? 'No description available for this product.' }}
                    </p>
                </div>

                <!-- Add to Cart Form -->
                <form action="{{ route('cart.add') }}" method="POST" id="addToCartForm" class="space-y-6">
                    @csrf
                    <input type="hidden" name="product_id" value="{{ $product->id }}">
                    <input type="hidden" name="product_variant_id" id="selectedVariantId" value="">

                    @if($product->has_variants)
                        <!-- Color Selection -->
                        @if($product->available_colors->isNotEmpty())
                        <div>
                            <label class="block font-cg text-sm font-bold uppercase tracking-wider text-gray-900 mb-3">
                                Color: <span id="selectedColorName" class="text-gray-500 font-normal">Select a color</span>
                            </label>
                            <div class="flex flex-wrap gap-3">
                                @foreach($product->available_colors as $color)
                                <button type="button" 
                                        class="color-option group relative w-12 h-12 rounded-full border-2 border-gray-300 hover:border-gray-900 transition-all overflow-hidden"
                                        style="background-color: {{ $color->color_hex ?? '#ccc' }}"
                                        data-color="{{ $color->color }}"
                                        data-hex="{{ $color->color_hex }}"
                                        title="{{ $color->color }}"
                                        onclick="selectColor(this, '{{ $color->color }}')">
                                    <span class="sr-only">{{ $color->color }}</span>
                                    <span class="absolute inset-0 flex items-center justify-center opacity-0 group-hover:opacity-100 transition-opacity">
                                        <svg class="w-6 h-6 text-white drop-shadow-lg" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                                            <path stroke-linecap="round" stroke-linejoin="round" stroke-width="3" d="M5 13l4 4L19 7"/>
                                        </svg>
                                    </span>
                                </button>
                                @endforeach
                            </div>
                        </div>
                        @endif

                        <!-- Size Selection -->
                        @if($product->available_sizes->isNotEmpty())
                        <div>
                            <label class="block font-cg text-sm font-bold uppercase tracking-wider text-gray-900 mb-3">
                                Size: <span id="selectedSizeName" class="text-gray-500 font-normal">Select a size</span>
                            </label>
                            <div class="flex flex-wrap gap-3">
                                @foreach($product->available_sizes as $size)
                                <button type="button"
                                        class="size-option px-6 py-3 border-2 border-gray-300 rounded-md font-cg font-semibold hover:border-gray-900 hover:bg-gray-900 hover:text-white transition-all"
                                        data-size="{{ $size }}"
                                        onclick="selectSize(this, '{{ $size }}')">
                                    {{ $size }}
                                </button>
                                @endforeach
                            </div>
                        </div>
                        @endif
                    @endif

                    <!-- Quantity Selector -->
                    <div>
                        <label class="block font-cg text-sm font-bold uppercase tracking-wider text-gray-900 mb-3">
                            Quantity
                        </label>
                        <div class="flex items-center gap-4">
                            <div class="flex items-center border-2 border-gray-300 rounded-md overflow-hidden">
                                <button type="button" onclick="decrementQuantity()" 
                                        class="px-4 py-3 bg-gray-50 hover:bg-gray-100 transition-colors">
                                    <svg class="w-4 h-4" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                                        <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M20 12H4"/>
                                    </svg>
                                </button>
                                <input type="number" 
                                       id="quantity" 
                                       name="quantity" 
                                       value="1" 
                                       min="1" 
                                       max="{{ $product->has_variants ? 999 : $product->stock }}"
                                       class="w-20 text-center border-0 font-lora font-semibold text-gray-900 focus:ring-0">
                                <button type="button" onclick="incrementQuantity()" 
                                        class="px-4 py-3 bg-gray-50 hover:bg-gray-100 transition-colors">
                                    <svg class="w-4 h-4" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                                        <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M12 4v16m8-8H4"/>
                                    </svg>
                                </button>
                            </div>
                            <p id="quantityWarning" class="text-sm text-yellow-600 font-cg hidden"></p>
                        </div>
                    </div>

                    <!-- Action Buttons -->
                    <div class="space-y-3">
                        @auth
                            <button type="submit" 
                                    id="addToCartBtn"
                                    @if(!$product->has_variants && $product->stock <= 0) disabled @endif
                                    class="w-full px-8 py-4 font-cg text-base font-semibold text-white bg-gray-900 rounded-md hover:bg-gray-800 transition-all duration-300 flex items-center justify-center gap-2 disabled:bg-gray-400 disabled:cursor-not-allowed">
                                <svg class="w-5 h-5" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                                    <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M3 3h2l.4 2M7 13h10l4-8H5.4M7 13L5.4 5M7 13l-2.293 2.293c-.63.63-.184 1.707.707 1.707H17m0 0a2 2 0 100 4 2 2 0 000-4zm-8 2a2 2 0 11-4 0 2 2 0 014 0z"/>
                                </svg>
                                <span id="addToCartText">
                                    @if($product->has_variants)
                                        Select Options
                                    @elseif($product->stock <= 0)
                                        Out of Stock
                                    @else
                                        Add to Cart
                                    @endif
                                </span>
                            </button>
                        @else
                        <a href="{{ route('login') }}" 
                           class="block w-full px-8 py-4 font-cg text-base font-semibold text-center text-white bg-gray-900 rounded-md hover:bg-gray-800 transition-all duration-300">
                            Login to Purchase
                        </a>
                        @endauth

                        <a href="{{ route('products.index') }}" 
                           class="block w-full px-8 py-4 font-cg text-base font-semibold text-center text-gray-900 bg-white border-2 border-gray-900 rounded-md hover:bg-gray-50 transition-all duration-300">
                            Continue Shopping
                        </a>
                    </div>
                </form>

                <!-- Product Collections -->
                @if($product->collections->isNotEmpty())
                <div class="mt-8 pt-8 border-t border-gray-200">
                    <h3 class="font-cg text-sm font-bold uppercase tracking-wider text-gray-900 mb-3">
                        Part of Collections
                    </h3>
                    <div class="flex flex-wrap gap-2">
                        @foreach($product->collections as $collection)
                        <a href="{{ route('collections.show', $collection->slug) }}"
                           class="px-4 py-2 bg-gray-100 text-gray-700 font-cg text-sm rounded-md hover:bg-gray-900 hover:text-white transition-all">
                            {{ $collection->name }}
                        </a>
                        @endforeach
                    </div>
                </div>
                @endif

                <!-- Product Details -->
                <div class="mt-8 pt-8 border-t border-gray-200 space-y-4">
                    <div class="flex items-start gap-3">
                        <svg class="w-5 h-5 text-gray-400 flex-shrink-0 mt-0.5" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                            <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M5 8h14M5 8a2 2 0 110-4h14a2 2 0 110 4M5 8v10a2 2 0 002 2h10a2 2 0 002-2V8m-9 4h4"/>
                        </svg>
                        <div>
                            <p class="text-sm font-semibold text-gray-900 font-cg">Premium Materials</p>
                            <p class="text-sm text-gray-600 font-lora">High-quality fabrics designed to last</p>
                        </div>
                    </div>
                    <div class="flex items-start gap-3">
                        <svg class="w-5 h-5 text-gray-400 flex-shrink-0 mt-0.5" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                            <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M3 10h18M7 15h1m4 0h1m-7 4h12a3 3 0 003-3V8a3 3 0 00-3-3H6a3 3 0 00-3 3v8a3 3 0 003 3z"/>
                        </svg>
                        <div>
                            <p class="text-sm font-semibold text-gray-900 font-cg">Secure Checkout</p>
                            <p class="text-sm text-gray-600 font-lora">Safe and encrypted payment processing</p>
                        </div>
                    </div>
                    <div class="flex items-start gap-3">
                        <svg class="w-5 h-5 text-gray-400 flex-shrink-0 mt-0.5" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                            <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M5 13l4 4L19 7"/>
                        </svg>
                        <div>
                            <p class="text-sm font-semibold text-gray-900 font-cg">Fast Shipping</p>
                            <p class="text-sm text-gray-600 font-lora">Quick delivery to your doorstep</p>
                        </div>
                    </div>
                </div>
            </div>
        </div>
    </div>

    <!-- Related Products Section -->
    @if($relatedProducts->count() > 0)
    <div class="bg-neutral-50 py-20 border-t border-gray-200">
        <div class="container mx-auto px-6 md:px-12 lg:px-20 max-w-7xl">
            <h2 class="font-cg text-3xl md:text-4xl font-bold tracking-tight uppercase text-gray-900 mb-10">
                You Might Also Like
            </h2>

            <div class="grid grid-cols-1 sm:grid-cols-2 lg:grid-cols-4 gap-6">
                @foreach($relatedProducts as $related)
                <a href="{{ route('products.show', $related->id) }}" 
                   class="bg-white rounded-sm border border-gray-200 overflow-hidden group cursor-pointer hover:shadow-xl hover:border-gray-300 transition-all duration-300">
                    <div class="aspect-square bg-gray-100 overflow-hidden">
                        @if($related->images->count() > 0)
                        <img src="{{ asset('storage/' . $related->images->first()->image_url) }}" 
                             loading="lazy" 
                             alt="{{ $related->name }}" 
                             class="w-full h-full object-cover group-hover:scale-105 transition-transform duration-500">
                        @else
                        <div class="w-full h-full flex items-center justify-center">
                            <svg class="w-16 h-16 text-gray-300" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                                <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M4 16l4.586-4.586a2 2 0 012.828 0L16 16m-2-2l1.586-1.586a2 2 0 012.828 0L20 14m-6-6h.01M6 20h12a2 2 0 002-2V6a2 2 0 00-2-2H6a2 2 0 00-2 2v12a2 2 0 002 2z"/>
                            </svg>
                        </div>
                        @endif
                    </div>
                    <div class="p-4">
                        @if($related->category)
                        <p class="text-xs text-gray-500 font-cg uppercase tracking-wider mb-2">
                            {{ $related->category->name }}
                        </p>
                        @endif
                        <h3 class="font-lora text-base text-gray-900 mb-2 group-hover:text-gray-600 transition-colors line-clamp-2">
                            {{ $related->name }}
                        </h3>
                        <div class="flex items-center justify-between">
                            <p class="font-lora text-lg font-semibold text-gray-900">
                                ${{ number_format($related->price, 2) }}
                            </p>
                            @if($related->stock <= 0)
                            <span class="text-xs text-red-600 font-cg">Out of stock</span>
                            @elseif($related->stock <= 10)
                            <span class="text-xs text-yellow-600 font-cg">Low stock</span>
                            @endif
                        </div>
                    </div>
                </a>
                @endforeach
            </div>
        </div>
    </div>
    @endif
</div>

@push('scripts')
<script>
// Product variants data from backend
const variants = @json($product->variants ?? []);
const hasVariants = {{ $product->has_variants ? 'true' : 'false' }};
let selectedColor = null;
let selectedSize = null;
let maxStock = {{ $product->stock }};

// Change main image
function changeImage(imageUrl) {
    const mainImage = document.getElementById('mainImage');
    mainImage.style.opacity = '0';
    setTimeout(() => {
        mainImage.src = imageUrl;
        mainImage.style.opacity = '1';
    }, 200);
}

// Select color
function selectColor(element, color) {
    selectedColor = color;
    
    // Update UI
    document.querySelectorAll('.color-option').forEach(btn => {
        btn.classList.remove('ring-4', 'ring-gray-900', 'border-gray-900');
        btn.classList.add('border-gray-300');
    });
    element.classList.remove('border-gray-300');
    element.classList.add('ring-4', 'ring-gray-900', 'border-gray-900');
    document.getElementById('selectedColorName').textContent = color;
    document.getElementById('selectedColorName').classList.remove('text-gray-500');
    document.getElementById('selectedColorName').classList.add('text-gray-900');
    
    updateVariantSelection();
}

// Select size
function selectSize(element, size) {
    selectedSize = size;
    
    // Update UI
    document.querySelectorAll('.size-option').forEach(btn => {
        btn.classList.remove('bg-gray-900', 'text-white', 'border-gray-900');
        btn.classList.add('border-gray-300');
    });
    element.classList.remove('border-gray-300');
    element.classList.add('bg-gray-900', 'text-white', 'border-gray-900');
    document.getElementById('selectedSizeName').textContent = size;
    document.getElementById('selectedSizeName').classList.remove('text-gray-500');
    document.getElementById('selectedSizeName').classList.add('text-gray-900');
    
    updateVariantSelection();
}

// Update variant selection
function updateVariantSelection() {
    if (!hasVariants) return;
    
    const variant = variants.find(v => 
        v.color === selectedColor && v.size === selectedSize
    );
    
    const addToCartBtn = document.getElementById('addToCartBtn');
    const addToCartText = document.getElementById('addToCartText');
    const priceDisplay = document.getElementById('productPrice');
    const stockStatus = document.getElementById('stockStatus');
    const stockBadge = document.getElementById('variantStockBadge');
    
    if (variant) {
        document.getElementById('selectedVariantId').value = variant.id;
        
        // Update price
        priceDisplay.textContent = '$' + parseFloat(variant.final_price).toFixed(2);
        
        // Update stock
        maxStock = variant.stock;
        document.getElementById('quantity').max = variant.stock;
        
        if (variant.stock > 0) {
            stockStatus.innerHTML = `<span class="text-green-600">✓ In Stock (${variant.stock} available)</span>`;
            stockBadge.innerHTML = variant.stock <= 10 
                ? `<div class="bg-yellow-500 text-white text-xs font-cg px-4 py-2 rounded-full">Only ${variant.stock} Left</div>`
                : '';
            addToCartBtn.disabled = false;
            addToCartText.textContent = 'Add to Cart';
        } else {
            stockStatus.innerHTML = '<span class="text-red-600">✗ Out of Stock</span>';
            stockBadge.innerHTML = '<div class="bg-red-600 text-white text-xs font-cg px-4 py-2 rounded-full">Out of Stock</div>';
            addToCartBtn.disabled = true;
            addToCartText.textContent = 'Out of Stock';
        }
        
        // Change main image if variant has one
        if (variant.image_url) {
            changeImage(variant.image_url);
        }
        
        // Update quantity warning
        updateQuantityWarning();
    } else if (selectedColor || selectedSize) {
        stockStatus.innerHTML = '<span class="text-gray-500">Please select both color and size</span>';
        stockBadge.innerHTML = '';
        addToCartBtn.disabled = true;
        addToCartText.textContent = 'Select Options';
        
        // Reset price to base
        const basePrice = parseFloat(priceDisplay.getAttribute('data-base-price'));
        priceDisplay.textContent = '$' + basePrice.toFixed(2);
    }
}

// Quantity Controls
function incrementQuantity() {
    const input = document.getElementById('quantity');
    const max = parseInt(input.max);
    const current = parseInt(input.value);
    if (current < max) {
        input.value = current + 1;
        updateQuantityWarning();
    }
}

function decrementQuantity() {
    const input = document.getElementById('quantity');
    const min = parseInt(input.min);
    const current = parseInt(input.value);
    if (current > min) {
        input.value = current - 1;
        updateQuantityWarning();
    }
}

function updateQuantityWarning() {
    const quantity = parseInt(document.getElementById('quantity').value);
    const warning = document.getElementById('quantityWarning');
    
    if (hasVariants && maxStock > 0 && maxStock <= 10 && quantity >= maxStock * 0.5) {
        warning.textContent = `Only ${maxStock} available`;
        warning.classList.remove('hidden');
    } else if (!hasVariants && maxStock > 0 && maxStock <= 10 && quantity >= maxStock * 0.5) {
        warning.textContent = `Only ${maxStock} available`;
        warning.classList.remove('hidden');
    } else {
        warning.classList.add('hidden');
    }
}

// Form validation
document.getElementById('addToCartForm')?.addEventListener('submit', function(e) {
    if (hasVariants && (!selectedColor || !selectedSize)) {
        e.preventDefault();
        alert('Please select both color and size');
        return false;
    }
    
    const button = this.querySelector('button[type="submit"]');
    if (button && !button.disabled) {
        button.innerHTML = `
            <svg class="animate-spin w-5 h-5" fill="none" viewBox="0 0 24 24">
                <circle class="opacity-25" cx="12" cy="12" r="10" stroke="currentColor" stroke-width="4"></circle>
                <path class="opacity-75" fill="currentColor" d="M4 12a8 8 0 018-8V0C5.373 0 0 5.373 0 12h4zm2 5.291A7.962 7.962 0 014 12H0c0 3.042 1.135 5.824 3 7.938l3-2.647z"></path>
            </svg>
            <span>Adding to Cart...</span>
        `;
        button.disabled = true;
    }
});
</script>

<style>
#mainImage {
    transition: opacity 0.2s ease-in-out;
}

.color-option {
    position: relative;
}

.color-option::after {
    content: '';
    position: absolute;
    inset: -2px;
    border-radius: 9999px;
    padding: 2px;
    background: transparent;
    -webkit-mask: linear-gradient(#fff 0 0) content-box, linear-gradient(#fff 0 0);
    -webkit-mask-composite: xor;
    mask-composite: exclude;
}
</style>
@endpush
@endsection