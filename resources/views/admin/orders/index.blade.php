@extends('layouts.admin')
@section('title', 'Manage Orders - Admin')

@section('content')
<div class="py-8">
    <div class="max-w-7xl mx-auto px-4 sm:px-6 lg:px-8">
        <!-- Header -->
        <div class="flex justify-between items-center mb-8">
            <div>
                <h1 class="font-cg text-3xl font-bold text-gray-900 uppercase tracking-tight">Order Management</h1>
                <p class="font-lora text-gray-600 mt-1">View and manage all customer orders</p>
            </div>
        </div>

        @if(session('success'))
            <div class="mb-6 bg-green-50 border border-green-200 text-green-800 px-4 py-3 rounded-sm">
                <p class="font-lora">{{ session('success') }}</p>
            </div>
        @endif

        <!-- Status Filter Tabs -->
        <div class="bg-white rounded-sm shadow-sm mb-6 overflow-x-auto">
            <div class="flex border-b border-gray-200">
                <a href="{{ route('admin.orders.index') }}" 
                   class="px-6 py-3 font-cg text-sm uppercase tracking-wide whitespace-nowrap
                          {{ !request('status') ? 'border-b-2 border-gray-900 text-gray-900 font-semibold' : 'text-gray-600 hover:text-gray-900' }}">
                    All Orders
                    <span class="ml-2 px-2 py-0.5 text-xs rounded-full bg-gray-100">{{ $statusCounts['all'] }}</span>
                </a>
                <a href="{{ route('admin.orders.index', ['status' => 'pending']) }}" 
                   class="px-6 py-3 font-cg text-sm uppercase tracking-wide whitespace-nowrap
                          {{ request('status') === 'pending' ? 'border-b-2 border-yellow-500 text-yellow-700 font-semibold' : 'text-gray-600 hover:text-gray-900' }}">
                    Pending
                    <span class="ml-2 px-2 py-0.5 text-xs rounded-full bg-yellow-100">{{ $statusCounts['pending'] }}</span>
                </a>
                <a href="{{ route('admin.orders.index', ['status' => 'processing']) }}" 
                   class="px-6 py-3 font-cg text-sm uppercase tracking-wide whitespace-nowrap
                          {{ request('status') === 'processing' ? 'border-b-2 border-blue-500 text-blue-700 font-semibold' : 'text-gray-600 hover:text-gray-900' }}">
                    Processing
                    <span class="ml-2 px-2 py-0.5 text-xs rounded-full bg-blue-100">{{ $statusCounts['processing'] }}</span>
                </a>
                <a href="{{ route('admin.orders.index', ['status' => 'shipped']) }}" 
                   class="px-6 py-3 font-cg text-sm uppercase tracking-wide whitespace-nowrap
                          {{ request('status') === 'shipped' ? 'border-b-2 border-purple-500 text-purple-700 font-semibold' : 'text-gray-600 hover:text-gray-900' }}">
                    Shipped
                    <span class="ml-2 px-2 py-0.5 text-xs rounded-full bg-purple-100">{{ $statusCounts['shipped'] }}</span>
                </a>
                <a href="{{ route('admin.orders.index', ['status' => 'delivered']) }}" 
                   class="px-6 py-3 font-cg text-sm uppercase tracking-wide whitespace-nowrap
                          {{ request('status') === 'delivered' ? 'border-b-2 border-green-500 text-green-700 font-semibold' : 'text-gray-600 hover:text-gray-900' }}">
                    Delivered
                    <span class="ml-2 px-2 py-0.5 text-xs rounded-full bg-green-100">{{ $statusCounts['delivered'] }}</span>
                </a>
                <a href="{{ route('admin.orders.index', ['status' => 'cancelled']) }}" 
                   class="px-6 py-3 font-cg text-sm uppercase tracking-wide whitespace-nowrap
                          {{ request('status') === 'cancelled' ? 'border-b-2 border-red-500 text-red-700 font-semibold' : 'text-gray-600 hover:text-gray-900' }}">
                    Cancelled
                    <span class="ml-2 px-2 py-0.5 text-xs rounded-full bg-red-100">{{ $statusCounts['cancelled'] }}</span>
                </a>
            </div>
        </div>

        <!-- Search and Filters -->
        <div class="bg-white rounded-sm shadow-sm p-4 mb-6">
            <form method="GET" action="{{ route('admin.orders.index') }}" class="flex flex-col md:flex-row gap-4">
                <!-- Preserve status filter -->
                @if(request('status'))
                    <input type="hidden" name="status" value="{{ request('status') }}">
                @endif

                <!-- Search -->
                <div class="flex-1">
                    <input type="text" 
                           name="search" 
                           value="{{ request('search') }}"
                           placeholder="Search by Order ID, Customer Name or Email..."
                           class="w-full px-4 py-2 border border-gray-300 rounded-sm font-lora focus:outline-none focus:border-gray-900">
                </div>

                <!-- Sort By -->
                <div class="flex gap-2">
                    <select name="sort_by" class="px-4 py-2 border border-gray-300 rounded-sm font-lora focus:outline-none focus:border-gray-900">
                        <option value="created_at" {{ request('sort_by') === 'created_at' ? 'selected' : '' }}>Date</option>
                        <option value="total_amount" {{ request('sort_by') === 'total_amount' ? 'selected' : '' }}>Amount</option>
                        <option value="id" {{ request('sort_by') === 'id' ? 'selected' : '' }}>Order ID</option>
                    </select>

                    <select name="sort_order" class="px-4 py-2 border border-gray-300 rounded-sm font-lora focus:outline-none focus:border-gray-900">
                        <option value="desc" {{ request('sort_order') === 'desc' ? 'selected' : '' }}>Descending</option>
                        <option value="asc" {{ request('sort_order') === 'asc' ? 'selected' : '' }}>Ascending</option>
                    </select>
                </div>

                <!-- Buttons -->
                <div class="flex gap-2">
                    <button type="submit" class="px-6 py-2 bg-gray-900 text-white font-cg uppercase text-sm rounded-sm hover:bg-gray-800 transition-colors">
                        Apply
                    </button>
                    <a href="{{ route('admin.orders.index') }}" class="px-6 py-2 border border-gray-300 text-gray-700 font-cg uppercase text-sm rounded-sm hover:bg-gray-50 transition-colors">
                        Reset
                    </a>
                </div>
            </form>
        </div>

        <!-- Orders Table -->
        <div class="bg-white rounded-sm shadow-sm overflow-hidden">
            @if($orders->isEmpty())
                <div class="text-center py-12">
                    <svg class="mx-auto h-12 w-12 text-gray-400" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                        <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M20 13V6a2 2 0 00-2-2H6a2 2 0 00-2 2v7m16 0v5a2 2 0 01-2 2H6a2 2 0 01-2-2v-5m16 0h-2.586a1 1 0 00-.707.293l-2.414 2.414a1 1 0 01-.707.293h-3.172a1 1 0 01-.707-.293l-2.414-2.414A1 1 0 006.586 13H4"/>
                    </svg>
                    <h3 class="mt-4 text-lg font-medium text-gray-900 font-lora">No orders found</h3>
                    <p class="mt-2 text-sm text-gray-500 font-lora">
                        {{ request('search') || request('status') ? 'Try adjusting your filters' : 'Orders will appear here once customers place them' }}
                    </p>
                </div>
            @else
                <div class="overflow-x-auto">
                    <table class="min-w-full divide-y divide-gray-200">
                        <thead class="bg-gray-50">
                            <tr>
                                <th class="px-6 py-3 text-left text-xs font-cg font-semibold text-gray-700 uppercase tracking-wider">Order ID</th>
                                <th class="px-6 py-3 text-left text-xs font-cg font-semibold text-gray-700 uppercase tracking-wider">Customer</th>
                                <th class="px-6 py-3 text-left text-xs font-cg font-semibold text-gray-700 uppercase tracking-wider">Date</th>
                                <th class="px-6 py-3 text-left text-xs font-cg font-semibold text-gray-700 uppercase tracking-wider">Items</th>
                                <th class="px-6 py-3 text-left text-xs font-cg font-semibold text-gray-700 uppercase tracking-wider">Total</th>
                                <th class="px-6 py-3 text-left text-xs font-cg font-semibold text-gray-700 uppercase tracking-wider">Status</th>
                                <th class="px-6 py-3 text-right text-xs font-cg font-semibold text-gray-700 uppercase tracking-wider">Actions</th>
                            </tr>
                        </thead>
                        <tbody class="bg-white divide-y divide-gray-200">
                            @foreach($orders as $order)
                                <tr class="hover:bg-gray-50 transition-colors">
                                    <td class="px-6 py-4 whitespace-nowrap">
                                        <span class="font-cg font-semibold text-gray-900">#{{ $order->id }}</span>
                                    </td>
                                    <td class="px-6 py-4">
                                        <div class="text-sm">
                                            <div class="font-lora font-medium text-gray-900">{{ $order->user->first_name , $order->user->last_name }}</div>
                                            <div class="font-lora text-gray-500">{{ $order->user->email }}</div>
                                        </div>
                                    </td>
                                    <td class="px-6 py-4 whitespace-nowrap">
                                        <div class="text-sm font-lora text-gray-900">{{ $order->order_date->format('M d, Y') }}</div>
                                        <div class="text-xs font-lora text-gray-500">{{ $order->order_date->format('g:i A') }}</div>
                                    </td>
                                    <td class="px-6 py-4 whitespace-nowrap">
                                        <span class="font-lora text-sm text-gray-900">{{ $order->orderItems->count() }} item(s)</span>
                                    </td>
                                    <td class="px-6 py-4 whitespace-nowrap">
                                        <span class="font-cg font-semibold text-gray-900">₱{{ number_format($order->total_amount, 2) }}</span>
                                    </td>
                                    <td class="px-6 py-4 whitespace-nowrap">
                                        <span class="px-3 py-1 inline-flex text-xs leading-5 font-cg uppercase tracking-wide rounded-full
                                            @if($order->status === 'pending') bg-yellow-100 text-yellow-800
                                            @elseif($order->status === 'processing') bg-blue-100 text-blue-800
                                            @elseif($order->status === 'shipped') bg-purple-100 text-purple-800
                                            @elseif($order->status === 'delivered') bg-green-100 text-green-800
                                            @elseif($order->status === 'cancelled') bg-red-100 text-red-800
                                            @endif">
                                            {{ ucfirst($order->status) }}
                                        </span>
                                    </td>
                                    <td class="px-6 py-4 whitespace-nowrap text-right text-sm font-medium">
                                        <a href="{{ route('admin.orders.show', $order->id) }}" 
                                           class="text-gray-900 hover:text-[#1fac99ff] font-cg uppercase transition-colors">
                                            View Details →
                                        </a>
                                    </td>
                                </tr>
                            @endforeach
                        </tbody>
                    </table>
                </div>

                <!-- Pagination -->
                <div class="px-6 py-4 border-t border-gray-200">
                    {{ $orders->links() }}
                </div>
            @endif
        </div>
    </div>
</div>
@endsection