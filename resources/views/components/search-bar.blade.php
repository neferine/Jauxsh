<!-- Enhanced Search Bar Overlay -->
<div id="searchOverlay" 
     class="fixed inset-0 bg-black/50 backdrop-blur-md z-40 opacity-0 pointer-events-none transition-all duration-500">
</div>

<div id="searchBar"
     class="fixed top-0 left-0 w-full bg-white shadow-2xl transform -translate-y-full transition-all duration-500 ease-out z-50">
    
    <div class="container mx-auto px-6 md:px-12 lg:px-20 max-w-5xl">
        <!-- Search Header -->
        <div class="flex items-center justify-between py-8 border-b border-gray-100">
            <div class="flex items-center gap-4">
                <div class="w-12 h-12 bg-gray-50 rounded-full flex items-center justify-center">
                    <svg class="w-6 h-6 text-gray-900" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                        <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M21 21l-6-6m2-5a7 7 0 11-14 0 7 7 0 0114 0z"/>
                    </svg>
                </div>
                <div>
                    <h3 class="font-cg text-2xl font-bold text-gray-900 tracking-tight uppercase">Search Products</h3>
                    <p class="text-sm text-gray-500 font-lora mt-0.5">Find your perfect style</p>
                </div>
            </div>
            <button id="closeSearchBar" 
                    class="w-12 h-12 flex items-center justify-center hover:bg-gray-50 rounded-full transition-all duration-300 group">
                <svg class="w-6 h-6 text-gray-600 group-hover:text-gray-900 group-hover:rotate-90 transition-all duration-300" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                    <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M6 18L18 6M6 6l12 12"/>
                </svg>
            </button>
        </div>

        <!-- Search Input -->
        <div class="py-10">
            <div class="relative">
                <input type="text" 
                       id="searchInput" 
                       placeholder="Search for jackets, hoodies, accessories..." 
                       autocomplete="off"
                       class="w-full px-7 py-5 pr-28 border-2 border-gray-200 rounded-full font-lora text-lg bg-gray-50 focus:outline-none focus:ring-2 focus:ring-gray-900 focus:border-transparent focus:bg-white placeholder-gray-400 transition-all duration-300 shadow-sm hover:shadow-md hover:border-gray-300">
                
                <!-- Search Icon -->
                <div class="absolute right-6 top-1/2 -translate-y-1/2 pointer-events-none">
                    <svg id="searchIcon" class="w-6 h-6 text-gray-400 transition-opacity duration-300" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                        <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M21 21l-6-6m2-5a7 7 0 11-14 0 7 7 0 0114 0z"/>
                    </svg>
                    
                    <!-- Loading Spinner -->
                    <div id="searchSpinner" class="hidden">
                        <svg class="animate-spin w-6 h-6 text-gray-900" fill="none" viewBox="0 0 24 24">
                            <circle class="opacity-25" cx="12" cy="12" r="10" stroke="currentColor" stroke-width="4"></circle>
                            <path class="opacity-75" fill="currentColor" d="M4 12a8 8 0 018-8V0C5.373 0 0 5.373 0 12h4zm2 5.291A7.962 7.962 0 014 12H0c0 3.042 1.135 5.824 3 7.938l3-2.647z"></path>
                        </svg>
                    </div>
                </div>

                <!-- Clear Button -->
                <button id="clearSearchBtn" 
                        class="hidden absolute right-16 top-1/2 -translate-y-1/2 w-8 h-8 flex items-center justify-center bg-gray-200 hover:bg-gray-900 hover:text-white rounded-full transition-all duration-200">
                    <svg class="w-4 h-4" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                        <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M6 18L18 6M6 6l12 12"/>
                    </svg>
                </button>
            </div>

            <!-- Search Hint -->
            <div class="mt-4 flex items-center justify-between text-sm text-gray-500 font-lora">
                <span class="flex items-center gap-2">
                    <svg class="w-4 h-4" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                        <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M13 16h-1v-4h-1m1-4h.01M21 12a9 9 0 11-18 0 9 9 0 0118 0z"/>
                    </svg>
                    <span>Press <kbd class="px-2 py-1 bg-gray-100 rounded-md border border-gray-200 text-xs font-semibold font-cg">ESC</kbd> to close</span>
                </span>
                <span id="resultCount" class="hidden font-medium text-gray-700"></span>
            </div>
        </div>

        <!-- Search Results -->
        <div id="searchResults" class="pb-8 max-h-[55vh] overflow-y-auto hidden scroll-smooth">
            <!-- Dynamic results will appear here -->
        </div>

        <!-- Empty State -->
        <div id="emptyState" class="hidden pb-12 text-center">
            <div class="py-16">
                <div class="w-24 h-24 mx-auto mb-6 bg-gray-50 rounded-full flex items-center justify-center">
                    <svg class="w-12 h-12 text-gray-300" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                        <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M21 21l-6-6m2-5a7 7 0 11-14 0 7 7 0 0114 0z"/>
                    </svg>
                </div>
                <h4 class="font-cg text-xl font-bold text-gray-900 mb-3 uppercase tracking-tight">No products found</h4>
                <p class="text-base text-gray-500 font-lora">Try searching with different keywords or browse our collections</p>
            </div>
        </div>

        <!-- Popular Searches (shown when search is empty) -->
        <div id="popularSearches" class="pb-12">
            <h4 class="font-cg text-sm font-bold text-gray-900 mb-5 uppercase tracking-wide">Popular Searches</h4>
            <div class="flex flex-wrap gap-3">
                <button onclick="quickSearch('jackets')" class="px-6 py-3 bg-gray-50 hover:bg-gray-900 hover:text-white border-2 border-transparent hover:border-gray-900 rounded-full font-lora text-sm transition-all duration-300 shadow-sm hover:shadow-md">
                    Jackets
                </button>
                <button onclick="quickSearch('hoodies')" class="px-6 py-3 bg-gray-50 hover:bg-gray-900 hover:text-white border-2 border-transparent hover:border-gray-900 rounded-full font-lora text-sm transition-all duration-300 shadow-sm hover:shadow-md">
                    Hoodies
                </button>
                <button onclick="quickSearch('sweatshirts')" class="px-6 py-3 bg-gray-50 hover:bg-gray-900 hover:text-white border-2 border-transparent hover:border-gray-900 rounded-full font-lora text-sm transition-all duration-300 shadow-sm hover:shadow-md">
                    Sweatshirts
                </button>
                <button onclick="quickSearch('accessories')" class="px-6 py-3 bg-gray-50 hover:bg-gray-900 hover:text-white border-2 border-transparent hover:border-gray-900 rounded-full font-lora text-sm transition-all duration-300 shadow-sm hover:shadow-md">
                    Accessories
                </button>
            </div>
        </div>
    </div>
