@extends('layouts.admin')
@section('title', 'Admin Dashboard | Jauxsh')
@section('page-title', 'Dashboard Overview')

@section('content')
<div class="min-h-screen">
    <!-- Welcome Header -->
    <div class="mb-8">
        <h1 class="text-3xl font-lora font-bold text-[#1D433F] mb-2">
            Welcome back, {{ auth()->user()->first_name ?? 'Admin' }}
        </h1>
        <p class="text-gray-600 font-cg">Here's what's happening with your store today.</p>
    </div>

    <!-- Dashboard Stats Grid -->
    <div class="grid grid-cols-1 md:grid-cols-2 lg:grid-cols-4 gap-6 mb-10">
        <!-- Total Users Card -->
        <div class="bg-white rounded-lg shadow-sm border border-gray-100 p-6 hover:shadow-md transition-shadow">
            <div class="flex items-center justify-between mb-4">
                <div class="p-3 bg-[#d8e8e7] rounded-lg">
                    <svg class="w-6 h-6 text-[#1FAC99]" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                        <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M12 4.354a4 4 0 110 5.292M15 21H3v-1a6 6 0 0112 0v1zm0 0h6v-1a6 6 0 00-9-5.197M13 7a4 4 0 11-8 0 4 4 0 018 0z"/>
                    </svg>
                </div>
            </div>
            <h2 class="text-3xl font-bold text-[#1D433F] font-lora mb-1">{{ $totalUsers }}</h2>
            <p class="text-gray-500 text-sm font-cg">Registered Users</p>
            <div class="mt-3 flex items-center text-xs text-green-600 font-cg">
                <svg class="w-4 h-4 mr-1" fill="currentColor" viewBox="0 0 20 20">
                    <path fill-rule="evenodd" d="M5.293 9.707a1 1 0 010-1.414l4-4a1 1 0 011.414 0l4 4a1 1 0 01-1.414 1.414L11 7.414V15a1 1 0 11-2 0V7.414L6.707 9.707a1 1 0 01-1.414 0z" clip-rule="evenodd"/>
                </svg>
                <span>+12% from last month</span>
            </div>
        </div>

        <!-- Total Orders Card -->
        <div class="bg-white rounded-lg shadow-sm border border-gray-100 p-6 hover:shadow-md transition-shadow">
            <div class="flex items-center justify-between mb-4">
                <div class="p-3 bg-[#d8e8e7] rounded-lg">
                    <svg class="w-6 h-6 text-[#1FAC99]" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                        <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M16 11V7a4 4 0 00-8 0v4M5 9h14l1 12H4L5 9z"/>
                    </svg>
                </div>
            </div>
            <h2 class="text-3xl font-bold text-[#1D433F] font-lora mb-1">{{ $totalOrders }}</h2>
            <p class="text-gray-500 text-sm font-cg">Total Orders</p>
            <div class="mt-3 flex items-center text-xs text-green-600 font-cg">
                <svg class="w-4 h-4 mr-1" fill="currentColor" viewBox="0 0 20 20">
                    <path fill-rule="evenodd" d="M5.293 9.707a1 1 0 010-1.414l4-4a1 1 0 011.414 0l4 4a1 1 0 01-1.414 1.414L11 7.414V15a1 1 0 11-2 0V7.414L6.707 9.707a1 1 0 01-1.414 0z" clip-rule="evenodd"/>
                </svg>
                <span>+8% from last month</span>
            </div>
        </div>

        <!-- Total Products Card -->
        <div class="bg-white rounded-lg shadow-sm border border-gray-100 p-6 hover:shadow-md transition-shadow">
            <div class="flex items-center justify-between mb-4">
                <div class="p-3 bg-[#d8e8e7] rounded-lg">
                    <svg class="w-6 h-6 text-[#1FAC99]" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                        <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M20 7l-8-4-8 4m16 0l-8 4m8-4v10l-8 4m0-10L4 7m8 4v10M4 7v10l8 4"/>
                    </svg>
                </div>
            </div>
            <h2 class="text-3xl font-bold text-[#1D433F] font-lora mb-1">{{ $totalProducts }}</h2>
            <p class="text-gray-500 text-sm font-cg">Available Products</p>
            <div class="mt-3 flex items-center text-xs text-gray-500 font-cg">
                <span>Active inventory</span>
            </div>
        </div>

        <!-- Revenue Card -->
        <div class="bg-white rounded-lg shadow-sm border border-gray-100 p-6 hover:shadow-md transition-shadow">
            <div class="flex items-center justify-between mb-4">
                <div class="p-3 bg-[#d8e8e7] rounded-lg">
                    <svg class="w-6 h-6 text-[#1FAC99]" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                        <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M12 8c-1.657 0-3 .895-3 2s1.343 2 3 2 3 .895 3 2-1.343 2-3 2m0-8c1.11 0 2.08.402 2.599 1M12 8V7m0 1v8m0 0v1m0-1c-1.11 0-2.08-.402-2.599-1M21 12a9 9 0 11-18 0 9 9 0 0118 0z"/>
                    </svg>
                </div>
            </div>
            <h2 class="text-3xl font-bold text-[#1D433F] font-lora mb-1">$24,580</h2>
            <p class="text-gray-500 text-sm font-cg">Total Revenue</p>
            <div class="mt-3 flex items-center text-xs text-green-600 font-cg">
                <svg class="w-4 h-4 mr-1" fill="currentColor" viewBox="0 0 20 20">
                    <path fill-rule="evenodd" d="M5.293 9.707a1 1 0 010-1.414l4-4a1 1 0 011.414 0l4 4a1 1 0 01-1.414 1.414L11 7.414V15a1 1 0 11-2 0V7.414L6.707 9.707a1 1 0 01-1.414 0z" clip-rule="evenodd"/>
                </svg>
                <span>+23% from last month</span>
            </div>
        </div>
    </div>

    <!-- Quick Actions -->
    <div class="grid grid-cols-1 md:grid-cols-3 gap-6 mb-10">
        <a href="/admin/products/create" class="bg-gradient-to-br from-[#1FAC99] to-[#1D433F] text-white rounded-lg p-6 hover:shadow-lg transition-shadow">
            <div class="flex items-center justify-between">
                <div>
                    <h3 class="text-lg font-semibold font-lora mb-2">Add New Product</h3>
                    <p class="text-sm text-gray-100 font-cg">Create and list a new item</p>
                </div>
                <svg class="w-8 h-8" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                    <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M12 6v6m0 0v6m0-6h6m-6 0H6"/>
                </svg>
            </div>
        </a>

        <a href="/admin/orders" class="bg-white border-2 border-[#1FAC99] text-[#1D433F] rounded-lg p-6 hover:bg-[#d8e8e7] transition-colors">
            <div class="flex items-center justify-between">
                <div>
                    <h3 class="text-lg font-semibold font-lora mb-2">Manage Orders</h3>
                    <p class="text-sm text-gray-600 font-cg">Process pending orders</p>
                </div>
                <svg class="w-8 h-8 text-[#1FAC99]" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                    <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M9 5H7a2 2 0 00-2 2v12a2 2 0 002 2h10a2 2 0 002-2V7a2 2 0 00-2-2h-2M9 5a2 2 0 002 2h2a2 2 0 002-2M9 5a2 2 0 012-2h2a2 2 0 012 2"/>
                </svg>
            </div>
        </a>

        <a href="/admin/users" class="bg-white border-2 border-[#1FAC99] text-[#1D433F] rounded-lg p-6 hover:bg-[#d8e8e7] transition-colors">
            <div class="flex items-center justify-between">
                <div>
                    <h3 class="text-lg font-semibold font-lora mb-2">View Users</h3>
                    <p class="text-sm text-gray-600 font-cg">Manage customer accounts</p>
                </div>
                <svg class="w-8 h-8 text-[#1FAC99]" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                    <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M17 20h5v-2a3 3 0 00-5.356-1.857M17 20H7m10 0v-2c0-.656-.126-1.283-.356-1.857M7 20H2v-2a3 3 0 015.356-1.857M7 20v-2c0-.656.126-1.283.356-1.857m0 0a5.002 5.002 0 019.288 0M15 7a3 3 0 11-6 0 3 3 0 016 0zm6 3a2 2 0 11-4 0 2 2 0 014 0zM7 10a2 2 0 11-4 0 2 2 0 014 0z"/>
                </svg>
            </div>
        </a>
    </div>

    <!-- Recent Orders Table -->
    <div class="bg-white rounded-lg shadow-sm border border-gray-100 overflow-hidden">
        <div class="px-6 py-4 border-b border-gray-100 flex items-center justify-between">
            <h3 class="text-lg font-semibold text-[#1D433F] font-lora">Recent Orders</h3>
            <a href="/admin/orders" class="text-sm text-[#1FAC99] hover:text-[#1D433F] font-cg hover:underline">View all orders →</a>
        </div>
        
        @if($recentOrders->count())
        <div class="overflow-x-auto">
            <table class="w-full">
                <thead class="bg-gray-50">
                    <tr class="text-left text-xs font-semibold text-gray-600 uppercase tracking-wider font-cg">
                        <th class="px-6 py-3">Order ID</th>
                        <th class="px-6 py-3">Customer</th>
                        <th class="px-6 py-3">Status</th>
                        <th class="px-6 py-3">Amount</th>
                        <th class="px-6 py-3">Date</th>
                        <th class="px-6 py-3">Actions</th>
                    </tr>
                </thead>
                <tbody class="divide-y divide-gray-100">
                    @foreach($recentOrders as $order)
                    <tr class="hover:bg-gray-50 transition-colors">
                        <td class="px-6 py-4 text-sm font-medium text-gray-900 font-cg">#{{ $order->id }}</td>
                        <td class="px-6 py-4 text-sm text-gray-700 font-cg">
                            <div class="flex items-center">
                                <div class="h-8 w-8 rounded-full bg-[#d8e8e7] flex items-center justify-center text-[#1FAC99] font-semibold mr-3">
                                    {{ substr($order->user->first_name ?? 'G', 0, 1) }}
                                </div>
                                {{ $order->user->first_name ?? 'Guest' }} {{ $order->user->last_name ?? '' }}
                            </div>
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
                        <td class="px-6 py-4 text-sm font-medium text-gray-900 font-cg">
                            ${{ number_format($order->total ?? 0, 2) }}
                        </td>
                        <td class="px-6 py-4 text-sm text-gray-500 font-cg">
                            {{ $order->created_at->format('M d, Y') }}
                        </td>
                        <td class="px-6 py-4 text-sm font-cg">
                            <a href="/admin/orders/{{ $order->id }}" class="text-[#1FAC99] hover:text-[#1D433F] hover:underline">
                                View
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
                <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M20 13V6a2 2 0 00-2-2H6a2 2 0 00-2 2v7m16 0v5a2 2 0 01-2 2H6a2 2 0 01-2-2v-5m16 0h-2.586a1 1 0 00-.707.293l-2.414 2.414a1 1 0 01-.707.293h-3.172a1 1 0 01-.707-.293l-2.414-2.414A1 1 0 006.586 13H4"/>
            </svg>
            <p class="mt-4 text-gray-500 font-cg">No recent orders found.</p>
            <p class="text-sm text-gray-400 font-cg mt-1">Orders will appear here once customers make purchases.</p>
        </div>
        @endif
    </div>
</div>
@endsection