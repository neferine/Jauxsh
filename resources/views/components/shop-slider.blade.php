{{-- Shop Slider Component --}}
<div id="shopSlider" 
     class="fixed top-0 left-0 h-full w-full sm:w-[480px] bg-[#d8e8e7] shadow-2xl z-50 transform -translate-x-full transition-transform duration-300 overflow-y-auto">
    
    <div class="relative h-full flex flex-col">
        {{-- Header --}}
        <div class="sticky top-0 bg-[#d8e8e7] z-10 border-b border-gray-200">
            <div class="flex items-center justify-between px-6 py-5">
                <h2 class="font-cg text-2xl font-bold tracking-tight uppercase text-gray-900">Shop</h2>
                <button onclick="closeShopSlider()" 
                        class="w-10 h-10 flex items-center justify-center hover:bg-white/50 rounded-full transition-colors duration-200">
                    <svg class="w-6 h-6 text-gray-900" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                        <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M6 18L18 6M6 6l12 12"/>
                    </svg>
                </button>
            </div>
        </div>

        {{-- Content --}}
        <div class="flex-1 px-6 py-6 space-y-8">
            {{-- Shop All Section --}}
            <div class="space-y-3">
                <h3 class="font-lora text-xs uppercase tracking-wider text-gray-600 font-semibold">Quick Links</h3>
                <a href="/shop" 
                   class="block group">
                    <div class="flex items-center justify-between p-4 bg-white rounded-lg hover:bg-gray-50 transition-all duration-200 shadow-sm hover:shadow-md">
                        <div class="flex items-center gap-4">
                            <div class="w-12 h-12 bg-[#1fac99ff] rounded-full flex items-center justify-center">
                                <svg class="w-6 h-6 text-white" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                                    <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M3 3h2l.4 2M7 13h10l4-8H5.4M7 13L5.4 5M7 13l-2.293 2.293c-.63.63-.184 1.707.707 1.707H17m0 0a2 2 0 100 4 2 2 0 000-4zm-8 2a2 2 0 11-4 0 2 2 0 014 0z"/>
                                </svg>
                            </div>
                            <div>
                                <p class="font-lora text-base font-semibold text-gray-900">Shop All Products</p>
                                <p class="font-lora text-sm text-gray-500">Browse our entire collection</p>
                            </div>
                        </div>
                        <svg class="w-5 h-5 text-gray-400 group-hover:text-gray-900 group-hover:translate-x-1 transition-all duration-200" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                            <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M9 5l7 7-7 7"/>
                        </svg>
                    </div>
                </a>
            </div>

            {{-- Categories Section --}}
            <div class="space-y-3">
                <h3 class="font-lora text-xs uppercase tracking-wider text-gray-600 font-semibold">Categories</h3>
                <div id="categoriesLoader" class="flex justify-center py-8">
                    <div class="animate-spin rounded-full h-8 w-8 border-b-2 border-[#1fac99ff]"></div>
                </div>
                <div id="categoriesList" class="space-y-2 hidden"></div>
                <div id="categoriesError" class="hidden p-4 bg-red-50 rounded-lg">
                    <p class="text-sm text-red-600 font-lora">Unable to load categories. Please try again.</p>
                </div>
            </div>

            {{-- Collections Section --}}
            <div class="space-y-3">
                <h3 class="font-lora text-xs uppercase tracking-wider text-gray-600 font-semibold">Collections</h3>
                <div id="collectionsLoader" class="flex justify-center py-8">
                    <div class="animate-spin rounded-full h-8 w-8 border-b-2 border-[#1fac99ff]"></div>
                </div>
                <div id="collectionsList" class="space-y-2 hidden"></div>
                <div id="collectionsError" class="hidden p-4 bg-red-50 rounded-lg">
                    <p class="text-sm text-red-600 font-lora">Unable to load collections. Please try again.</p>
                </div>
                <div id="collectionsEmpty" class="hidden p-4 bg-gray-50 rounded-lg text-center">
                    <p class="text-sm text-gray-500 font-lora">No collections available</p>
                </div>
            </div>
        </div>

        {{-- Footer --}}
        <div class="sticky bottom-0 bg-[#d8e8e7] border-t border-gray-200 px-6 py-4">
            <p class="text-xs text-gray-500 font-lora text-center">
                Free shipping on orders over $100
            </p>
        </div>
    </div>
</div>

