@extends('layouts.admin')
@section('title', 'Edit User | Admin')

@section('content')
<div class="min-h-screen">
    <!-- Back Button -->
    <div class="mb-6">
        <a href="{{ route('admin.users.show', $user->id) }}" 
           class="inline-flex items-center text-gray-600 hover:text-[#1FAC99] font-cg transition-colors">
            <svg class="w-5 h-5 mr-2" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M15 19l-7-7 7-7"/>
            </svg>
            Back to User Details
        </a>
    </div>

    <!-- Header -->
    <div class="mb-8">
        <h1 class="text-3xl font-bold text-[#1D433F] font-lora mb-2">Edit User</h1>
        <p class="text-gray-600 font-cg">Update user information and account settings</p>
    </div>

    <!-- Edit Form -->
    <div class="bg-white rounded-lg shadow-sm border border-gray-100 p-8">
        <form action="{{ route('admin.users.update', $user->id) }}" method="POST">
            @csrf
            @method('PUT')

            <div class="grid grid-cols-1 md:grid-cols-2 gap-6">
                <!-- First Name -->
                <div>
                    <label for="first_name" class="block text-sm font-semibold text-gray-700 mb-2 font-cg uppercase tracking-wide">
                        First Name <span class="text-red-500">*</span>
                    </label>
                    <input type="text" 
                           name="first_name" 
                           id="first_name"
                           value="{{ old('first_name', $user->first_name) }}"
                           required
                           class="w-full px-4 py-3 border border-gray-300 rounded-lg focus:ring-2 focus:ring-[#1FAC99] focus:border-transparent font-lora @error('first_name') border-red-500 @enderror">
                    @error('first_name')
                    <p class="text-red-500 text-xs mt-1 font-cg">{{ $message }}</p>
                    @enderror
                </div>

                <!-- Last Name -->
                <div>
                    <label for="last_name" class="block text-sm font-semibold text-gray-700 mb-2 font-cg uppercase tracking-wide">
                        Last Name <span class="text-red-500">*</span>
                    </label>
                    <input type="text" 
                           name="last_name" 
                           id="last_name"
                           value="{{ old('last_name', $user->last_name) }}"
                           required
                           class="w-full px-4 py-3 border border-gray-300 rounded-lg focus:ring-2 focus:ring-[#1FAC99] focus:border-transparent font-lora @error('last_name') border-red-500 @enderror">
                    @error('last_name')
                    <p class="text-red-500 text-xs mt-1 font-cg">{{ $message }}</p>
                    @enderror
                </div>

                <!-- Email -->
                <div>
                    <label for="email" class="block text-sm font-semibold text-gray-700 mb-2 font-cg uppercase tracking-wide">
                        Email Address <span class="text-red-500">*</span>
                    </label>
                    <input type="email" 
                           name="email" 
                           id="email"
                           value="{{ old('email', $user->email) }}"
                           required
                           class="w-full px-4 py-3 border border-gray-300 rounded-lg focus:ring-2 focus:ring-[#1FAC99] focus:border-transparent font-lora @error('email') border-red-500 @enderror">
                    @error('email')
                    <p class="text-red-500 text-xs mt-1 font-cg">{{ $message }}</p>
                    @enderror
                </div>

                <!-- Phone -->
                <div>
                    <label for="phone" class="block text-sm font-semibold text-gray-700 mb-2 font-cg uppercase tracking-wide">
                        Phone Number
                    </label>
                    <input type="text" 
                           name="phone" 
                           id="phone"
                           value="{{ old('phone', $user->phone) }}"
                           class="w-full px-4 py-3 border border-gray-300 rounded-lg focus:ring-2 focus:ring-[#1FAC99] focus:border-transparent font-lora @error('phone') border-red-500 @enderror">
                    @error('phone')
                    <p class="text-red-500 text-xs mt-1 font-cg">{{ $message }}</p>
                    @enderror
                </div>

                <!-- User Type -->
                <div>
                    <label for="is_admin" class="block text-sm font-semibold text-gray-700 mb-2 font-cg uppercase tracking-wide">
                        Account Type <span class="text-red-500">*</span>
                    </label>
                    <select name="is_admin" 
                            id="is_admin"
                            required
                            class="w-full px-4 py-3 border border-gray-300 rounded-lg focus:ring-2 focus:ring-[#1FAC99] focus:border-transparent font-lora @error('is_admin') border-red-500 @enderror">
                        <option value="0" {{ old('is_admin', $user->is_admin) == 0 ? 'selected' : '' }}>Customer</option>
                        <option value="1" {{ old('is_admin', $user->is_admin) == 1 ? 'selected' : '' }}>Admin</option>
                    </select>
                    @error('is_admin')
                    <p class="text-red-500 text-xs mt-1 font-cg">{{ $message }}</p>
                    @enderror
                </div>
            </div>

            <!-- Password Section -->
            <div class="mt-8 pt-8 border-t border-gray-200">
                <h3 class="text-lg font-bold text-[#1D433F] font-lora mb-4">Change Password</h3>
                <p class="text-sm text-gray-600 font-cg mb-4">Leave blank to keep current password</p>

                <div class="grid grid-cols-1 md:grid-cols-2 gap-6">
                    <!-- New Password -->
                    <div>
                        <label for="password" class="block text-sm font-semibold text-gray-700 mb-2 font-cg uppercase tracking-wide">
                            New Password
                        </label>
                        <input type="password" 
                               name="password" 
                               id="password"
                               class="w-full px-4 py-3 border border-gray-300 rounded-lg focus:ring-2 focus:ring-[#1FAC99] focus:border-transparent font-lora @error('password') border-red-500 @enderror">
                        @error('password')
                        <p class="text-red-500 text-xs mt-1 font-cg">{{ $message }}</p>
                        @enderror
                    </div>

                    <!-- Confirm Password -->
                    <div>
                        <label for="password_confirmation" class="block text-sm font-semibold text-gray-700 mb-2 font-cg uppercase tracking-wide">
                            Confirm Password
                        </label>
                        <input type="password" 
                               name="password_confirmation" 
                               id="password_confirmation"
                               class="w-full px-4 py-3 border border-gray-300 rounded-lg focus:ring-2 focus:ring-[#1FAC99] focus:border-transparent font-lora">
                    </div>
                </div>
            </div>

            <!-- Action Buttons -->
            <div class="flex items-center justify-end gap-4 mt-8 pt-8 border-t border-gray-200">
                <a href="{{ route('admin.users.show', $user->id) }}" 
                   class="px-6 py-3 border border-gray-300 rounded-lg font-cg font-semibold text-gray-700 hover:bg-gray-50 transition-all">
                    Cancel
                </a>
                <button type="submit" 
                        class="px-6 py-3 bg-[#1FAC99] text-white rounded-lg font-cg font-semibold hover:bg-[#1D433F] transition-all">
                    Update User
                </button>
            </div>
        </form>
    </div>
</div>
@endsection