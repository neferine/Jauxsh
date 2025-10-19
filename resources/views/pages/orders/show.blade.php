@extends('layouts.app')
@section('title', 'Order #' . $order->id . ' | Jauxsh')

@section('content')
<div class="min-h-screen bg-gray-50">
    <div class="px-6 md:px-20 lg:px-40 py-32">
        <div class="max-w-5xl mx-auto">
            <!-- Back Button -->
            <div class="mb-6">
                <a href="{{ route('orders.index') }}" class="inline-flex items-center gap-2 font-lora text-gray-600 hover:text-gray-900 transition-colors">
                    <svg class="w-5 h-5" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                        <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M15 19l-7-7 7-7"/>
                    </svg>
                    Back to Orders
                </a>
            </div>

            <!-- Order Header -->
            <div class="bg-white p-6 md:p-8 rounded-sm shadow-sm mb-6">
                <div class="flex flex-col md:flex-row md:items-center md:justify-between">
                    <div class="mb-4 md:mb-0">
                        <div class="flex items-center gap-3 mb-2">
                            <h1 class="font-cg font-bold text-3xl md:text-4xl uppercase text-gray-900 tracking-tight">
                                Order #{{ $order->id }}
                            </h1>
                            <span class="px-4 py-1.5 rounded-full text-sm font-cg uppercase tracking-wide
                                @if($order->status === 'pending') bg-yellow-100 text-yellow-800
                                @elseif($order->status === 'processing') bg-blue-100 text-blue-800
                                @elseif($order->status === 'shipped') bg-purple-100 text-purple-800
                                @elseif($order->status === 'delivered') bg-green-100 text-green-800
                                @elseif($order->status === 'cancelled') bg-red-100 text-red-800
                                @endif">
                                {{ ucfirst($order->status) }}
                            </span>
                        </div>
                        <p class="font-lora text-gray-600">
                            Placed on {{ $order->order_date->format('F d, Y \a\t g:i A') }}
                        </p>
                    </div>
                    <div class="text-left md:text-right">
                        <p class="font-cg text-sm uppercase text-gray-600 mb-1">Total Amount</p>
                        <p class="font-cg font-bold text-3xl text-gray-900">₱{{ number_format($order->total_amount, 2) }}</p>
                    </div>
                </div>
            </div>

            <div class="grid grid-cols-1 lg:grid-cols-3 gap-6">
                <!-- Order Items -->
                <div class="lg:col-span-2">
                    <div class="bg-white p-6 md:p-8 rounded-sm shadow-sm">
                        <h2 class="font-cg font-bold text-2xl uppercase text-gray-900 mb-6 tracking-tight">
                            Order Items
                        </h2>

                        <div class="space-y-4">
                            @foreach($order->orderItems as $item)
                                <div class="flex gap-4 pb-4 border-b border-gray-200 last:border-b-0">
                                    <!-- Product Image -->
                                    <div class="flex-shrink-0">
                                        @if($item->product && $item->product->images->count() > 0)
                                            <img src="{{ asset('storage/' . $item->product->images->first()->image_url) }}" 
                                                 alt="{{ $item->product->name }}" 
                                                 class="w-24 h-24 object-cover rounded-sm">
                                        @else
                                            <div class="w-24 h-24 bg-gray-200 rounded-sm flex items-center justify-center">
                                                <svg class="w-12 h-12 text-gray-400" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                                                    <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M4 16l4.586-4.586a2 2 0 012.828 0L16 16m-2-2l1.586-1.586a2 2 0 012.828 0L20 14m-6-6h.01M6 20h12a2 2 0 002-2V6a2 2 0 00-2-2H6a2 2 0 00-2 2v12a2 2 0 002 2z"/>
                                                </svg>
                                            </div>
                                        @endif
                                    </div>

                                    <!-- Product Details -->
                                    <div class="flex-1">
                                        <h3 class="font-lora font-semibold text-lg text-gray-900 mb-1">
                                            {{ $item->product ? $item->product->name : 'Product Unavailable' }}
                                        </h3>
                                        @if($item->product && $item->product->category)
                                            <p class="font-lora text-sm text-gray-600 mb-2">
                                                {{ $item->product->category->name }}
                                            </p>
                                        @endif
                                        <div class="flex flex-wrap items-center gap-4 mt-3">
                                            <div>
                                                <p class="font-cg text-xs uppercase text-gray-600">Price</p>
                                                <p class="font-cg font-semibold text-gray-900">₱{{ number_format($item->price, 2) }}</p>
                                            </div>
                                            <div>
                                                <p class="font-cg text-xs uppercase text-gray-600">Quantity</p>
                                                <p class="font-cg font-semibold text-gray-900">{{ $item->quantity }}</p>
                                            </div>
                                            <div>
                                                <p class="font-cg text-xs uppercase text-gray-600">Subtotal</p>
                                                <p class="font-cg font-semibold text-gray-900">₱{{ number_format($item->price * $item->quantity, 2) }}</p>
                                            </div>
                                        </div>
                                    </div>
                                </div>
                            @endforeach
                        </div>

                        <!-- Order Summary -->
                        <div class="mt-6 pt-6 border-t border-gray-200">
                            <div class="flex justify-between items-center mb-2">
                                <p class="font-lora text-gray-600">Subtotal</p>
                                <p class="font-lora text-gray-900">₱{{ number_format($order->orderItems->sum(function($item) { return $item->price * $item->quantity; }), 2) }}</p>
                            </div>
                            <div class="flex justify-between items-center mb-2">
                                <p class="font-lora text-gray-600">Shipping</p>
                                <p class="font-lora text-gray-900">Free</p>
                            </div>
                            <div class="flex justify-between items-center pt-4 border-t border-gray-200">
                                <p class="font-cg font-bold text-lg uppercase text-gray-900">Total</p>
                                <p class="font-cg font-bold text-2xl text-gray-900">₱{{ number_format($order->total_amount, 2) }}</p>
                            </div>
                        </div>
                    </div>
                </div>

                <!-- Order Information Sidebar -->
                <div class="lg:col-span-1 space-y-6">
                    <!-- Customer Information -->
                    <div class="bg-white p-6 rounded-sm shadow-sm">
                        <h3 class="font-cg font-bold text-lg uppercase text-gray-900 mb-4 tracking-tight">
                            Customer Information
                        </h3>
                        <div class="space-y-3">
                            <div>
                                <p class="font-cg text-xs uppercase text-gray-600 mb-1">Name</p>
                                <p class="font-lora text-gray-900">{{ $order->user->name }}</p>
                            </div>
                            <div>
                                <p class="font-cg text-xs uppercase text-gray-600 mb-1">Email</p>
                                <p class="font-lora text-gray-900 break-words">{{ $order->user->email }}</p>
                            </div>
                        </div>
                    </div>

                    <!-- Shipping Address -->
                    @if($order->user->shippingAddresses->count() > 0)
                        @php
                            $address = $order->user->shippingAddresses->first();
                        @endphp
                        <div class="bg-white p-6 rounded-sm shadow-sm">
                            <h3 class="font-cg font-bold text-lg uppercase text-gray-900 mb-4 tracking-tight">
                                Shipping Address
                            </h3>
                            <div class="font-lora text-gray-900 space-y-1">
                                <p>{{ $address->address_line1 }}</p>
                                @if($address->address_line2)
                                    <p>{{ $address->address_line2 }}</p>
                                @endif
                                <p>{{ $address->city }}, {{ $address->postal_code }}</p>
                                <p>{{ $address->country }}</p>
                                <p class="pt-2">{{ $address->phone_number }}</p>
                            </div>
                        </div>
                    @endif

                    <!-- Order Status Timeline -->
                    <div class="bg-white p-6 rounded-sm shadow-sm">
                        <h3 class="font-cg font-bold text-lg uppercase text-gray-900 mb-4 tracking-tight">
                            Order Status
                        </h3>
                        <div class="space-y-4">
                            @php
                                $statuses = ['pending', 'processing', 'shipped', 'delivered'];
                                $currentIndex = array_search($order->status, $statuses);
                                $isCancelled = $order->status === 'cancelled';
                            @endphp

                            @if($isCancelled)
                                <div class="flex items-start gap-3">
                                    <div class="flex-shrink-0 w-6 h-6 rounded-full bg-red-500 flex items-center justify-center">
                                        <svg class="w-4 h-4 text-white" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                                            <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M6 18L18 6M6 6l12 12"/>
                                        </svg>
                                    </div>
                                    <div>
                                        <p class="font-cg font-semibold text-red-600 uppercase text-sm">Cancelled</p>
                                        <p class="font-lora text-xs text-gray-600">This order has been cancelled</p>
                                    </div>
                                </div>
                            @else
                                @foreach($statuses as $index => $status)
                                    @php
                                        $isComplete = $index <= $currentIndex;
                                        $isCurrent = $index === $currentIndex;
                                    @endphp
                                    <div class="flex items-start gap-3">
                                        <div class="flex-shrink-0 w-6 h-6 rounded-full flex items-center justify-center
                                            {{ $isComplete ? 'bg-[#1fac99ff]' : 'bg-gray-300' }}">
                                            @if($isComplete)
                                                <svg class="w-4 h-4 text-white" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                                                    <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M5 13l4 4L19 7"/>
                                                </svg>
                                            @endif
                                        </div>
                                        <div>
                                            <p class="font-cg font-semibold uppercase text-sm
                                                {{ $isComplete ? 'text-gray-900' : 'text-gray-400' }}">
                                                {{ ucfirst($status) }}
                                            </p>
                                            @if($isCurrent)
                                                <p class="font-lora text-xs text-gray-600">Current status</p>
                                            @endif
                                        </div>
                                    </div>
                                    @if($index < count($statuses) - 1)
                                        <div class="ml-3 w-0.5 h-6 {{ $isComplete ? 'bg-[#1fac99ff]' : 'bg-gray-300' }}"></div>
                                    @endif
                                @endforeach
                            @endif
                        </div>
                    </div>
                </div>
            </div>
        </div>
    </div>
</div>
@endsection