<aside class="w-64 bg-[#1D433F] text-white flex flex-col h-full">
    <!-- Logo Section -->
    <div class="p-6 border-b border-gray-700">
        <a href="/" class="flex items-center space-x-3">
            <img src="{{ asset('images/Jauxsh.png') }}" alt="Jauxsh Logo" class="h-12 w-auto">
        </a>
        <p class="text-xs text-gray-400 mt-2 font-cg">Admin Panel</p>
    </div>

    <!-- Navigation Menu -->
    <nav class="flex-1 px-4 py-6 overflow-y-auto">
        <div class="space-y-1">
            <!-- Dashboard -->
            <a href="/admin/dashboard" 
               class="flex items-center px-4 py-3 text-sm font-cg rounded-lg transition-colors {{ request()->is('admin/dashboard') || request()->is('admin') ? 'bg-[#1FAC99] text-white' : 'text-gray-300 hover:bg-gray-700 hover:text-white' }}">
                <svg class="w-5 h-5 mr-3" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                    <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M3 12l2-2m0 0l7-7 7 7M5 10v10a1 1 0 001 1h3m10-11l2 2m-2-2v10a1 1 0 01-1 1h-3m-6 0a1 1 0 001-1v-4a1 1 0 011-1h2a1 1 0 011 1v4a1 1 0 001 1m-6 0h6"/>
                </svg>
                Dashboard
            </a>

            <!-- Products Section -->
            <div class="pt-4">
                <p class="px-4 text-xs font-semibold text-gray-500 uppercase tracking-wider font-pf mb-2">
                    Catalog
                </p>
                <a href="/admin/products" 
                   class="flex items-center px-4 py-3 text-sm font-cg rounded-lg transition-colors {{ request()->is('admin/products') || request()->is('admin/products/*') && !request()->is('admin/products/*/variants*') ? 'bg-[#1FAC99] text-white' : 'text-gray-300 hover:bg-gray-700 hover:text-white' }}">
                    <svg class="w-5 h-5 mr-3" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                        <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M20 7l-8-4-8 4m16 0l-8 4m8-4v10l-8 4m0-10L4 7m8 4v10M4 7v10l8 4"/>
                    </svg>
                    All Products
                </a>
                <a href="/admin/products/create" 
                   class="flex items-center px-4 py-3 text-sm font-cg rounded-lg transition-colors text-gray-300 hover:bg-gray-700 hover:text-white">
                    <svg class="w-5 h-5 mr-3" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                        <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M12 6v6m0 0v6m0-6h6m-6 0H6"/>
                    </svg>
                    Add Product
                </a>
                <a href="/admin/categories" 
                   class="flex items-center px-4 py-3 text-sm font-cg rounded-lg transition-colors {{ request()->is('admin/categories*') ? 'bg-[#1FAC99] text-white' : 'text-gray-300 hover:bg-gray-700 hover:text-white' }}">
                    <svg class="w-5 h-5 mr-3" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                        <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M7 7h.01M7 3h5c.512 0 1.024.195 1.414.586l7 7a2 2 0 010 2.828l-7 7a2 2 0 01-2.828 0l-7-7A1.994 1.994 0 013 12V7a4 4 0 014-4z"/>
                    </svg>
                    Categories
                </a>
                <a href="/admin/collections" 
                   class="flex items-center px-4 py-3 text-sm font-cg rounded-lg transition-colors {{ request()->is('admin/collections*') ? 'bg-[#1FAC99] text-white' : 'text-gray-300 hover:bg-gray-700 hover:text-white' }}">
                    <svg class="w-5 h-5 mr-3" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                        <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M19 11H5m14 0a2 2 0 012 2v6a2 2 0 01-2 2H5a2 2 0 01-2-2v-6a2 2 0 012-2m14 0V9a2 2 0 00-2-2M5 11V9a2 2 0 012-2m0 0V5a2 2 0 012-2h6a2 2 0 012 2v2M7 7h10"/>
                    </svg>
                    Collections
                </a>
            </div>

            <!-- Orders Section -->
            <div class="pt-4">
                <p class="px-4 text-xs font-semibold text-gray-500 uppercase tracking-wider font-pf mb-2">
                    Orders
                </p>
                <a href="/admin/orders" 
                   class="flex items-center px-4 py-3 text-sm font-cg rounded-lg transition-colors {{ request()->is('admin/orders*') ? 'bg-[#1FAC99] text-white' : 'text-gray-300 hover:bg-gray-700 hover:text-white' }}">
                    <svg class="w-5 h-5 mr-3" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                        <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M16 11V7a4 4 0 00-8 0v4M5 9h14l1 12H4L5 9z"/>
                    </svg>
                    All Orders
                </a>
            </div>

            <!-- Customers Section -->
            <div class="pt-4">
                <p class="px-4 text-xs font-semibold text-gray-500 uppercase tracking-wider font-pf mb-2">
                    Customers
                </p>
                <a href="/admin/users" 
                   class="flex items-center px-4 py-3 text-sm font-cg rounded-lg transition-colors {{ request()->is('admin/users*') ? 'bg-[#1FAC99] text-white' : 'text-gray-300 hover:bg-gray-700 hover:text-white' }}">
                    <svg class="w-5 h-5 mr-3" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                        <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M12 4.354a4 4 0 110 5.292M15 21H3v-1a6 6 0 0112 0v1zm0 0h6v-1a6 6 0 00-9-5.197M13 7a4 4 0 11-8 0 4 4 0 018 0z"/>
                    </svg>
                    All Users
                </a>
            </div>

            <!-- Settings Section -->
            <div class="pt-4">
                <p class="px-4 text-xs font-semibold text-gray-500 uppercase tracking-wider font-pf mb-2">
                    Settings
                </p>
                <a href="/admin/settings" 
                   class="flex items-center px-4 py-3 text-sm font-cg rounded-lg transition-colors {{ request()->is('admin/settings*') ? 'bg-[#1FAC99] text-white' : 'text-gray-300 hover:bg-gray-700 hover:text-white' }}">
                    <svg class="w-5 h-5 mr-3" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                        <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M10.325 4.317c.426-1.756 2.924-1.756 3.35 0a1.724 1.724 0 002.573 1.066c1.543-.94 3.31.826 2.37 2.37a1.724 1.724 0 001.065 2.572c1.756.426 1.756 2.924 0 3.35a1.724 1.724 0 00-1.066 2.573c.94 1.543-.826 3.31-2.37 2.37a1.724 1.724 0 00-2.572 1.065c-.426 1.756-2.924 1.756-3.35 0a1.724 1.724 0 00-2.573-1.066c-1.543.94-3.31-.826-2.37-2.37a1.724 1.724 0 00-1.065-2.572c-1.756-.426-1.756-2.924 0-3.35a1.724 1.724 0 001.066-2.573c-.94-1.543.826-3.31 2.37-2.37.996.608 2.296.07 2.572-1.065z"/>
                        <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M15 12a3 3 0 11-6 0 3 3 0 016 0z"/>
                    </svg>
                    Settings
                </a>
            </div>
        </div>
    </nav>

    <!-- Bottom Section -->
    <div class="p-4 border-t border-gray-700">
        <a href="/" class="flex items-center px-4 py-3 text-sm font-cg rounded-lg transition-colors text-gray-300 hover:bg-gray-700 hover:text-white">
            <svg class="w-5 h-5 mr-3" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M3 12l2-2m0 0l7-7 7 7M5 10v10a1 1 0 001 1h3m10-11l2 2m-2-2v10a1 1 0 01-1 1h-3m-6 0a1 1 0 001-1v-4a1 1 0 011-1h2a1 1 0 011 1v4a1 1 0 001 1m-6 0h6"/>
            </svg>
            Back to Store
        </a>
    </div>
</aside>