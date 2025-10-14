@extends('layouts.admin')
@section('title', 'Create Category | Admin')
@section('page-title', 'Create New Category')
@section('page-description', 'Add a new product category')

@section('content')
<div class="max-w-2xl">
    <div class="bg-white rounded-lg shadow-sm border border-gray-100 overflow-hidden">
        <form action="/admin/categories" method="POST" class="p-8">
            @csrf

            <!-- Category Name -->
            <div class="mb-6">
                <label for="name" class="block text-sm font-medium text-gray-700 font-cg mb-2">
                    Category Name <span class="text-red-500">*</span>
                </label>
                <input type="text" 
                       name="name" 
                       id="name" 
                       value="{{ old('name') }}"
                       class="w-full px-4 py-3 border border-gray-300 rounded-lg focus:ring-2 focus:ring-[#1FAC99] focus:border-transparent font-cg"
                       placeholder="e.g., T-Shirts, Accessories"
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
                          placeholder="Brief description of this category">{{ old('description') }}</textarea>
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
                    <option value="{{ $parent->id }}" {{ old('parent_id') == $parent->id ? 'selected' : '' }}>
                        {{ $parent->name }}
                    </option>
                    @endforeach
                </select>
                <p class="mt-2 text-sm text-gray-500 font-cg">
                    Optional: Select a parent category to create a subcategory
                </p>
                @error('parent_id')
                <p class="mt-1 text-sm text-red-600 font-cg">{{ $message }}</p>
                @enderror
            </div>

            <!-- Action Buttons -->
            <div class="flex items-center justify-end space-x-4 pt-6 border-t border-gray-200">
                <a href="/admin/categories" class="px-6 py-3 border border-gray-300 text-gray-700 font-cg rounded-lg hover:bg-gray-50 transition-colors">
                    Cancel
                </a>
                <button type="submit" class="px-6 py-3 bg-[#1FAC99] text-white font-cg rounded-lg hover:bg-[#1D433F] transition-colors shadow-sm">
                    Create Category
                </button>
            </div>
        </form>
    </div>

    <!-- Info Card -->
    <div class="mt-6 bg-blue-50 border border-blue-200 rounded-lg p-4">
        <div class="flex">
            <svg class="w-5 h-5 text-blue-600 mr-3 flex-shrink-0" fill="currentColor" viewBox="0 0 20 20">
                <path fill-rule="evenodd" d="M18 10a8 8 0 11-16 0 8 8 0 0116 0zm-7-4a1 1 0 11-2 0 1 1 0 012 0zM9 9a1 1 0 000 2v3a1 1 0 001 1h1a1 1 0 100-2v-3a1 1 0 00-1-1H9z" clip-rule="evenodd"/>
            </svg>
            <div>
                <h4 class="text-sm font-medium text-blue-900 font-lora mb-1">Category Tips</h4>
                <ul class="text-sm text-blue-800 font-cg space-y-1 list-disc list-inside">
                    <li>Use clear, descriptive names for easy navigation</li>
                    <li>Parent categories can have multiple subcategories</li>
                    <li>Deleting a category will affect all its products</li>
                </ul>
            </div>
        </div>
    </div>
</div>
@endsection