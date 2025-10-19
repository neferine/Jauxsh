<nav id="navbar" class="py-3 bg-[#d8e8e7] fixed left-0 top-0 w-full z-20 transition-transform duration-300">
  <div class="container mx-auto px-8 py-4">
    <div class="flex items-center justify-between relative">
      <!-- Left Nav -->
      <ul class="flex space-x-10">
        <li class="nav-item">
            <button onclick="openShopSlider();" class="font-lora text-sm tracking-wide text-black hover:opacity-70 transition uppercase cursor-pointer bg-transparent border-0 p-0">
                Shop
            </button>
        </li>
        <li class="nav-item">
          <a href="{{ route('about') }}" class="font-lora text-sm tracking-wide text-black hover:opacity-70 transition uppercase">
            About
          </a>
        </li>
      </ul>

      <!-- Center Logo -->
      <a href="{{ route('home') }}" class="absolute left-1/2 transform -translate-x-1/2 flex items-center">
        <div class="h-14 w-14 flex items-center justify-center">
          <img src="/images/Jauxsh.png" alt="JauxShop Logo" class="w-auto h-auto scale-290">
        </div>
      </a>

      <!-- Right Nav -->
      <ul class="flex space-x-10">
        <li class="nav-item">
          <button   id="searchNavBtn"  onclick="openSearchBar()" class="font-lora text-sm tracking-wide text-black hover:opacity-70 transition uppercase cursor-pointer bg-transparent border-0 p-0">
            Search
          </button>
        </li>

        {{-- Account / Profile Dropdown --}}
        @auth
            <li class="nav-item relative">
                <a href="{{ route('account.index') }}"
                  class="font-lora text-sm tracking-wide text-black hover:opacity-70 transition uppercase">
                    Account
                </a>
            </li>

            {{-- If user is admin show Dashboard link --}}
            @if (auth()->check() && auth()->user()->is_admin)
                <li class="nav-item">
                    <a href="{{ route('admin.dashboard') }}"
                      class="font-lora text-sm tracking-wide text-black hover:opacity-70 transition uppercase">
                        Dashboard
                    </a>
                </li>
            @endif
        @else
            <li class="nav-item">
                <a href="{{ route('login') }}"
                  class="font-lora text-sm tracking-wide text-black hover:opacity-70 transition uppercase">
                    Account
                </a>
            </li>
        @endauth

        @auth
        <li class="nav-item">
          <button onclick="openCartSlider();" class="font-lora text-sm tracking-wide text-black hover:opacity-70 transition uppercase relative cursor-pointer bg-transparent border-0 p-0">
              Cart
              <span id="cartCount" class="absolute -top-2 -right-3 bg-[#1fac99ff] text-white text-xs rounded-full w-5 h-5 flex items-center justify-center font-bold hidden">0</span>
          </button>
        </li>
        @endauth
      </ul>
    </div>
  </div>

  <!-- Search Bar (Below Navbar) -->
  <div id="searchBar"
    class="fixed top-[0px] left-0 w-full bg-[#d8e8e7] shadow-md transform -translate-y-full transition-transform duration-300 z-30 border-b border-gray-200">
    <div class="container mx-auto px-8 py-4 flex items-center justify-between">
      <form id="searchForm" action="{{ route('products.index') }}" method="GET" class="flex items-center w-full gap-3">
        <input type="text" id="searchInput" name="search" placeholder="Search for products..." autocomplete="off"
          class="w-full px-4 py-2 border border-gray-300 rounded font-lora text-sm focus:outline-none focus:ring-1 focus:ring-[#1fac99ff]">
        <button type="submit"
          class="px-4 py-2 bg-[#1fac99ff] text-white font-lora text-sm rounded hover:bg-[#179383] transition">
          Search
        </button>
      </form>
      <button id="closeSearchBar" class="ml-4 text-2xl text-gray-600 hover:text-black transition">&times;</button>
    </div>

    <!-- Results -->
    <div id="searchResults" class="max-h-72 overflow-y-auto border-t border-gray-100 hidden">
      <!-- Results will appear here -->
    </div>
  </div>
</nav>

@push('scripts')
<script>
document.addEventListener('DOMContentLoaded', function() {
  // Search controls
  const searchNavBtn = document.getElementById('searchNavBtn');
  const searchBar = document.getElementById('searchBar');
  const closeSearchBar = document.getElementById('closeSearchBar');

  // Update cart count on page load
  @auth
  function updateCartCount() {
    const csrfToken = document.querySelector('meta[name="csrf-token"]')?.getAttribute('content');
    
    fetch('/api/cart', {
      method: 'GET',
      credentials: 'include',
      headers: {
        'X-CSRF-TOKEN': csrfToken || '',
        'Accept': 'application/json',
        'X-Requested-With': 'XMLHttpRequest'
      }
    })
      .then(response => {
        if (response.status === 401) return null;
        return response.json();
      })
      .then(data => {
        if (!data) return;
        const cartCount = document.getElementById('cartCount');
        if (cartCount && data.items && data.items.length > 0) {
          cartCount.textContent = data.items.length;
          cartCount.classList.remove('hidden');
        }
      })
      .catch(error => console.error('Error loading cart count:', error));
  }

  updateCartCount();
  @endauth

  // Search Bar - Only opens when Search button is clicked
  searchNavBtn?.addEventListener('click', function(e) {
    e.preventDefault();
    e.stopPropagation();
    searchBar.classList.remove('-translate-y-full');
    searchBar.classList.add('translate-y-0');
    document.getElementById('searchInput')?.focus();
  });

  closeSearchBar?.addEventListener('click', function() {
    searchBar.classList.add('-translate-y-full');
    searchBar.classList.remove('translate-y-0');
  });

  // Close search bar when clicking outside
  document.addEventListener('click', function(e) {
    if (!searchBar.contains(e.target) && !searchNavBtn.contains(e.target)) {
      searchBar.classList.add('-translate-y-full');
      searchBar.classList.remove('translate-y-0');
    }
  });

  // Close search bar on escape key
  document.addEventListener('keydown', function(e) {
    if (e.key === 'Escape') {
      searchBar.classList.add('-translate-y-full');
      searchBar.classList.remove('translate-y-0');
    }
  });
});
</script>
@endpush

<style>
  .nav-item {
    position: relative;
  }

  .nav-item a,
  .nav-item button {
    position: relative;
    display: inline-block;
    font-weight: 400;
    letter-spacing: 0.05em;
  }

  .nav-item a::after,
  .nav-item button::after {
    content: '';
    position: absolute;
    bottom: -4px;
    left: 0;
    width: 0;
    height: 1.5px;
    background-color: #1fac99ff;
    transition: width 0.3s ease;
  }

  .nav-item a:hover::after,
  .nav-item button:hover::after {
    width: 100%;
  }

  .currency-option:first-child {
    border-top-left-radius: 0.375rem;
    border-top-right-radius: 0.375rem;
  }

  .currency-option:last-child {
    border-bottom-left-radius: 0.375rem;
    border-bottom-right-radius: 0.375rem;
  }
</style>