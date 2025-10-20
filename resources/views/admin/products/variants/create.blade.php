@extends('layouts.admin')

@section('title', 'Add Variant - ' . $product->name)
@section('page-title', 'Add Product Variant')
@section('page-description', 'Create a new variant for ' . $product->name)

@section('content')
<div class="space-y-6">
    <!-- Back Link -->
    <a href="/admin/products/{{ $product->id }}/variants" 
       class="text-[#1FAC99] hover:text-[#1D433F] font-cg text-sm inline-flex items-center gap-2">
        <svg class="w-4 h-4" fill="none" stroke="currentColor" viewBox="0 0 24 24">
            <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M15 19l-7-7 7-7"/>
        </svg>
        Back to Variants
    </a>

    <!-- Form Card -->
    <div class="bg-white rounded-lg shadow-sm border border-gray-100 overflow-hidden">
        <form action="/admin/products/{{ $product->id }}/variants" method="POST" enctype="multipart/form-data" class="p-8">
            @csrf

            <!-- Product Info -->
            <div class="mb-8 pb-6 border-b border-gray-200">
                <h2 class="text-2xl font-bold text-[#1D433F] font-lora mb-1">Add New Variant</h2>
                <p class="text-gray-600 font-cg">
                    Product: <span class="font-semibold text-gray-900">{{ $product->name }}</span> | 
                    Base Price: <span class="font-semibold text-gray-900">₱{{ number_format($product->price, 2) }}</span>
                </p>
            </div>

            <!-- SKU -->
            <div class="mb-6">
                <label for="sku" class="block text-sm font-medium text-gray-700 font-cg mb-2">
                    SKU (Stock Keeping Unit) <span class="text-red-500">*</span>
                </label>
                <input type="text" 
                       name="sku" 
                       id="sku"
                       value="{{ old('sku') }}"
                       placeholder="e.g., TSHIRT-BLK-M"
                       class="w-full px-4 py-3 border border-gray-300 rounded-lg focus:ring-2 focus:ring-[#1FAC99] focus:border-transparent font-cg"
                       required>
                @error('sku')
                <p class="mt-1 text-sm text-red-600 font-cg">{{ $message }}</p>
                @enderror
                <p class="mt-1 text-xs text-gray-500 font-cg">Unique identifier for this variant (e.g., TSHIRT-BLACK-MEDIUM)</p>
            </div>

            <!-- Size and Color Row -->
            <div class="grid grid-cols-1 md:grid-cols-2 gap-6 mb-6">
                <!-- Size -->
                <div>
                    <label for="size" class="block text-sm font-medium text-gray-700 font-cg mb-2">
                        Size
                    </label>
                    <select name="size" 
                            id="size"
                            class="w-full px-4 py-3 border border-gray-300 rounded-lg focus:ring-2 focus:ring-[#1FAC99] focus:border-transparent font-cg">
                        <option value="">Select a size</option>
                        <optgroup label="Apparel Sizes">
                            <option value="XS">XS - Extra Small</option>
                            <option value="S">S - Small</option>
                            <option value="M">M - Medium</option>
                            <option value="L">L - Large</option>
                            <option value="XL">XL - Extra Large</option>
                            <option value="XXL">XXL - 2X Large</option>
                            <option value="XXXL">XXXL - 3X Large</option>
                        </optgroup>
                        <optgroup label="Numeric Sizes">
                            <option value="28">28</option>
                            <option value="30">30</option>
                            <option value="32">32</option>
                            <option value="34">34</option>
                            <option value="36">36</option>
                            <option value="38">38</option>
                            <option value="40">40</option>
                        </optgroup>
                    </select>
                    @error('size')
                    <p class="mt-1 text-sm text-red-600 font-cg">{{ $message }}</p>
                    @enderror
                </div>

                <!-- Color -->
                <div>
                    <label for="colorSelect" class="block text-sm font-medium text-gray-700 font-cg mb-2">
                        Color Name
                    </label>
                    <select name="color" 
                            id="colorSelect"
                            class="w-full px-4 py-3 border border-gray-300 rounded-lg focus:ring-2 focus:ring-[#1FAC99] focus:border-transparent font-cg"
                            onchange="updateColorPreview()">
                        <option value="">Select a color</option>
                        <optgroup label="Basic Colors">
                            <option value="Black" data-hex="#000000">Black</option>
                            <option value="White" data-hex="#FFFFFF">White</option>
                            <option value="Gray" data-hex="#808080">Gray</option>
                            <option value="Red" data-hex="#DC2626">Red</option>
                            <option value="Blue" data-hex="#2563EB">Blue</option>
                            <option value="Navy" data-hex="#1E3A8A">Navy</option>
                            <option value="Green" data-hex="#16A34A">Green</option>
                            <option value="Yellow" data-hex="#EAB308">Yellow</option>
                            <option value="Orange" data-hex="#EA580C">Orange</option>
                            <option value="Pink" data-hex="#EC4899">Pink</option>
                        </optgroup>
                        <optgroup label="Neutral Colors">
                            <option value="Brown" data-hex="#92400E">Brown</option>
                            <option value="Beige" data-hex="#D4C5B9">Beige</option>
                            <option value="Cream" data-hex="#FFFDD0">Cream</option>
                            <option value="Khaki" data-hex="#C3B091">Khaki</option>
                        </optgroup>
                        <optgroup label="Dark Colors">
                            <option value="Maroon" data-hex="#800000">Maroon</option>
                            <option value="Olive" data-hex="#808000">Olive</option>
                            <option value="Teal" data-hex="#008080">Teal</option>
                        </optgroup>
                        <optgroup label="Bright Colors">
                            <option value="Purple" data-hex="#9333EA">Purple</option>
                            <option value="Turquoise" data-hex="#40E0D0">Turquoise</option>
                            <option value="Lavender" data-hex="#E6E6FA">Lavender</option>
                        </optgroup>
                        <optgroup label="Custom">
                            <option value="custom">Custom Color...</option>
                        </optgroup>
                    </select>
                    @error('color')
                    <p class="mt-1 text-sm text-red-600 font-cg">{{ $message }}</p>
                    @enderror
                </div>
            </div>

            <!-- Custom Color Input (Hidden) -->
            <div id="customColorDiv" class="hidden mb-6">
                <label for="customColorInput" class="block text-sm font-medium text-gray-700 font-cg mb-2">
                    Custom Color Name
                </label>
                <input type="text" 
                       id="customColorInput"
                       placeholder="e.g., Sky Blue"
                       class="w-full px-4 py-3 border border-gray-300 rounded-lg focus:ring-2 focus:ring-[#1FAC99] focus:border-transparent font-cg">
            </div>

            <!-- Color Hex and Preview Row -->
            <div class="grid grid-cols-1 md:grid-cols-2 gap-6 mb-6">
                <!-- Color Hex -->
                <div>
                    <label class="block text-sm font-medium text-gray-700 font-cg mb-2">
                        Color Hex Code
                    </label>
                    <div class="flex gap-3">
                        <input type="color" 
                               name="color_hex" 
                               id="colorHex"
                               value="{{ old('color_hex', '#000000') }}"
                               class="h-12 w-16 border-2 border-gray-300 rounded-lg cursor-pointer"
                               onchange="updateColorPreview()">
                        <input type="text" 
                               id="colorHexText"
                               value="{{ old('color_hex', '#000000') }}"
                               placeholder="#000000"
                               class="flex-1 px-4 py-3 border border-gray-300 rounded-lg focus:ring-2 focus:ring-[#1FAC99] focus:border-transparent font-cg font-mono"
                               onchange="syncColorPicker(this.value)">
                    </div>
                    @error('color_hex')
                    <p class="mt-1 text-sm text-red-600 font-cg">{{ $message }}</p>
                    @enderror
                </div>

                <!-- Color Preview -->
                <div>
                    <label class="block text-sm font-medium text-gray-700 font-cg mb-2">
                        Color Preview
                    </label>
                    <div class="flex items-center gap-4">
                        <div id="colorPreview" 
                             class="w-16 h-12 rounded-lg border-2 border-gray-300 shadow-sm"
                             style="background-color: #000000"></div>
                        <span id="colorPreviewText" class="text-gray-900 font-semibold font-cg">Black</span>
                    </div>
                </div>
            </div>

            <!-- Price Adjustment and Stock Row -->
            <div class="grid grid-cols-1 md:grid-cols-2 gap-6 mb-8">
                <!-- Price Adjustment -->
                <div>
                    <label for="price_adjustment" class="block text-sm font-medium text-gray-700 font-cg mb-2">
                        Price Adjustment
                    </label>
                    <div class="relative">
                        <span class="absolute left-4 top-3.5 text-gray-500 font-cg">$</span>
                        <input type="number" 
                               name="price_adjustment" 
                               id="price_adjustment"
                               value="{{ old('price_adjustment', 0) }}"
                               step="0.01"
                               placeholder="0.00"
                               class="w-full pl-8 pr-4 py-3 border border-gray-300 rounded-lg focus:ring-2 focus:ring-[#1FAC99] focus:border-transparent font-cg">
                    </div>
                    @error('price_adjustment')
                    <p class="mt-1 text-sm text-red-600 font-cg">{{ $message }}</p>
                    @enderror
                    <p class="mt-1 text-xs text-gray-500 font-cg">
                        Final price will be: <span class="font-semibold text-gray-900">₱{{ number_format($product->price, 2) }}</span> + adjustment
                    </p>
                </div>

                <!-- Stock Quantity -->
                <div>
                    <label for="stock" class="block text-sm font-medium text-gray-700 font-cg mb-2">
                        Stock Quantity <span class="text-red-500">*</span>
                    </label>
                    <input type="number" 
                           name="stock" 
                           id="stock"
                           value="{{ old('stock', 0) }}"
                           min="0"
                           placeholder="0"
                           class="w-full px-4 py-3 border border-gray-300 rounded-lg focus:ring-2 focus:ring-[#1FAC99] focus:border-transparent font-cg"
                           required>
                    @error('stock')
                    <p class="mt-1 text-sm text-red-600 font-cg">{{ $message }}</p>
                    @enderror
                </div>
            </div>

            <!-- Variant Image -->
            <div class="mb-8">
                <label class="block text-sm font-medium text-gray-700 font-cg mb-2">
                    Variant Image (Optional)
                </label>
                <div class="border-2 border-dashed border-gray-300 rounded-lg p-6 text-center hover:border-[#1FAC99] transition-colors">
                    <input type="file" 
                           name="variant_image" 
                           id="variant_image"
                           accept="image/*"
                           class="hidden"
                           onchange="previewImage(event)">
                    <label for="variant_image" class="cursor-pointer">
                        <svg class="mx-auto h-12 w-12 text-gray-400 mb-2" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                            <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M4 16l4.586-4.586a2 2 0 012.828 0L16 16m-2-2l1.586-1.586a2 2 0 012.828 0L20 14m-6-6h.01M6 20h12a2 2 0 002-2V6a2 2 0 00-2-2H6a2 2 0 00-2 2v12a2 2 0 002 2z"/>
                        </svg>
                        <p class="text-sm text-gray-600 font-cg">Click to upload a variant-specific image</p>
                        <p class="text-xs text-gray-500 font-cg">PNG, JPG, GIF up to 2MB</p>
                    </label>
                </div>
                <div id="imagePreview" class="mt-4"></div>
            </div>

            <!-- Action Buttons -->
            <div class="flex items-center justify-end space-x-4 pt-6 border-t border-gray-200">
                <a href="/admin/products/{{ $product->id }}/variants" 
                   class="px-6 py-3 border border-gray-300 text-gray-700 font-cg rounded-lg hover:bg-gray-50 transition-colors">
                    Cancel
                </a>
                <button type="submit" 
                        class="px-6 py-3 bg-[#1FAC99] text-white font-cg rounded-lg hover:bg-[#1D433F] transition-colors shadow-sm">
                    Create Variant
                </button>
            </div>
        </form>
    </div>
