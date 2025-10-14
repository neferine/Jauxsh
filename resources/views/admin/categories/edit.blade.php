@extends('layouts.admin')
@section('title', 'Edit Category | Admin')
@section('page-title', 'Edit Category')
@section('page-description', 'Update category information')

@section('content')
<div class="max-w-2xl">
    <div class="bg-white rounded-lg shadow-sm border border-gray-100 overflow-hidden">
        <form action="/admin/categories/{{ $category->id }}" method="POST" class="p-8">
            @csrf
            @method('PUT')

            <!-- Category Name -->
            <div class="mb-6">
                <label for="name" class="block text-sm font-medium text-gray-700 font-cg mb-2">
                    Category Name <span class="text-red-500">*</span>
                </label>
                <input type="text" 
                       name="name" 
                       id="name" 
                       value="{{ old('name', $category->name) }}"
                       class="w-full px-4 py-3 border border-gray-300 rounded-lg focus:ring-2 focus:ring-[#1FAC99] focus:border-transparent font-cg"
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
                          class="w-full px-4 py-3 border border-gray-300 rounded-lg focus:ring-2 focus:ring-[#1FAC99] focus:border-transparent font-cg">{{ old('description', $category->description) }}</textarea>
                @error('description')
                <p class="mt-1 text-sm text-red-600 font-cg">{{ $message }}</p>
                @enderror
            </div>

            <!-- Parent Category -->
            <div class="mb-8">
                <label for="parent_id" class="block text-sm font-medium text-gray-700 font-cg mb-2">
                    Parent Category
                </label>
                <select name="parent_id" 
                        id="parent_id"
                        class="w-full px-4 py-3 border border-gray-300 rounded-lg focus:ring-2 focus:ring-[#1FAC99] focus:border-transparent font-cg">
                    <option value="">None (Top-level category)</option>
                    @foreach($parentCategories as $parent)
                    <option value="{{ $parent->id }}" {{ old('parent_id', $category->parent_id) == $parent->id ? 'selected' : '' }}>
                        {{ $parent->name }}
                    </option>
                    @endforeach
                </select>
                <p class="mt-2 text-sm text-gray-500 font-cg">
                    Optional: Select a parent category to make this a subcategory
                </p>
                @error('parent_id')
                <p class="mt-1 text-sm text-red-600 font-cg">{{ $message }}</p>
                @enderror
            </div>

            <!-- Category Stats -->
            <div class="mb-8 p-4 bg-gray-50 rounded-lg">
                <h4 class="text-sm font-medium text-gray-700 font-lora mb-3">Category Statistics</h4>
                <div class="grid grid-cols-2 gap-4">
                    <div>
                        <p class="text-xs text-gray-500 font-cg">Products</p>
                        <p class="text-lg font-semibold text-[#1D433F] font-lora">{{ $category->products->count() }}</p>
                    </div>
                    <div>
                        <p class="text-xs text-gray-500 font-cg">Subcategories</p>
                        <p class="text-lg font-semibold text-[#1D433F] font-lora">{{ $category->children->count() }}</p>
                    </div>
                </div>
            </div>

            <!-- Action Buttons -->
            <div class="flex items-center justify-end space-x-4 pt-6 border-t border-gray-200">
                <a href="/admin/categories" class="px-6 py-3 border border-gray-300 text-gray-700 font-cg rounded-lg hover:bg-gray-50 transition-colors">
                    Cancel
                </a>
                <button type="submit" class="px-6 py-3 bg-[#1FAC99] text-white font-cg rounded-lg hover:bg-[#1D433F] transition-colors shadow-sm">
                    Update Category
                </button>
            </div>
        </form>
    </div>

    <!-- Warning Card -->
    @if($category->products->count() > 0 || $category->children->count() > 0)
    <div class="mt-6 bg-yellow-50 border border-yellow-200 rounded-lg p-4">
        <div class="flex">
            <svg class="w-5 h-5 text-yellow-600 mr-3 flex-shrink-0" fill="currentColor" viewBox="0 0 20 20">
                <path fill-rule="evenodd" d="M8.257 3.099c.765-1.36 2.722-1.36 3.486 0l5.58 9.92c.75 1.334-.213 2.98-1.742 2.98H4.42c-1.53 0-2.493-1.646-1.743-2.98l5.58-9.92zM11 13a1 1 0 11-2 0 1 1 0 012 0zm-1-8a1 1 0 00-1 1v3a1 1 0 002 0V6a1 1 0 00-1-1z" clip-rule="evenodd"/>
            </svg>
            <div>
                <h4 class="text-sm font-medium text-yellow-900 font-lora mb-1">Important Notice</h4>
                <p class="text-sm text-yellow-800 font-cg">
                    This category contains {{ $category->products->count() }} product(s) and {{ $category->children->count() }} subcategory(ies). 
                    Changes may affect these items.
                </p>
            </div>
        </div>
    </div>
    @endif
</div>
@endsection