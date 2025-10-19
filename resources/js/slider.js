function openShopSlider() {
    const slider = document.getElementById('shopSlider');
    const backdrop = document.getElementById('sliderBackdrop');
    
    if (!slider || !backdrop) return;
    
    backdrop.classList.remove('hidden');
    setTimeout(() => backdrop.style.opacity = '1', 10);
    
    slider.style.transform = 'translateX(0)';
    document.body.style.overflow = 'hidden';
}

function closeShopSlider() {
    const slider = document.getElementById('shopSlider');
    const backdrop = document.getElementById('sliderBackdrop');
    
    if (!slider || !backdrop) return;
    
    slider.style.transform = 'translateX(-100%)';
    backdrop.style.opacity = '0';
    
    setTimeout(() => {
        backdrop.classList.add('hidden');
        document.body.style.overflow = '';
    }, 300);
}

function loadCategories() {
    const list = document.getElementById('categoriesList');
    if (!list) return;
    
    fetch('/api/categories')
        .then(response => response.json())
        .then(categories => {
            if (categories.length === 0) {
                list.innerHTML = '<p class="text-sm text-gray-500 px-4 py-2 font-lora">No categories available</p>';
                return;
            }
            
            list.innerHTML = categories.map(category => `
                <a href="/products?category=${category.id}" class="block group">
                    <div class="flex items-center justify-between py-3 px-4 rounded-lg hover:bg-gray-50 transition">
                        <span class="text-gray-700 group-hover:text-[#1fac99ff] transition font-lora">${category.name}</span>
                        <svg class="w-4 h-4 text-gray-400 group-hover:text-[#1fac99ff] transition" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                            <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M9 5l7 7-7 7"/>
                        </svg>
                    </div>
                </a>
            `).join('');
        })
        .catch(error => {
            console.error('Error loading categories:', error);
            list.innerHTML = '<p class="text-sm text-red-500 px-4 py-2 font-lora">Failed to load categories</p>';
        });
}

// ===== CART SLIDER =====
function openCartSlider() {
    const slider = document.getElementById('cartSlider');
    const backdrop = document.getElementById('sliderBackdrop');
    
    if (!slider) {
        window.location.href = '/login';
        return;
    }
    
    if (!backdrop) return;
    
    backdrop.classList.remove('hidden');
    setTimeout(() => backdrop.style.opacity = '1', 10);
    
    slider.style.transform = 'translateX(0)';
    document.body.style.overflow = 'hidden';
    
    loadCart();
}

function closeCartSlider() {
    const slider = document.getElementById('cartSlider');
    const backdrop = document.getElementById('sliderBackdrop');
    
    if (!slider || !backdrop) return;
    
    slider.style.transform = 'translateX(100%)';
    backdrop.style.opacity = '0';
    
    setTimeout(() => {
        backdrop.classList.add('hidden');
        document.body.style.overflow = '';
    }, 300);
}

function loadCart() {
    const loading = document.getElementById('cartLoading');
    const empty = document.getElementById('cartEmpty');
    const list = document.getElementById('cartList');
    const footer = document.getElementById('cartFooter');
    
    if (!loading || !empty || !list || !footer) return;
    
    loading.classList.remove('hidden');
    empty.classList.add('hidden');
    list.classList.add('hidden');
    footer.classList.add('hidden');
    
    fetch('/api/cart', {
        headers: {
            'X-Requested-With': 'XMLHttpRequest',
            'Accept': 'application/json'
        },
        credentials: 'same-origin'
    })
    .then(response => response.json())
    .then(data => {
        loading.classList.add('hidden');
        
        if (!data.items || data.items.length === 0) {
            empty.classList.remove('hidden');
        } else {
            list.classList.remove('hidden');
            footer.classList.remove('hidden');
            renderCart(data.items, data.total);
        }
    })
    .catch(error => {
        console.error('Error loading cart:', error);
        loading.classList.add('hidden');
        empty.classList.remove('hidden');
    });
}

