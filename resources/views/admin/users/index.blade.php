@extends('layouts.admin')
@section('title', 'Manage Users | Admin')

@section('content')
<div class="min-h-screen">
    <!-- Header -->
    <div class="flex justify-between items-center mb-8">
        <div>
            <h1 class="text-3xl font-bold text-[#1D433F] font-lora mb-2">User Management</h1>
            <p class="text-gray-600 font-cg">Manage all registered users</p>
        </div>
        <a href="{{ route('admin.users.create') }}" 
           class="bg-[#1FAC99] text-white px-6 py-3 rounded-lg font-cg font-semibold hover:bg-[#1D433F] transition-all flex items-center gap-2 shadow-sm">
            <svg class="w-5 h-5" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M12 4v16m8-8H4"/>
            </svg>
            Add New User
        </a>
    </div>

    <!-- Success/Error Messages -->
    @if(session('success'))
    <div class="bg-green-50 border-l-4 border-green-500 p-4 mb-6 rounded-sm">
        <div class="flex items-center">
            <svg class="w-5 h-5 text-green-500 mr-3" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M5 13l4 4L19 7"/>
            </svg>
            <p class="text-green-800 font-cg">{{ session('success') }}</p>
        </div>
    </div>
    @endif

    @if(session('error'))
    <div class="bg-red-50 border-l-4 border-red-500 p-4 mb-6 rounded-sm">
        <div class="flex items-center">
            <svg class="w-5 h-5 text-red-500 mr-3" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M6 18L18 6M6 6l12 12"/>
            </svg>
            <p class="text-red-800 font-cg">{{ session('error') }}</p>
        </div>
    </div>
    @endif

    <!-- Search and Filter Bar -->
    <div class="bg-white rounded-lg shadow-sm border border-gray-100 p-6 mb-6">
        <form method="GET" action="{{ route('admin.users.index') }}" class="grid grid-cols-1 md:grid-cols-4 gap-4">
            <!-- Search -->
            <div class="md:col-span-2">
                <label class="block text-sm font-semibold text-gray-700 mb-2 font-cg uppercase tracking-wide">Search</label>
                <input type="text" 
                       name="search" 
                       value="{{ request('search') }}"
                       placeholder="Search by name, email, or phone..."
                       class="w-full px-4 py-2 border border-gray-300 rounded-lg focus:ring-2 focus:ring-[#1FAC99] focus:border-transparent font-lora">
            </div>

            <!-- Role Filter -->
            <div>
                <label class="block text-sm font-semibold text-gray-700 mb-2 font-cg uppercase tracking-wide">User Type</label>
                <select name="is_admin" class="w-full px-4 py-2 border border-gray-300 rounded-lg focus:ring-2 focus:ring-[#1FAC99] focus:border-transparent font-lora">
                    <option value="">All Users</option>
                    <option value="1" {{ request('is_admin') == '1' ? 'selected' : '' }}>Admins</option>
                    <option value="0" {{ request('is_admin') == '0' ? 'selected' : '' }}>Customers</option>
                </select>
            </div>

            <!-- Sort -->
            <div>
                <label class="block text-sm font-semibold text-gray-700 mb-2 font-cg uppercase tracking-wide">Sort By</label>
                <select name="sort_by" class="w-full px-4 py-2 border border-gray-300 rounded-lg focus:ring-2 focus:ring-[#1FAC99] focus:border-transparent font-lora">
                    <option value="created_at" {{ request('sort_by') == 'created_at' ? 'selected' : '' }}>Date Joined</option>
                    <option value="first_name" {{ request('sort_by') == 'first_name' ? 'selected' : '' }}>First Name</option>
                    <option value="last_name" {{ request('sort_by') == 'last_name' ? 'selected' : '' }}>Last Name</option>
                    <option value="email" {{ request('sort_by') == 'email' ? 'selected' : '' }}>Email</option>
                </select>
            </div>

            <!-- Hidden sort order -->
            <input type="hidden" name="sort_order" value="{{ request('sort_order', 'desc') }}">

            <!-- Buttons -->
            <div class="md:col-span-4 flex gap-3">
                <button type="submit" 
                        class="bg-[#1D433F] text-white px-6 py-2 rounded-lg font-cg font-semibold hover:bg-[#1FAC99] transition-all">
                    Apply Filters
                </button>
                <a href="{{ route('admin.users.index') }}" 
                   class="bg-gray-200 text-gray-700 px-6 py-2 rounded-lg font-cg font-semibold hover:bg-gray-300 transition-all">
                    Clear Filters
                </a>
            </div>
        </form>
    </div>

    <!-- Users Table -->
    <div class="bg-white rounded-lg shadow-sm border border-gray-100 overflow-hidden">
        <div class="overflow-x-auto">
            <table class="w-full">
                <thead class="bg-gray-50">
                    <tr class="text-left text-xs font-semibold text-gray-600 uppercase tracking-wider font-cg">
                        <th class="px-6 py-4">User</th>
                        <th class="px-6 py-4">Contact</th>
                        <th class="px-6 py-4">User Type</th>
                        <th class="px-6 py-4">Joined</th>
                        <th class="px-6 py-4">Orders</th>
                        <th class="px-6 py-4 text-center">Actions</th>
                    </tr>
                </thead>
                <tbody class="divide-y divide-gray-100">
                    @forelse($users as $user)
                    <tr class="hover:bg-gray-50 transition-colors">
                        <!-- User Info -->
                        <td class="px-6 py-4">
                            <div class="flex items-center">
                                <div class="w-10 h-10 bg-[#d8e8e7] rounded-full flex items-center justify-center text-[#1FAC99] font-bold font-cg">
                                    {{ strtoupper(substr($user->first_name, 0, 1)) }}{{ strtoupper(substr($user->last_name, 0, 1)) }}
                                </div>
                                <div class="ml-3">
                                    <p class="font-semibold text-gray-900 font-lora">{{ $user->first_name }} {{ $user->last_name }}</p>
                                    @if($user->id === auth()->id())
                                    <span class="text-xs text-blue-600 font-cg">(You)</span>
                                    @endif
                                </div>
                            </div>
                        </td>

                        <!-- Contact -->
                        <td class="px-6 py-4">
                            <p class="text-gray-700 font-lora text-sm">{{ $user->email }}</p>
                            <p class="text-gray-500 font-cg text-xs">{{ $user->phone ?? 'No phone' }}</p>
                        </td>

                        <!-- User Type -->
                        <td class="px-6 py-4">
                            @if($user->is_admin)
                            <span class="px-3 py-1 text-xs font-semibold bg-purple-100 text-purple-800 rounded-full font-cg uppercase">
                                Admin
                            </span>
                            @else
                            <span class="px-3 py-1 text-xs font-semibold bg-gray-100 text-gray-800 rounded-full font-cg uppercase">
                                Customer
                            </span>
                            @endif
                        </td>

                        <!-- Joined Date -->
                        <td class="px-6 py-4">
                            <p class="text-gray-700 font-lora text-sm">{{ $user->created_at->format('M d, Y') }}</p>
                            <p class="text-gray-500 font-cg text-xs">{{ $user->created_at->diffForHumans() }}</p>
                        </td>

                        <!-- Orders Count -->
                        <td class="px-6 py-4">
                            <p class="text-gray-900 font-semibold font-cg">{{ $user->orders->count() }}</p>
                        </td>

                        <!-- Actions -->
                        <td class="px-6 py-4">
                            <div class="flex items-center justify-center gap-2">
                                <a href="{{ route('admin.users.show', $user->id) }}" 
                                   class="text-[#1FAC99] hover:text-[#1D433F] font-cg text-sm hover:underline">
                                    View
                                </a>
                                <span class="text-gray-300">|</span>
                                <a href="{{ route('admin.users.edit', $user->id) }}" 
                                   class="text-blue-600 hover:text-blue-800 font-cg text-sm hover:underline">
                                    Edit
                                </a>
                                @if($user->id !== auth()->id())
                                <span class="text-gray-300">|</span>
                                <form action="{{ route('admin.users.destroy', $user->id) }}" 
                                      method="POST" 
                                      class="inline"
                                      onsubmit="return confirm('Are you sure you want to delete this user?');">
                                    @csrf
                                    @method('DELETE')
                                    <button type="submit" class="text-red-600 hover:text-red-800 font-cg text-sm hover:underline">
                                        Delete
                                    </button>
                                </form>
                                @endif
                            </div>
                        </td>
                    </tr>
                    @empty
                    <tr>
                        <td colspan="6" class="px-6 py-12 text-center">
                            <svg class="mx-auto h-12 w-12 text-gray-400" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                                <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M12 4.354a4 4 0 110 5.292M15 21H3v-1a6 6 0 0112 0v1zm0 0h6v-1a6 6 0 00-9-5.197M13 7a4 4 0 11-8 0 4 4 0 018 0z"/>
                            </svg>
                            <p class="mt-4 text-gray-500 font-cg">No users found.</p>
                        </td>
                    </tr>
                    @endforelse
                </tbody>
            </table>
        </div>

        <!-- Pagination -->
        @if($users->hasPages())
        <div class="px-6 py-4 border-t border-gray-100">
            {{ $users->links() }}
        </div>
        @endif
    </div>
</div>
@endsection