</div>

@push('scripts')
<script>
let searchTimeout = null;

// Open search bar
window.openSearchBar = function() {
    const searchBar = document.getElementById('searchBar');
    const searchOverlay = document.getElementById('searchOverlay');
    const searchInput = document.getElementById('searchInput');
    
    searchBar.classList.remove('-translate-y-full');
    searchBar.classList.add('translate-y-0');
    searchOverlay.classList.remove('opacity-0', 'pointer-events-none');
    searchOverlay.classList.add('opacity-100', 'pointer-events-auto');
    
    setTimeout(() => searchInput?.focus(), 400);
};

// Close search bar
window.closeSearchBar = function() {
    const searchBar = document.getElementById('searchBar');
    const searchOverlay = document.getElementById('searchOverlay');
    
    searchBar.classList.add('-translate-y-full');
    searchBar.classList.remove('translate-y-0');
    searchOverlay.classList.add('opacity-0', 'pointer-events-none');
    searchOverlay.classList.remove('opacity-100', 'pointer-events-auto');
    
    // Clear search after closing
    setTimeout(() => {
        document.getElementById('searchInput').value = '';
        document.getElementById('searchResults').classList.add('hidden');
        document.getElementById('popularSearches').classList.remove('hidden');
        document.getElementById('emptyState').classList.add('hidden');
        document.getElementById('clearSearchBtn').classList.add('hidden');
        document.getElementById('resultCount').classList.add('hidden');
    }, 500);
};

// Quick search function
window.quickSearch = function(term) {
    const searchInput = document.getElementById('searchInput');
    searchInput.value = term;
    searchInput.dispatchEvent(new Event('input'));
};

