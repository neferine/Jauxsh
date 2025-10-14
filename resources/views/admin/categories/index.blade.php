@extends('layouts.admin')
@section('title', 'Categories | Admin')
@section('page-title', 'Categories')
@section('page-description', 'Manage product categories')

@section('content')
<div class="space-y-6">
    <!-- Header with Add Button -->
    <div class="flex justify-between items-center">
        <div>
            <h2 class="text-2xl font-bold text-[#1D433F] font-lora">All Categories</h2>
            <p class="text-gray-600 font-cg mt-1">{{ $categories->total() }} total categories</p>
        </div>
        <a href="/admin/categories/create" class="inline-flex items-center px-6 py-3 bg-[#1FAC99] text-white font-cg rounded-lg hover:bg-[#1D433F] transition-colors shadow-sm">
            <svg class="w-5 h-5 mr-2" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M12 6v6m0 0v6m0-6h6m-6 0H6"/>
            </svg>
            Add New Category
        </a>
    </div>

    <!-- Categories Table -->
    <div class="bg-white rounded-lg shadow-sm border border-gray-100 overflow-hidden">
        @if($categories->count())
        <div class="overflow-x-auto">
            <table class="w-full">
                <thead class="bg-gray-50 border-b border-gray-200">
                    <tr class="text-left text-xs font-semibold text-gray-600 uppercase tracking-wider font-cg">
                        <th class="px-6 py-4">Name</th>
                        <th class="px-6 py-4">Description</th>
                        <th class="px-6 py-4">Parent Category</th>
                        <th class="px-6 py-4">Products</th>
                        <th class="px-6 py-4">Created</th>
                        <th class="px-6 py-4 text-right">Actions</th>
                    </tr>
                </thead>
                <tbody class="divide-y divide-gray-100">
                    @foreach($categories as $category)
                    <tr class="hover:bg-gray-50 transition-colors">
                        <td class="px-6 py-4">
                            <div class="flex items-center">
                                <div class="w-10 h-10 bg-[#d8e8e7] rounded-lg flex items-center justify-center mr-3">
                                    <svg class="w-5 h-5 text-[#1FAC99]" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                                        <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M7 7h.01M7 3h5c.512 0 1.024.195 1.414.586l7 7a2 2 0 010 2.828l-7 7a2 2 0 01-2.828 0l-7-7A1.994 1.994 0 013 12V7a4 4 0 014-4z"/>
                                    </svg>
                                </div>
                                <div>
                                    <div class="text-sm font-medium text-gray-900 font-cg">{{ $category->name }}</div>
                                    <div class="text-xs text-gray-500 font-cg">ID: #{{ $category->id }}</div>
                                </div>
                            </div>
                        </td>
                        <td class="px-6 py-4">
                            <div class="text-sm text-gray-700 font-cg max-w-xs truncate">
                                {{ $category->description ?? 'No description' }}
                            </div>
                        </td>
                        <td class="px-6 py-4">
                            @if($category->parent)
                            <span class="inline-flex items-center px-3 py-1 rounded-full text-xs font-medium bg-blue-100 text-blue-800 font-cg">
                                {{ $category->parent->name }}
                            </span>
                            @else
                            <span class="inline-flex items-center px-3 py-1 rounded-full text-xs font-medium bg-gray-100 text-gray-600 font-cg">
                                Parent
                            </span>
                            @endif
                        </td>
                        <td class="px-6 py-4">
                            <span class="text-sm font-medium text-gray-900 font-cg">
                                {{ $category->products->count() ?? 0 }}
                            </span>
                        </td>
                        <td class="px-6 py-4 text-sm text-gray-500 font-cg">
                            {{ $category->created_at->format('M d, Y') }}
                        </td>
                        <td class="px-6 py-4 text-right">
                            <div class="flex items-center justify-end space-x-3">
                                <a href="/admin/categories/{{ $category->id }}/edit" 
                                   class="text-[#1FAC99] hover:text-[#1D433F] font-cg text-sm hover:underline">
                                    Edit
                                </a>
                                <form action="/admin/categories/{{ $category->id }}" method="POST" 
                                      onsubmit="return confirm('Are you sure? This will also delete all subcategories and products in this category.')" 
                                      class="inline">
                                    @csrf
                                    @method('DELETE')
                                    <button type="submit" class="text-red-600 hover:text-red-800 font-cg text-sm hover:underline">
                                        Delete
                                    </button>
                                </form>
                            </div>
                        </td>
                    </tr>
                    @endforeach
                </tbody>
            </table>
        </div>

        <!-- Pagination -->
        <div class="px-6 py-4 border-t border-gray-100">
            {{ $categories->links() }}
        </div>
        @else
        <div class="px-6 py-12 text-center">
            <svg class="mx-auto h-12 w-12 text-gray-400" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M7 7h.01M7 3h5c.512 0 1.024.195 1.414.586l7 7a2 2 0 010 2.828l-7 7a2 2 0 01-2.828 0l-7-7A1.994 1.994 0 013 12V7a4 4 0 014-4z"/>
            </svg>
            <h3 class="mt-4 text-lg font-medium text-gray-900 font-lora">No categories yet</h3>
            <p class="mt-2 text-sm text-gray-500 font-cg">Get started by creating your first category.</p>
            <div class="mt-6">
                <a href="/admin/categories/create" class="inline-flex items-center px-4 py-2 bg-[#1FAC99] text-white font-cg rounded-lg hover:bg-[#1D433F] transition-colors">
                    <svg class="w-5 h-5 mr-2" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                        <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M12 6v6m0 0v6m0-6h6m-6 0H6"/>
                    </svg>
                    Add Category
                </a>
            </div>
        </div>
        @endif
    </div>
</div>
@endsection