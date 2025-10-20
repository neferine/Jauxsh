@extends('layouts.app')
@section('title', 'Shop - Jauxsh')

@section('content')
<div class="w-full min-h-screen bg-white">
    <div class="container mx-auto px-6 md:px-12 lg:px-20 max-w-7xl pt-32 pb-20">
        
        {{-- Header --}}
        <div class="mb-12">
            <h1 class="font-cg text-4xl md:text-5xl font-bold tracking-tight uppercase text-gray-900 mb-4">
                Shop All
            </h1>
            <p class="text-gray-600 text-lg font-lora">
                Discover our complete collection of premium apparel
            </p>
        </div>

        {{-- Filter Bar --}}
        <div class="sticky top-20 bg-white z-30 pb-6 mb-8 border-b border-gray-200">
            <div class="flex flex-wrap items-center justify-between gap-4">
                {{-- Category Filter --}}
                <div class="flex items-center gap-3">
                    <button id="categoryFilterBtn" 
                            class="flex items-center gap-2 px-5 py-2.5 bg-gray-50 hover:bg-gray-100 border-2 border-gray-200 rounded-full font-lora text-sm transition-all duration-200">
                        <svg class="w-4 h-4" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                            <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M3 4a1 1 0 011-1h16a1 1 0 011 1v2.586a1 1 0 01-.293.707l-6.414 6.414a1 1 0 00-.293.707V17l-4 4v-6.586a1 1 0 00-.293-.707L3.293 7.293A1 1 0 013 6.586V4z"/>
                        </svg>
                        <span id="categoryFilterLabel">All Categories</span>
                        <svg class="w-4 h-4" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                            <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M19 9l-7 7-7-7"/>
                        </svg>
                    </button>

                    {{-- Active Filters --}}
                    <div id="activeFilters" class="flex flex-wrap gap-2"></div>
                </div>

                {{-- Sort & Results Count --}}
                <div class="flex items-center gap-4">
                    <span id="resultsCount" class="text-sm text-gray-600 font-lora">
                        Loading...
                    </span>
                    <select id="sortSelect" 
                            class="px-4 py-2.5 bg-gray-50 border-2 border-gray-200 rounded-full font-lora text-sm focus:outline-none focus:ring-2 focus:ring-gray-900 focus:border-transparent">
                        <option value="featured">Featured</option>
                        <option value="newest">Newest</option>
                        <option value="price_low">Price: Low to High</option>
                        <option value="price_high">Price: High to Low</option>
                        <option value="name">Name: A to Z</option>
                    </select>
                </div>
            </div>

            {{-- Category Dropdown --}}
            <div id="categoryDropdown" 
                 class="hidden absolute top-full left-0 mt-2 w-64 bg-white border-2 border-gray-200 rounded-xl shadow-xl overflow-hidden z-40">
                <div class="max-h-80 overflow-y-auto">
                    <button onclick="filterByCategory(null)" 
                            class="w-full px-4 py-3 text-left hover:bg-gray-50 transition-colors duration-200 border-b border-gray-100 font-lora text-sm">
                        <div class="flex items-center gap-2">
                            <div class="w-2 h-2 bg-gray-900 rounded-full"></div>
                            <span class="font-semibold">All Categories</span>
                        </div>
                    </button>
                    <div id="categoryList"></div>
                </div>
            </div>
        </div>

        {{-- Products Grid --}}
        <div id="productsGrid" 
             class="grid grid-cols-1 sm:grid-cols-2 lg:grid-cols-4 gap-8 mb-12">
            {{-- Products will be loaded here --}}
        </div>

        {{-- Loading Spinner --}}
        <div id="loadingSpinner" class="flex justify-center py-12">
            <div class="flex flex-col items-center gap-4">
                <div class="animate-spin rounded-full h-12 w-12 border-b-2 border-gray-900"></div>
                <p class="text-sm text-gray-600 font-lora">Loading products...</p>
            </div>
        </div>

        {{-- End of Results --}}
        <div id="endOfResults" class="hidden text-center py-12">
            <div class="w-20 h-20 mx-auto mb-4 bg-gray-50 rounded-full flex items-center justify-center">
                <svg class="w-10 h-10 text-gray-400" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                    <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M5 13l4 4L19 7"/>
                </svg>
            </div>
            <h3 class="font-cg text-xl font-bold text-gray-900 mb-2 uppercase tracking-tight">
                You've seen it all!
            </h3>
            <p class="text-gray-600 font-lora">
                No more products to show
            </p>
        </div>

        {{-- No Results --}}
        <div id="noResults" class="hidden text-center py-16">
            <div class="w-24 h-24 mx-auto mb-6 bg-gray-50 rounded-full flex items-center justify-center">
                <svg class="w-12 h-12 text-gray-400" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                    <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M20 13V6a2 2 0 00-2-2H6a2 2 0 00-2 2v7m16 0v5a2 2 0 01-2 2H6a2 2 0 01-2-2v-5m16 0h-2.586a1 1 0 00-.707.293l-2.414 2.414a1 1 0 01-.707.293h-3.172a1 1 0 01-.707-.293l-2.414-2.414A1 1 0 006.586 13H4"/>
                </svg>
            </div>
            <h3 class="font-cg text-2xl font-bold text-gray-900 mb-3 uppercase tracking-tight">
                No Products Found
            </h3>
            <p class="text-gray-600 font-lora mb-6">
                Try adjusting your filters or browse all products
            </p>
            <button onclick="clearFilters()" 
                    class="inline-block px-8 py-3 bg-gray-900 text-white font-lora text-sm rounded-full hover:bg-gray-800 transition-all duration-300">
                Clear Filters
            </button>
        </div>
    </div>
