@extends('layouts.app')
@section('title', 'Checkout | Jauxsh')
@section('content')
<div class="min-h-screen bg-gray-50">
    <!-- Breadcrumb -->
    <div class="px-6 md:px-20 lg:px-40 pt-32 pb-8">
        <nav class="text-sm text-gray-600 font-lora">
            <a href="/" class="hover:text-gray-900 transition-colors">HOME</a>
            <span class="mx-2">/</span>
            <a href="{{ route('cart.index') }}" class="hover:text-gray-900 transition-colors">CART</a>
            <span class="mx-2">/</span>
            <span class="text-gray-900">CHECKOUT</span>
        </nav>
    </div>

    <div class="px-6 md:px-20 lg:px-40 pb-20">
        <h1 class="font-cg font-bold text-4xl md:text-5xl uppercase text-gray-900 mb-12 tracking-tight">
            Checkout
        </h1>

        <div class="grid grid-cols-1 lg:grid-cols-3 gap-12">
            <!-- Checkout Form -->
            <div class="lg:col-span-2">
                <form action="{{ route('checkout.process') }}" method="POST" class="space-y-8">
                    @csrf

                    <!-- Shipping Address Section -->
                    <div class="bg-white p-6 rounded-sm shadow-sm">
                        <h2 class="font-cg font-bold text-2xl uppercase text-gray-900 mb-6 tracking-wide">
                            Shipping Address
                        </h2>

                        @if($shippingAddresses->count() > 0)
                            <div class="mb-6">
                                <label class="block font-cg text-sm uppercase tracking-wide text-gray-900 mb-4">
                                    Select Existing Address
                                </label>
                                <div class="space-y-3">
                                    @foreach($shippingAddresses as $address)
                                        <label class="flex items-start p-4 border-2 border-gray-300 rounded-sm cursor-pointer hover:border-[#1fac99ff] transition-colors"
                                               @if($loop->first) style="border-color: #1fac99ff; background-color: rgba(31, 172, 153, 0.05);" @endif>
                                            <input type="radio" name="shipping_address_id" value="{{ $address->id }}" 
                                                   {{ $loop->first ? 'checked' : '' }} class="mt-1 mr-3" required>
                                            <div>
                                                <p class="font-cg font-semibold text-gray-900">{{ $address->address_line1 }}</p>
                                                @if($address->address_line2)
                                                    <p class="font-lora text-sm text-gray-600">{{ $address->address_line2 }}</p>
                                                @endif
                                                <p class="font-lora text-sm text-gray-600">{{ $address->city }}, {{ $address->postal_code }}</p>
                                                <p class="font-lora text-sm text-gray-600">{{ $address->country }}</p>
                                                <p class="font-lora text-sm text-gray-600">{{ $address->phone_number }}</p>
                                            </div>
                                        </label>
                                    @endforeach
                                </div>
                            </div>

                            <div class="border-t-2 pt-6">
                                <a href="{{ route('account.address.create') }}" 
                                   class="font-cg text-sm uppercase text-[#1fac99ff] hover:text-[#1fac99ff] hover:underline">
                                    + Add New Address
                                </a>
                            </div>
                        @else
                            <!-- No saved addresses - show form -->
                            <div class="space-y-4 mb-6">
                                <div>
                                    <label for="address_line1" class="block font-cg text-sm uppercase tracking-wide text-gray-900 mb-2">
                                        Address Line 1 <span class="text-red-500">*</span>
                                    </label>
                                    <input type="text" id="address_line1" name="address_line1" required
                                           class="w-full px-4 py-3 border border-gray-300 rounded-sm focus:outline-none focus:border-[#1fac99ff] font-lora">
                                </div>

                                <div>
                                    <label for="address_line2" class="block font-cg text-sm uppercase tracking-wide text-gray-900 mb-2">
                                        Address Line 2 <span class="text-gray-500 text-xs">(Optional)</span>
                                    </label>
                                    <input type="text" id="address_line2" name="address_line2"
                                           class="w-full px-4 py-3 border border-gray-300 rounded-sm focus:outline-none focus:border-[#1fac99ff] font-lora">
                                </div>

                                <div class="grid grid-cols-2 gap-4">
                                    <div>
                                        <label for="city" class="block font-cg text-sm uppercase tracking-wide text-gray-900 mb-2">
                                            City <span class="text-red-500">*</span>
                                        </label>
                                        <input type="text" id="city" name="city" required
                                               class="w-full px-4 py-3 border border-gray-300 rounded-sm focus:outline-none focus:border-[#1fac99ff] font-lora">
                                    </div>

                                    <div>
                                        <label for="postal_code" class="block font-cg text-sm uppercase tracking-wide text-gray-900 mb-2">
                                            Postal Code <span class="text-red-500">*</span>
                                        </label>
                                        <input type="text" id="postal_code" name="postal_code" required
                                               class="w-full px-4 py-3 border border-gray-300 rounded-sm focus:outline-none focus:border-[#1fac99ff] font-lora">
                                    </div>
                                </div>

                                <div>
                                    <label for="country" class="block font-cg text-sm uppercase tracking-wide text-gray-900 mb-2">
                                        Country <span class="text-red-500">*</span>
                                    </label>
                                    <input type="text" id="country" name="country" value="Philippines" required
                                           class="w-full px-4 py-3 border border-gray-300 rounded-sm focus:outline-none focus:border-[#1fac99ff] font-lora">
                                </div>

                                <div>
                                    <label for="phone_number" class="block font-cg text-sm uppercase tracking-wide text-gray-900 mb-2">
                                        Phone Number <span class="text-red-500">*</span>
                                    </label>
                                    <input type="tel" id="phone_number" name="phone_number" required
                                           class="w-full px-4 py-3 border border-gray-300 rounded-sm focus:outline-none focus:border-[#1fac99ff] font-lora">
                                </div>
                            </div>

                            <p class="font-lora text-sm text-gray-600">
                                Already have a saved address? <a href="{{ route('account.address.create') }}" class="text-[#1fac99ff] hover:underline">Add it here</a>
                            </p>
                        @endif
                    </div>

                    <!-- Payment Method -->
                    <div class="bg-white p-6 rounded-sm shadow-sm">
                        <h2 class="font-cg font-bold text-2xl uppercase text-gray-900 mb-6 tracking-wide">
                            Payment Method
                        </h2>

                        <div class="space-y-3">
                            <label class="flex items-center p-4 border-2 border-gray-300 rounded-sm cursor-pointer hover:border-[#1fac99ff] transition-colors">
                                <input type="radio" name="payment_method" value="credit_card" checked class="mr-3" required>
                                <span class="font-cg uppercase text-gray-900">Credit Card</span>
                            </label>

                            <label class="flex items-center p-4 border-2 border-gray-300 rounded-sm cursor-pointer hover:border-[#1fac99ff] transition-colors">
                                <input type="radio" name="payment_method" value="debit_card" class="mr-3">
                                <span class="font-cg uppercase text-gray-900">Debit Card</span>
                            </label>

                            <label class="flex items-center p-4 border-2 border-gray-300 rounded-sm cursor-pointer hover:border-[#1fac99ff] transition-colors">
                                <input type="radio" name="payment_method" value="bank_transfer" class="mr-3">
                                <span class="font-cg uppercase text-gray-900">Bank Transfer</span>
                            </label>

                            <label class="flex items-center p-4 border-2 border-gray-300 rounded-sm cursor-pointer hover:border-[#1fac99ff] transition-colors">
                                <input type="radio" name="payment_method" value="paypal" class="mr-3">
                                <span class="font-cg uppercase text-gray-900">PayPal</span>
                            </label>
                        </div>
                    </div>

                    <!-- Place Order Button -->
                    <button type="submit" 
                            class="w-full bg-gray-900 text-white font-cg uppercase tracking-wide py-4 rounded-sm hover:bg-[#1fac99ff] transition-colors duration-300">
                        Place Order
                    </button>
                </form>
            </div>

            <!-- Order Summary -->
            <div class="lg:col-span-1">
                <div class="bg-white p-6 rounded-sm shadow-sm sticky top-20">
                    <h2 class="font-cg font-bold text-xl uppercase text-gray-900 mb-6 tracking-wide">
                        Order Summary
                    </h2>

                    <div class="space-y-4 mb-6">
                        @foreach($cart->cartItems as $item)
                            <div class="flex justify-between pb-4 border-b border-gray-200">
                                <div>
                                    <p class="font-cg font-semibold text-gray-900">{{ $item->product->name }}</p>
                                    <p class="font-lora text-sm text-gray-600">Qty: {{ $item->quantity }}</p>
                                </div>
                                <p class="font-cg font-semibold text-gray-900">
                                    ₱{{ number_format($item->product->price * $item->quantity, 2) }}
                                </p>
                            </div>
                        @endforeach
                    </div>

                    <div class="border-t-2 pt-4">
                        <div class="flex justify-between mb-2">
                            <span class="font-lora text-gray-600">Subtotal:</span>
                            <span class="font-cg font-semibold">₱{{ number_format($cartTotal, 2) }}</span>
                        </div>
                        <div class="flex justify-between mb-4">
                            <span class="font-lora text-gray-600">Shipping:</span>
                            <span class="font-cg font-semibold">FREE</span>
                        </div>
                        <div class="flex justify-between border-t pt-4">
                            <span class="font-cg font-bold text-lg text-gray-900">Total:</span>
                            <span class="font-cg font-bold text-lg text-[#1fac99ff]">₱{{ number_format($cartTotal, 2) }}</span>
                        </div>
                    </div>
                </div>
            </div>
        </div>
    </div>
</div>
@endsection