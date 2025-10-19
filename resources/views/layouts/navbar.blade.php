<nav id="navbar" class="py-3 bg-[#d8e8e7] fixed left-0 top-0 w-full z-20 transition-transform duration-300">
  <div class="container mx-auto px-8 py-4">
    <div class="flex items-center justify-between relative">
      <!-- Left Nav -->
      <ul class="flex space-x-10">
        <li class="nav-item">
          <a href="{{ route('products.index') }}" class="font-lora text-sm tracking-wide text-black hover:opacity-70 transition uppercase">
            Shop
          </a>
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
        <!-- Currency Dropdown -->
        <li class="nav-item relative">
          <a>
            <button id="currencyBtn"
              class="font-lora text-sm tracking-wide text-black hover:opacity-70 transition flex items-center gap-1 uppercase">
              <span id="currentCurrency">USD $</span>
            </button>
          </a>
          <!-- Dropdown Menu -->
          <div id="currencyDropdown"
            class="hidden absolute top-full mt-2 right-0 bg-white border border-gray-200 rounded shadow-lg min-w-[120px] z-50">
            <button onclick="changeCurrency('USD', '$')"
              class="currency-option w-full text-left px-4 py-2 font-lora text-sm text-gray-700 hover:bg-gray-100 transition flex items-center justify-between">
              <span>USD</span><span class="text-gray-500">$</span>
            </button>
            <button onclick="changeCurrency('PHP', '₱')"
              class="currency-option w-full text-left px-4 py-2 font-lora text-sm text-gray-700 hover:bg-gray-100 transition flex items-center justify-between">
              <span>PHP</span><span class="text-gray-500">₱</span>
            </button>
            <button onclick="changeCurrency('CAD', 'C$')"
              class="currency-option w-full text-left px-4 py-2 font-lora text-sm text-gray-700 hover:bg-gray-100 transition flex items-center justify-between">
              <span>CAD</span><span class="text-gray-500">C$</span>
            </button>
            <button onclick="changeCurrency('EUR', '€')"
              class="currency-option w-full text-left px-4 py-2 font-lora text-sm text-gray-700 hover:bg-gray-100 transition flex items-center justify-between">
              <span>EUR</span><span class="text-gray-500">€</span>
            </button>
            <button onclick="changeCurrency('GBP', '£')"
              class="currency-option w-full text-left px-4 py-2 font-lora text-sm text-gray-700 hover:bg-gray-100 transition flex items-center justify-between">
              <span>GBP</span><span class="text-gray-500">£</span>
            </button>
          </div>
        </li>

        <li class="nav-item">
          <a href="#" id="searchNavBtn"
            class="font-lora text-sm tracking-wide text-black hover:opacity-70 transition uppercase">Search</a>
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
          <a href="{{ route('cart.index') }}" class="font-lora text-sm tracking-wide text-black hover:opacity-70 transition uppercase relative">
            Cart
            <span id="cartCount" class="absolute -top-2 -right-3 bg-[#1fac99ff] text-white text-xs rounded-full w-5 h-5 flex items-center justify-center font-bold hidden">0</span>
          </a>
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
  // Currency controls
  const currencyBtn = document.getElementById('currencyBtn');
  const currencyDropdown = document.getElementById('currencyDropdown');

  // Search controls
  const searchNavBtn = document.getElementById('searchNavBtn');
  const searchBar = document.getElementById('searchBar');
  const closeSearchBar = document.getElementById('closeSearchBar');

  // Update cart count on page load
  @auth
  function updateCartCount() {
    fetch('/api/cart')
      .then(response => response.json())
      .then(data => {
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

  // Currency Dropdown
  currencyBtn?.addEventListener('click', function(e) {
    e.stopPropagation();
    currencyDropdown.classList.toggle('hidden');
  });

  document.addEventListener('click', function(e) {
    if (!currencyBtn?.contains(e.target)) {
      currencyDropdown?.classList.add('hidden');
    }
  });

  // Search Bar
  searchNavBtn?.addEventListener('click', function(e) {
    e.preventDefault();
    searchBar.classList.remove('-translate-y-full');
    searchBar.classList.add('translate-y-0');
    document.getElementById('searchInput')?.focus();
  });

  closeSearchBar?.addEventListener('click', function() {
    searchBar.classList.add('-translate-y-full');
    searchBar.classList.remove('translate-y-0');
  });
});

// Currency change function
window.changeCurrency = function(currency, symbol) {
  document.getElementById('currentCurrency').textContent = `${currency} ${symbol}`;
  document.getElementById('currencyDropdown').classList.add('hidden');
};
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

  .nav-item a::after {
    content: '';
    position: absolute;
    bottom: -4px;
    left: 0;
    width: 0;
    height: 1.5px;
    background-color: #1fac99ff;
    transition: width 0.3s ease;
  }

  .nav-item a:hover::after {
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