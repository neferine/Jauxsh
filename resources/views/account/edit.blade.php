@extends('layouts.app')
@section('title', 'Edit Profile')

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
                Edit Profile
            </h1>
        </div>
        <p class="font-lora text-gray-600 ml-10">Update your account information</p>
    </div>

    <!-- Form Content -->
    <div class="container mx-auto px-6 md:px-12 lg:px-20 max-w-4xl pb-20">
        @if(session('success'))
        <div class="bg-green-50 border border-green-200 text-green-800 px-6 py-4 rounded-sm mb-6 flex items-center gap-3">
            <svg class="w-5 h-5" fill="currentColor" viewBox="0 0 20 20">
                <path fill-rule="evenodd" d="M10 18a8 8 0 100-16 8 8 0 000 16zm3.707-9.293a1 1 0 00-1.414-1.414L9 10.586 7.707 9.293a1 1 0 00-1.414 1.414l2 2a1 1 0 001.414 0l4-4z" clip-rule="evenodd"/>
            </svg>
            <span class="font-lora">{{ session('success') }}</span>
        </div>
        @endif

        <form action="{{ route('account.update') }}" method="POST" class="bg-neutral-50 rounded-sm p-8">
            @csrf
            @method('PUT')

            <!-- Personal Information -->
            <div class="mb-8">
                <h2 class="font-cg text-xl font-bold tracking-tight uppercase text-gray-900 mb-6">
                    Personal Information
                </h2>

                <div class="grid grid-cols-1 md:grid-cols-2 gap-6">
                    <!-- First Name -->
                    <div>
                        <label for="first_name" class="block font-cg text-xs uppercase tracking-wide text-gray-700 mb-2">
                            First Name <span class="text-red-600">*</span>
                        </label>
                        <input type="text" 
                               name="first_name" 
                               id="first_name" 
                               value="{{ old('first_name', $user->first_name) }}"
                               class="w-full px-4 py-3 font-lora text-gray-900 bg-white border border-gray-300 rounded-sm focus:outline-none focus:ring-2 focus:ring-gray-900 focus:border-transparent @error('first_name') border-red-500 @enderror">
                        @error('first_name')
                            <p class="mt-1 text-sm text-red-600 font-lora">{{ $message }}</p>
                        @enderror
                    </div>

                    <!-- Last Name -->
                    <div>
                        <label for="last_name" class="block font-cg text-xs uppercase tracking-wide text-gray-700 mb-2">
                            Last Name <span class="text-red-600">*</span>
                        </label>
                        <input type="text" 
                               name="last_name" 
                               id="last_name" 
                               value="{{ old('last_name', $user->last_name) }}"
                               class="w-full px-4 py-3 font-lora text-gray-900 bg-white border border-gray-300 rounded-sm focus:outline-none focus:ring-2 focus:ring-gray-900 focus:border-transparent @error('last_name') border-red-500 @enderror">
                        @error('last_name')
                            <p class="mt-1 text-sm text-red-600 font-lora">{{ $message }}</p>
                        @enderror
                    </div>

                    <!-- Email -->
                    <div>
                        <label for="email" class="block font-cg text-xs uppercase tracking-wide text-gray-700 mb-2">
                            Email <span class="text-red-600">*</span>
                        </label>
                        <input type="email" 
                               name="email" 
                               id="email" 
                               value="{{ old('email', $user->email) }}"
                               class="w-full px-4 py-3 font-lora text-gray-900 bg-white border border-gray-300 rounded-sm focus:outline-none focus:ring-2 focus:ring-gray-900 focus:border-transparent @error('email') border-red-500 @enderror">
                        @error('email')
                            <p class="mt-1 text-sm text-red-600 font-lora">{{ $message }}</p>
                        @enderror
                    </div>

                    <!-- Phone -->
                    <div>
                        <label for="phone" class="block font-cg text-xs uppercase tracking-wide text-gray-700 mb-2">
                            Phone
                        </label>
                        <input type="tel" 
                               name="phone" 
                               id="phone" 
                               value="{{ old('phone', $user->phone) }}"
                               class="w-full px-4 py-3 font-lora text-gray-900 bg-white border border-gray-300 rounded-sm focus:outline-none focus:ring-2 focus:ring-gray-900 focus:border-transparent @error('phone') border-red-500 @enderror">
                        @error('phone')
                            <p class="mt-1 text-sm text-red-600 font-lora">{{ $message }}</p>
                        @enderror
                    </div>
                </div>
            </div>

            <!-- Change Password (Optional) -->
            <div class="border-t border-gray-200 pt-8 mb-8">
                <h2 class="font-cg text-xl font-bold tracking-tight uppercase text-gray-900 mb-2">
                    Change Password
                </h2>
                <p class="font-lora text-sm text-gray-600 mb-6">Leave blank if you don't want to change your password</p>

                <div class="space-y-6">
                    <!-- Current Password -->
                    <div>
                        <label for="current_password" class="block font-cg text-xs uppercase tracking-wide text-gray-700 mb-2">
                            Current Password
                        </label>
                        <input type="password" 
                               name="current_password" 
                               id="current_password"
                               class="w-full px-4 py-3 font-lora text-gray-900 bg-white border border-gray-300 rounded-sm focus:outline-none focus:ring-2 focus:ring-gray-900 focus:border-transparent @error('current_password') border-red-500 @enderror">
                        @error('current_password')
                            <p class="mt-1 text-sm text-red-600 font-lora">{{ $message }}</p>
                        @enderror
                    </div>

                    <div class="grid grid-cols-1 md:grid-cols-2 gap-6">
                        <!-- New Password -->
                        <div>
                            <label for="new_password" class="block font-cg text-xs uppercase tracking-wide text-gray-700 mb-2">
                                New Password
                            </label>
                            <input type="password" 
                                   name="new_password" 
                                   id="new_password"
                                   class="w-full px-4 py-3 font-lora text-gray-900 bg-white border border-gray-300 rounded-sm focus:outline-none focus:ring-2 focus:ring-gray-900 focus:border-transparent @error('new_password') border-red-500 @enderror">
                            @error('new_password')
                                <p class="mt-1 text-sm text-red-600 font-lora">{{ $message }}</p>
                            @enderror
                        </div>

                        <!-- Confirm New Password -->
                        <div>
                            <label for="new_password_confirmation" class="block font-cg text-xs uppercase tracking-wide text-gray-700 mb-2">
                                Confirm New Password
                            </label>
                            <input type="password" 
                                   name="new_password_confirmation" 
                                   id="new_password_confirmation"
                                   class="w-full px-4 py-3 font-lora text-gray-900 bg-white border border-gray-300 rounded-sm focus:outline-none focus:ring-2 focus:ring-gray-900 focus:border-transparent">
                        </div>
                    </div>
                </div>
            </div>

            <!-- Action Buttons -->
            <div class="flex flex-col sm:flex-row gap-4 justify-end">
                <a href="{{ route('account.index') }}" 
                   class="px-8 py-3 font-lora text-sm text-center text-gray-900 bg-white border border-gray-300 rounded-full hover:bg-gray-50 transition-all duration-300">
                    Cancel
                </a>
                <button type="submit" 
                        class="px-8 py-3 font-lora text-sm text-white bg-gray-900 rounded-full hover:bg-gray-800 transition-all duration-300">
                    Save Changes
                </button>
            </div>
        </form>
    </div>
</div>
@endsection