<script>
// Open shop slider
window.openShopSlider = function() {
    const slider = document.getElementById('shopSlider');
    slider.classList.remove('-translate-x-full');
    slider.classList.add('translate-x-0');
    showBackdrop();
    loadCategories();
    loadCollections();
};

// Close shop slider
window.closeShopSlider = function() {
    const slider = document.getElementById('shopSlider');
    slider.classList.add('-translate-x-full');
    slider.classList.remove('translate-x-0');
    hideBackdrop();
};

// Load categories from API
function loadCategories() {
    const loader = document.getElementById('categoriesLoader');
    const list = document.getElementById('categoriesList');
    const error = document.getElementById('categoriesError');

    // Show loader
    loader.classList.remove('hidden');
    list.classList.add('hidden');
    error.classList.add('hidden');

    fetch('/api/categories')
        .then(response => {
            if (!response.ok) throw new Error('Failed to load categories');
            return response.json();
        })
        .then(categories => {
            loader.classList.add('hidden');
            
            if (categories.length === 0) {
                list.innerHTML = `
                    <div class="p-4 bg-gray-50 rounded-lg text-center">
                        <p class="text-sm text-gray-500 font-lora">No categories available</p>
                    </div>
                `;
            } else {
                list.innerHTML = categories.map(category => `
                    <a href="/category/${category.slug}"
                       class="block group p-4 bg-white rounded-lg hover:bg-gray-50 transition-all duration-200 shadow-sm hover:shadow-md">
                        <div class="flex items-center justify-between">
                            <div class="flex items-center gap-3">
                                <div class="w-2 h-2 bg-gray-400 rounded-full group-hover:bg-[#1fac99ff] transition-colors duration-200"></div>
                                <span class="font-lora text-sm font-medium text-gray-900">${category.name}</span>
                            </div>
                            <svg class="w-4 h-4 text-gray-400 group-hover:text-gray-900 group-hover:translate-x-1 transition-all duration-200" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                                <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M9 5l7 7-7 7"/>
                            </svg>
                        </div>
                    </a>
                `).join('');
            }
            
            list.classList.remove('hidden');
        })
        .catch(err => {
            console.error('Error loading categories:', err);
            loader.classList.add('hidden');
            error.classList.remove('hidden');
        });
}

// Load collections from API
function loadCollections() {
    const loader = document.getElementById('collectionsLoader');
    const list = document.getElementById('collectionsList');
    const error = document.getElementById('collectionsError');
    const empty = document.getElementById('collectionsEmpty');

    // Show loader
    loader.classList.remove('hidden');
    list.classList.add('hidden');
    error.classList.add('hidden');
    empty.classList.add('hidden');

    fetch('/api/collections')
        .then(response => {
            if (!response.ok) throw new Error('Failed to load collections');
            return response.json();
        })
        .then(collections => {
            loader.classList.add('hidden');
            
            if (collections.length === 0) {
                empty.classList.remove('hidden');
            } else {
                list.innerHTML = collections.map(collection => `
                    <a href="/collections/${collection.slug}" 
                       class="block group p-4 bg-white rounded-lg hover:bg-gray-50 transition-all duration-200 shadow-sm hover:shadow-md">
                        <div class="flex items-center justify-between">
                            <div class="flex items-center gap-3 flex-1 min-w-0">
                                <div class="w-2 h-2 bg-[#1fac99ff] rounded-full flex-shrink-0"></div>
                                <div class="flex-1 min-w-0">
                                    <span class="font-lora text-sm font-medium text-gray-900 block">${collection.name}</span>
                                    ${collection.product_count > 0 ? `
                                        <span class="text-xs text-gray-500 font-lora">${collection.product_count} ${collection.product_count === 1 ? 'item' : 'items'}</span>
                                    ` : ''}
                                </div>
                            </div>
                            <svg class="w-4 h-4 text-gray-400 group-hover:text-gray-900 group-hover:translate-x-1 transition-all duration-200 flex-shrink-0" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                                <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M9 5l7 7-7 7"/>
                            </svg>
                        </div>
                    </a>
                `).join('');
                list.classList.remove('hidden');
            }
        })
        .catch(err => {
            console.error('Error loading collections:', err);
            loader.classList.add('hidden');
            error.classList.remove('hidden');
        });
}

// Close slider on escape key
document.addEventListener('keydown', function(e) {
    if (e.key === 'Escape') {
        closeShopSlider();
    }
});
</script>