function renderCart(items, total) {
    const list = document.getElementById('cartList');
    if (!list) return;
    
    list.innerHTML = items.map(item => {
        const imageUrl = item.product.images && item.product.images.length > 0 
            ? `/storage/${item.product.images[0].image_url}` 
            : '/images/placeholder.png';
        
        return `
            <div class="flex gap-4 p-3 bg-white border border-gray-200 rounded-lg">
                <img src="${imageUrl}" 
                     alt="${item.product.name}" 
                     class="w-20 h-20 object-cover rounded"
                     onerror="this.src='/images/placeholder.png'">
                <div class="flex-1">
                    <h4 class="font-medium text-gray-800 mb-1 font-lora">${item.product.name}</h4>
                    <p class="text-sm text-gray-600 mb-2 font-lora">$${parseFloat(item.product.price).toFixed(2)}</p>
                    <div class="flex items-center gap-2">
                        <button onclick="updateCartQuantity(${item.id}, ${item.quantity - 1})" 
                                class="w-6 h-6 flex items-center justify-center border border-gray-300 rounded hover:bg-gray-100 transition"
                                ${item.quantity <= 1 ? 'disabled' : ''}>
                            -
                        </button>
                        <span class="text-sm font-medium w-8 text-center font-lora">${item.quantity}</span>
                        <button onclick="updateCartQuantity(${item.id}, ${item.quantity + 1})" 
                                class="w-6 h-6 flex items-center justify-center border border-gray-300 rounded hover:bg-gray-100 transition">
                            +
                        </button>
                        <button onclick="removeCartItem(${item.id})" 
                                class="ml-auto text-red-500 hover:text-red-700 text-sm font-lora">
                            Remove
                        </button>
                    </div>
                </div>
            </div>
        `;
    }).join('');
    
    const totalElement = document.getElementById('cartTotal');
    if (totalElement) {
        totalElement.textContent = `$${parseFloat(total).toFixed(2)}`;
    }
}

function updateCartQuantity(cartItemId, newQuantity) {
    if (newQuantity < 1) return;
    
    fetch(`/cart/${cartItemId}`, {
        method: 'PATCH',
        headers: {
            'Content-Type': 'application/json',
            'X-CSRF-TOKEN': document.querySelector('meta[name="csrf-token"]').content,
            'Accept': 'application/json'
        },
        body: JSON.stringify({ quantity: newQuantity })
    })
    .then(response => response.json())
    .then(data => {
        if (data.success) {
            loadCart();
            updateNavbarCartCount();
        }
    })
    .catch(error => console.error('Error updating cart:', error));
}

function removeCartItem(cartItemId) {
    if (!confirm('Remove this item from cart?')) return;
    
    fetch(`/api/cart/${cartItemId}`, {
        method: 'DELETE',
        headers: {
            'X-CSRF-TOKEN': document.querySelector('meta[name="csrf-token"]').content,
            'Accept': 'application/json'
        }
    })
    .then(response => response.json())
    .then(data => {
        if (data.success) {
            loadCart();
            updateNavbarCartCount();
        }
    })
    .catch(error => console.error('Error removing item:', error));
}

function updateNavbarCartCount() {
    const cartCount = document.getElementById('cartCount');
    if (!cartCount) return;
    
    fetch('/api/cart')
        .then(response => response.json())
        .then(data => {
            if (data.items && data.items.length > 0) {
                cartCount.textContent = data.items.length;
                cartCount.classList.remove('hidden');
            } else {
                cartCount.classList.add('hidden');
            }
        })
        .catch(error => console.error('Error updating cart count:', error));
}

// ===== CLOSE ALL =====
function closeAllSliders() {
    closeShopSlider();
    closeCartSlider();
}

// ===== INITIALIZE =====
document.addEventListener('DOMContentLoaded', function() {
    loadCategories();
    
    const cartCount = document.getElementById('cartCount');
    if (cartCount) {
        updateNavbarCartCount();
    }
    
    document.addEventListener('keydown', (e) => {
        if (e.key === 'Escape') {
            closeAllSliders();
        }
    });
});

// Make functions global
window.openShopSlider = openShopSlider;
window.closeShopSlider = closeShopSlider;
window.openCartSlider = openCartSlider;
window.closeCartSlider = closeCartSlider;
window.closeAllSliders = closeAllSliders;
window.updateCartQuantity = updateCartQuantity;
window.removeCartItem = removeCartItem;