@extends('layouts.app')
@section('title', 'Login | Jauxsh')
@section('content')
<div class="min-h-screen flex items-center justify-center py-32 px-6">
    <div class="w-full max-w-md">
        <!-- Login Heading -->
        <div class="text-center mb-10">
            <h1 class="font-cg font-bold text-4xl uppercase text-gray-900 mb-2">Login</h1>
            <p class="font-lora text-gray-600 text-sm">Welcome back to Jauxsh</p>
        </div>

        <!-- Error Messages -->
        @if ($errors->any())
        <div class="bg-red-50 border border-red-200 text-red-700 px-4 py-3 rounded-lg mb-6">
            <ul class="text-sm space-y-1">
                @foreach ($errors->all() as $error)
                    <li>{{ $error }}</li>
                @endforeach
            </ul>
        </div>
        @endif

        <!-- Success Message -->
        @if (session('status'))
        <div class="bg-green-50 border border-green-200 text-green-700 px-4 py-3 rounded-lg mb-6">
            <p class="text-sm">{{ session('status') }}</p>
        </div>
        @endif

        <!-- Login Form -->
        <form action="{{ route('login') }}" method="POST" class=" p-8 space-y-6">
            @csrf
            
            <!-- Email -->
            <div class="flex flex-col space-y-2">
                <label for="email" class="font-lora text-sm text-gray-700">Email</label>
                <input type="email" 
                       name="email" 
                       id="email" 
                       value="{{ old('email') }}"
                       placeholder="your@email.com"
                       class="border border-gray-300 rounded-lg px-4 py-2.5 font-lora text-gray-900 focus:outline-none focus:border-[#1FAC99] focus:ring-1 focus:ring-[#1FAC99] transition-colors" 
                       required>
            </div>

            <!-- Password -->
            <div class="flex flex-col space-y-2">
                <label for="password" class="font-lora text-sm text-gray-700">Password</label>
                <input type="password" 
                       name="password" 
                       id="password" 
                       placeholder="Enter your password"
                       class="border border-gray-300 rounded-lg px-4 py-2.5 font-lora text-gray-900 focus:outline-none focus:border-[#1FAC99] focus:ring-1 focus:ring-[#1FAC99] transition-colors" 
                       required>
            </div>

            <!-- Remember Me & Forgot Password -->
            <div class="flex items-center justify-between">
                <label class="flex items-center cursor-pointer">
                    <input type="checkbox" name="remember" class="w-4 h-4 text-[#1FAC99] border-gray-300 rounded focus:ring-[#1FAC99]">
                    <span class="ml-2 text-sm text-gray-700 font-lora">Remember me</span>
                </label>
                <a href="" class="text-sm text-gray-700 font-lora hover:text-[#1FAC99] transition-colors">
                    Forgot password?
                </a>
            </div>

            <!-- Submit Button -->
            <button type="submit"
                    class="w-full bg-[#1FAC99] text-white text-sm uppercase tracking-wide font-lora py-3 rounded-lg hover:bg-[#159a84] transition-colors">
                Sign in
            </button>

            <!-- Create Account Link -->
            <div class="text-center pt-4">
                <p class="text-sm text-gray-600 font-lora">
                    Don't have an account? 
                    <a href="{{ route('register') }}" class="text-gray-900 font-semibold hover:text-[#1FAC99] transition-colors">
                        Create account
                    </a>
                </p>
            </div>
        </form>
    </div>
</div>
@endsection