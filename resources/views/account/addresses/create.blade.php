@extends('layouts.app')
@section('title', 'Add Shipping Address')

@section('content')
<div class="w-full bg-white">
    <!-- Header Section -->
    <div class="container mx-auto px-6 md:px-12 lg:px-20 max-w-7xl pt-32 pb-12">
        <div class="flex items-center gap-4 mb-4">
            <a href="{{ route('account.index') }}" class="text-gray-600 hover:text-gray-900 transition-colors">
                <svg class="w-6 h-6" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                    <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M15 19l-7-7 7-7"/>
                </svg>
            </a>
            <h1 class="font-cg text-4xl md:text-5xl font-bold tracking-tight uppercase text-gray-900">
                Add Shipping Address
            </h1>
        </div>
        <p class="font-lora text-gray-600 ml-10">Add a new delivery address to your account</p>
    </div>

    <!-- Form Content -->
    <div class="container mx-auto px-6 md:px-12 lg:px-20 max-w-4xl pb-20">
        <form action="{{ route('account.address.store') }}" method="POST" class="bg-neutral-50 rounded-sm p-8">
            @csrf

            <div class="space-y-6">
                <!-- Address Line 1 -->
                <div>
                    <label for="address_line1" class="block font-cg text-xs uppercase tracking-wide text-gray-700 mb-2">
                        Address Line 1 <span class="text-red-600">*</span>
                    </label>
                    <input type="text" 
                           name="address_line1" 
                           id="address_line1" 
                           value="{{ old('address_line1') }}"
                           placeholder="Street address, P.O. box"
                           class="w-full px-4 py-3 font-lora text-gray-900 bg-white border border-gray-300 rounded-sm focus:outline-none focus:ring-2 focus:ring-gray-900 focus:border-transparent @error('address_line1') border-red-500 @enderror">
                    @error('address_line1')
                        <p class="mt-1 text-sm text-red-600 font-lora">{{ $message }}</p>
                    @enderror
                </div>

                <!-- Address Line 2 -->
                <div>
                    <label for="address_line2" class="block font-cg text-xs uppercase tracking-wide text-gray-700 mb-2">
                        Address Line 2 (Optional)
                    </label>
                    <input type="text" 
                           name="address_line2" 
                           id="address_line2" 
                           value="{{ old('address_line2') }}"
                           placeholder="Apartment, suite, unit, building, floor, etc."
                           class="w-full px-4 py-3 font-lora text-gray-900 bg-white border border-gray-300 rounded-sm focus:outline-none focus:ring-2 focus:ring-gray-900 focus:border-transparent @error('address_line2') border-red-500 @enderror">
                    @error('address_line2')
                        <p class="mt-1 text-sm text-red-600 font-lora">{{ $message }}</p>
                    @enderror
                </div>

                <div class="grid grid-cols-1 md:grid-cols-2 gap-6">
                    <!-- City -->
                    <div>
                        <label for="city" class="block font-cg text-xs uppercase tracking-wide text-gray-700 mb-2">
                            City <span class="text-red-600">*</span>
                        </label>
                        <input type="text" 
                               name="city" 
                               id="city" 
                               value="{{ old('city') }}"
                               class="w-full px-4 py-3 font-lora text-gray-900 bg-white border border-gray-300 rounded-sm focus:outline-none focus:ring-2 focus:ring-gray-900 focus:border-transparent @error('city') border-red-500 @enderror">
                        @error('city')
                            <p class="mt-1 text-sm text-red-600 font-lora">{{ $message }}</p>
                        @enderror
                    </div>

                    <!-- Postal Code -->
                    <div>
                        <label for="postal_code" class="block font-cg text-xs uppercase tracking-wide text-gray-700 mb-2">
                            Postal Code <span class="text-red-600">*</span>
                        </label>
                        <input type="text" 
                               name="postal_code" 
                               id="postal_code" 
                               value="{{ old('postal_code') }}"
                               class="w-full px-4 py-3 font-lora text-gray-900 bg-white border border-gray-300 rounded-sm focus:outline-none focus:ring-2 focus:ring-gray-900 focus:border-transparent @error('postal_code') border-red-500 @enderror">
                        @error('postal_code')
                            <p class="mt-1 text-sm text-red-600 font-lora">{{ $message }}</p>
                        @enderror
                    </div>
                </div>

                <div class="grid grid-cols-1 md:grid-cols-2 gap-6">
                    <!-- Country -->
                    <div>
                        <label for="country" class="block font-cg text-xs uppercase tracking-wide text-gray-700 mb-2">
                            Country <span class="text-red-600">*</span>
                        </label>
                        <select name="country" 
                                id="country"
                                class="w-full px-4 py-3 font-lora text-gray-900 bg-white border border-gray-300 rounded-sm focus:outline-none focus:ring-2 focus:ring-gray-900 focus:border-transparent @error('country') border-red-500 @enderror">
                            <option value="">Select Country</option>
                            <option value="Philippines" {{ old('country') == 'Philippines' ? 'selected' : '' }}>Philippines</option>
                            <option value="United States" {{ old('country') == 'United States' ? 'selected' : '' }}>United States</option>
                            <option value="Canada" {{ old('country') == 'Canada' ? 'selected' : '' }}>Canada</option>
                            <option value="United Kingdom" {{ old('country') == 'United Kingdom' ? 'selected' : '' }}>United Kingdom</option>
                            <option value="Australia" {{ old('country') == 'Australia' ? 'selected' : '' }}>Australia</option>
                            <!-- Add more countries as needed -->
                        </select>
                        @error('country')
                            <p class="mt-1 text-sm text-red-600 font-lora">{{ $message }}</p>
                        @enderror
                    </div>

                    <!-- Phone Number -->
                    <div>
                        <label for="phone_number" class="block font-cg text-xs uppercase tracking-wide text-gray-700 mb-2">
                            Phone Number <span class="text-red-600">*</span>
                        </label>
                        <input type="tel" 
                               name="phone_number" 
                               id="phone_number" 
                               value="{{ old('phone_number') }}"
                               placeholder="e.g. +63 912 345 6789"
                               class="w-full px-4 py-3 font-lora text-gray-900 bg-white border border-gray-300 rounded-sm focus:outline-none focus:ring-2 focus:ring-gray-900 focus:border-transparent @error('phone_number') border-red-500 @enderror">
                        @error('phone_number')
                            <p class="mt-1 text-sm text-red-600 font-lora">{{ $message }}</p>
                        @enderror
                    </div>
                </div>
            </div>

            <!-- Action Buttons -->
            <div class="flex flex-col sm:flex-row gap-4 justify-end mt-8">
                <a href="{{ route('account.index') }}" 
                   class="px-8 py-3 font-lora text-sm text-center text-gray-900 bg-white border border-gray-300 rounded-full hover:bg-gray-50 transition-all duration-300">
                    Cancel
                </a>
                <button type="submit" 
                        class="px-8 py-3 font-lora text-sm text-white bg-gray-900 rounded-full hover:bg-gray-800 transition-all duration-300">
                    Save Address
                </button>
            </div>
        </form>
    </div>
</div>
@endsection