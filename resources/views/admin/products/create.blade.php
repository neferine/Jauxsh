@extends('layouts.admin')
@section('title', 'Create Product | Admin')
@section('page-title', 'Create New Product')
@section('page-description', 'Add a new product to your inventory')

@section('content')
<div class="max-w-4xl">
    <div class="bg-white rounded-lg shadow-sm border border-gray-100 overflow-hidden">
        <form action="/admin/products" method="POST" enctype="multipart/form-data" class="p-8">
            @csrf

            <!-- Product Name -->
            <div class="mb-6">
                <label for="name" class="block text-sm font-medium text-gray-700 font-cg mb-2">
                    Product Name <span class="text-red-500">*</span>
                </label>
                <input type="text" 
                       name="name" 
                       id="name" 
                       value="{{ old('name') }}"
                       class="w-full px-4 py-3 border border-gray-300 rounded-lg focus:ring-2 focus:ring-[#1FAC99] focus:border-transparent font-cg"
                       placeholder="Enter product name"
                       required>
                @error('name')
                <p class="mt-1 text-sm text-red-600 font-cg">{{ $message }}</p>
                @enderror
            </div>

            <!-- Description -->
            <div class="mb-6">
                <label for="description" class="block text-sm font-medium text-gray-700 font-cg mb-2">
                    Description
                </label>
                <textarea name="description" 
                          id="description" 
                          rows="4"
                          class="w-full px-4 py-3 border border-gray-300 rounded-lg focus:ring-2 focus:ring-[#1FAC99] focus:border-transparent font-cg"
                          placeholder="Enter product description">{{ old('description') }}</textarea>
                @error('description')
                <p class="mt-1 text-sm text-red-600 font-cg">{{ $message }}</p>
                @enderror
            </div>

            <!-- Price and Stock Row -->
            <div class="grid grid-cols-1 md:grid-cols-2 gap-6 mb-6">
                <!-- Price -->
                <div>
                    <label for="price" class="block text-sm font-medium text-gray-700 font-cg mb-2">
                        Price (USD) <span class="text-red-500">*</span>
                    </label>
                    <div class="relative">
                        <span class="absolute left-4 top-3 text-gray-500 font-cg">$</span>
                        <input type="number" 
                               name="price" 
                               id="price" 
                               value="{{ old('price') }}"
                               step="0.01"
                               min="0"
                               class="w-full pl-8 pr-4 py-3 border border-gray-300 rounded-lg focus:ring-2 focus:ring-[#1FAC99] focus:border-transparent font-cg"
                               placeholder="0.00"
                               required>
                    </div>
                    @error('price')
                    <p class="mt-1 text-sm text-red-600 font-cg">{{ $message }}</p>
                    @enderror
                </div>

                <!-- Stock -->
                <div>
                    <label for="stock" class="block text-sm font-medium text-gray-700 font-cg mb-2">
                        Stock Quantity <span class="text-red-500">*</span>
                    </label>
                    <input type="number" 
                           name="stock" 
                           id="stock" 
                           value="{{ old('stock', 0) }}"
                           min="0"
                           class="w-full px-4 py-3 border border-gray-300 rounded-lg focus:ring-2 focus:ring-[#1FAC99] focus:border-transparent font-cg"
                           placeholder="0"
                           required>
                    @error('stock')
                    <p class="mt-1 text-sm text-red-600 font-cg">{{ $message }}</p>
                    @enderror
                </div>
            </div>

            <!-- Category -->
            <div class="mb-6">
                <label for="category_id" class="block text-sm font-medium text-gray-700 font-cg mb-2">
                    Category <span class="text-red-500">*</span>
                </label>
                <select name="category_id" 
                        id="category_id"
                        class="w-full px-4 py-3 border border-gray-300 rounded-lg focus:ring-2 focus:ring-[#1FAC99] focus:border-transparent font-cg"
                        required>
                    <option value="">Select a category</option>
                    @foreach($categories as $category)
                    <option value="{{ $category->id }}" {{ old('category_id') == $category->id ? 'selected' : '' }}>
                        {{ $category->name }}
                    </option>
                    @endforeach
                </select>
                @error('category_id')
                <p class="mt-1 text-sm text-red-600 font-cg">{{ $message }}</p>
                @enderror
            </div>

            <!-- Product Images -->
            <div class="mb-8">
                <label class="block text-sm font-medium text-gray-700 font-cg mb-2">
                    Product Images
                </label>
                <div class="border-2 border-dashed border-gray-300 rounded-lg p-6 text-center hover:border-[#1FAC99] transition-colors">
                    <input type="file" 
                           name="images[]" 
                           id="images" 
                           multiple
                           accept="image/*"
                           class="hidden"
                           onchange="previewImages(event)">
                    <label for="images" class="cursor-pointer">
                        <svg class="mx-auto h-12 w-12 text-gray-400" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                            <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M4 16l4.586-4.586a2 2 0 012.828 0L16 16m-2-2l1.586-1.586a2 2 0 012.828 0L20 14m-6-6h.01M6 20h12a2 2 0 002-2V6a2 2 0 00-2-2H6a2 2 0 00-2 2v12a2 2 0 002 2z"/>
                        </svg>
                        <p class="mt-2 text-sm text-gray-600 font-cg">Click to upload images</p>
                        <p class="mt-1 text-xs text-gray-500 font-cg">PNG, JPG, GIF up to 2MB each</p>
                    </label>
                </div>
                <div id="imagePreview" class="mt-4 grid grid-cols-4 gap-4"></div>
                @error('images.*')
                <p class="mt-1 text-sm text-red-600 font-cg">{{ $message }}</p>
                @enderror
            </div>

            <!-- Action Buttons -->
            <div class="flex items-center justify-end space-x-4 pt-6 border-t border-gray-200">
                <a href="/admin/products" class="px-6 py-3 border border-gray-300 text-gray-700 font-cg rounded-lg hover:bg-gray-50 transition-colors">
                    Cancel
                </a>
                <button type="submit" class="px-6 py-3 bg-[#1FAC99] text-white font-cg rounded-lg hover:bg-[#1D433F] transition-colors shadow-sm">
                    Create Product
                </button>
            </div>
        </form>
    </div>
</div>

@push('scripts')
<script>
function previewImages(event) {
    const preview = document.getElementById('imagePreview');
    preview.innerHTML = '';
    
    const files = event.target.files;
    
    for (let i = 0; i < files.length; i++) {
        const file = files[i];
        const reader = new FileReader();
        
        reader.onload = function(e) {
            const div = document.createElement('div');
            div.className = 'relative group';
            div.innerHTML = `
                <img src="${e.target.result}" class="w-full h-24 object-cover rounded-lg border border-gray-200">
                <div class="absolute inset-0 bg-black bg-opacity-0 group-hover:bg-opacity-30 transition-all rounded-lg flex items-center justify-center">
                    <span class="text-white text-xs opacity-0 group-hover:opacity-100">${file.name}</span>
                </div>
            `;
            preview.appendChild(div);
        };
        
        reader.readAsDataURL(file);
    }
}
</script>
@endpush
@endsection