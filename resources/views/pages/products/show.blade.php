@extends('layouts.app')
@section('title', $product->name . ' | Jauxsh')

@section('content')
<div class="w-full">
    <!-- Breadcrumb -->
    <div class=" py-4 border-b border-gray-200">
        <div class="container mx-auto px-6 md:px-12 lg:px-20 max-w-7xl">
            <nav class="flex items-center space-x-2 text-xs font-cg uppercase tracking-wide">
                <a href="{{ route('home') }}" class="text-gray-600 hover:text-gray-900 transition-colors">Home</a>
                <span class="text-gray-400">/</span>
                <a href="{{ route('products.index') }}" class="text-gray-600 hover:text-gray-900 transition-colors">Shop</a>
                @if($product->category)
                <span class="text-gray-400">/</span>
                <a href="{{ route('products.index') }}?category={{ $product->category->id }}" class="text-gray-600 hover:text-gray-900 transition-colors">{{ $product->category->name }}</a>
                @endif
                <span class="text-gray-400">/</span>
                <span class="text-gray-900 font-semibold">{{ $product->name }}</span>
            </nav>
        </div>
    </div>

    <!-- Product Details -->
    <div class="container mx-auto px-6 md:px-12 lg:px-20 max-w-7xl py-16">
        <div class="grid grid-cols-1 lg:grid-cols-2 gap-12 lg:gap-20">
            <!-- Image Gallery -->
            <div class="space-y-4">
                <!-- Main Image -->
                <div class="aspect-square bg-gray-100 rounded-sm overflow-hidden border border-gray-200 relative group">
                    @if($product->images->count() > 0)
                    <img id="mainImage" 
                         src="{{ asset('storage/' . $product->images->first()->image_url) }}" 
                         alt="{{ $product->name }}"
                         class="w-full h-full object-cover transition-transform duration-500 group-hover:scale-105">
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
                        <div class="absolute top-4 right-4 bg-red-600 text-white text-xs font-semibold font-cg px-3 py-1.5 rounded-full">
                            Out of Stock
                        </div>
                        @elseif($product->stock <= 10)
                        <div class="absolute top-4 right-4 bg-yellow-500 text-white text-xs font-semibold font-cg px-3 py-1.5 rounded-full">
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
                            class="aspect-square bg-gray-100 rounded-sm overflow-hidden border-2 border-gray-200 hover:border-[#1D433F] transition-colors cursor-pointer hover:shadow-md">
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
                <p class="text-xs text-gray-500 font-cg uppercase tracking-widest mb-2">
                    {{ $product->category->name }}
                </p>
                @endif

                <h1 class="font-cg text-4xl md:text-5xl font-bold tracking-tight uppercase text-gray-900 mb-2 leading-tight">
                    {{ $product->name }}
                </h1>

                <!-- Price and Stock -->
                <div class="mb-6 pt-4">
                    <p class="font-lora text-3xl font-semibold text-gray-900 mb-2" id="productPrice" data-base-price="{{ $product->price }}">
                        ${{ number_format($product->price, 2) }}
                    </p>
                    @if(!$product->has_variants)
                        @if($product->stock > 0)
                        <p class="text-sm text-green-600 font-cg font-medium">
                            ✓ In Stock ({{ $product->stock }} available)
                        </p>
                        @else
                        <p class="text-sm text-red-600 font-cg font-medium">
                            Out of Stock
                        </p>
                        @endif
                    @else
                        <p id="stockStatus" class="text-sm font-cg font-medium"></p>
                    @endif
                </div>

                <!-- Description -->
                <div class="mb-8 pb-8 border-b-2 border-gray-200">
                    <p class="text-gray-600 font-lora leading-relaxed text-base">
                        {{ $product->description ?? 'No description available for this product.' }}
                    </p>
                </div>

                <!-- Add to Cart Form -->
                <form action="{{ route('cart.add') }}" method="POST" id="addToCartForm" class="space-y-8">
                    @csrf
                    <input type="hidden" name="product_id" value="{{ $product->id }}">
                    <input type="hidden" name="product_variant_id" id="selectedVariantId" value="">

                    @if($product->has_variants)
                        <!-- Color Selection -->
                        @if($product->available_colors->isNotEmpty())
                        <div>
                            <label class="block font-cg text-xs font-bold uppercase tracking-widest text-gray-900 mb-4">
                                Color: <span id="selectedColorName" class="text-gray-500 font-normal">Select a color</span>
                            </label>
                            <div class="flex flex-wrap gap-3">
                                @foreach($product->available_colors as $color)
                                <button type="button" 
                                        class="color-option group relative w-12 h-12 rounded-full border-2 border-gray-300 hover:border-[#1D433F] transition-all overflow-hidden"
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
                            <label class="block font-cg text-xs font-bold uppercase tracking-widest text-gray-900 mb-4">
                                Size: <span id="selectedSizeName" class="text-gray-500 font-normal">Select a size</span>
                            </label>
                            <div class="flex flex-wrap gap-3">
                                @foreach($product->available_sizes as $size)
                                <button type="button"
                                        class="size-option px-4 py-2.5 border-2 border-gray-300 rounded-sm font-cg font-semibold text-sm hover:border-[#1D433F] hover:bg-[#1D433F] hover:text-white transition-all"
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
                        <label class="block font-cg text-xs font-bold uppercase tracking-widest text-gray-900 mb-4">
                            Quantity
                        </label>
                        <div class="flex items-center gap-4">
                            <div class="flex items-center border-2 border-gray-300 rounded-sm overflow-hidden">
                                <button type="button" onclick="decrementQuantity()" 
                                        class="px-4 py-3 bg-gray-50 hover:bg-gray-100 transition-colors">
                                    <svg class="w-4 h-4 text-gray-900" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                                        <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2.5" d="M20 12H4"/>
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
                                    <svg class="w-4 h-4 text-gray-900" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                                        <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2.5" d="M12 4v16m8-8H4"/>
                                    </svg>
                                </button>
                            </div>
                            <p id="quantityWarning" class="text-sm text-yellow-600 font-cg font-medium hidden"></p>
                        </div>
                    </div>

                    <!-- Action Buttons -->
                    <div class="space-y-3 pt-4">
                        @auth
                            <button type="submit" 
                                    id="addToCartBtn"
                                    @if(!$product->has_variants && $product->stock <= 0) disabled @endif
                                    class="w-full px-8 py-4 font-cg text-base font-semibold text-white bg-gray-900 rounded-sm hover:bg-[#1D433F] transition-all duration-300 flex items-center justify-center gap-2 disabled:bg-gray-400 disabled:cursor-not-allowed">
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
                           class="block w-full px-8 py-4 font-cg text-base font-semibold text-center text-white bg-gray-900 rounded-sm hover:bg-[#1D433F] transition-all duration-300">
                            Login to Purchase
                        </a>
                        @endauth

                        <a href="{{ route('products.index') }}" 
                           class="block w-full px-8 py-4 font-cg text-base font-semibold text-center text-gray-900 bg-white border-2 border-gray-900 rounded-sm hover:bg-gray-50 transition-all duration-300">
                            Continue Shopping
                        </a>
                    </div>
                </form>

                <!-- Additional Information Accordions -->
                <div class="mt-12 pt-12 border-t-2 border-gray-200 space-y-4">
                    <!-- Size Guide -->
                    <details class="group">
                        <summary class="flex items-center justify-between cursor-pointer py-4 px-0 font-cg text-sm font-bold uppercase tracking-widest text-gray-900 hover:text-[#1D433F] transition-colors">
                            <span>Size Guide</span>
                            <svg class="w-5 h-5 transition-transform group-open:rotate-180" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                                <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M19 14l-7 7m0 0l-7-7m7 7V3"/>
                            </svg>
                        </summary>
                        <div class="pb-4 font-lora text-sm text-gray-600 space-y-4">
                            <div class="overflow-x-auto">
                                <table class="w-full text-xs">
                                    <thead>
                                        <tr class="border-b border-gray-300">
                                            <th class="text-left py-2 px-2 font-semibold">Measurement</th>
                                            <th class="text-center py-2 px-2">XS</th>
                                            <th class="text-center py-2 px-2">S</th>
                                            <th class="text-center py-2 px-2">M</th>
                                            <th class="text-center py-2 px-2">L</th>
                                            <th class="text-center py-2 px-2">XL</th>
                                            <th class="text-center py-2 px-2">XXL</th>
                                        </tr>
                                    </thead>
                                    <tbody>
                                        <tr class="border-b border-gray-200">
                                            <td class="py-2 px-2 font-medium">Length</td>
                                            <td class="text-center py-2 px-2">25.00"</td>
                                            <td class="text-center py-2 px-2">26.00"</td>
                                            <td class="text-center py-2 px-2">27.00"</td>
                                            <td class="text-center py-2 px-2">28.00"</td>
                                            <td class="text-center py-2 px-2">29.00"</td>
                                            <td class="text-center py-2 px-2">30.00"</td>
                                        </tr>
                                        <tr class="border-b border-gray-200">
                                            <td class="py-2 px-2 font-medium">Chest</td>
                                            <td class="text-center py-2 px-2">21.25"</td>
                                            <td class="text-center py-2 px-2">22.50"</td>
                                            <td class="text-center py-2 px-2">23.75"</td>
                                            <td class="text-center py-2 px-2">25.00"</td>
                                            <td class="text-center py-2 px-2">26.25"</td>
                                            <td class="text-center py-2 px-2">27.50"</td>
                                        </tr>
                                        <tr class="border-b border-gray-200">
                                            <td class="py-2 px-2 font-medium">Shoulder</td>
                                            <td class="text-center py-2 px-2">17.00"</td>
                                            <td class="text-center py-2 px-2">18.00"</td>
                                            <td class="text-center py-2 px-2">19.00"</td>
                                            <td class="text-center py-2 px-2">20.00"</td>
                                            <td class="text-center py-2 px-2">21.00"</td>
                                            <td class="text-center py-2 px-2">22.00"</td>
                                        </tr>
                                        <tr>
                                            <td class="py-2 px-2 font-medium">Sleeve</td>
                                            <td class="text-center py-2 px-2">25.25"</td>
                                            <td class="text-center py-2 px-2">25.50"</td>
                                            <td class="text-center py-2 px-2">26.00"</td>
                                            <td class="text-center py-2 px-2">26.75"</td>
                                            <td class="text-center py-2 px-2">26.75"</td>
                                            <td class="text-center py-2 px-2">27.00"</td>
                                        </tr>
                                    </tbody>
                                </table>
                            </div>
                        </div>
                    </details>

                    <!-- Shipping Information -->
                    <details class="group border-t border-gray-200">
                        <summary class="flex items-center justify-between cursor-pointer py-4 px-0 font-cg text-sm font-bold uppercase tracking-widest text-gray-900 hover:text-[#1D433F] transition-colors">
                            <span>Shipping Information</span>
                            <svg class="w-5 h-5 transition-transform group-open:rotate-180" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                                <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M19 14l-7 7m0 0l-7-7m7 7V3"/>
                            </svg>
                        </summary>
                        <div class="pb-4 font-lora text-sm text-gray-600 space-y-3">
                            <p>Orders typically take 1-3 business days to be processed and shipped out.</p>
                            <p>All orders will be sent with a tracking number once dispatched from the warehouse.</p>
                            <p class="text-xs text-gray-500">Orders to PO boxes will not be accepted.</p>
                        </div>
                    </details>

                    <!-- Fabric Information -->

                    <!-- Return Policy -->
                    <details class="group border-t border-gray-200">
                        <summary class="flex items-center justify-between cursor-pointer py-4 px-0 font-cg text-sm font-bold uppercase tracking-widest text-gray-900 hover:text-[#1D433F] transition-colors">
                            <span>Return Policy</span>
                            <svg class="w-5 h-5 transition-transform group-open:rotate-180" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                                <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M19 14l-7 7m0 0l-7-7m7 7V3"/>
                            </svg>
                        </summary>
                        <div class="pb-4 font-lora text-sm text-gray-600 space-y-3">
                            <p>Items returned within 14 days of delivery in as new unused condition will be eligible for a refund.</p>
                            <p class="text-xs">Shipping and handling is not refundable. All sale items are final purchase.</p>
                            <p>You are responsible for return shipping costs.</p>
                        </div>
                    </details>

                    <!-- FAQ -->
                    <details class="group border-t border-gray-200">
                        <summary class="flex items-center justify-between cursor-pointer py-4 px-0 font-cg text-sm font-bold uppercase tracking-widest text-gray-900 hover:text-[#1D433F] transition-colors">
                            <span>FAQ</span>
                            <svg class="w-5 h-5 transition-transform group-open:rotate-180" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                                <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M19 14l-7 7m0 0l-7-7m7 7V3"/>
                            </svg>
                        </summary>
                        <div class="pb-4 font-lora text-sm text-gray-600 space-y-4">
                            <div>
                                <p class="font-semibold text-gray-900 mb-2">How long does shipping take?</p>
                                <p>Orders typically take 1-3 business days to process and ship. Extra time may be needed during busy seasons.</p>
                            </div>
                            <div>
                                <p class="font-semibold text-gray-900 mb-2">Can I return items?</p>
                                <p>Yes, items can be returned within 14 days in unused condition. Return shipping costs are your responsibility.</p>
                            </div>
                            <div>
                                <p class="font-semibold text-gray-900 mb-2">How do I know my size?</p>
                                <p>Check the size guide above for accurate measurements. We recommend measuring a garment you already own.</p>
                            </div>
                        </div>
                    </details>
                </div>
            </div>
        </div>
    </div>

    <!-- Related Products Section -->
    @if($relatedProducts->count() > 0)
    <div class="bg-gray-50 py-20 border-t border-gray-200">
        <div class="container mx-auto px-6 md:px-12 lg:px-20 max-w-7xl">
            <h2 class="font-cg text-3xl md:text-4xl font-bold tracking-tight uppercase text-gray-900 mb-10">
                You Might Also Like
            </h2>

            <div class="grid grid-cols-1 sm:grid-cols-2 lg:grid-cols-4 gap-6">
                @foreach($relatedProducts as $related)
                <a href="{{ route('products.show', $related->id) }}" 
                   class="bg-white rounded-sm border border-gray-200 overflow-hidden group cursor-pointer hover:shadow-lg hover:border-gray-300 transition-all duration-300">
                    <div class="aspect-square bg-gray-100 overflow-hidden">
                        @if($related->images->count() > 0)
                        <img src="{{ asset('storage/' . $related->images->first()->image_url) }}" 
                             loading="lazy" 
                             alt="{{ $related->name }}" 
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
                        @if($related->category)
                        <p class="text-xs text-gray-500 font-cg uppercase tracking-wider mb-2">
                            {{ $related->category->name }}
                        </p>
                        @endif
                        <h3 class="font-lora text-base text-gray-900 mb-2 group-hover:text-[#1D433F] transition-colors line-clamp-2 font-medium">
                            {{ $related->name }}
                        </h3>
                        <div class="flex items-center justify-between">
                            <p class="font-lora text-lg font-semibold text-gray-900">
                                ${{ number_format($related->price, 2) }}
                            </p>
                            @if($related->has_variants)
                                <span class="text-xs text-[#1FAC99] font-cg font-semibold">In stock</span>
                            @else
                                @if($related->stock <= 0)
                                <span class="text-xs text-red-600 font-cg font-semibold">Out of stock</span>
                                @elseif($related->stock <= 10)
                                <span class="text-xs text-yellow-600 font-cg font-semibold">Low stock</span>
                                @endif
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
// All the variant selection code from your existing file
const variants = @json($product->variants ?? []);
const hasVariants = {{ $product->has_variants ? 'true' : 'false' }};
let selectedColor = null;
let selectedSize = null;
let maxStock = {{ $product->stock }};

