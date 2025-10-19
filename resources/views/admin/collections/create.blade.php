@extends('layouts.admin')
@section('title', 'Add Collection | Admin')
@section('page-title', 'Add New Collection')

@section('content')
<div class="min-h-screen">
    <!-- Header with Breadcrumb -->
    <div class="mb-8">
        <div class="flex items-center text-sm text-gray-500 font-cg mb-4">
            <a href="{{ route('admin.collections.index') }}" class="hover:text-[#1FAC99] transition">Collections</a>
            <svg class="w-4 h-4 mx-2" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M9 5l7 7-7 7"/>
            </svg>
            <span class="text-[#1D433F] font-medium">Add New</span>
        </div>
        
        <div class="flex items-center justify-between">
            <div>
                <h1 class="text-3xl font-lora font-bold text-[#1D433F] mb-2">
                    Add New Collection
                </h1>
                <p class="text-gray-600 font-cg">Create a new collection to organize and group products.</p>
            </div>
            <a href="{{ route('admin.collections.index') }}"
               class="inline-flex items-center px-4 py-2.5 bg-white border-2 border-gray-200 text-gray-700 rounded-lg font-cg hover:border-gray-300 hover:shadow-sm transition-all">
                <svg class="w-4 h-4 mr-2" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                    <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M10 19l-7-7m0 0l7-7m-7 7h18"/>
                </svg>
                Back to Collections
            </a>
        </div>
    </div>

    <!-- Form Card -->
    <div class="max-w-4xl">
        <form action="{{ route('admin.collections.store') }}" method="POST" enctype="multipart/form-data">
            @csrf
            
            <div class="bg-white rounded-lg shadow-sm border border-gray-100 overflow-hidden">
                <!-- Form Header -->
                <div class="px-8 py-5 border-b border-gray-100 bg-gradient-to-r from-gray-50 to-white">
                    <h2 class="text-lg font-semibold text-[#1D433F] font-lora">Collection Information</h2>
                    <p class="text-sm text-gray-500 font-cg mt-1">Fill in the details below to create your collection</p>
                </div>

                <!-- Form Body -->
                <div class="px-8 py-6 space-y-6">
                    <!-- Name Field -->
                    <div>
                        <label class="block text-sm font-semibold text-gray-700 font-cg mb-2">
                            Collection Name <span class="text-red-500">*</span>
                        </label>
                        <input type="text" 
                               name="name" 
                               value="{{ old('name') }}"
                               placeholder="e.g., Summer Collection, Best Sellers"
                               class="w-full px-4 py-3 border border-gray-300 rounded-lg focus:ring-2 focus:ring-[#1FAC99] focus:border-transparent font-cg transition-all"
                               required>
                        @error('name') 
                            <p class="text-red-500 text-sm mt-2 flex items-center">
                                <svg class="w-4 h-4 mr-1" fill="currentColor" viewBox="0 0 20 20">
                                    <path fill-rule="evenodd" d="M18 10a8 8 0 11-16 0 8 8 0 0116 0zm-7 4a1 1 0 11-2 0 1 1 0 012 0zm-1-9a1 1 0 00-1 1v4a1 1 0 102 0V6a1 1 0 00-1-1z" clip-rule="evenodd"/>
                                </svg>
                                {{ $message }}
                            </p>
                        @enderror
                    </div>

                    <!-- Description Field -->
                    <div>
                        <label class="block text-sm font-semibold text-gray-700 font-cg mb-2">
                            Description
                        </label>
                        <textarea name="description" 
                                  rows="4"
                                  placeholder="Describe what makes this collection special..."
                                  class="w-full px-4 py-3 border border-gray-300 rounded-lg focus:ring-2 focus:ring-[#1FAC99] focus:border-transparent font-cg resize-none transition-all">{{ old('description') }}</textarea>
                        <p class="text-xs text-gray-500 mt-2 font-cg">Help customers understand what this collection is about</p>
                        @error('description') 
                            <p class="text-red-500 text-sm mt-2 flex items-center">
                                <svg class="w-4 h-4 mr-1" fill="currentColor" viewBox="0 0 20 20">
                                    <path fill-rule="evenodd" d="M18 10a8 8 0 11-16 0 8 8 0 0116 0zm-7 4a1 1 0 11-2 0 1 1 0 012 0zm-1-9a1 1 0 00-1 1v4a1 1 0 102 0V6a1 1 0 00-1-1z" clip-rule="evenodd"/>
                                </svg>
                                {{ $message }}
                            </p>
                        @enderror
                    </div>

                    <!-- Image Upload Field -->
                    <div>
                        <label class="block text-sm font-semibold text-gray-700 font-cg mb-2">
                            Collection Image
                        </label>
                        <div class="mt-2 flex justify-center px-6 pt-5 pb-6 border-2 border-gray-300 border-dashed rounded-lg hover:border-[#1FAC99] transition-colors">
                            <div class="space-y-2 text-center">
                                <svg class="mx-auto h-12 w-12 text-gray-400" stroke="currentColor" fill="none" viewBox="0 0 48 48">
                                    <path d="M28 8H12a4 4 0 00-4 4v20m32-12v8m0 0v8a4 4 0 01-4 4H12a4 4 0 01-4-4v-4m32-4l-3.172-3.172a4 4 0 00-5.656 0L28 28M8 32l9.172-9.172a4 4 0 015.656 0L28 28m0 0l4 4m4-24h8m-4-4v8m-12 4h.02" stroke-width="2" stroke-linecap="round" stroke-linejoin="round" />
                                </svg>
                                <div class="flex text-sm text-gray-600 font-cg">
                                    <label for="image_url" class="relative cursor-pointer bg-white rounded-md font-medium text-[#1FAC99] hover:text-[#1D433F] focus-within:outline-none transition">
                                        <span>Upload a file</span>
                                        <input id="image_url" name="image_url" type="file" class="sr-only" accept="image/*">
                                    </label>
                                    <p class="pl-1">or drag and drop</p>
                                </div>
                                <p class="text-xs text-gray-500">PNG, JPG, GIF up to 10MB</p>
                            </div>
                        </div>
                        @error('image_url') 
                            <p class="text-red-500 text-sm mt-2 flex items-center">
                                <svg class="w-4 h-4 mr-1" fill="currentColor" viewBox="0 0 20 20">
                                    <path fill-rule="evenodd" d="M18 10a8 8 0 11-16 0 8 8 0 0116 0zm-7 4a1 1 0 11-2 0 1 1 0 012 0zm-1-9a1 1 0 00-1 1v4a1 1 0 102 0V6a1 1 0 00-1-1z" clip-rule="evenodd"/>
                                </svg>
                                {{ $message }}
                            </p>
                        @enderror
                    </div>

                    <!-- Settings Grid -->
                    <div class="grid grid-cols-1 md:grid-cols-2 gap-6 pt-4">
                        <!-- Sort Order -->
                        <div>
                            <label class="block text-sm font-semibold text-gray-700 font-cg mb-2">
                                Sort Order
                            </label>
                            <input type="number" 
                                   name="sort_order" 
                                   value="{{ old('sort_order', 0) }}"
                                   placeholder="0"
                                   class="w-full px-4 py-3 border border-gray-300 rounded-lg focus:ring-2 focus:ring-[#1FAC99] focus:border-transparent font-cg transition-all">
                            <p class="text-xs text-gray-500 mt-2 font-cg">Lower numbers appear first</p>
                        </div>

                        <!-- Active Status -->
                        <div>
                            <label class="block text-sm font-semibold text-gray-700 font-cg mb-2">
                                Status
                            </label>
                            <div class="flex items-center h-full">
                                <label class="relative inline-flex items-center cursor-pointer">
                                    <input type="checkbox" 
                                           name="is_active" 
                                           id="is_active" 
                                           value="1" 
                                           {{ old('is_active', true) ? 'checked' : '' }}
                                           class="sr-only peer">
                                    <div class="w-11 h-6 bg-gray-200 peer-focus:outline-none peer-focus:ring-4 peer-focus:ring-[#1FAC99]/20 rounded-full peer peer-checked:after:translate-x-full peer-checked:after:border-white after:content-[''] after:absolute after:top-[2px] after:left-[2px] after:bg-white after:border-gray-300 after:border after:rounded-full after:h-5 after:w-5 after:transition-all peer-checked:bg-[#1FAC99]"></div>
                                    <span class="ml-3 text-sm font-medium text-gray-700 font-cg">Make collection active</span>
                                </label>
                            </div>
                        </div>
                    </div>
                </div>

                <!-- Form Footer -->
                <div class="px-8 py-5 bg-gray-50 border-t border-gray-100 flex items-center justify-between">
                    <p class="text-sm text-gray-500 font-cg">
                        <span class="text-red-500">*</span> Required fields
                    </p>
                    <div class="flex items-center space-x-3">
                        <a href="{{ route('admin.collections.index') }}"
                           class="px-5 py-2.5 bg-white border border-gray-300 text-gray-700 rounded-lg font-cg hover:bg-gray-50 transition-colors">
                            Cancel
                        </a>
                        <button type="submit"
                                class="inline-flex items-center px-6 py-2.5 bg-gradient-to-br from-[#1FAC99] to-[#1D433F] text-white rounded-lg font-cg shadow-md hover:shadow-lg transition-all">
                            <svg class="w-5 h-5 mr-2" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                                <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M5 13l4 4L19 7"/>
                            </svg>
                            Create Collection
                        </button>
                    </div>
                </div>
            </div>
        </form>
    </div>
</div>
@endsection