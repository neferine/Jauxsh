
@extends('layouts.app')
@section('title', 'Order Confirmation | Jauxsh')
@section('content')
<div class="min-h-screen bg-gray-50">
    <div class="px-6 md:px-20 lg:px-40 py-32">
        <div class="max-w-2xl mx-auto bg-white p-8 rounded-sm shadow-sm text-center">
            <!-- Success Icon -->
            <div class="mb-6">
                <svg class="w-20 h-20 text-[#1fac99ff] mx-auto" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                    <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M9 12l2 2 4-4m6 2a9 9 0 11-18 0 9 9 0 0118 0z"/>
                </svg>
            </div>

            <h1 class="font-cg font-bold text-4xl uppercase text-gray-900 mb-4 tracking-tight">
                Order Confirmed
            </h1>

            <p class="font-lora text-gray-600 text-lg mb-8">
                Thank you for your purchase! Your order has been successfully placed.
            </p>

            <!-- Order Details -->
            <div class="bg-gray-50 p-6 rounded-sm mb-8 text-left">
                <div class="grid grid-cols-2 gap-4">
                    <div>
                        <p class="font-cg text-sm uppercase text-gray-600">Order Number</p>
                        <p class="font-cg font-bold text-lg text-gray-900">#{{ $order->id }}</p>
                    </div>
                    <div>
                        <p class="font-cg text-sm uppercase text-gray-600">Order Date</p>
                        <p class="font-cg font-bold text-lg text-gray-900">{{ $order->order_date->format('M d, Y') }}</p>
                    </div>
                    <div>
                        <p class="font-cg text-sm uppercase text-gray-600">Status</p>
                        <p class="font-cg font-bold text-lg text-[#1fac99ff] uppercase">{{ $order->status }}</p>
                    </div>
                    <div>
                        <p class="font-cg text-sm uppercase text-gray-600">Total Amount</p>
                        <p class="font-cg font-bold text-lg text-gray-900">₱{{ number_format($order->total_amount, 2) }}</p>
                    </div>
                </div>
            </div>

            <!-- Items Ordered -->
            <div class="mb-8 text-left">
                <h2 class="font-cg font-bold text-xl uppercase text-gray-900 mb-4">Items Ordered</h2>
                <div class="space-y-3">
                    @foreach($order->items as $item)
                        <div class="flex justify-between py-3 border-b border-gray-200">
                            <div>
                                <p class="font-cg font-semibold text-gray-900">{{ $item->product->name }}</p>
                                <p class="font-lora text-sm text-gray-600">Quantity: {{ $item->quantity }}</p>
                            </div>
                            <p class="font-cg font-semibold text-gray-900">₱{{ number_format($item->price * $item->quantity, 2) }}</p>
                        </div>
                    @endforeach
                </div>
            </div>

            <!-- Action Buttons -->
            <div class="flex flex-col sm:flex-row gap-4 justify-center">
                <a href="{{ route('home') }}" class="px-8 py-3 bg-gray-900 text-white font-cg uppercase tracking-wide rounded-sm hover:bg-[#1fac99ff] transition-colors">
                    Continue Shopping
                </a>
                <a href="{{ route('orders.index') }}" class="px-8 py-3 border-2 border-gray-900 text-gray-900 font-cg uppercase tracking-wide rounded-sm hover:bg-gray-100 transition-colors">
                    View My Orders
                </a>
            </div>

            <p class="font-lora text-gray-600 text-sm mt-8">
                A confirmation email has been sent to <strong>{{ $order->user->email }}</strong>
            </p>
        </div>
    </div>
</div>
@endsection