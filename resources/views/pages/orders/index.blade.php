@extends('layouts.app')
@section('title', 'My Orders | Jauxsh')

@section('content')
<div class="min-h-screen bg-gray-50">
    <div class="px-6 md:px-20 lg:px-40 py-32">
        <div class="max-w-6xl mx-auto">
            <!-- Page Header -->
            <div class="mb-8">
                <h1 class="font-cg font-bold text-4xl md:text-5xl uppercase text-gray-900 mb-2 tracking-tight">
                    My Orders
                </h1>
                <p class="font-lora text-gray-600 text-lg">
                    Track and manage your order history
                </p>
            </div>

            @if($orders->isEmpty())
                <!-- Empty State -->
                <div class="bg-white p-12 rounded-sm shadow-sm text-center">
                    <svg class="w-20 h-20 text-gray-300 mx-auto mb-6" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                        <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M16 11V7a4 4 0 00-8 0v4M5 9h14l1 12H4L5 9z"/>
                    </svg>
                    <h2 class="font-cg font-bold text-2xl uppercase text-gray-900 mb-4">No Orders Yet</h2>
                    <p class="font-lora text-gray-600 mb-8">
                        You haven't placed any orders yet. Start shopping to see your orders here.
                    </p>
                    <a href="{{ route('home') }}" class="inline-block px-8 py-3 bg-gray-900 text-white font-cg uppercase tracking-wide rounded-sm hover:bg-[#1fac99ff] transition-colors">
                        Start Shopping
                    </a>
                </div>
            @else
                <!-- Orders List -->
                <div class="space-y-4">
                    @foreach($orders as $order)
                        <div class="bg-white rounded-sm shadow-sm overflow-hidden hover:shadow-md transition-shadow">
                            <div class="p-6">
                                <!-- Order Header -->
                                <div class="flex flex-col lg:flex-row lg:items-center lg:justify-between mb-4 pb-4 border-b border-gray-200">
                                    <div class="mb-4 lg:mb-0">
                                        <div class="flex items-center gap-3 mb-2">
                                            <h3 class="font-cg font-bold text-xl text-gray-900">
                                                Order #{{ $order->id }}
                                            </h3>
                                            <span class="px-3 py-1 rounded-full text-xs font-cg uppercase tracking-wide
                                                @if($order->status === 'pending') bg-yellow-100 text-yellow-800
                                                @elseif($order->status === 'processing') bg-blue-100 text-blue-800
                                                @elseif($order->status === 'shipped') bg-purple-100 text-purple-800
                                                @elseif($order->status === 'delivered') bg-green-100 text-green-800
                                                @elseif($order->status === 'cancelled') bg-red-100 text-red-800
                                                @endif">
                                                {{ ucfirst($order->status) }}
                                            </span>
                                        </div>
                                        <p class="font-lora text-sm text-gray-600">
                                            Placed on {{ $order->order_date->format('F d, Y \a\t g:i A') }}
                                        </p>
                                    </div>
                                    <div class="text-left lg:text-right">
                                        <p class="font-cg text-sm uppercase text-gray-600 mb-1">Total Amount</p>
                                        <p class="font-cg font-bold text-2xl text-gray-900">₱{{ number_format($order->total_amount, 2) }}</p>
                                    </div>
                                </div>

                                <!-- Order Items Preview -->
                                <div class="mb-4">
                                    <p class="font-cg text-sm uppercase text-gray-600 mb-3">Items ({{ $order->orderItems->count() }})</p>
                                    <div class="grid grid-cols-1 md:grid-cols-2 lg:grid-cols-3 gap-3">
                                        @foreach($order->orderItems->take(3) as $item)
                                            <div class="flex items-center gap-3 bg-gray-50 p-3 rounded-sm">
                                                @if($item->product && $item->product->images->count() > 0)
                                                    <img src="{{ asset('storage/' . $item->product->images->first()->image_url) }}" 
                                                         alt="{{ $item->product->name }}" 
                                                         class="w-16 h-16 object-cover rounded-sm">
                                                @else
                                                    <div class="w-16 h-16 bg-gray-200 rounded-sm flex items-center justify-center">
                                                        <svg class="w-8 h-8 text-gray-400" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                                                            <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M4 16l4.586-4.586a2 2 0 012.828 0L16 16m-2-2l1.586-1.586a2 2 0 012.828 0L20 14m-6-6h.01M6 20h12a2 2 0 002-2V6a2 2 0 00-2-2H6a2 2 0 00-2 2v12a2 2 0 002 2z"/>
                                                        </svg>
                                                    </div>
                                                @endif
                                                <div class="flex-1 min-w-0">
                                                    <p class="font-lora text-sm font-semibold text-gray-900 truncate">
                                                        {{ $item->product ? $item->product->name : 'Product Unavailable' }}
                                                    </p>
                                                    <p class="font-lora text-xs text-gray-600">Qty: {{ $item->quantity }}</p>
                                                </div>
                                            </div>
                                        @endforeach
                                        @if($order->orderItems->count() > 3)
                                            <div class="flex items-center justify-center bg-gray-50 p-3 rounded-sm">
                                                <p class="font-cg text-sm text-gray-600">
                                                    +{{ $order->orderItems->count() - 3 }} more item(s)
                                                </p>
                                            </div>
                                        @endif
                                    </div>
                                </div>

                                <!-- Action Button -->
                                <div class="flex justify-end">
                                    <a href="{{ route('orders.show', $order->id) }}" 
                                       class="px-6 py-2.5 border-2 border-gray-900 text-gray-900 font-cg uppercase text-sm tracking-wide rounded-sm hover:bg-gray-900 hover:text-white transition-colors">
                                        View Details →
                                    </a>
                                </div>
                            </div>
                        </div>
                    @endforeach
                </div>

                <!-- Pagination -->
                @if($orders->hasPages())
                    <div class="mt-8">
                        {{ $orders->links() }}
                    </div>
                @endif
            @endif

            <!-- Back to Account Link -->
            <div class="mt-8 text-center">
                <a href="{{ route('account.index') }}" class="font-lora text-gray-600 hover:text-gray-900 transition-colors">
                    ← Back to Account
                </a>
            </div>
        </div>
    </div>
</div>
@endsection