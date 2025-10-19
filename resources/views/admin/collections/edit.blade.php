@extends('layouts.admin')
@section('title', 'Edit Collection | Admin')
@section('page-title', 'Edit Collection')

@section('content')
<div class="min-h-screen">
    <!-- Header with Breadcrumb -->
    <div class="mb-8">
        <div class="flex items-center text-sm text-gray-500 font-cg mb-4">
            <a href="{{ route('admin.collections.index') }}" class="hover:text-[#1FAC99] transition">Collections</a>
            <svg class="w-4 h-4 mx-2" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M9 5l7 7-7 7"/>
            </svg>
            <span class="text-[#1D433F] font-medium">Edit {{ $collection->name }}</span>
        </div>
        
        <div class="flex items-center justify-between">
            <div>
                <h1 class="text-3xl font-lora font-bold text-[#1D433F] mb-2">
                    Edit Collection
                </h1>
                <p class="text-gray-600 font-cg">Modify details for "{{ $collection->name }}"</p>
            </div>
            <div class="flex items-center space-x-3">
                <a href="{{ route('admin.collections.show', $collection->id) }}"
                   class="inline-flex items-center px-4 py-2.5 bg-white border-2 border-gray-200 text-gray-700 rounded-lg font-cg hover:border-gray-300 hover:shadow-sm transition-all">
                    <svg class="w-4 h-4 mr-2" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                        <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M15 12a3 3 0 11-6 0 3 3 0 016 0z"/>
                        <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M2.458 12C3.732 7.943 7.523 5 12 5c4.478 0 8.268 2.943 9.542 7-1.274 4.057-5.064 7-9.542 7-4.477 0-8.268-2.943-9.542-7z"/>
                    </svg>
                    View
                </a>
                <a href="{{ route('admin.collections.index') }}"
                   class="inline-flex items-center px-4 py-2.5 bg-white border-2 border-gray-200 text-gray-700 rounded-lg font-cg hover:border-gray-300 hover:shadow-sm transition-all">
                    <svg class="w-4 h-4 mr-2" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                        <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M10 19l-7-7m0 0l7-7m-7 7h18"/>
                    </svg>
                    Back
                </a>
            </div>
        </div>
    </div>

    <div class="grid grid-cols-1 lg:grid-cols-3 gap-6">
        <!-- Main Content -->
        <div class="lg:col-span-2 space-y-6">
            <!-- Collection Information Form -->
            <form action="{{ route('admin.collections.update', $collection->id) }}" method="POST" enctype="multipart/form-data">
                @csrf
                @method('PUT')
                
                <div class="bg-white rounded-lg shadow-sm border border-gray-100 overflow-hidden">
                    <!-- Form Header -->
                    <div class="px-8 py-5 border-b border-gray-100 bg-gradient-to-r from-gray-50 to-white">
                        <h2 class="text-lg font-semibold text-[#1D433F] font-lora">Collection Information</h2>
                        <p class="text-sm text-gray-500 font-cg mt-1">Update the collection details below</p>
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
                                   value="{{ old('name', $collection->name) }}"
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
                                      class="w-full px-4 py-3 border border-gray-300 rounded-lg focus:ring-2 focus:ring-[#1FAC99] focus:border-transparent font-cg resize-none transition-all">{{ old('description', $collection->description) }}</textarea>
                            <p class="text-xs text-gray-500 mt-2 font-cg">Help customers understand what this collection is about</p>
                        </div>

                        <!-- Image Upload Field -->
                        <div>
                            <label class="block text-sm font-semibold text-gray-700 font-cg mb-2">
                                Collection Image
                            </label>
                            
                            @if($collection->image_url)
                                <div class="mb-4 relative inline-block">
                                    <img src="{{ asset('storage/' . $collection->image_url) }}" 
                                         alt="{{ $collection->name }}" 
                                         class="w-40 h-40 object-cover rounded-lg border-2 border-gray-200 shadow-sm">
                                    <div class="absolute top-2 right-2 bg-[#1FAC99] text-white text-xs px-2 py-1 rounded-md font-cg">
                                        Current
                                    </div>
                                </div>
                            @endif

                            <div class="mt-2 flex justify-center px-6 pt-5 pb-6 border-2 border-gray-300 border-dashed rounded-lg hover:border-[#1FAC99] transition-colors">
                                <div class="space-y-2 text-center">
                                    <svg class="mx-auto h-12 w-12 text-gray-400" stroke="currentColor" fill="none" viewBox="0 0 48 48">
                                        <path d="M28 8H12a4 4 0 00-4 4v20m32-12v8m0 0v8a4 4 0 01-4 4H12a4 4 0 01-4-4v-4m32-4l-3.172-3.172a4 4 0 00-5.656 0L28 28M8 32l9.172-9.172a4 4 0 015.656 0L28 28m0 0l4 4m4-24h8m-4-4v8m-12 4h.02" stroke-width="2" stroke-linecap="round" stroke-linejoin="round" />
                                    </svg>
                                    <div class="flex text-sm text-gray-600 font-cg">
                                        <label for="image_url" class="relative cursor-pointer bg-white rounded-md font-medium text-[#1FAC99] hover:text-[#1D433F] focus-within:outline-none transition">
                                            <span>Upload a new file</span>
                                            <input id="image_url" name="image_url" type="file" class="sr-only" accept="image/*">
                                        </label>
                                        <p class="pl-1">or drag and drop</p>
                                    </div>
                                    <p class="text-xs text-gray-500">PNG, JPG, GIF up to 10MB</p>
                                    @if($collection->image_url)
                                        <p class="text-xs text-[#1FAC99] font-medium">Leave blank to keep existing image</p>
                                    @endif
                                </div>
                            </div>
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
                                       value="{{ old('sort_order', $collection->sort_order) }}"
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
                                               {{ old('is_active', $collection->is_active) ? 'checked' : '' }}
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
                                Update Collection
                            </button>
                        </div>
                    </div>
                </div>
            </form>

            <!-- Manage Products Section -->
            <div class="bg-white rounded-lg shadow-sm border border-gray-100 overflow-hidden">
                <div class="px-8 py-5 border-b border-gray-100 bg-gradient-to-r from-gray-50 to-white">
                    <h2 class="text-lg font-semibold text-[#1D433F] font-lora">Manage Products</h2>
                    <p class="text-sm text-gray-500 font-cg mt-1">Add or remove products from this collection</p>
                </div>

                <!-- Add Product Form -->
                <div class="px-8 py-6 border-b border-gray-100 bg-blue-50/30">
                    <form action="{{ route('admin.collections.attachProduct', $collection->id) }}" method="POST" class="flex items-end gap-4">
                        @csrf
                        <div class="flex-1">
                            <label class="block text-sm font-semibold text-gray-700 font-cg mb-2">
                                Select Product
                            </label>
                            <select name="product_id" 
                                    class="w-full px-4 py-3 border border-gray-300 rounded-lg focus:ring-2 focus:ring-[#1FAC99] focus:border-transparent font-cg transition-all"
                                    required>
                                <option value="">Choose a product...</option>
                                @foreach($products as $product)
                                    @if(!in_array($product->id, $collectionProducts))
                                        <option value="{{ $product->id }}">{{ $product->name }} - ${{ number_format($product->price, 2) }}</option>
                                    @endif
                                @endforeach
                            </select>
                        </div>
                        <div class="w-32">
                            <label class="block text-sm font-semibold text-gray-700 font-cg mb-2">
                                Sort Order
                            </label>
                            <input type="number" 
                                   name="sort_order" 
                                   value="0"
                                   placeholder="0"
                                   class="w-full px-4 py-3 border border-gray-300 rounded-lg focus:ring-2 focus:ring-[#1FAC99] focus:border-transparent font-cg transition-all">
                        </div>
                        <button type="submit"
                                class="inline-flex items-center px-6 py-3 bg-[#1FAC99] text-white rounded-lg font-cg hover:bg-[#1D433F] transition-colors">
                            <svg class="w-5 h-5 mr-2" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                                <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M12 6v6m0 0v6m0-6h6m-6 0H6"/>
                            </svg>
                            Add Product
                        </button>
                    </form>
                </div>

                <!-- Products List -->
                <div class="px-8 py-6">
                    @if($collection->products->count())
                        <div class="space-y-3">
                            @foreach($collection->products->sortBy('pivot.sort_order') as $product)
                                <div class="flex items-center justify-between p-4 bg-gray-50 rounded-lg border border-gray-200 hover:border-[#1FAC99] transition">
                                    <div class="flex items-center space-x-4 flex-1">
                                        @if($product->images->first())
                                            <img src="{{ asset('storage/' . $product->images->first()->image_path) }}" 
                                                 alt="{{ $product->name }}"
                                                 class="w-16 h-16 object-cover rounded-lg border">
                                        @else
                                            <div class="w-16 h-16 bg-gray-200 rounded-lg flex items-center justify-center">
                                                <svg class="w-8 h-8 text-gray-400" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                                                    <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M20 7l-8-4-8 4m16 0l-8 4m8-4v10l-8 4m0-10L4 7m8 4v10M4 7v10l8 4"/>
                                                </svg>
                                            </div>
                                        @endif
                                        
                                        <div class="flex-1 min-w-0">
                                            <h4 class="text-sm font-semibold text-gray-900 font-cg truncate">
                                                {{ $product->name }}
                                            </h4>
                                            <p class="text-sm text-gray-500 font-cg mt-1">
                                                ${{ number_format($product->price, 2) }} • Sort: {{ $product->pivot->sort_order }}
                                            </p>
                                        </div>
                                    </div>

                                    <div class="flex items-center space-x-2">
                                        <a href="{{ route('admin.products.show', $product->id) }}" 
                                           class="inline-flex items-center px-3 py-1.5 text-sm bg-blue-50 text-blue-600 rounded-md hover:bg-blue-100 transition font-cg">
                                            <svg class="w-4 h-4 mr-1" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                                                <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M15 12a3 3 0 11-6 0 3 3 0 016 0z"/>
                                                <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M2.458 12C3.732 7.943 7.523 5 12 5c4.478 0 8.268 2.943 9.542 7-1.274 4.057-5.064 7-9.542 7-4.477 0-8.268-2.943-9.542-7z"/>
                                            </svg>
                                            View
                                        </a>
                                        
                                        <form action="{{ route('admin.collections.detachProduct', [$collection->id, $product->id]) }}" 
                                              method="POST" 
                                              onsubmit="return confirm('Remove this product from the collection?');">
                                            @csrf
                                            @method('DELETE')
                                            <button type="submit"
                                                    class="inline-flex items-center px-3 py-1.5 text-sm bg-red-50 text-red-600 rounded-md hover:bg-red-100 transition font-cg">
                                                <svg class="w-4 h-4 mr-1" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                                                    <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M6 18L18 6M6 6l12 12"/>
                                                </svg>
                                                Remove
                                            </button>
                                        </form>
                                    </div>
                                </div>
                            @endforeach
                        </div>
                    @else
                        <div class="text-center py-12">
                            <svg class="mx-auto h-16 w-16 text-gray-400" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                                <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M20 7l-8-4-8 4m16 0l-8 4m8-4v10l-8 4m0-10L4 7m8 4v10M4 7v10l8 4"/>
                            </svg>
                            <h3 class="mt-4 text-sm font-semibold text-gray-900 font-cg">No products yet</h3>
                            <p class="mt-2 text-sm text-gray-500 font-cg">Add products to this collection using the form above.</p>
                        </div>
                    @endif
                </div>
            </div>
        </div>

        <!-- Sidebar -->
        <div class="space-y-6">
            <!-- Metadata Card -->
            <div class="bg-white rounded-lg shadow-sm border border-gray-100 overflow-hidden">
                <div class="px-6 py-4 border-b border-gray-100 bg-gradient-to-r from-gray-50 to-white">
                    <h3 class="text-lg font-semibold text-[#1D433F] font-lora">Information</h3>
                </div>
                <div class="p-6 space-y-4">
                    <div>
                        <p class="text-xs font-semibold text-gray-500 uppercase tracking-wider font-cg mb-1">Status</p>
                        <p class="text-sm font-medium text-gray-900 font-cg">
                            @if($collection->is_active)
                                <span class="inline-flex items-center px-2.5 py-1 bg-green-100 text-green-800 text-xs font-semibold rounded-full">
                                    <svg class="w-3 h-3 mr-1" fill="currentColor" viewBox="0 0 20 20">
                                        <path fill-rule="evenodd" d="M10 18a8 8 0 100-16 8 8 0 000 16zm3.707-9.293a1 1 0 00-1.414-1.414L9 10.586 7.707 9.293a1 1 0 00-1.414 1.414l2 2a1 1 0 001.414 0l4-4z" clip-rule="evenodd"/>
                                    </svg>
                                    Active
                                </span>
                            @else
                                <span class="inline-flex items-center px-2.5 py-1 bg-gray-100 text-gray-800 text-xs font-semibold rounded-full">
                                    Inactive
                                </span>
                            @endif
                        </p>
                    </div>

                    <div class="border-t border-gray-100 pt-4">
                        <p class="text-xs font-semibold text-gray-500 uppercase tracking-wider font-cg mb-1">Total Products</p>
                        <p class="text-2xl font-bold text-[#1D433F] font-lora">{{ $collection->products->count() }}</p>
                    </div>

                    <div class="border-t border-gray-100 pt-4">
                        <p class="text-xs font-semibold text-gray-500 uppercase tracking-wider font-cg mb-1">Created</p>
                        <p class="text-sm text-gray-900 font-cg">{{ $collection->created_at->format('M d, Y h:i A') }}</p>
                    </div>

                    <div class="border-t border-gray-100 pt-4">
                        <p class="text-xs font-semibold text-gray-500 uppercase tracking-wider font-cg mb-1">Last Updated</p>
                        <p class="text-sm text-gray-900 font-cg">{{ $collection->updated_at->format('M d, Y h:i A') }}</p>
                    </div>
                </div>
            </div>

            <!-- Delete Section -->
            <div class="bg-white rounded-lg shadow-sm border border-red-200 overflow-hidden">
                <div class="px-6 py-4 border-b border-red-100 bg-red-50">
                    <h3 class="text-lg font-semibold text-red-900 font-lora">Danger Zone</h3>
                </div>
                <div class="p-6">
                    <p class="text-sm text-gray-600 font-cg mb-4">Once deleted, this collection and all its associations will be permanently removed.</p>
                    <form action="{{ route('admin.collections.destroy', $collection->id) }}" method="POST" 
                          onsubmit="return confirm('Are you sure you want to delete this collection? This action cannot be undone.');">
                        @csrf
                        @method('DELETE')
                        <button type="submit"
                                class="w-full inline-flex items-center justify-center px-5 py-2.5 bg-red-600 text-white rounded-lg font-cg hover:bg-red-700 transition-colors">
                            <svg class="w-5 h-5 mr-2" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                                <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M19 7l-.867 12.142A2 2 0 0116.138 21H7.862a2 2 0 01-1.995-1.858L5 7m5 4v6m4-6v6m1-10V4a1 1 0 00-1-1h-4a1 1 0 00-1 1v3M4 7h16"/>
                            </svg>
                            Delete Collection
                        </button>
                    </form>
                </div>
            </div>
        </div>
    </div>
</div>
@endsection