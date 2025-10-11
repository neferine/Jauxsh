@extends('layouts.admin')

@section('title', 'Add New Product')
@section('page-title', 'Add New Product')

@section('content')
<div class="max-w-3xl">
    <form action="{{ route('admin.products.store') }}" method="POST" enctype="multipart/form-data" class="bg-white rounded-lg shadow p-6">
        @csrf
        
        <div class="mb-4">
            <label for="name" class="block text-gray-700 font-semibold mb-2">Product Name</label>
            <input type="text" name="name" id="name" required
                   class="w-full px-4 py-2 border border-gray-300 rounded-lg focus:outline-none focus:ring-2 focus:ring-blue-500"
                   value="{{ old('name') }}">
            @error('name')
                <p class="text-red-500 text-sm mt-1">{{ $message }}</p>
            @enderror
        </div>
        
        <div class="mb-4">
            <label for="description" class="block text-gray-700 font-semibold mb-2">Description</label>
            <textarea name="description" id="description" rows="4" required
                      class="w-full px-4 py-2 border border-gray-300 rounded-lg focus:outline-none focus:ring-2 focus:ring-blue-500">{{ old('description') }}</textarea>
            @error('description')
                <p class="text-red-500 text-sm mt-1">{{ $message }}</p>
            @enderror
        </div>
        
        <div class="grid grid-cols-2 gap-4 mb-4">
            <div>
                <label for="price" class="block text-gray-700 font-semibold mb-2">Price</label>
                <input type="number" name="price" id="price" step="0.01" required
                       class="w-full px-4 py-2 border border-gray-300 rounded-lg focus:outline-none focus:ring-2 focus:ring-blue-500"
                       value="{{ old('price') }}">
                @error('price')
                    <p class="text-red-500 text-sm mt-1">{{ $message }}</p>
                @enderror
            </div>
            
            <div>
                <label for="stock" class="block text-gray-700 font-semibold mb-2">Stock Quantity</label>
                <input type="number" name="stock" id="stock" required
                       class="w-full px-4 py-2 border border-gray-300 rounded-lg focus:outline-none focus:ring-2 focus:ring-blue-500"
                       value="{{ old('stock') }}">
                @error('stock')
                    <p class="text-red-500 text-sm mt-1">{{ $message }}</p>
                @enderror
            </div>
        </div>
        
        <div class="mb-4">
            <label for="image" class="block text-gray-700 font-semibold mb-2">Product Image</label>
            <input type="file" name="image" id="image" accept="image/*"
                   class="w-full px-4 py-2 border border-gray-300 rounded-lg">
            @error('image')
                <p class="text-red-500 text-sm mt-1">{{ $message }}</p>
            @enderror
        </div>
        
        <div class="flex justify-end space-x-4">
            <a href="{{ route('admin.products.index') }}" 
               class="px-6 py-2 border border-gray-300 rounded-lg hover:bg-gray-50">
                Cancel
            </a>
            <button type="submit" 
                    class="px-6 py-2 bg-blue-600 text-white rounded-lg hover:bg-blue-700">
                Add Product
            </button>
        </div>
    </form>
</div>
@endsection