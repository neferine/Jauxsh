@extends('layouts.admin')
@section('title', 'Order #' . $order->id . ' - Admin')

@section('content')
<div class="py-8">
    <div class="max-w-7xl mx-auto px-4 sm:px-6 lg:px-8">
        <!-- Back Button -->
        <div class="mb-6">
            <a href="{{ route('admin.orders.index') }}" class="inline-flex items-center gap-2 font-lora text-gray-600 hover:text-gray-900 transition-colors">
                <svg class="w-5 h-5" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                    <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M15 19l-7-7 7-7"/>
                </svg>
                Back to Orders
            </a>
        </div>

        @if(session('success'))
            <div class="mb-6 bg-green-50 border border-green-200 text-green-800 px-4 py-3 rounded-sm">
                <p class="font-lora">{{ session('success') }}</p>
            </div>
        @endif

        <!-- Order Header -->
        <div class="bg-white rounded-sm shadow-sm p-6 mb-6">
            <div class="flex flex-col lg:flex-row lg:items-center lg:justify-between">
                <div class="mb-4 lg:mb-0">
                    <div class="flex items-center gap-3 mb-2">
                        <h1 class="font-cg text-3xl font-bold text-gray-900 uppercase tracking-tight">
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
                <div class="text-left lg:text-right">
                    <p class="font-cg text-sm uppercase text-gray-600 mb-1">Total Amount</p>
                    <p class="font-cg font-bold text-3xl text-gray-900">₱{{ number_format($order->total_amount, 2) }}</p>
                </div>
            </div>
        </div>

        <div class="grid grid-cols-1 lg:grid-cols-3 gap-6">
            <!-- Order Items -->
            <div class="lg:col-span-2 space-y-6">
                <!-- Items List -->
                <div class="bg-white rounded-sm shadow-sm p-6">
                    <h2 class="font-cg text-xl font-bold text-gray-900 uppercase tracking-tight mb-6">
                        Order Items ({{ $order->orderItems->count() }})
                    </h2>

                    <div class="space-y-4">
                        @foreach($order->orderItems as $item)
                            <div class="flex gap-4 pb-4 border-b border-gray-200 last:border-b-0">
                                <!-- Product Image -->
                                <div class="flex-shrink-0">
                                    @if($item->product && $item->product->images->count() > 0)
                                        <img src="{{ asset('storage/' . $item->product->images->first()->image_url) }}" 
                                             alt="{{ $item->product->name }}" 
                                             class="w-24 h-24 object-cover rounded-sm border border-gray-200">
                                    @else
                                        <div class="w-24 h-24 bg-gray-200 rounded-sm flex items-center justify-center border border-gray-300">
                                            <svg class="w-12 h-12 text-gray-400" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                                                <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M4 16l4.586-4.586a2 2 0 012.828 0L16 16m-2-2l1.586-1.586a2 2 0 012.828 0L20 14m-6-6h.01M6 20h12a2 2 0 002-2V6a2 2 0 00-2-2H6a2 2 0 00-2 2v12a2 2 0 002 2z"/>
                                            </svg>
                                        </div>
                                    @endif
                                </div>

                                <!-- Product Details -->
                                <div class="flex-1">
                                    <div class="flex justify-between items-start mb-2">
                                        <div>
                                            <h3 class="font-lora font-semibold text-lg text-gray-900">
                                                {{ $item->product ? $item->product->name : 'Product Unavailable' }}
                                            </h3>
                                            @if($item->product && $item->product->category)
                                                <p class="font-lora text-sm text-gray-600">
                                                    {{ $item->product->category->name }}
                                                </p>
                                            @endif
                                            @if($item->product)
                                                <a href="{{ route('admin.products.edit', $item->product->id) }}" 
                                                   class="text-xs font-cg text-gray-500 hover:text-gray-900 uppercase mt-1 inline-block">
                                                    View Product →
                                                </a>
                                            @endif
                                        </div>
                                    </div>
                                    <div class="grid grid-cols-3 gap-4 mt-3">
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
                    <div class="mt-6 pt-6 border-t-2 border-gray-200">
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

            <!-- Sidebar -->
            <div class="lg:col-span-1 space-y-6">
                <!-- Update Order Status -->
                <div class="bg-white rounded-sm shadow-sm p-6">
                    <h3 class="font-cg text-lg font-bold text-gray-900 uppercase tracking-tight mb-4">
                        Update Status
                    </h3>
                    <form method="POST" action="{{ route('admin.orders.updateStatus', $order->id) }}">
                        @csrf
                        @method('PATCH')
                        
                        <div class="mb-4">
                            <label class="block font-cg text-sm uppercase text-gray-700 mb-2">
                                Current Status
                            </label>
                            <select name="status" 
                                    class="w-full px-4 py-2 border border-gray-300 rounded-sm font-lora focus:outline-none focus:border-gray-900">
                                <option value="pending" {{ $order->status === 'pending' ? 'selected' : '' }}>Pending</option>
                                <option value="processing" {{ $order->status === 'processing' ? 'selected' : '' }}>Processing</option>
                                <option value="shipped" {{ $order->status === 'shipped' ? 'selected' : '' }}>Shipped</option>
                                <option value="delivered" {{ $order->status === 'delivered' ? 'selected' : '' }}>Delivered</option>
                                <option value="cancelled" {{ $order->status === 'cancelled' ? 'selected' : '' }}>Cancelled</option>
                            </select>
                        </div>

                        <button type="submit" 
                                class="w-full px-4 py-2.5 bg-gray-900 text-white font-cg uppercase text-sm rounded-sm hover:bg-[#1fac99ff] transition-colors">
                            Update Status
                        </button>
                    </form>
                </div>

                <!-- Customer Information -->
                <div class="bg-white rounded-sm shadow-sm p-6">
                    <h3 class="font-cg text-lg font-bold text-gray-900 uppercase tracking-tight mb-4">
                        Customer Details
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
                        <div class="pt-2">
                            <a href="{{ route('admin.users.show', $order->user->id) }}" 
                               class="text-sm font-cg text-gray-900 hover:text-[#1fac99ff] uppercase transition-colors">
                                View Customer Profile →
                            </a>
                        </div>
                    </div>
                </div>

                <!-- Shipping Address -->
                @if($order->user->shippingAddresses->count() > 0)
                    @php
                        $address = $order->user->shippingAddresses->first();
                    @endphp
                    <div class="bg-white rounded-sm shadow-sm p-6">
                        <h3 class="font-cg text-lg font-bold text-gray-900 uppercase tracking-tight mb-4">
                            Shipping Address
                        </h3>
                        <div class="font-lora text-gray-900 space-y-1">
                            <p>{{ $address->address_line1 }}</p>
                            @if($address->address_line2)
                                <p>{{ $address->address_line2 }}</p>
                            @endif
                            <p>{{ $address->city }}, {{ $address->postal_code }}</p>
                            <p>{{ $address->country }}</p>
                            <div class="pt-3 mt-3 border-t border-gray-200">
                                <p class="font-cg text-xs uppercase text-gray-600 mb-1">Phone</p>
                                <p>{{ $address->phone_number }}</p>
                            </div>
                        </div>
                    </div>
                @else
                    <div class="bg-white rounded-sm shadow-sm p-6">
                        <h3 class="font-cg text-lg font-bold text-gray-900 uppercase tracking-tight mb-4">
                            Shipping Address
                        </h3>
                        <p class="font-lora text-gray-600 text-sm">No shipping address on file</p>
                    </div>
                @endif

                <!-- Order Timeline -->
                <div class="bg-white rounded-sm shadow-sm p-6">
                    <h3 class="font-cg text-lg font-bold text-gray-900 uppercase tracking-tight mb-4">
                        Order Timeline
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
                                            <p class="font-lora text-xs text-[#1fac99ff]">Current status</p>
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

                <!-- Order Metadata -->
                <div class="bg-white rounded-sm shadow-sm p-6">
                    <h3 class="font-cg text-lg font-bold text-gray-900 uppercase tracking-tight mb-4">
                        Order Information
                    </h3>
                    <div class="space-y-3 text-sm">
                        <div class="flex justify-between">
                            <span class="font-cg uppercase text-gray-600">Created</span>
                            <span class="font-lora text-gray-900">{{ $order->created_at->format('M d, Y g:i A') }}</span>
                        </div>
                        <div class="flex justify-between">
                            <span class="font-cg uppercase text-gray-600">Updated</span>
                            <span class="font-lora text-gray-900">{{ $order->updated_at->format('M d, Y g:i A') }}</span>
                        </div>
                        <div class="flex justify-between">
                            <span class="font-cg uppercase text-gray-600">Items Count</span>
                            <span class="font-lora text-gray-900">{{ $order->orderItems->count() }}</span>
                        </div>
                    </div>
                </div>
            </div>
        </div>
    </div>
</div>
@endsection