</div>

@push('scripts')
<script>
let currentPage = 1;
let isLoading = false;
let hasMoreProducts = true;
let selectedCategory = null;
let selectedSort = 'featured';
let allCategories = [];

// Initialize
document.addEventListener('DOMContentLoaded', function() {
    // Check URL params
    const urlParams = new URLSearchParams(window.location.search);
    selectedCategory = urlParams.get('category');
    
    // Load categories
    loadCategories();
    
    // Load initial products
    loadProducts(true);
    
    // Setup infinite scroll
    setupInfiniteScroll();
    
    // Setup filters
    setupFilters();
});

// Load categories
function loadCategories() {
    fetch('/api/categories')
        .then(response => response.json())
        .then(categories => {
            allCategories = categories;
            renderCategoryList(categories);
            updateCategoryLabel();
        })
        .catch(error => console.error('Error loading categories:', error));
}

// Render category list
function renderCategoryList(categories) {
    const list = document.getElementById('categoryList');
    list.innerHTML = categories.map(category => `
        <button onclick="filterByCategory(${category.id})" 
                class="w-full px-4 py-3 text-left hover:bg-gray-50 transition-colors duration-200 border-b border-gray-100 font-lora text-sm ${selectedCategory == category.id ? 'bg-gray-50' : ''}">
            <div class="flex items-center gap-2">
                <div class="w-2 h-2 bg-[#1fac99ff] rounded-full"></div>
                <span>${category.name}</span>
            </div>
        </button>
    `).join('');
}

// Filter by category
window.filterByCategory = function(categoryId) {
    selectedCategory = categoryId;
    currentPage = 1;
    hasMoreProducts = true;
    document.getElementById('productsGrid').innerHTML = '';
    document.getElementById('categoryDropdown').classList.add('hidden');
    
    // Update URL
    const url = new URL(window.location);
    if (categoryId) {
        url.searchParams.set('category', categoryId);
    } else {
        url.searchParams.delete('category');
    }
    window.history.pushState({}, '', url);
    
    updateCategoryLabel();
    updateActiveFilters();
    loadProducts(true);
}

// Update category label
function updateCategoryLabel() {
    const label = document.getElementById('categoryFilterLabel');
    if (selectedCategory) {
        const category = allCategories.find(c => c.id == selectedCategory);
        label.textContent = category ? category.name : 'All Categories';
    } else {
        label.textContent = 'All Categories';
    }
}

// Update active filters
function updateActiveFilters() {
    const container = document.getElementById('activeFilters');
    if (selectedCategory) {
        const category = allCategories.find(c => c.id == selectedCategory);
        container.innerHTML = `
            <div class="flex items-center gap-2 px-3 py-1.5 bg-gray-900 text-white rounded-full text-xs font-lora">
                <span>${category.name}</span>
                <button onclick="filterByCategory(null)" class="hover:text-gray-300">
                    <svg class="w-3 h-3" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                        <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M6 18L18 6M6 6l12 12"/>
                    </svg>
                </button>
            </div>
        `;
    } else {
        container.innerHTML = '';
    }
}

// Setup filters
function setupFilters() {
    // Category dropdown toggle
    document.getElementById('categoryFilterBtn').addEventListener('click', function() {
        document.getElementById('categoryDropdown').classList.toggle('hidden');
    });
    
    // Close dropdown when clicking outside
    document.addEventListener('click', function(e) {
        const btn = document.getElementById('categoryFilterBtn');
        const dropdown = document.getElementById('categoryDropdown');
        if (!btn.contains(e.target) && !dropdown.contains(e.target)) {
            dropdown.classList.add('hidden');
        }
    });
    
    // Sort change
    document.getElementById('sortSelect').addEventListener('change', function() {
        selectedSort = this.value;
        currentPage = 1;
        hasMoreProducts = true;
        document.getElementById('productsGrid').innerHTML = '';
        loadProducts(true);
    });
}