</div>

@push('scripts')
<script>
function updateColorPreview() {
    const select = document.getElementById('colorSelect');
    const colorHex = document.getElementById('colorHex');
    const colorHexText = document.getElementById('colorHexText');
    const preview = document.getElementById('colorPreview');
    const previewText = document.getElementById('colorPreviewText');
    const customDiv = document.getElementById('customColorDiv');
    const customInput = document.getElementById('customColorInput');
    
    const selectedOption = select.options[select.selectedIndex];
    
    if (selectedOption.value === 'custom') {
        customDiv.classList.remove('hidden');
        customInput.required = true;
        previewText.textContent = customInput.value || 'Custom Color';
    } else {
        customDiv.classList.add('hidden');
        customInput.required = false;
        
        if (selectedOption.dataset.hex) {
            const hex = selectedOption.dataset.hex;
            colorHex.value = hex;
            colorHexText.value = hex;
            preview.style.backgroundColor = hex;
        }
        previewText.textContent = selectedOption.value || 'Select a color';
    }
}

function syncColorPicker(value) {
    const colorHex = document.getElementById('colorHex');
    const colorHexText = document.getElementById('colorHexText');
    const preview = document.getElementById('colorPreview');
    
    if (/^#[0-9A-F]{6}$/i.test(value)) {
        colorHex.value = value;
        colorHexText.value = value;
        preview.style.backgroundColor = value;
    }
}

