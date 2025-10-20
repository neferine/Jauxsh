@extends('layouts.app')
@section('title', 'Checkout | Jauxsh')
@section('content')
<div class="min-h-screen bg-gray-50">
    <!-- Breadcrumb -->
    <div class="container mx-auto px-6 md:px-12 lg:px-20 max-w-7xl pt-32 pb-8">
        <nav class="text-sm text-gray-500 font-cg">
            <a href="/" class="hover:text-gray-900 transition-colors">HOME</a>
            <span class="mx-2">/</span>
            <a href="{{ route('cart.index') }}" class="hover:text-gray-900 transition-colors">CART</a>
            <span class="mx-2">/</span>
            <span class="text-gray-900">CHECKOUT</span>
        </nav>
    </div>

    <div class="container mx-auto px-6 md:px-12 lg:px-20 max-w-7xl pb-20">
        <h1 class="font-cg font-bold text-4xl md:text-5xl lg:text-6xl uppercase text-gray-900 mb-3 tracking-tight">
            Checkout
        </h1>
        <p class="font-lora text-gray-600 mb-12">Complete your order details below</p>

        <div class="grid grid-cols-1 lg:grid-cols-3 gap-8">
            <!-- Checkout Form -->
            <div class="lg:col-span-2 space-y-6">
                <form action="{{ route('checkout.process') }}" method="POST" class="space-y-6">
                    @csrf

                    <!-- Shipping Address Section -->
                    <div class="bg-white p-8 rounded-sm shadow-sm border border-gray-100">
                        <div class="flex items-center mb-6">
                            <div class="w-10 h-10 rounded-full bg-gray-900 text-white flex items-center justify-center font-cg font-bold mr-4">
                                1
                            </div>
                            <h2 class="font-cg font-bold text-2xl uppercase text-gray-900 tracking-wide">
                                Shipping Address
                            </h2>
                        </div>

                        @if($shippingAddresses->count() > 0)
                            <div class="mb-6">
                                <label class="block font-cg text-xs uppercase tracking-wider text-gray-700 mb-4">
                                    Select Delivery Address
                                </label>
                                <div class="space-y-3">
                                    @foreach($shippingAddresses as $address)
                                        <label class="block relative">
                                            <input type="radio" name="shipping_address_id" value="{{ $address->id }}" 
                                                   {{ $loop->first ? 'checked' : '' }} 
                                                   class="peer sr-only" required>
                                            <div class="p-5 border-2 border-gray-200 rounded-sm cursor-pointer transition-all duration-300 peer-checked:border-gray-900 peer-checked:bg-gray-50 hover:border-gray-400">
                                                <div class="flex items-start justify-between">
                                                    <div class="flex-1">
                                                        <p class="font-cg font-semibold text-gray-900 mb-1">{{ $address->address_line1 }}</p>
                                                        @if($address->address_line2)
                                                            <p class="font-lora text-sm text-gray-600 mb-1">{{ $address->address_line2 }}</p>
                                                        @endif
                                                        <p class="font-lora text-sm text-gray-600">{{ $address->city }}, {{ $address->postal_code }}</p>
                                                        <p class="font-lora text-sm text-gray-600">{{ $address->country }}</p>
                                                        <p class="font-lora text-sm text-gray-500 mt-2">
                                                            <span class="inline-block mr-1">📞</span>{{ $address->phone_number }}
                                                        </p>
                                                    </div>
                                                    <div class="ml-4 flex-shrink-0">
                                                        <div class="w-5 h-5 rounded-full border-2 border-gray-300 peer-checked:border-gray-900 peer-checked:bg-gray-900 transition-all duration-300 flex items-center justify-center">
                                                            <svg class="w-3 h-3 text-white" fill="currentColor" viewBox="0 0 20 20">
                                                                <path fill-rule="evenodd" d="M16.707 5.293a1 1 0 010 1.414l-8 8a1 1 0 01-1.414 0l-4-4a1 1 0 011.414-1.414L8 12.586l7.293-7.293a1 1 0 011.414 0z" clip-rule="evenodd"/>
                                                            </svg>
                                                        </div>
                                                    </div>
                                                </div>
                                            </div>
                                        </label>
                                    @endforeach
                                </div>
                            </div>

                            <div class="pt-4 border-t border-gray-200">
                                <a href="{{ route('account.address.create') }}" 
                                   class="inline-flex items-center font-cg text-sm uppercase text-gray-900 hover:text-gray-600 transition-colors">
                                    <svg class="w-4 h-4 mr-2" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                                        <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M12 4v16m8-8H4"/>
                                    </svg>
                                    Add New Address
                                </a>
                            </div>
                        @else
                            <!-- No saved addresses - prompt to add one -->
                            <div class="text-center py-12 bg-gray-50 rounded-sm border-2 border-dashed border-gray-300">
                                <svg class="mx-auto h-16 w-16 text-gray-400 mb-4" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                                    <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M17.657 16.657L13.414 20.9a1.998 1.998 0 01-2.827 0l-4.244-4.243a8 8 0 1111.314 0z"/>
                                    <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M15 11a3 3 0 11-6 0 3 3 0 016 0z"/>
                                </svg>
                                <h3 class="font-cg text-lg font-semibold text-gray-900 mb-2 uppercase">No Shipping Address</h3>
                                <p class="font-lora text-sm text-gray-600 mb-6 max-w-sm mx-auto">
                                    You need to add a shipping address before you can complete your order.
                                </p>
                                <a href="{{ route('account.address.create') }}" 
                                   class="inline-flex items-center px-6 py-3 bg-gray-900 text-white font-cg text-sm uppercase tracking-wider rounded-sm hover:bg-gray-800 transition-all duration-300">
                                    <svg class="w-5 h-5 mr-2" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                                        <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M12 4v16m8-8H4"/>
                                    </svg>
                                    Add Shipping Address
                                </a>
                            </div>
                        @endif
                    </div>

                    <!-- Payment Method -->
                    <div class="bg-white p-8 rounded-sm shadow-sm border border-gray-100">
                        <div class="flex items-center mb-6">
                            <div class="w-10 h-10 rounded-full bg-gray-900 text-white flex items-center justify-center font-cg font-bold mr-4">
                                2
                            </div>
                            <h2 class="font-cg font-bold text-2xl uppercase text-gray-900 tracking-wide">
                                Payment Method
                            </h2>
                        </div>

                        <p class="font-lora text-sm text-gray-500 mb-6 italic">Note: Payment processing is simulated for demonstration purposes</p>

                        <div class="space-y-3">
                            <!-- Credit Card -->
                            <label class="block relative">
                                <input type="radio" name="payment_method" value="credit_card" checked class="peer sr-only" required>
                                <div class="p-5 border-2 border-gray-200 rounded-sm cursor-pointer transition-all duration-300 peer-checked:border-gray-900 peer-checked:bg-gray-50 hover:border-gray-400">
                                    <div class="flex items-center justify-between">
                                        <div class="flex items-center">
                                            <div class="w-12 h-12 bg-gradient-to-br from-gray-800 to-gray-600 rounded flex items-center justify-center mr-4">
                                                <svg class="w-6 h-6 text-white" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                                                    <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M3 10h18M7 15h1m4 0h1m-7 4h12a3 3 0 003-3V8a3 3 0 00-3-3H6a3 3 0 00-3 3v8a3 3 0 003 3z"/>
                                                </svg>
                                            </div>
                                            <div>
                                                <p class="font-cg font-semibold text-gray-900">Credit Card</p>
                                                <p class="font-lora text-xs text-gray-500">Visa, Mastercard, Amex</p>
                                            </div>
                                        </div>
                                        <div class="w-5 h-5 rounded-full border-2 border-gray-300 peer-checked:border-gray-900 peer-checked:bg-gray-900 transition-all duration-300 flex items-center justify-center">
                                            <svg class="w-3 h-3 text-white opacity-0 peer-checked:opacity-100" fill="currentColor" viewBox="0 0 20 20">
                                                <path fill-rule="evenodd" d="M16.707 5.293a1 1 0 010 1.414l-8 8a1 1 0 01-1.414 0l-4-4a1 1 0 011.414-1.414L8 12.586l7.293-7.293a1 1 0 011.414 0z" clip-rule="evenodd"/>
                                            </svg>
                                        </div>
                                    </div>
                                </div>
                            </label>

                            <!-- Debit Card -->
                            <label class="block relative">
                                <input type="radio" name="payment_method" value="debit_card" class="peer sr-only">
                                <div class="p-5 border-2 border-gray-200 rounded-sm cursor-pointer transition-all duration-300 peer-checked:border-gray-900 peer-checked:bg-gray-50 hover:border-gray-400">
                                    <div class="flex items-center justify-between">
                                        <div class="flex items-center">
                                            <div class="w-12 h-12 bg-gradient-to-br from-blue-600 to-blue-400 rounded flex items-center justify-center mr-4">
                                                <svg class="w-6 h-6 text-white" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                                                    <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M3 10h18M7 15h1m4 0h1m-7 4h12a3 3 0 003-3V8a3 3 0 00-3-3H6a3 3 0 00-3 3v8a3 3 0 003 3z"/>
                                                </svg>
                                            </div>
                                            <div>
                                                <p class="font-cg font-semibold text-gray-900">Debit Card</p>
                                                <p class="font-lora text-xs text-gray-500">Direct bank payment</p>
                                            </div>
                                        </div>
                                        <div class="w-5 h-5 rounded-full border-2 border-gray-300 peer-checked:border-gray-900 peer-checked:bg-gray-900 transition-all duration-300 flex items-center justify-center">
                                            <svg class="w-3 h-3 text-white opacity-0 peer-checked:opacity-100" fill="currentColor" viewBox="0 0 20 20">
                                                <path fill-rule="evenodd" d="M16.707 5.293a1 1 0 010 1.414l-8 8a1 1 0 01-1.414 0l-4-4a1 1 0 011.414-1.414L8 12.586l7.293-7.293a1 1 0 011.414 0z" clip-rule="evenodd"/>
                                            </svg>
                                        </div>
                                    </div>
                                </div>
                            </label>

                            <!-- GCash -->
                            <label class="block relative">
                                <input type="radio" name="payment_method" value="gcash" class="peer sr-only">
                                <div class="p-5 border-2 border-gray-200 rounded-sm cursor-pointer transition-all duration-300 peer-checked:border-gray-900 peer-checked:bg-gray-50 hover:border-gray-400">
                                    <div class="flex items-center justify-between">
                                        <div class="flex items-center">
                                            <div class="w-12 h-12 bg-gradient-to-br from-blue-500 to-blue-700 rounded flex items-center justify-center mr-4">
                                                <span class="text-white font-bold text-xs">G₱</span>
                                            </div>
                                            <div>
                                                <p class="font-cg font-semibold text-gray-900">GCash</p>
                                                <p class="font-lora text-xs text-gray-500">Fast & secure e-wallet</p>
                                            </div>
                                        </div>
                                        <div class="w-5 h-5 rounded-full border-2 border-gray-300 peer-checked:border-gray-900 peer-checked:bg-gray-900 transition-all duration-300 flex items-center justify-center">
                                            <svg class="w-3 h-3 text-white opacity-0 peer-checked:opacity-100" fill="currentColor" viewBox="0 0 20 20">
                                                <path fill-rule="evenodd" d="M16.707 5.293a1 1 0 010 1.414l-8 8a1 1 0 01-1.414 0l-4-4a1 1 0 011.414-1.414L8 12.586l7.293-7.293a1 1 0 011.414 0z" clip-rule="evenodd"/>
                                            </svg>
                                        </div>
                                    </div>
                                </div>
                            </label>

                            <!-- PayPal -->
                            <label class="block relative">
                                <input type="radio" name="payment_method" value="paypal" class="peer sr-only">
                                <div class="p-5 border-2 border-gray-200 rounded-sm cursor-pointer transition-all duration-300 peer-checked:border-gray-900 peer-checked:bg-gray-50 hover:border-gray-400">
                                    <div class="flex items-center justify-between">
                                        <div class="flex items-center">
                                            <div class="w-12 h-12 bg-gradient-to-br from-blue-600 to-blue-800 rounded flex items-center justify-center mr-4">
                                                <span class="text-white font-bold text-sm">PP</span>
                                            </div>
                                            <div>
                                                <p class="font-cg font-semibold text-gray-900">PayPal</p>
                                                <p class="font-lora text-xs text-gray-500">Pay with PayPal account</p>
                                            </div>
                                        </div>
                                        <div class="w-5 h-5 rounded-full border-2 border-gray-300 peer-checked:border-gray-900 peer-checked:bg-gray-900 transition-all duration-300 flex items-center justify-center">
                                            <svg class="w-3 h-3 text-white opacity-0 peer-checked:opacity-100" fill="currentColor" viewBox="0 0 20 20">
                                                <path fill-rule="evenodd" d="M16.707 5.293a1 1 0 010 1.414l-8 8a1 1 0 01-1.414 0l-4-4a1 1 0 011.414-1.414L8 12.586l7.293-7.293a1 1 0 011.414 0z" clip-rule="evenodd"/>
                                            </svg>
                                        </div>
                                    </div>
                                </div>
                            </label>

                            <!-- Bank Transfer -->
                            <label class="block relative">
                                <input type="radio" name="payment_method" value="bank_transfer" class="peer sr-only">
                                <div class="p-5 border-2 border-gray-200 rounded-sm cursor-pointer transition-all duration-300 peer-checked:border-gray-900 peer-checked:bg-gray-50 hover:border-gray-400">
                                    <div class="flex items-center justify-between">
                                        <div class="flex items-center">
                                            <div class="w-12 h-12 bg-gradient-to-br from-green-600 to-green-800 rounded flex items-center justify-center mr-4">
                                                <svg class="w-6 h-6 text-white" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                                                    <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M8 14v3m4-3v3m4-3v3M3 21h18M3 10h18M3 7l9-4 9 4M4 10h16v11H4V10z"/>
                                                </svg>
                                            </div>
                                            <div>
                                                <p class="font-cg font-semibold text-gray-900">Bank Transfer</p>
                                                <p class="font-lora text-xs text-gray-500">Direct bank deposit</p>
                                            </div>
                                        </div>
                                        <div class="w-5 h-5 rounded-full border-2 border-gray-300 peer-checked:border-gray-900 peer-checked:bg-gray-900 transition-all duration-300 flex items-center justify-center">
                                            <svg class="w-3 h-3 text-white opacity-0 peer-checked:opacity-100" fill="currentColor" viewBox="0 0 20 20">
                                                <path fill-rule="evenodd" d="M16.707 5.293a1 1 0 010 1.414l-8 8a1 1 0 01-1.414 0l-4-4a1 1 0 011.414-1.414L8 12.586l7.293-7.293a1 1 0 011.414 0z" clip-rule="evenodd"/>
                                            </svg>
                                        </div>
                                    </div>
                                </div>
                            </label>

                            <!-- Cash on Delivery -->
                            <label class="block relative">
                                <input type="radio" name="payment_method" value="cod" class="peer sr-only">
                                <div class="p-5 border-2 border-gray-200 rounded-sm cursor-pointer transition-all duration-300 peer-checked:border-gray-900 peer-checked:bg-gray-50 hover:border-gray-400">
                                    <div class="flex items-center justify-between">
                                        <div class="flex items-center">
                                            <div class="w-12 h-12 bg-gradient-to-br from-amber-600 to-amber-800 rounded flex items-center justify-center mr-4">
                                                <svg class="w-6 h-6 text-white" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                                                    <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M17 9V7a2 2 0 00-2-2H5a2 2 0 00-2 2v6a2 2 0 002 2h2m2 4h10a2 2 0 002-2v-6a2 2 0 00-2-2H9a2 2 0 00-2 2v6a2 2 0 002 2zm7-5a2 2 0 11-4 0 2 2 0 014 0z"/>
                                                </svg>
                                            </div>
                                            <div>
                                                <p class="font-cg font-semibold text-gray-900">Cash on Delivery</p>
                                                <p class="font-lora text-xs text-gray-500">Pay when you receive</p>
                                            </div>
                                        </div>
                                        <div class="w-5 h-5 rounded-full border-2 border-gray-300 peer-checked:border-gray-900 peer-checked:bg-gray-900 transition-all duration-300 flex items-center justify-center">
                                            <svg class="w-3 h-3 text-white opacity-0 peer-checked:opacity-100" fill="currentColor" viewBox="0 0 20 20">
                                                <path fill-rule="evenodd" d="M16.707 5.293a1 1 0 010 1.414l-8 8a1 1 0 01-1.414 0l-4-4a1 1 0 011.414-1.414L8 12.586l7.293-7.293a1 1 0 011.414 0z" clip-rule="evenodd"/>
                                            </svg>
                                        </div>
                                    </div>
                                </div>
                            </label>
                        </div>
                    </div>

                    <!-- Place Order Button -->
                    <button type="submit" 
                            class="w-full bg-gray-900 text-white font-cg uppercase tracking-wider py-5 rounded-sm hover:bg-gray-800 transition-all duration-300 text-lg font-bold shadow-lg hover:shadow-xl">
                        Complete Order
                    </button>

                    <p class="text-center font-lora text-xs text-gray-500 mt-4">
                        By placing your order, you agree to our Terms & Conditions
                    </p>
                </form>
            </div>

            <!-- Order Summary -->
            <div class="lg:col-span-1">
                <div class="bg-white p-8 rounded-sm shadow-sm border border-gray-100 sticky top-24">
                    <h2 class="font-cg font-bold text-xl uppercase text-gray-900 mb-6 tracking-wide border-b pb-4">
                        Order Summary
                    </h2>

                    <div class="space-y-5 mb-6">
                        @foreach($cart->cartItems as $item)
                            <div class="flex gap-4 pb-5 border-b border-gray-100">
                                <div class="w-20 h-20 bg-gray-100 rounded-sm overflow-hidden flex-shrink-0">
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
                                <div class="flex-1 min-w-0">
                                    <p class="font-cg font-semibold text-gray-900 truncate mb-1">{{ $item->product->name }}</p>
                                    <p class="font-lora text-sm text-gray-500 mb-2">Qty: {{ $item->quantity }}</p>
                                    <p class="font-cg font-bold text-gray-900">
                                        ₱{{ number_format($item->product->price * $item->quantity, 2) }}
                                    </p>
                                </div>
                            </div>
                        @endforeach
                    </div>

                    <div class="space-y-3 pt-4 border-t-2 border-gray-900">
                        <div class="flex justify-between font-lora text-sm">
                            <span class="text-gray-600">Subtotal:</span>
                            <span class="font-semibold text-gray-900">₱{{ number_format($cartTotal, 2) }}</span>
                        </div>
                        <div class="flex justify-between font-lora text-sm">
                            <span class="text-gray-600">Shipping:</span>
                            <span class="font-semibold text-green-600">FREE</span>
                        </div>
                        <div class="flex justify-between font-lora text-sm pb-4 border-b border-gray-200">
                            <span class="text-gray-600">Tax:</span>
                            <span class="font-semibold text-gray-900">₱0.00</span>
                        </div>
                        <div class="flex justify-between items-center pt-2">
                            <span class="font-cg font-bold text-lg uppercase text-gray-900">Total:</span>
                            <span class="font-cg font-bold text-2xl text-gray-900">₱{{ number_format($cartTotal, 2) }}</span>
                        </div>
                    </div>

                    <div class="mt-6 p-4 bg-gray-50 rounded-sm">
                        <div class="flex items-start">
                            <svg class="w-5 h-5 text-green-600 mr-3 mt-0.5 flex-shrink-0" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                                <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M9 12l2 2 4-4m5.618-4.016A11.955 11.955 0 0112 2.944a11.955 11.955 0 01-8.618 3.04A12.02 12.02 0 003 9c0 5.591 3.824 10.29 9 11.622 5.176-1.332 9-6.03 9-11.622 0-1.042-.133-2.052-.382-3.016z"/>
                            </svg>
                            <div>
                                <p class="font-cg font-semibold text-sm text-gray-900 mb-1">Secure Checkout</p>
                                <p class="font-lora text-xs text-gray-600">Your payment information is protected</p>
                            </div>
                        </div>
                    </div>
                </div>
            </div>
        </div>
    </div>
</div>

<style>
    /* Custom radio button styling */
    input[type="radio"]:checked + div {
        animation: pulse 0.3s ease-in-out;
    }
    
    @keyframes pulse {
        0%, 100% {
            transform: scale(1);
        }
        50% {
            transform: scale(0.98);
        }
    }

    /* Smooth transitions for all interactive elements */
    input:focus {
        transition: all 0.3s ease;
    }
</style>
@endsection