document.addEventListener('DOMContentLoaded', function() {
    const searchInput = document.getElementById('searchInput');
    const searchResults = document.getElementById('searchResults');
    const popularSearches = document.getElementById('popularSearches');
    const emptyState = document.getElementById('emptyState');
    const searchIcon = document.getElementById('searchIcon');
    const searchSpinner = document.getElementById('searchSpinner');
    const clearSearchBtn = document.getElementById('clearSearchBtn');
    const searchOverlay = document.getElementById('searchOverlay');
    const closeSearchBtn = document.getElementById('closeSearchBar');
    const resultCount = document.getElementById('resultCount');

    // Search input handler with debounce
    searchInput?.addEventListener('input', function() {
        const query = this.value.trim();
        
        // Show/hide clear button
        if (query.length > 0) {
            clearSearchBtn.classList.remove('hidden');
        } else {
            clearSearchBtn.classList.add('hidden');
            searchResults.classList.add('hidden');
            popularSearches.classList.remove('hidden');
            emptyState.classList.add('hidden');
            resultCount.classList.add('hidden');
            return;
        }

        // Clear previous timeout
        if (searchTimeout) clearTimeout(searchTimeout);

        // Show loading
        searchIcon.classList.add('hidden');
        searchSpinner.classList.remove('hidden');

        // Debounce search
        searchTimeout = setTimeout(() => {
            performSearch(query);
        }, 400);
    });

    // Clear search button
    clearSearchBtn?.addEventListener('click', function() {
        searchInput.value = '';
        clearSearchBtn.classList.add('hidden');
        searchResults.classList.add('hidden');
        popularSearches.classList.remove('hidden');
        emptyState.classList.add('hidden');
        resultCount.classList.add('hidden');
        searchInput.focus();
    });

    // Close search button
    closeSearchBtn?.addEventListener('click', closeSearchBar);

    // Close on overlay click
    searchOverlay?.addEventListener('click', closeSearchBar);

    // Close on escape key
    document.addEventListener('keydown', function(e) {
        if (e.key === 'Escape') {
            closeSearchBar();
        }
    });

    // Perform search
    function performSearch(query) {
        fetch(`/api/search?query=${encodeURIComponent(query)}`, {
            method: 'GET',
            headers: {
                'Accept': 'application/json',
                'X-Requested-With': 'XMLHttpRequest'
            }
        })
        .then(response => response.json())
        .then(products => {
            // Hide loading
            searchIcon.classList.remove('hidden');
            searchSpinner.classList.add('hidden');

            // Hide popular searches
            popularSearches.classList.add('hidden');

            if (products.length === 0) {
                searchResults.classList.add('hidden');
                emptyState.classList.remove('hidden');
                resultCount.classList.add('hidden');
                return;
            }

            emptyState.classList.add('hidden');
            searchResults.classList.remove('hidden');
            
            // Update result count
            resultCount.classList.remove('hidden');
            resultCount.textContent = `${products.length} ${products.length === 1 ? 'result' : 'results'} found`;
            
            renderSearchResults(products);
        })
        .catch(error => {
            console.error('Search error:', error);
            searchIcon.classList.remove('hidden');
            searchSpinner.classList.add('hidden');
            emptyState.classList.remove('hidden');
            searchResults.classList.add('hidden');
            resultCount.classList.add('hidden');
        });
    }

    // Render search results
    function renderSearchResults(products) {
        searchResults.innerHTML = `
            <div class="space-y-3">
                ${products.map(product => `
                    <a href="/products/${product.id}" 
                       onclick="closeSearchBar()"
                       class="group flex gap-5 p-5 bg-white border-2 border-gray-100 rounded-lg hover:shadow-lg hover:border-gray-900 transition-all duration-300">
                        <div class="flex-shrink-0 w-24 h-24 bg-gray-50 rounded-lg overflow-hidden">
                            ${product.image 
                                ? `<img src="${product.image}" alt="${product.name}" class="w-full h-full object-cover group-hover:scale-110 transition-transform duration-500">`
                                : `<div class="w-full h-full flex items-center justify-center">
                                    <svg class="w-10 h-10 text-gray-300" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                                        <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M4 16l4.586-4.586a2 2 0 012.828 0L16 16m-2-2l1.586-1.586a2 2 0 012.828 0L20 14m-6-6h.01M6 20h12a2 2 0 002-2V6a2 2 0 00-2-2H6a2 2 0 00-2 2v12a2 2 0 002 2z"/>
                                    </svg>
                                </div>`
                            }
                        </div>
                        <div class="flex-1 min-w-0 flex flex-col justify-center">
                            <h5 class="font-lora text-base font-semibold text-gray-900 group-hover:text-gray-900 transition-colors line-clamp-2 mb-2">
                                ${product.name}
                            </h5>
                            <div class="flex items-center gap-3">
                                <p class="font-lora text-lg font-bold text-gray-900">
                                    $${parseFloat(product.price).toFixed(2)}
                                </p>
                                ${product.category ? `<span class="text-xs text-gray-500 font-cg uppercase tracking-wide">${product.category}</span>` : ''}
                            </div>
                        </div>
                        <div class="flex items-center">
                            <div class="w-10 h-10 flex items-center justify-center bg-gray-50 group-hover:bg-gray-900 rounded-full transition-all duration-300">
                                <svg class="w-5 h-5 text-gray-400 group-hover:text-white group-hover:translate-x-0.5 transition-all duration-300" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                                    <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M9 5l7 7-7 7"/>
                                </svg>
                            </div>
                        </div>
                    </a>
                `).join('')}
            </div>
        `;
    }
});
</script>
@endpush

<style>
kbd {
    font-family: ui-monospace, SFMono-Regular, Menlo, Monaco, Consolas, monospace;
}

#searchResults::-webkit-scrollbar {
    width: 8px;
}

#searchResults::-webkit-scrollbar-track {
    background: transparent;
}

#searchResults::-webkit-scrollbar-thumb {
    background: #e5e7eb;
    border-radius: 4px;
}

#searchResults::-webkit-scrollbar-thumb:hover {
    background: #d1d5db;
}

#searchInput:focus {
    transform: translateY(-1px);
}
</style>