function previewImage(event) {
    const preview = document.getElementById('imagePreview');
    preview.innerHTML = '';
    
    const file = event.target.files[0];
    if (file) {
        const reader = new FileReader();
        reader.onload = function(e) {
            const div = document.createElement('div');
            div.className = 'relative group';
            div.innerHTML = `
                <img src="${e.target.result}" class="w-32 h-32 object-cover rounded-lg border-2 border-gray-200">
                <p class="mt-2 text-sm text-gray-600 font-cg">${file.name}</p>
            `;
            preview.appendChild(div);
        };
        reader.readAsDataURL(file);
    }
}

// Color picker sync
document.getElementById('colorHex').addEventListener('change', function() {
    document.getElementById('colorHexText').value = this.value;
    document.getElementById('colorPreview').style.backgroundColor = this.value;
});

// Listen to custom color input
document.getElementById('customColorInput').addEventListener('input', function() {
    document.getElementById('colorPreviewText').textContent = this.value || 'Custom Color';
});

// Form submission - handle custom color
document.querySelector('form').addEventListener('submit', function(e) {
    const select = document.getElementById('colorSelect');
    const customInput = document.getElementById('customColorInput');
    
    if (select.value === 'custom' && customInput.value) {
        const hiddenInput = document.createElement('input');
        hiddenInput.type = 'hidden';
        hiddenInput.name = 'color';
        hiddenInput.value = customInput.value;
        this.appendChild(hiddenInput);
    }
});
</script>
@endpush
@endsection