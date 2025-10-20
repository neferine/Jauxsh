{{-- Cart Slider Component (Auth Only) --}}
<div id="cartSlider" 
     class="fixed top-0 right-0 h-full w-full sm:w-[480px] bg-[#d8e8e7] shadow-2xl z-50 transform translate-x-full transition-transform duration-300 overflow-y-auto">
    
    <div class="relative h-full flex flex-col">
        {{-- Header --}}
        <div class="sticky top-0 bg-[#d8e8e7] z-10 border-b border-gray-200">
            <div class="flex items-center justify-between px-6 py-5">
                <div>
                    <h2 class="font-cg text-2xl font-bold tracking-tight uppercase text-gray-900">Your Cart</h2>
                    <p id="cartItemCount" class="font-lora text-sm text-gray-600 mt-1">0 items</p>
                </div>
                <button onclick="closeCartSlider()" 
                        class="w-10 h-10 flex items-center justify-center hover:bg-white/50 rounded-full transition-colors duration-200">
                    <svg class="w-6 h-6 text-gray-900" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                        <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M6 18L18 6M6 6l12 12"/>
                    </svg>
                </button>
            </div>
        </div>

        {{-- Content --}}
        <div class="flex-1 overflow-y-auto">
            {{-- Loading State --}}
            <div id="cartLoader" class="flex flex-col items-center justify-center py-16 px-6">
                <div class="animate-spin rounded-full h-12 w-12 border-b-2 border-[#1fac99ff] mb-4"></div>
                <p class="font-lora text-sm text-gray-600">Loading your cart...</p>
            </div>

            {{-- Empty State --}}
            <div id="cartEmpty" class="hidden flex flex-col items-center justify-center py-16 px-6">
                <div class="w-20 h-20 bg-gray-100 rounded-full flex items-center justify-center mb-4">
                    <svg class="w-10 h-10 text-gray-400" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                        <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M16 11V7a4 4 0 00-8 0v4M5 9h14l1 12H4L5 9z"/>
                    </svg>
                </div>
                <h3 class="font-cg text-xl font-semibold text-gray-900 mb-2">Your cart is empty</h3>
                <p class="font-lora text-sm text-gray-600 text-center mb-6">Add some products to get started!</p>
                <a href="/shop" 
                   onclick="closeCartSlider()"
                   class="inline-block px-6 py-3 bg-[#1fac99ff] text-white font-lora text-sm rounded-full hover:bg-[#179383] transition-colors duration-200">
                    Start Shopping
                </a>
            </div>

            {{-- Cart Items --}}
            <div id="cartItems" class="hidden px-6 py-4 space-y-4">
                <!-- Cart items will be inserted here -->
            </div>
        </div>

        {{-- Footer (Checkout Section) --}}
        <div id="cartFooter" class="hidden sticky bottom-0 bg-[#d8e8e7] border-t border-gray-200 px-6 py-4 space-y-4">
            {{-- Subtotal --}}
            <div class="flex items-center justify-between">
                <span class="font-lora text-base text-gray-700">Subtotal</span>
                <span id="cartSubtotal" class="font-lora text-xl font-semibold text-gray-900">₱0.00</span>
            </div>

            {{-- Shipping Note --}}
            <p class="text-xs text-gray-500 font-lora text-center">
                Shipping and taxes calculated at checkout
            </p>

            {{-- Checkout Button --}}
            <a href="/checkout" 
               class="block w-full px-6 py-4 bg-[#1fac99ff] text-white font-lora text-base text-center rounded-full hover:bg-[#179383] transition-colors duration-200 shadow-md hover:shadow-lg">
                Proceed to Checkout
            </a>

            {{-- Continue Shopping --}}
            <button onclick="closeCartSlider()" 
                    class="block w-full px-6 py-3 text-gray-700 font-lora text-sm text-center hover:text-gray-900 transition-colors duration-200">
                Continue Shopping
            </button>
        </div>
    </div>
</div>

<script>
// Open cart slider
window.openCartSlider = function() {
    const slider = document.getElementById('cartSlider');
    slider.classList.remove('translate-x-full');
    slider.classList.add('translate-x-0');
    showBackdrop();
    loadCart();
};

// Close cart slider
window.closeCartSlider = function() {
    const slider = document.getElementById('cartSlider');
    slider.classList.add('translate-x-full');
    slider.classList.remove('translate-x-0');
    hideBackdrop();
};

// Load cart from API
function loadCart() {
    const loader = document.getElementById('cartLoader');
    const empty = document.getElementById('cartEmpty');
    const items = document.getElementById('cartItems');
    const footer = document.getElementById('cartFooter');

    // Show loader
    loader.classList.remove('hidden');
    empty.classList.add('hidden');
    items.classList.add('hidden');
    footer.classList.add('hidden');

    fetch('/api/cart', {
        credentials: 'same-origin',
        headers: {
            'X-CSRF-TOKEN': document.querySelector('meta[name="csrf-token"]')?.content || '',
            'Accept': 'application/json'
        }
    })
        .then(response => {
            if (!response.ok) throw new Error('Failed to load cart');
            return response.json();
        })
        .then(data => {
            loader.classList.add('hidden');

            if (!data.items || data.items.length === 0) {
                empty.classList.remove('hidden');
                updateCartCount(0);
            } else {
                renderCartItems(data.items);
                updateCartTotal(data.total);
                updateCartCount(data.items.length);
                items.classList.remove('hidden');
                footer.classList.remove('hidden');
            }
        })
        .catch(err => {
            console.error('Error loading cart:', err);
            loader.classList.add('hidden');
            empty.classList.remove('hidden');
        });
}

