@extends('layouts.app')
@section('title', 'My Account')

@section('content')
<div class="w-full ">
    <!-- Header Section -->
    <div class="container mx-auto px-6 md:px-12 lg:px-20 max-w-7xl pt-32 pb-12">
        <h1 class="font-cg text-4xl md:text-5xl font-bold tracking-tight uppercase text-gray-900 mb-2">
            My Account
        </h1>
        <p class="font-lora text-gray-600">Manage your profile, addresses, and orders</p>
    </div>

    <!-- Account Content -->
    <div class="container mx-auto px-6 md:px-12 lg:px-20 max-w-7xl pb-20">
        <div class="grid grid-cols-1 lg:grid-cols-3 gap-8">
            
            <!-- Profile Information -->
            <div class="lg:col-span-2 space-y-8">
                <!-- Profile Card -->
                <div class=" rounded-sm p-8">
                    <div class="flex justify-between items-start mb-6">
                        <h2 class="font-cg text-2xl font-bold tracking-tight uppercase text-gray-900">
                            Profile Information
                        </h2>
                        <a href="{{ route('account.edit') }}" 
                           class="inline-block px-6 py-2 font-lora text-sm text-gray-900 border border-gray-900 rounded-full hover:bg-gray-900 hover:text-white transition-all duration-300">
                            Edit
                        </a>
                    </div>
                    
                    <div class="grid grid-cols-1 md:grid-cols-2 gap-6">
                        <div>
                            <label class="font-cg text-xs uppercase tracking-wide text-gray-500 block mb-1">First Name</label>
                            <p class="font-lora text-gray-900">{{ $user->first_name }}</p>
                        </div>
                        <div>
                            <label class="font-cg text-xs uppercase tracking-wide text-gray-500 block mb-1">Last Name</label>
                            <p class="font-lora text-gray-900">{{ $user->last_name }}</p>
                        </div>
                        <div>
                            <label class="font-cg text-xs uppercase tracking-wide text-gray-500 block mb-1">Email</label>
                            <p class="font-lora text-gray-900">{{ $user->email }}</p>
                        </div>
                        <div>
                            <label class="font-cg text-xs uppercase tracking-wide text-gray-500 block mb-1">Phone</label>
                            <p class="font-lora text-gray-900">{{ $user->phone ?? 'Not provided' }}</p>
                        </div>
                    </div>
                </div>

                <!-- Shipping Addresses -->
                <div class=" rounded-sm p-8">
                    <div class="flex justify-between items-start mb-6">
                        <h2 class="font-cg text-2xl font-bold tracking-tight uppercase text-gray-900">
                            Shipping Addresses
                        </h2>
                        <a href="{{ route('account.address.create') }}" 
                           class="inline-block px-6 py-2 font-lora text-sm text-gray-900 border border-gray-900 rounded-full hover:bg-gray-900 hover:text-white transition-all duration-300">
                            Add New
                        </a>
                    </div>
                    
                    @if($addresses->count())
                        <div class="space-y-4">
                            @foreach($addresses as $address)
                                <div class="rounded-sm p-6 border border-gray-200 hover:border-gray-900 transition-colors duration-300">
                                    <div class="flex justify-between items-start">
                                        <div class="flex-1">
                                            <p class="font-lora text-gray-900 mb-1">{{ $address->address_line1 }}</p>
                                            @if($address->address_line2)
                                                <p class="font-lora text-gray-900 mb-1">{{ $address->address_line2 }}</p>
                                            @endif
                                            <p class="font-lora text-gray-600">
                                                {{ $address->city }}, {{ $address->postal_code }}
                                            </p>
                                            <p class="font-lora text-gray-600">{{ $address->country }}</p>
                                            <p class="font-cg text-xs text-gray-500 mt-2">Phone: {{ $address->phone_number }}</p>
                                        </div>
                                        <div class="flex gap-2">
                                            <a href="{{ route('account.address.edit', $address) }}" 
                                               class="text-gray-600 hover:text-gray-900 transition-colors">
                                                <svg class="w-5 h-5" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                                                    <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M11 5H6a2 2 0 00-2 2v11a2 2 0 002 2h11a2 2 0 002-2v-5m-1.414-9.414a2 2 0 112.828 2.828L11.828 15H9v-2.828l8.586-8.586z"/>
                                                </svg>
                                            </a>
                                            <form action="{{ route('account.address.destroy', $address) }}" method="POST" class="inline">
                                                @csrf
                                                @method('DELETE')
                                                <button type="submit" 
                                                        onclick="return confirm('Are you sure you want to delete this address?')"
                                                        class="text-gray-600 hover:text-red-600 transition-colors">
                                                    <svg class="w-5 h-5" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                                                        <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M19 7l-.867 12.142A2 2 0 0116.138 21H7.862a2 2 0 01-1.995-1.858L5 7m5 4v6m4-6v6m1-10V4a1 1 0 00-1-1h-4a1 1 0 00-1 1v3M4 7h16"/>
                                                    </svg>
                                                </button>
                                            </form>
                                        </div>
                                    </div>
                                </div>
                            @endforeach
                        </div>
                    @else
                        <div class="text-center py-8">
                            <svg class="mx-auto h-12 w-12 text-gray-400 mb-4" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                                <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M17.657 16.657L13.414 20.9a1.998 1.998 0 01-2.827 0l-4.244-4.243a8 8 0 1111.314 0z"/>
                                <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M15 11a3 3 0 11-6 0 3 3 0 016 0z"/>
                            </svg>
                            <p class="font-lora text-gray-600">You have no saved shipping addresses.</p>
                            <a href="{{ route('account.address.create') }}" 
                               class="inline-block mt-4 px-6 py-2 font-lora text-sm text-white bg-gray-900 rounded-full hover:bg-gray-800 transition-all duration-300">
                                Add Your First Address
                            </a>
                        </div>
                    @endif
                </div>
            </div>

            <!-- Sidebar -->
            <div class="lg:col-span-1">
                <!-- Quick Actions -->
                <div class=" rounded-sm p-6 mb-8 sticky top-24">
                    <h3 class="font-cg text-lg font-bold tracking-tight uppercase text-gray-900 mb-4">
                        Quick Actions
                    </h3>
                    <div class="space-y-3">
                        <a href="{{ route('cart.index') }}" 
                           class="flex items-center gap-3 p-3  rounded-sm hover:bg-gray-900 hover:text-white transition-all duration-300 group">
                            <svg class="w-5 h-5" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                                <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M3 3h2l.4 2M7 13h10l4-8H5.4M7 13L5.4 5M7 13l-2.293 2.293c-.63.63-.184 1.707.707 1.707H17m0 0a2 2 0 100 4 2 2 0 000-4zm-8 2a2 2 0 11-4 0 2 2 0 014 0z"/>
                            </svg>
                            <span class="font-lora text-sm">View Cart</span>
                        </a>
                        <a href="{{ route('products.index') }}" 
                           class="flex items-center gap-3 p-3 rounded-sm hover:bg-gray-900 hover:text-white transition-all duration-300 group">
                            <svg class="w-5 h-5" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                                <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M16 11V7a4 4 0 00-8 0v4M5 9h14l1 12H4L5 9z"/>
                            </svg>
                            <span class="font-lora text-sm">Continue Shopping</span>
                        </a>
                        <a href="{{ route('account.edit') }}" 
                           class="flex items-center gap-3 p-3 rounded-sm hover:bg-gray-900 hover:text-white transition-all duration-300 group">
                            <svg class="w-5 h-5" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                                <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M10.325 4.317c.426-1.756 2.924-1.756 3.35 0a1.724 1.724 0 002.573 1.066c1.543-.94 3.31.826 2.37 2.37a1.724 1.724 0 001.065 2.572c1.756.426 1.756 2.924 0 3.35a1.724 1.724 0 00-1.066 2.573c.94 1.543-.826 3.31-2.37 2.37a1.724 1.724 0 00-2.572 1.065c-.426 1.756-2.924 1.756-3.35 0a1.724 1.724 0 00-2.573-1.066c-1.543.94-3.31-.826-2.37-2.37a1.724 1.724 0 00-1.065-2.572c-1.756-.426-1.756-2.924 0-3.35a1.724 1.724 0 001.066-2.573c-.94-1.543.826-3.31 2.37-2.37.996.608 2.296.07 2.572-1.065z"/>
                                <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M15 12a3 3 0 11-6 0 3 3 0 016 0z"/>
                            </svg>
                            <span class="font-lora text-sm">Account Settings</span>
                        </a>
                        <form action="{{ route('logout') }}" method="POST">
                            @csrf
                            <button type="submit" 
                                    class="w-full flex items-center gap-3 p-3  rounded-sm hover:bg-red-600 hover:text-white transition-all duration-300 group">
                                <svg class="w-5 h-5" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                                    <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M17 16l4-4m0 0l-4-4m4 4H7m6 4v1a3 3 0 01-3 3H6a3 3 0 01-3-3V7a3 3 0 013-3h4a3 3 0 013 3v1"/>
                                </svg>
                                <span class="font-lora text-sm">Logout</span>
                            </button>
                        </form>
                    </div>
                </div>
            </div>
        </div>

        <!-- Recent Orders Section -->
        <div class="mt-12">
            <div class="flex justify-between items-center mb-6">
                <h2 class="font-cg text-3xl font-bold tracking-tight uppercase text-gray-900">
                    Recent Orders
                </h2>
                <a href="{{ route('orders.index') }}" 
                   class="inline-block px-6 py-2 font-lora text-sm text-gray-900 border border-gray-900 rounded-full hover:bg-gray-900 hover:text-white transition-all duration-300">
                    View All Orders
                </a>
            </div>

            @if($orders->count())
                <div class=" rounded-sm overflow-hidden">
                    <div class="overflow-x-auto">
                        <table class="w-full">
                            <thead class=" border-b border-gray-200">
                                <tr>
                                    <th class="px-6 py-4 text-left font-cg text-xs uppercase tracking-wide text-gray-600">Order #</th>
                                    <th class="px-6 py-4 text-left font-cg text-xs uppercase tracking-wide text-gray-600">Date</th>
                                    <th class="px-6 py-4 text-left font-cg text-xs uppercase tracking-wide text-gray-600">Total</th>
                                    <th class="px-6 py-4 text-left font-cg text-xs uppercase tracking-wide text-gray-600">Status</th>
                                    <th class="px-6 py-4 text-right font-cg text-xs uppercase tracking-wide text-gray-600">Action</th>
                                </tr>
                            </thead>
                            <tbody class=" divide-y divide-gray-200">
                                @foreach($orders as $order)
                                    <tr class="hover:bg-gray-50 transition-colors duration-150">
                                        <td class="px-6 py-4 font-lora text-sm text-gray-900">#{{ $order->id }}</td>
                                        <td class="px-6 py-4 font-lora text-sm text-gray-600">{{ $order->created_at->format('M d, Y') }}</td>
                                        <td class="px-6 py-4 font-lora text-sm font-medium text-gray-900">₱{{ number_format($order->total_amount, 2) }}</td>
                                        <td class="px-6 py-4">
                                            <span class="inline-flex items-center px-3 py-1 rounded-full text-xs font-cg uppercase tracking-wide
                                                {{ $order->status === 'delivered' ? 'bg-green-100 text-green-800' : '' }}
                                                {{ $order->status === 'processing' ? 'bg-blue-100 text-blue-800' : '' }}
                                                {{ $order->status === 'shipped' ? 'bg-purple-100 text-purple-800' : '' }}
                                                {{ $order->status === 'pending' ? 'bg-yellow-100 text-yellow-800' : '' }}
                                                {{ $order->status === 'cancelled' ? 'bg-red-100 text-red-800' : '' }}">
                                                {{ $order->status }}
                                            </span>
                                        </td>
                                        <td class="px-6 py-4 text-right">
                                            <a href="{{ route('orders.show', $order) }}" 
                                               class="inline-flex items-center gap-1 font-lora text-sm text-gray-900 hover:text-gray-600 transition-colors">
                                                View Details
                                                <svg class="w-4 h-4" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                                                    <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M9 5l7 7-7 7"/>
                                                </svg>
                                            </a>
                                        </td>
                                    </tr>
                                @endforeach
                            </tbody>
                        </table>
                    </div>
                </div>
            @else
                <div class=" rounded-sm p-12 text-center">
                    <svg class="mx-auto h-16 w-16 text-gray-400 mb-4" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                        <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M16 11V7a4 4 0 00-8 0v4M5 9h14l1 12H4L5 9z"/>
                    </svg>
                    <h3 class="font-cg text-xl font-bold text-gray-900 mb-2">No Orders Yet</h3>
                    <p class="font-lora text-gray-600 mb-6">Start shopping to see your orders here.</p>
                    <a href="{{ route('products.index') }}" 
                       class="inline-block px-8 py-3 font-lora text-sm text-white bg-gray-900 rounded-full hover:bg-gray-800 transition-all duration-300">
                        Start Shopping
                    </a>
                </div>
            @endif
        </div>
    </div>
</div>
@endsection