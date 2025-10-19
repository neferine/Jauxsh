@extends('layouts.admin')

@section('title', 'Collections | Admin')
@section('page-title', 'Collections Management')

@section('content')

<div class="min-h-screen">
    <!-- Header -->
    <div class="flex items-center justify-between mb-8">
        <div>
            <h1 class="text-3xl font-lora font-bold text-[#1D433F] mb-2">
                Collections
            </h1>
            <p class="text-gray-600 font-cg">Manage your product collections and groupings.</p>
        </div>
        <a href="{{ route('admin.collections.create') }}"
           class="inline-flex items-center px-5 py-3 bg-gradient-to-br from-[#1FAC99] to-[#1D433F] text-white text-sm font-cg rounded-lg shadow-md hover:shadow-lg transition-all">
            <svg class="w-5 h-5 mr-2" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2"
                      d="M12 6v6m0 0v6m0-6h6m-6 0H6"/>
            </svg>
            Add Collection
        </a>
    </div>

    <!-- Collections Table -->
    <div class="bg-white rounded-lg shadow-sm border border-gray-100 overflow-hidden">
        <div class="px-6 py-4 border-b border-gray-100 flex items-center justify-between">
            <h3 class="text-lg font-semibold text-[#1D433F] font-lora">All Collections</h3>
            <form method="GET" action="{{ route('admin.collections.index') }}" class="relative">
                <input type="text" name="search" placeholder="Search collections..."
                       class="pl-10 pr-4 py-2 border border-gray-300 rounded-lg text-sm focus:ring-[#1FAC99] focus:border-[#1FAC99] font-cg"
                       value="{{ request('search') }}">
                <svg class="absolute left-3 top-2.5 w-4 h-4 text-gray-400" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                    <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2"
                          d="M21 21l-4.35-4.35M11 5a6 6 0 100 12 6 6 0 000-12z"/>
                </svg>
            </form>
        </div>

        @if($collections->count())
        <div class="overflow-x-auto">
            <table class="w-full">
                <thead class="bg-gray-50">
                    <tr class="text-left text-xs font-semibold text-gray-600 uppercase tracking-wider font-cg">
                        <th class="px-6 py-3">Image</th>
                        <th class="px-6 py-3">Name</th>
                        <th class="px-6 py-3">Description</th>
                        <th class="px-6 py-3">Products</th>
                        <th class="px-6 py-3">Created</th>
                        <th class="px-6 py-3">Actions</th>
                    </tr>
                </thead>
                <tbody class="divide-y divide-gray-100">
                    @foreach($collections as $collection)
                    <tr class="hover:bg-gray-50 transition-colors cursor-pointer" 
                        onclick="window.location='{{ route('admin.collections.show', $collection->id) }}'">
                        <td class="px-6 py-4">
                            @if($collection->image_url)
                                <img src="{{ asset('storage/' . $collection->image_url) }}" 
                                     alt="{{ $collection->name }}" 
                                     class="w-16 h-16 rounded-lg object-cover border">
                            @else
                                <div class="w-16 h-16 rounded-lg bg-[#d8e8e7] flex items-center justify-center text-[#1FAC99] font-bold">
                                    {{ substr($collection->name, 0, 1) }}
                                </div>
                            @endif
                        </td>
                        <td class="px-6 py-4 text-sm font-medium text-gray-900 font-cg">
                            {{ $collection->name }}
                        </td>
                        <td class="px-6 py-4 text-sm text-gray-600 font-cg line-clamp-2 max-w-xs">
                            {{ $collection->description ?? '—' }}
                        </td>
                        <td class="px-6 py-4 text-sm text-gray-600 font-cg">
                            {{ $collection->products_count ?? 0 }}
                        </td>
                        <td class="px-6 py-4 text-sm text-gray-500 font-cg">
                            {{ $collection->created_at->format('M d, Y') }}
                        </td>
                        <td class="px-6 py-4 text-sm font-cg space-x-2" onclick="event.stopPropagation()">
                            <a href="{{ route('admin.collections.edit', $collection->id) }}"
                               class="inline-flex items-center px-3 py-1.5 bg-[#1FAC99]/10 text-[#1D433F] rounded-md hover:bg-[#1FAC99]/20 transition">
                                <svg class="w-4 h-4 mr-1" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                                    <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2"
                                          d="M15.232 5.232l3.536 3.536m-2.036-1.5a2.5 2.5 0 11-3.536-3.536l2.036 1.5zM3 17.25V21h3.75L17.81 9.94a2.5 2.5 0 00-3.536-3.536L3 17.25z"/>
                                </svg>
                                Edit
                            </a>
                            <form action="{{ route('admin.collections.destroy', $collection->id) }}" method="POST" class="inline-block"
                                  onsubmit="return confirm('Are you sure you want to delete this collection?');">
                                @csrf
                                @method('DELETE')
                                <button type="submit"
                                        class="inline-flex items-center px-3 py-1.5 bg-red-50 text-red-600 rounded-md hover:bg-red-100 transition">
                                    <svg class="w-4 h-4 mr-1" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                                        <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2"
                                              d="M19 7l-.867 12.142A2 2 0 0116.138 21H7.862a2 2 0 01-1.995-1.858L5 7m5 4v6m4-6v6M9 7h6m2-2H7m5-2v2"/>
                                    </svg>
                                    Delete
                                </button>
                            </form>
                        </td>
                    </tr>
                    @endforeach
                </tbody>
            </table>
        </div>

        <!-- Pagination -->
        <div class="px-6 py-4 border-t border-gray-100">
            {{ $collections->links() }}
        </div>
        @else
        <div class="py-12 text-center text-gray-500 font-cg">
            No collections found.
        </div>
        @endif
    </div>
</div>
@endsection