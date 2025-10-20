@extends('layouts.admin')
@section('title', 'User Details | Admin')

@section('content')
<div class="min-h-screen">
    <!-- Back Button -->
    <div class="mb-6">
        <a href="{{ route('admin.users.index') }}" 
           class="inline-flex items-center text-gray-600 hover:text-[#1FAC99] font-cg transition-colors">
            <svg class="w-5 h-5 mr-2" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M15 19l-7-7 7-7"/>
            </svg>
            Back to Users
        </a>
    </div>

    <!-- Success Message -->
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

    <!-- Header -->
    <div class="flex justify-between items-start mb-8">
        <div class="flex items-center">
            <div class="w-16 h-16 bg-[#d8e8e7] rounded-full flex items-center justify-center text-[#1FAC99] font-bold font-cg text-2xl mr-4">
                {{ strtoupper(substr($user->first_name, 0, 1)) }}{{ strtoupper(substr($user->last_name, 0, 1)) }}
            </div>
            <div>
                <h1 class="text-3xl font-bold text-[#1D433F] font-lora mb-1">
                    {{ $user->first_name }} {{ $user->last_name }}
                    @if($user->id === auth()->id())
                    <span class="text-sm text-blue-600">(You)</span>
                    @endif
                </h1>
                <p class="text-gray-600 font-cg">User ID: #{{ $user->id }}</p>
            </div>
        </div>
        <div class="flex gap-3">
            <a href="{{ route('admin.users.edit', $user->id) }}" 
               class="bg-[#1FAC99] text-white px-6 py-3 rounded-lg font-cg font-semibold hover:bg-[#1D433F] transition-all flex items-center gap-2">
                <svg class="w-5 h-5" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                    <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M11 5H6a2 2 0 00-2 2v11a2 2 0 002 2h11a2 2 0 002-2v-5m-1.414-9.414a2 2 0 112.828 2.828L11.828 15H9v-2.828l8.586-8.586z"/>
                </svg>
                Edit User
            </a>
            @if($user->id !== auth()->id())
            <form action="{{ route('admin.users.destroy', $user->id) }}" 
                  method="POST" 
                  onsubmit="return confirm('Are you sure you want to delete this user?');">
                @csrf
                @method('DELETE')
                <button type="submit" 
                        class="bg-red-600 text-white px-6 py-3 rounded-lg font-cg font-semibold hover:bg-red-700 transition-all flex items-center gap-2">
                    <svg class="w-5 h-5" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                        <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M19 7l-.867 12.142A2 2 0 0116.138 21H7.862a2 2 0 01-1.995-1.858L5 7m5 4v6m4-6v6m1-10V4a1 1 0 00-1-1h-4a1 1 0 00-1 1v3M4 7h16"/>
                    </svg>
                    Delete User
                </button>
            </form>
            @endif
        </div>
    </div>

    <!-- User Information Cards -->
    <div class="grid grid-cols-1 lg:grid-cols-3 gap-6 mb-8">
        <!-- Personal Information -->
        <div class="bg-white rounded-lg shadow-sm border border-gray-100 p-6">
            <h2 class="text-lg font-bold text-[#1D433F] font-lora mb-4">Personal Information</h2>
            <div class="space-y-3">
                <div>
                    <p class="text-xs font-semibold text-gray-500 uppercase tracking-wide font-cg">Full Name</p>
                    <p class="text-gray-900 font-lora mt-1">{{ $user->first_name }} {{ $user->last_name }}</p>
                </div>
                <div>
                    <p class="text-xs font-semibold text-gray-500 uppercase tracking-wide font-cg">Email Address</p>
                    <p class="text-gray-900 font-lora mt-1">{{ $user->email }}</p>
                </div>
                <div>
                    <p class="text-xs font-semibold text-gray-500 uppercase tracking-wide font-cg">Phone Number</p>
                    <p class="text-gray-900 font-lora mt-1">{{ $user->phone ?? 'Not provided' }}</p>
                </div>
            </div>
        </div>

        <!-- Account Details -->
        <div class="bg-white rounded-lg shadow-sm border border-gray-100 p-6">
            <h2 class="text-lg font-bold text-[#1D433F] font-lora mb-4">Account Details</h2>
            <div class="space-y-3">
                <div>
                    <p class="text-xs font-semibold text-gray-500 uppercase tracking-wide font-cg">Account Type</p>
                    @if($user->is_admin)
                    <span class="inline-block px-3 py-1 text-xs font-semibold bg-purple-100 text-purple-800 rounded-full font-cg uppercase mt-1">
                        Admin
                    </span>
                    @else
                    <span class="inline-block px-3 py-1 text-xs font-semibold bg-gray-100 text-gray-800 rounded-full font-cg uppercase mt-1">
                        Customer
                    </span>
                    @endif
                </div>
                <div>
                    <p class="text-xs font-semibold text-gray-500 uppercase tracking-wide font-cg">Member Since</p>
                    <p class="text-gray-900 font-lora mt-1">{{ $user->created_at->format('F d, Y') }}</p>
                    <p class="text-gray-500 font-cg text-xs">{{ $user->created_at->diffForHumans() }}</p>
                </div>
                <div>
                    <p class="text-xs font-semibold text-gray-500 uppercase tracking-wide font-cg">Last Updated</p>
                    <p class="text-gray-900 font-lora mt-1">{{ $user->updated_at->format('F d, Y') }}</p>
                </div>
            </div>
        </div>

        <!-- Order Statistics -->
        <div class="bg-white rounded-lg shadow-sm border border-gray-100 p-6">
            <h2 class="text-lg font-bold text-[#1D433F] font-lora mb-4">Order Statistics</h2>
            <div class="space-y-3">
                <div>
                    <p class="text-xs font-semibold text-gray-500 uppercase tracking-wide font-cg">Total Orders</p>
                    <p class="text-3xl font-bold text-[#1FAC99] font-lora mt-1">{{ $totalOrders }}</p>
                </div>
                <div>
                    <p class="text-xs font-semibold text-gray-500 uppercase tracking-wide font-cg">Total Spent</p>
                    <p class="text-2xl font-bold text-gray-900 font-lora mt-1">₱{{ number_format($totalSpent, 2) }}</p>
                </div>
                <div>
                    <p class="text-xs font-semibold text-gray-500 uppercase tracking-wide font-cg">Average Order Value</p>
                    <p class="text-gray-900 font-lora mt-1">₱{{ number_format($averageOrderValue, 2) }}</p>
                </div>
            </div>
        </div>
    </div>

    <!-- Order History -->
    <div class="bg-white rounded-lg shadow-sm border border-gray-100 overflow-hidden">
        <div class="px-6 py-4 border-b border-gray-100">
            <h2 class="text-lg font-bold text-[#1D433F] font-lora">Order History</h2>
        </div>
        
        @if($user->orders->count() > 0)
        <div class="overflow-x-auto">
            <table class="w-full">
                <thead class="bg-gray-50">
                    <tr class="text-left text-xs font-semibold text-gray-600 uppercase tracking-wider font-cg">
                        <th class="px-6 py-3">Order ID</th>
                        <th class="px-6 py-3">Date</th>
                        <th class="px-6 py-3">Status</th>
                        <th class="px-6 py-3">Items</th>
                        <th class="px-6 py-3">Total</th>
                        <th class="px-6 py-3">Actions</th>
                    </tr>
                </thead>
                <tbody class="divide-y divide-gray-100">
                    @foreach($user->orders as $order)
                    <tr class="hover:bg-gray-50 transition-colors">
                        <td class="px-6 py-4 text-sm font-medium text-gray-900 font-cg">#{{ $order->id }}</td>
                        <td class="px-6 py-4 text-sm text-gray-700 font-lora">
                            {{ $order->created_at->format('M d, Y') }}
                            <p class="text-xs text-gray-500">{{ $order->created_at->format('h:i A') }}</p>
                        </td>
                        <td class="px-6 py-4 text-sm font-cg">
                            @php
                                $statusColors = [
                                    'pending' => 'bg-yellow-100 text-yellow-800',
                                    'processing' => 'bg-blue-100 text-blue-800',
                                    'completed' => 'bg-green-100 text-green-800',
                                    'cancelled' => 'bg-red-100 text-red-800',
                                ];
                                $statusClass = $statusColors[$order->status] ?? 'bg-gray-100 text-gray-800';
                            @endphp
                            <span class="px-3 py-1 rounded-full text-xs font-medium {{ $statusClass }} capitalize">
                                {{ $order->status }}
                            </span>
                        </td>
                        <td class="px-6 py-4 text-sm text-gray-700 font-cg">
                            {{ $order->orderItems->count() }} item(s)
                        </td>
                        <td class="px-6 py-4 text-sm font-medium text-gray-900 font-lora">
                            ₱{{ number_format($order->total_amount, 2) }}
                        </td>
                        <td class="px-6 py-4 text-sm font-cg">
                            <a href="{{ route('admin.orders.show', $order->id) }}" 
                               class="text-[#1FAC99] hover:text-[#1D433F] hover:underline">
                                View Details
                            </a>
                        </td>
                    </tr>
                    @endforeach
                </tbody>
            </table>
        </div>
        @else
        <div class="px-6 py-12 text-center">
            <svg class="mx-auto h-12 w-12 text-gray-400" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M16 11V7a4 4 0 00-8 0v4M5 9h14l1 12H4L5 9z"/>
            </svg>
            <p class="mt-4 text-gray-500 font-cg">No orders found for this user.</p>
            <p class="text-sm text-gray-400 font-cg mt-1">Orders will appear here once the user makes a purchase.</p>
        </div>
        @endif
    </div>
</div>
@endsection