// Load products
function loadProducts(reset = false) {
    if (isLoading || (!hasMoreProducts && !reset)) return;
    
    if (reset) {
        currentPage = 1;
        hasMoreProducts = true;
        document.getElementById('endOfResults').classList.add('hidden');
        document.getElementById('noResults').classList.add('hidden');
    }
    
    isLoading = true;
    document.getElementById('loadingSpinner').classList.remove('hidden');
    
    // Build query params
    const params = new URLSearchParams({
        page: currentPage,
        sort: selectedSort
    });
    
    if (selectedCategory) {
        params.append('category', selectedCategory);
    }
    
    fetch(`/api/products?${params}`)
        .then(response => response.json())
        .then(data => {
            const products = data.data || data;
            const productsGrid = document.getElementById('productsGrid');
            
            if (reset && products.length === 0) {
                document.getElementById('noResults').classList.remove('hidden');
                document.getElementById('loadingSpinner').classList.add('hidden');
                updateResultsCount(0);
                return;
            }
            
            if (products.length === 0) {
                hasMoreProducts = false;
                document.getElementById('endOfResults').classList.remove('hidden');
            } else {
                products.forEach(product => {
                    productsGrid.innerHTML += renderProductCard(product);
                });
                currentPage++;
            }
            
            updateResultsCount(data.total || productsGrid.children.length);
            isLoading = false;
            document.getElementById('loadingSpinner').classList.add('hidden');
        })
        .catch(error => {
            console.error('Error loading products:', error);
            isLoading = false;
            document.getElementById('loadingSpinner').classList.add('hidden');
        });
}

// Render product card
function renderProductCard(product) {
    const imageUrl = product.images && product.images.length > 0 
        ? `/storage/${product.images[0].image_url}` 
        : '';
    
    return `
        <a href="/products/${product.id}" 
           class="bg-white rounded-sm shadow-sm overflow-hidden group cursor-pointer hover:shadow-lg transition-shadow duration-300">
            <div class="aspect-square bg-gray-200 overflow-hidden">
                ${imageUrl 
                    ? `<img src="${imageUrl}" 
                           loading="lazy" 
                           alt="${product.name}" 
                           class="w-full h-full object-cover group-hover:scale-105 transition-transform duration-500">`
                    : `<div class="w-full h-full flex items-center justify-center bg-gray-100">
                        <svg class="w-16 h-16 text-gray-300" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                            <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M4 16l4.586-4.586a2 2 0 012.828 0L16 16m-2-2l1.586-1.586a2 2 0 012.828 0L20 14m-6-6h.01M6 20h12a2 2 0 002-2V6a2 2 0 00-2-2H6a2 2 0 00-2 2v12a2 2 0 002 2z"/>
                        </svg>
                    </div>`
                }
            </div>
            <div class="p-4">
                <h3 class="font-lora text-base text-gray-900 mb-1 truncate">${product.name}</h3>
                <div class="flex items-center justify-between">
                    <p class="font-lora text-sm font-medium text-gray-900">₱${parseFloat(product.price).toFixed(2)}</p>
                    ${product.stock <= 0 
                        ? '<span class="text-xs text-red-600 font-cg">Out of stock</span>' 
                        : product.stock <= 10 
                        ? '<span class="text-xs text-yellow-600 font-cg">Low stock</span>' 
                        : ''
                    }
                </div>
                ${product.category 
                    ? `<p class="text-xs text-gray-500 font-cg mt-1">${product.category.name}</p>` 
                    : ''
                }
            </div>
        </a>
    `;
}

// Update results count
function updateResultsCount(count) {
    document.getElementById('resultsCount').textContent = `${count} ${count === 1 ? 'product' : 'products'}`;
}

// Setup infinite scroll
function setupInfiniteScroll() {
    const observer = new IntersectionObserver((entries) => {
        entries.forEach(entry => {
            if (entry.isIntersecting && hasMoreProducts && !isLoading) {
                loadProducts();
            }
        });
    }, {
        rootMargin: '200px'
    });
    
    observer.observe(document.getElementById('loadingSpinner'));
}

// Clear filters
window.clearFilters = function() {
    selectedCategory = null;
    selectedSort = 'featured';
    document.getElementById('sortSelect').value = 'featured';
    
    const url = new URL(window.location);
    url.searchParams.delete('category');
    window.history.pushState({}, '', url);
    
    updateCategoryLabel();
    updateActiveFilters();
    
    currentPage = 1;
    hasMoreProducts = true;
    document.getElementById('productsGrid').innerHTML = '';
    document.getElementById('noResults').classList.add('hidden');
    loadProducts(true);
}
</script>
@endpush
@endsection