function changeImage(imageUrl) {
    const mainImage = document.getElementById('mainImage');
    mainImage.style.opacity = '0';
    setTimeout(() => {
        mainImage.src = imageUrl;
        mainImage.style.opacity = '1';
    }, 200);
}

function selectColor(element, color) {
    selectedColor = color;
    document.querySelectorAll('.color-option').forEach(btn => {
        btn.classList.remove('ring-4', 'ring-[#1D433F]', 'border-[#1D433F]');
        btn.classList.add('border-gray-300');
    });
    element.classList.remove('border-gray-300');
    element.classList.add('ring-4', 'ring-[#1D433F]', 'border-[#1D433F]');
    document.getElementById('selectedColorName').textContent = color;
    document.getElementById('selectedColorName').classList.remove('text-gray-500');
    document.getElementById('selectedColorName').classList.add('text-gray-900');
    updateVariantSelection();
}

function selectSize(element, size) {
    selectedSize = size;
    document.querySelectorAll('.size-option').forEach(btn => {
        btn.classList.remove('bg-[#1D433F]', 'text-white', 'border-[#1D433F]');
        btn.classList.add('border-gray-300');
    });
    element.classList.remove('border-gray-300');
    element.classList.add('bg-[#1D433F]', 'text-white', 'border-[#1D433F]');
    document.getElementById('selectedSizeName').textContent = size;
    document.getElementById('selectedSizeName').classList.remove('text-gray-500');
    document.getElementById('selectedSizeName').classList.add('text-gray-900');
    updateVariantSelection();
}

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
        priceDisplay.textContent = '$' + parseFloat(variant.final_price).toFixed(2);
        maxStock = variant.stock;
        document.getElementById('quantity').max = variant.stock;
        
        if (variant.stock > 0) {
            stockStatus.innerHTML = `<span class="text-[#1FAC99]">✓ In Stock (${variant.stock} available)</span>`;
            stockBadge.innerHTML = variant.stock <= 10 
                ? `<div class="bg-yellow-500 text-white text-xs font-semibold font-cg px-3 py-1.5 rounded-full">Only ${variant.stock} Left</div>`
                : '';
            addToCartBtn.disabled = false;
            addToCartText.textContent = 'Add to Cart';
        } else {
            stockStatus.innerHTML = '<span class="text-red-600">Out of Stock</span>';
            stockBadge.innerHTML = '<div class="bg-red-600 text-white text-xs font-semibold font-cg px-3 py-1.5 rounded-full">Out of Stock</div>';
            addToCartBtn.disabled = true;
            addToCartText.textContent = 'Out of Stock';
        }
        
        if (variant.image_url) {
            changeImage(variant.image_url);
        }
        
        updateQuantityWarning();
    }
}

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
    
    if (maxStock > 0 && maxStock <= 10 && quantity >= maxStock * 0.5) {
        warning.textContent = `Only ${maxStock} available`;
        warning.classList.remove('hidden');
    } else {
        warning.classList.add('hidden');
    }
}

document.getElementById('addToCartForm')?.addEventListener('submit', function(e) {
    if (hasVariants && (!selectedColor || !selectedSize)) {
        e.preventDefault();
        alert('Please select both color and size');
        return false;
    }
});
</script>

<style>
#mainImage {
    transition: opacity 0.2s ease-in-out;
}
</style>
@endpush
@endsection