// Render cart items
function renderCartItems(cartItems) {
    const container = document.getElementById('cartItems');
    
    container.innerHTML = cartItems.map(item => {
        const product = item.product;
        const imageUrl = product.images && product.images.length > 0 
            ? `/storage/${product.images[0].image_url}`
            : '/images/placeholder.png';
        
        return `
            <div class="cart-item bg-white rounded-lg shadow-sm p-4" data-item-id="${item.id}">
                <div class="flex gap-4">
                    <a href="/products/${product.id}" class="flex-shrink-0" onclick="closeCartSlider()">
                        <img src="${imageUrl}" 
                             alt="${product.name}" 
                             class="w-24 h-24 object-cover rounded-md bg-gray-100">
                    </a>
                    
                    <div class="flex-1 min-w-0">
                        <a href="/products/${product.id}" onclick="closeCartSlider()">
                            <h4 class="font-lora text-sm font-semibold text-gray-900 hover:text-[#1fac99ff] transition-colors line-clamp-2 mb-1">
                                ${product.name}
                            </h4>
                        </a>
                        
                        <p class="font-lora text-sm text-gray-600 mb-3">
                            ₱${parseFloat(product.price).toFixed(2)}
                        </p>
                        
                        <div class="flex items-center justify-between">
                            <div class="flex items-center gap-2 bg-gray-50 rounded-full px-3 py-1.5">
                                <button onclick="updateQuantity(${item.id}, ${item.quantity - 1})" 
                                        class="w-6 h-6 flex items-center justify-center text-gray-600 hover:text-gray-900 transition-colors"
                                        ${item.quantity <= 1 ? 'disabled' : ''}>
                                    <svg class="w-4 h-4" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                                        <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M20 12H4"/>
                                    </svg>
                                </button>
                                <span class="font-lora text-sm font-medium text-gray-900 min-w-[20px] text-center">
                                    ${item.quantity}
                                </span>
                                <button onclick="updateQuantity(${item.id}, ${item.quantity + 1})" 
                                        class="w-6 h-6 flex items-center justify-center text-gray-600 hover:text-gray-900 transition-colors">
                                    <svg class="w-4 h-4" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                                        <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M12 4v16m8-8H4"/>
                                    </svg>
                                </button>
                            </div>
                            
                            <button onclick="removeFromCart(${item.id})" 
                                    class="w-8 h-8 flex items-center justify-center text-red-500 hover:bg-red-50 rounded-full transition-colors">
                                <svg class="w-5 h-5" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                                    <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M19 7l-.867 12.142A2 2 0 0116.138 21H7.862a2 2 0 01-1.995-1.858L5 7m5 4v6m4-6v6m1-10V4a1 1 0 00-1-1h-4a1 1 0 00-1 1v3M4 7h16"/>
                                </svg>
                            </button>
                        </div>
                    </div>
                </div>
            </div>
        `;
    }).join('');
}

// Update cart total
function updateCartTotal(total) {
    const subtotal = document.getElementById('cartSubtotal');
    if (subtotal) {
        subtotal.textContent = `₱${parseFloat(total).toFixed(2)}`;
    }
}

// Update cart count in navbar and slider
function updateCartCount(count) {
    const navCount = document.getElementById('cartCount');
    const sliderCount = document.getElementById('cartItemCount');
    
    if (navCount) {
        navCount.textContent = count;
        if (count > 0) {
            navCount.classList.remove('hidden');
        } else {
            navCount.classList.add('hidden');
        }
    }
    
    if (sliderCount) {
        sliderCount.textContent = `${count} ${count === 1 ? 'item' : 'items'}`;
    }
}

// Remove item from cart
window.removeFromCart = function(itemId) {
    if (!confirm('Remove this item from your cart?')) return;

    fetch(`/api/cart/${itemId}`, {
        method: 'DELETE',
        credentials: 'same-origin',
        headers: {
            'X-CSRF-TOKEN': document.querySelector('meta[name="csrf-token"]')?.content || '',
            'Accept': 'application/json'
        }
    })
        .then(response => response.json())
        .then(data => {
            if (data.success) {
                loadCart(); // Reload cart
            } else {
                alert('Failed to remove item. Please try again.');
            }
        })
        .catch(err => {
            console.error('Error removing item:', err);
            alert('Failed to remove item. Please try again.');
        });
};

// Update quantity (placeholder - you'll need to implement this API endpoint)
window.updateQuantity = function(itemId, newQuantity) {
    if (newQuantity < 1) return;

    // You'll need to create this endpoint in your API
    fetch(`/api/cart/${itemId}`, {
        method: 'PATCH',
        credentials: 'same-origin',
        headers: {
            'X-CSRF-TOKEN': document.querySelector('meta[name="csrf-token"]')?.content || '',
            'Content-Type': 'application/json',
            'Accept': 'application/json'
        },
        body: JSON.stringify({ quantity: newQuantity })
    })
        .then(response => response.json())
        .then(data => {
            if (data.success) {
                loadCart(); // Reload cart
            }
        })
        .catch(err => console.error('Error updating quantity:', err));
};

// Close slider on escape key
document.addEventListener('keydown', function(e) {
    if (e.key === 'Escape') {
        closeCartSlider();
    }
});

// Auto-refresh cart count on page load
document.addEventListener('DOMContentLoaded', function() {
    @auth
    fetch('/api/cart')
        .then(response => response.json())
        .then(data => {
            if (data.items) {
                updateCartCount(data.items.length);
            }
        })
        .catch(err => console.error('Error loading cart count:', err));
    @endauth
});
</script>