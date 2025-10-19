/* ------------------------------
   SEARCH SLIDE-DOWN
------------------------------ */
document.addEventListener('DOMContentLoaded', () => {
    const searchBtn = document.querySelector('.nav-item a[href="#"]'); // "Search" link in navbar
    const searchBar = document.getElementById('searchBar');
    const closeSearchBar = document.getElementById('closeSearchBar');
    const searchInput = document.getElementById('searchInput');
    const searchResults = document.getElementById('searchResults');
    let searchOpen = false;
    let searchTimeout;

    if (!searchBtn || !searchBar) return;

    // Toggle open/close
    searchBtn.addEventListener('click', (e) => {
        e.preventDefault();
        e.stopPropagation();

        if (!searchOpen) {
            searchBar.classList.remove('-translate-y-full');
            searchOpen = true;
            setTimeout(() => searchInput.focus(), 300);
        } else {
            hideSearch();
        }
    });

    // Close with button or clicking outside
    closeSearchBar.addEventListener('click', hideSearch);
    document.addEventListener('click', (e) => {
        if (searchOpen && !searchBar.contains(e.target) && !searchBtn.contains(e.target)) {
            hideSearch();
        }
    });

    // Close with ESC
    document.addEventListener('keydown', (e) => {
        if (e.key === 'Escape' && searchOpen) hideSearch();
    });

    function hideSearch() {
        searchBar.classList.add('-translate-y-full');
        searchOpen = false;
    }

    // Input live search
    searchInput.addEventListener('input', (e) => {
        clearTimeout(searchTimeout);
        const query = e.target.value.trim();

        if (query.length < 2) {
            searchResults.classList.add('hidden');
            return;
        }

        searchResults.classList.remove('hidden');
        searchResults.innerHTML = `<p class="text-gray-500 text-sm px-6 py-3">Searching...</p>`;

        searchTimeout = setTimeout(() => fetchResults(query), 400);
    });

    function fetchResults(query) {
        fetch(`/api/search?query=${encodeURIComponent(query)}`)
            .then((res) => res.json())
            .then((data) => renderResults(data))
            .catch(() => {
                searchResults.innerHTML = `<p class="text-gray-500 text-sm px-6 py-3">Error loading results.</p>`;
            });
    }

    function renderResults(results) {
        if (!results.length) {
            searchResults.innerHTML = `<p class="text-gray-500 text-sm px-6 py-3">No products found.</p>`;
            return;
        }

        searchResults.innerHTML = results
            .map(
                (item) => `
                <a href="/products/${item.id}" class="flex items-center gap-4 px-6 py-3 hover:bg-gray-50 transition">
                    ${item.image
                        ? `<img src="${item.image}" alt="${item.name}" class="w-12 h-12 object-cover rounded">`
                        : `<div class="w-12 h-12 bg-gray-200 rounded flex items-center justify-center text-gray-400 text-xs">No Img</div>`}
                    <div>
                        <p class="font-lora text-sm text-black">${item.name}</p>
                        <p class="text-xs text-gray-500">${window.selectedCurrencySymbol}${(
                            item.price *
                            (window.CONVERSION_RATES?.[window.selectedCurrency] || 1)
                        ).toFixed(2)}</p>
                    </div>
                </a>
            `
            )
            .join('');
    }
});
