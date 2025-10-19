@extends('layouts.app')
@section('title', 'Shopping Cart')

@section('content')
<div class="w-full bg-white">
    <!-- Header Section -->
    <div class="container mx-auto px-6 md:px-12 lg:px-20 max-w-7xl pt-32 pb-12">
        <h1 class="font-cg text-4xl md:text-5xl font-bold tracking-tight uppercase text-gray-900 mb-2">
            Shopping Cart
        </h1>
        <p class="font-lora text-gray-600">Review your items before checkout</p>
    </div>

    <!-- Cart Content -->
    <div class="container mx-auto px-6 md:px-12 lg:px-20 max-w-7xl pb-20">
        @if(session('success'))
        <div class="bg-green-50 border border-green-200 text-green-800 px-6 py-4 rounded-sm mb-6 flex items-center gap-3">
            <svg class="w-5 h-5" fill="currentColor" viewBox="0 0 20 20">
                <path fill-rule="evenodd" d="M10 18a8 8 0 100-16 8 8 0 000 16zm3.707-9.293a1 1 0 00-1.414-1.414L9 10.586 7.707 9.293a1 1 0 00-1.414 1.414l2 2a1 1 0 001.414 0l4-4z" clip-rule="evenodd"/>
            </svg>
            <span class="font-lora">{{ session('success') }}</span>
        </div>
        @endif

        @if(session('error'))
        <div class="bg-red-50 border border-red-200 text-red-800 px-6 py-4 rounded-sm mb-6 flex items-center gap-3">
            <svg class="w-5 h-5" fill="currentColor" viewBox="0 0 20 20">
                <path fill-rule="evenodd" d="M10 18a8 8 0 100-16 8 8 0 000 16zM8.707 7.293a1 1 0 00-1.414 1.414L8.586 10l-1.293 1.293a1 1 0 101.414 1.414L10 11.414l1.293 1.293a1 1 0 001.414-1.414L11.414 10l1.293-1.293a1 1 0 00-1.414-1.414L10 8.586 8.707 7.293z" clip-rule="evenodd"/>
            </svg>
            <span class="font-lora">{{ session('error') }}</span>
        </div>
        @endif

        @if($cart->cartItems->count() > 0)
        <div class="grid grid-cols-1 lg:grid-cols-3 gap-8">
            <!-- Cart Items -->
            <div class="lg:col-span-2">
                <div class="bg-neutral-50 rounded-sm p-6">
                    <div class="flex justify-between items-center mb-6">
                        <h2 class="font-cg text-2xl font-bold tracking-tight uppercase text-gray-900">
                            Cart Items ({{ $cart->cartItems->count() }})
                        </h2>
                        <form action="{{ route('cart.clear') }}" method="POST" onsubmit="return confirm('Are you sure you want to clear your cart?');">
                            @csrf
                            @method('DELETE')
                            <button type="submit" class="font-lora text-sm text-red-600 hover:text-red-700 transition-colors">
                                Clear Cart
                            </button>
                        </form>
                    </div>

                    <div class="space-y-4">
                        @foreach($cart->cartItems as $item)
                        <div class="bg-white rounded-sm p-4 flex gap-4 border border-gray-200 hover:border-gray-900 transition-colors duration-300">
                            <!-- Product Image -->
                            <div class="w-24 h-24 flex-shrink-0 bg-gray-100 rounded-sm overflow-hidden">
                                @if($item->product->images->count() > 0)
                                <img src="{{ asset('storage/' . $item->product->images->first()->image_url) }}" 
                                     alt="{{ $item->product->name }}" 
                                     class="w-full h-full object-cover">
                                @else
                                <div class="w-full h-full flex items-center justify-center">
                                    <svg class="w-8 h-8 text-gray-300" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                                        <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M4 16l4.586-4.586a2 2 0 012.828 0L16 16m-2-2l1.586-1.586a2 2 0 012.828 0L20 14m-6-6h.01M6 20h12a2 2 0 002-2V6a2 2 0 00-2-2H6a2 2 0 00-2 2v12a2 2 0 002 2z"/>
                                    </svg>
                                </div>
                                @endif
                            </div>

                            <!-- Product Info -->
                            <div class="flex-1 flex flex-col justify-between">
                                <div>
                                    <h3 class="font-lora text-lg text-gray-900 mb-1">
                                        <a href="{{ route('products.show', $item->product->id) }}" class="hover:underline">
                                            {{ $item->product->name }}
                                        </a>
                                    </h3>
                                    @if($item->product->category)
                                    <p class="font-cg text-xs text-gray-500 uppercase">{{ $item->product->category->name }}</p>
                                    @endif
                                </div>
                                <div class="flex items-center gap-4 mt-2">
                                    <p class="font-lora text-lg font-medium text-gray-900">${{ number_format($item->product->price, 2) }}</p>
                                    @if($item->product->stock <= 0)
                                    <span class="text-xs text-red-600 font-cg uppercase">Out of stock</span>
                                    @elseif($item->product->stock < $item->quantity)
                                    <span class="text-xs text-yellow-600 font-cg uppercase">Only {{ $item->product->stock }} left</span>
                                    @endif
                                </div>
                            </div>

                            <!-- Quantity & Actions -->
                            <div class="flex flex-col items-end justify-between">
                                <form action="{{ route('cart.remove', $item) }}" method="POST">
                                    @csrf
                                    @method('DELETE')
                                    <button type="submit" class="text-gray-400 hover:text-red-600 transition-colors">
                                        <svg class="w-5 h-5" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                                            <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M6 18L18 6M6 6l12 12"/>
                                        </svg>
                                    </button>
                                </form>

                                <div class="flex items-center gap-2">
                                    <form action="{{ route('cart.update', $item) }}" method="POST" class="flex items-center gap-2">
                                        @csrf
                                        @method('PATCH')
                                        <input type="number" 
                                               name="quantity" 
                                               value="{{ $item->quantity }}" 
                                               min="1" 
                                               max="{{ $item->product->stock }}"
                                               class="w-16 px-2 py-1 text-center font-lora text-sm border border-gray-300 rounded focus:outline-none focus:ring-2 focus:ring-gray-900">
                                        <button type="submit" 
                                                class="px-3 py-1 font-cg text-xs uppercase bg-gray-900 text-white rounded hover:bg-gray-800 transition-colors">
                                            Update
                                        </button>
                                    </form>
                                </div>

                                <p class="font-lora text-sm text-gray-600 mt-2">
                                    Subtotal: <span class="font-medium text-gray-900">${{ number_format($item->quantity * $item->product->price, 2) }}</span>
                                </p>
                            </div>
                        </div>
                        @endforeach
                    </div>
                </div>
            </div>

            <!-- Order Summary -->
            <div class="lg:col-span-1">
                <div class="bg-neutral-50 rounded-sm p-6 sticky top-24">
                    <h2 class="font-cg text-xl font-bold tracking-tight uppercase text-gray-900 mb-6">
                        Order Summary
                    </h2>

                    <div class="space-y-3 mb-6">
                        <div class="flex justify-between font-lora text-sm">
                            <span class="text-gray-600">Subtotal</span>
                            <span class="text-gray-900">${{ number_format($total, 2) }}</span>
                        </div>
                        <div class="flex justify-between font-lora text-sm">
                            <span class="text-gray-600">Shipping</span>
                            <span class="text-gray-900">Calculated at checkout</span>
                        </div>
                        <div class="border-t border-gray-200 pt-3">
                            <div class="flex justify-between font-lora text-lg font-medium">
                                <span class="text-gray-900">Total</span>
                                <span class="text-gray-900">${{ number_format($total, 2) }}</span>
                            </div>
                        </div>
                    </div>

                    <a href="{{ route('checkout') }}" 
                       class="block w-full px-6 py-3 text-center font-lora text-sm text-white bg-gray-900 rounded-full hover:bg-gray-800 transition-all duration-300 mb-3">
                        Proceed to Checkout
                    </a>

                    <a href="{{ route('products.index') }}" 
                       class="block w-full px-6 py-3 text-center font-lora text-sm text-gray-900 bg-white border border-gray-300 rounded-full hover:bg-gray-50 transition-all duration-300">
                        Continue Shopping
                    </a>

                    <!-- Trust Badges -->
                    <div class="mt-6 pt-6 border-t border-gray-200">
                        <div class="space-y-3">
                            <div class="flex items-center gap-3 text-sm">
                                <svg class="w-5 h-5 text-gray-600" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                                    <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M9 12l2 2 4-4m5.618-4.016A11.955 11.955 0 0112 2.944a11.955 11.955 0 01-8.618 3.04A12.02 12.02 0 003 9c0 5.591 3.824 10.29 9 11.622 5.176-1.332 9-6.03 9-11.622 0-1.042-.133-2.052-.382-3.016z"/>
                                </svg>
                                <span class="font-lora text-gray-600">Secure Checkout</span>
                            </div>
                            <div class="flex items-center gap-3 text-sm">
                                <svg class="w-5 h-5 text-gray-600" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                                    <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M5 13l4 4L19 7"/>
                                </svg>
                                <span class="font-lora text-gray-600">Free Returns</span>
                            </div>
                            <div class="flex items-center gap-3 text-sm">
                                <svg class="w-5 h-5 text-gray-600" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                                    <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M13 10V3L4 14h7v7l9-11h-7z"/>
                                </svg>
                                <span class="font-lora text-gray-600">Fast Shipping</span>
                            </div>
                        </div>
                    </div>
                </div>
            </div>
        </div>

        @else
        <!-- Empty Cart -->
        <div class="bg-neutral-50 rounded-sm p-12 text-center">
            <svg class="mx-auto h-24 w-24 text-gray-400 mb-6" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M3 3h2l.4 2M7 13h10l4-8H5.4M7 13L5.4 5M7 13l-2.293 2.293c-.63.63-.184 1.707.707 1.707H17m0 0a2 2 0 100 4 2 2 0 000-4zm-8 2a2 2 0 11-4 0 2 2 0 014 0z"/>
            </svg>
            <h2 class="font-cg text-2xl font-bold text-gray-900 mb-2">Your Cart is Empty</h2>
            <p class="font-lora text-gray-600 mb-6">Start adding some products to your cart!</p>
            <a href="{{ route('products.index') }}" 
               class="inline-block px-8 py-3 font-lora text-sm text-white bg-gray-900 rounded-full hover:bg-gray-800 transition-all duration-300">
                Start Shopping
            </a>
        </div>
        @endif
    </div>
</div>
@endsection