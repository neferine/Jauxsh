@extends('layouts.admin')

@section('title', 'Add Variant - ' . $product->name)

@section('content')
<div class="container mx-auto px-6 py-8">
    <div class="mb-6">
        <a href="{{ route('admin.products.variants.index', $product) }}" 
           class="text-gray-600 hover:text-gray-900 flex items-center gap-2">
            <svg class="w-5 h-5" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M15 19l-7-7 7-7"/>
            </svg>
            Back to Variants
        </a>
    </div>

    <div class="bg-white rounded-lg shadow-md p-8">
        <h1 class="text-3xl font-bold text-gray-900 mb-2">Add Product Variant</h1>
        <p class="text-gray-600 mb-8">Product: <strong>{{ $product->name }}</strong></p>

        <form action="{{ route('admin.products.variants.store', $product) }}" method="POST" enctype="multipart/form-data">
            @csrf

            <div class="grid grid-cols-1 md:grid-cols-2 gap-6">
                <!-- SKU -->
                <div class="md:col-span-2">
                    <label class="block text-sm font-medium text-gray-700 mb-2">
                        SKU (Stock Keeping Unit) <span class="text-red-500">*</span>
                    </label>
                    <input type="text" 
                           name="sku" 
                           value="{{ old('sku') }}"
                           placeholder="e.g., TSHIRT-BLK-M"
                           class="w-full px-4 py-2 border border-gray-300 rounded-lg focus:ring-2 focus:ring-blue-500 focus:border-transparent"
                           required>
                    @error('sku')
                        <p class="text-red-500 text-sm mt-1">{{ $message }}</p>
                    @enderror
                    <p class="text-gray-500 text-sm mt-1">Unique identifier for this variant</p>
                </div>

                <!-- Color -->
                <div>
                    <label class="block text-sm font-medium text-gray-700 mb-2">
                        Color Name
                    </label>
                    <select name="color" 
                            id="colorSelect"
                            class="w-full px-4 py-2 border border-gray-300 rounded-lg focus:ring-2 focus:ring-blue-500 focus:border-transparent"
                            onchange="updateColorPreview()">
                        <option value="">Select a color</option>
                        <optgroup label="Common Colors">
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
                            <option value="Purple" data-hex="#9333EA">Purple</option>
                            <option value="Brown" data-hex="#92400E">Brown</option>
                            <option value="Beige" data-hex="#D4C5B9">Beige</option>
                            <option value="Cream" data-hex="#FFFDD0">Cream</option>
                            <option value="Khaki" data-hex="#C3B091">Khaki</option>
                            <option value="Maroon" data-hex="#800000">Maroon</option>
                            <option value="Olive" data-hex="#808000">Olive</option>
                            <option value="Teal" data-hex="#008080">Teal</option>
                            <option value="Turquoise" data-hex="#40E0D0">Turquoise</option>
                            <option value="Lavender" data-hex="#E6E6FA">Lavender</option>
                        </optgroup>
                        <optgroup label="Custom">
                            <option value="custom">Custom Color...</option>
                        </optgroup>
                    </select>
                    @error('color')
                        <p class="text-red-500 text-sm mt-1">{{ $message }}</p>
                    @enderror
                </div>

                <!-- Custom Color Input (Hidden by default) -->
                <div id="customColorDiv" class="hidden">
                    <label class="block text-sm font-medium text-gray-700 mb-2">
                        Custom Color Name
                    </label>
                    <input type="text" 
                           id="customColorInput"
                           placeholder="e.g., Sky Blue"
                           class="w-full px-4 py-2 border border-gray-300 rounded-lg focus:ring-2 focus:ring-blue-500 focus:border-transparent">
                </div>

                <!-- Color Hex Code -->
                <div>
                    <label class="block text-sm font-medium text-gray-700 mb-2">
                        Color Hex Code
                    </label>
                    <div class="flex gap-2">
                        <input type="color" 
                               name="color_hex" 
                               id="colorHex"
                               value="{{ old('color_hex', '#000000') }}"
                               class="h-11 w-20 border border-gray-300 rounded-lg cursor-pointer"
                               onchange="updateColorPreview()">
                        <input type="text" 
                               id="colorHexText"
                               value="{{ old('color_hex', '#000000') }}"
                               placeholder="#000000"
                               class="flex-1 px-4 py-2 border border-gray-300 rounded-lg focus:ring-2 focus:ring-blue-500 focus:border-transparent"
                               onchange="syncColorPicker(this.value)">
                    </div>
                    @error('color_hex')
                        <p class="text-red-500 text-sm mt-1">{{ $message }}</p>
                    @enderror
                    <p class="text-gray-500 text-sm mt-1">Visual representation of the color</p>
                </div>

                <!-- Color Preview -->
                <div>
                    <label class="block text-sm font-medium text-gray-700 mb-2">
                        Preview
                    </label>
                    <div class="flex items-center gap-3">
                        <div id="colorPreview" 
                             class="w-20 h-11 rounded-lg border-2 border-gray-300"
                             style="background-color: #000000"></div>
                        <span id="colorPreviewText" class="text-gray-700 font-medium">Black</span>
                    </div>
                </div>

                <!-- Size -->
                <div>
                    <label class="block text-sm font-medium text-gray-700 mb-2">
                        Size
                    </label>
                    <select name="size" 
                            class="w-full px-4 py-2 border border-gray-300 rounded-lg focus:ring-2 focus:ring-blue-500 focus:border-transparent">
                        <option value="">Select a size</option>
                        <optgroup label="Standard Sizes">
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
                        <p class="text-red-500 text-sm mt-1">{{ $message }}</p>
                    @enderror
                </div>

                <!-- Price Adjustment -->
                <div>
                    <label class="block text-sm font-medium text-gray-700 mb-2">
                        Price Adjustment
                    </label>
                    <div class="relative">
                        <span class="absolute left-3 top-2.5 text-gray-500">$</span>
                        <input type="number" 
                               name="price_adjustment" 
                               value="{{ old('price_adjustment', 0) }}"
                               step="0.01"
                               placeholder="0.00"
                               class="w-full pl-8 pr-4 py-2 border border-gray-300 rounded-lg focus:ring-2 focus:ring-blue-500 focus:border-transparent">
                    </div>
                    @error('price_adjustment')
                        <p class="text-red-500 text-sm mt-1">{{ $message }}</p>
                    @enderror
                    <p class="text-gray-500 text-sm mt-1">
                        Base price: ${{ number_format($product->price, 2) }} 
                        <span class="text-gray-400">| Use negative for discounts</span>
                    </p>
                </div>

                <!-- Stock -->
                <div>
                    <label class="block text-sm font-medium text-gray-700 mb-2">
                        Stock Quantity <span class="text-red-500">*</span>
                    </label>
                    <input type="number" 
                           name="stock" 
                           value="{{ old('stock', 0) }}"
                           min="0"
                           placeholder="0"
                           class="w-full px-4 py-2 border border-gray-300 rounded-lg focus:ring-2 focus:ring-blue-500 focus:border-transparent"
                           required>
                    @error('stock')
                        <p class="text-red-500 text-sm mt-1">{{ $message }}</p>
                    @enderror
                </div>

                <!-- Variant Image (Optional) -->
                <div class="md:col-span-2">
                    <label class="block text-sm font-medium text-gray-700 mb-2">
                        Variant Image (Optional)
                    </label>
                    <input type="file" 
                           name="variant_image" 
                           accept="image/*"
                           class="w-full px-4 py-2 border border-gray-300 rounded-lg focus:ring-2 focus:ring-blue-500 focus:border-transparent">
                    <p class="text-gray-500 text-sm mt-1">Upload a specific image for this color variant</p>
                </div>
            </div>

            <!-- Action Buttons -->
            <div class="flex gap-4 mt-8 pt-6 border-t border-gray-200">
                <button type="submit" 
                        class="px-6 py-3 bg-gray-900 text-white rounded-lg hover:bg-gray-800 transition-colors">
                    Create Variant
                </button>
                <a href="{{ route('admin.products.variants.index', $product) }}" 
                   class="px-6 py-3 bg-gray-200 text-gray-700 rounded-lg hover:bg-gray-300 transition-colors">
                    Cancel
                </a>
            </div>
        </form>
    </div>
</div>

<script>
// Update color preview
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

// Sync color picker
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

// Listen to color picker changes
document.getElementById('colorHex').addEventListener('change', function() {
    document.getElementById('colorHexText').value = this.value;
    document.getElementById('colorPreview').style.backgroundColor = this.value;
});

// Listen to custom color input
document.getElementById('customColorInput').addEventListener('input', function() {
    document.getElementById('colorPreviewText').textContent = this.value || 'Custom Color';
    // Update the hidden color name field
    document.getElementById('colorSelect').value = 'custom';
});

// Form submission - handle custom color
document.querySelector('form').addEventListener('submit', function(e) {
    const select = document.getElementById('colorSelect');
    const customInput = document.getElementById('customColorInput');
    
    if (select.value === 'custom' && customInput.value) {
        // Create a hidden input with the custom color value
        const hiddenInput = document.createElement('input');
        hiddenInput.type = 'hidden';
        hiddenInput.name = 'color';
        hiddenInput.value = customInput.value;
        this.appendChild(hiddenInput);
    }
});
</script>
@endsection