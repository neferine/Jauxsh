<!-- Shop Slider (Slides from Left) -->
<div id="shopSlider" class="fixed top-0 left-0 h-full w-80 bg-white shadow-2xl z-50 transform -translate-x-full transition-transform duration-300">
    <div class="flex flex-col h-full">
        <!-- Header -->
        <div class="flex items-center justify-between px-6 py-5 border-b border-gray-200 bg-[#d8e8e7]">
            <h2 class="text-xl font-semibold text-gray-800 tracking-wide font-lora">Shop</h2>
            <button onclick="closeShopSlider()" class="text-gray-600 hover:text-black transition text-2xl">&times;</button>
        </div>

        <!-- Content -->
        <div class="flex-1 overflow-y-auto px-6 py-6">
            <!-- Shop All -->
            <div class="mb-6">
                <a href="{{ route('products.index') }}" class="block group">
                    <div class="flex items-center justify-between py-3 px-4 rounded-lg hover:bg-gray-50 transition">
                        <div class="flex items-center gap-3">
                            <svg class="w-5 h-5 text-[#1fac99ff]" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                                <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M4 6h16M4 12h16M4 18h16"/>
                            </svg>
                            <span class="text-gray-800 font-medium group-hover:text-[#1fac99ff] transition font-lora">Shop All</span>
                        </div>
                        <svg class="w-4 h-4 text-gray-400 group-hover:text-[#1fac99ff] transition" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                            <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M9 5l7 7-7 7"/>
                        </svg>
                    </div>
                </a>
            </div>

            <!-- Categories Section -->
            <div class="mb-6">
                <h3 class="text-xs uppercase tracking-wider text-gray-500 font-semibold mb-3 px-4 font-lora">Categories</h3>
                <div class="space-y-1" id="categoriesList">
                    <!-- Loading state -->
                    <div class="flex items-center justify-center py-4">
                        <div class="animate-spin rounded-full h-6 w-6 border-b-2 border-[#1fac99ff]"></div>
                    </div>
                </div>
            </div>

            <!-- Collections Section -->
            <div>
                <h3 class="text-xs uppercase tracking-wider text-gray-500 font-semibold mb-3 px-4 font-lora">Collections</h3>
                <div class="space-y-1">
                    <a href="{{ route('collections.index') }}" class="block group">
                        <div class="flex items-center justify-between py-3 px-4 rounded-lg hover:bg-gray-50 transition">
                            <span class="text-gray-700 group-hover:text-[#1fac99ff] transition font-lora">All Collections</span>
                            <svg class="w-4 h-4 text-gray-400 group-hover:text-[#1fac99ff] transition" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                                <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M9 5l7 7-7 7"/>
                            </svg>
                        </div>
                    </a>
                </div>
            </div>
        </div>
    </div>
</div>
