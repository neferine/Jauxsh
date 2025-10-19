
<!-- Cart Slider (Slides from Right) -->
<div id="cartSlider" class="fixed top-0 right-0 h-full w-96 bg-white shadow-2xl z-50 transform translate-x-full transition-transform duration-300">
    <div class="flex flex-col h-full">
        <!-- Header -->
        <div class="flex items-center justify-between px-6 py-5 border-b border-gray-200 bg-[#d8e8e7]">
            <h2 class="text-xl font-semibold text-gray-800 tracking-wide font-lora">Shopping Cart</h2>
            <button onclick="closeCartSlider()" class="text-gray-600 hover:text-black transition text-2xl">&times;</button>
        </div>

        <!-- Cart Items -->
        <div class="flex-1 overflow-y-auto px-6 py-6" id="cartItemsContainer">
            <!-- Loading state -->
            <div id="cartLoading" class="flex items-center justify-center py-12">
                <div class="animate-spin rounded-full h-8 w-8 border-b-2 border-[#1fac99ff]"></div>
            </div>

            <!-- Empty cart state -->
            <div id="cartEmpty" class="hidden text-center py-12">
                <svg class="w-16 h-16 text-gray-300 mx-auto mb-4" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                    <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M16 11V7a4 4 0 00-8 0v4M5 9h14l1 12H4L5 9z"/>
                </svg>
                <p class="text-gray-500 mb-4 font-lora">Your cart is empty</p>
                <a href="{{ route('products.index') }}" class="inline-block px-6 py-2 bg-[#1fac99ff] text-white rounded hover:bg-[#179383] transition font-lora">
                    Start Shopping
                </a>
            </div>

            <!-- Cart items list -->
            <div id="cartList" class="space-y-4 hidden"></div>
        </div>

        <!-- Footer with Total and Checkout -->
        <div id="cartFooter" class="hidden border-t border-gray-200 px-6 py-5 bg-gray-50">
            <div class="flex items-center justify-between mb-4">
                <span class="text-gray-700 font-medium font-lora">Subtotal:</span>
                <span id="cartTotal" class="text-xl font-semibold text-gray-900 font-lora">$0.00</span>
            </div>
            <a href="{{ route('checkout') }}" class="block w-full py-3 bg-[#1fac99ff] text-white font-medium rounded-lg hover:bg-[#179383] transition text-center font-lora">
                Proceed to Checkout
            </a>
            <a href="{{ route('cart.index') }}" class="block text-center text-sm text-gray-600 hover:text-[#1fac99ff] mt-3 transition font-lora">
                View Full Cart
            </a>
        </div>
    </div>
</div>