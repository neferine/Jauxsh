<nav id="navbar" class="py-3 bg-[#d8e8e7] fixed left-0 top-0 w-full z-20 transition-transform duration-300">
    <div class="container mx-auto px-8 py-5">
        <div class="flex items-center justify-between relative">
            <ul class="flex space-x-8">
                <li class="nav-item">
                    <a href="#" class="font-lora text-black hover:opacity-70 transition">Shop</a>
                </li>
                <li class="nav-item">
                    <a href="#" class="font-lora text-black hover:opacity-70 transition">About</a>
                </li>
            </ul>
            <a href="/" class="absolute left-1/2 transform -translate-x-1/2 flex items-center">
                <div class="h-12 w-12 flex items-center justify-center">
                    <img src="{{ asset('images/Jauxsh.png') }}"
                        alt="JauxShop Logo"
                        class="w-auto h-auto scale-290">
                </div>
            </a>
            <ul class="flex space-x-8">
                <!-- Currency Dropdown -->
                <li class="nav-item relative">
                    <a>
                    <button id="currencyBtn" class="font-lora text-black hover:opacity-70 transition flex items-center gap-1">
                        <span id="currentCurrency">USD $</span>
                    </button>
                    </a>
                    <!-- Dropdown Menu -->
                    <div id="currencyDropdown" class="hidden absolute top-full mt-2 right-0 bg-white border border-gray-200 rounded shadow-lg min-w-[120px] z-50">
                        <button onclick="changeCurrency('USD', '$')" class="currency-option w-full text-left px-4 py-2 font-lora text-sm text-gray-700 hover:bg-gray-100 transition flex items-center justify-between">
                            <span>USD</span>
                            <span class="text-gray-500">$</span>
                        </button>
                        <button onclick="changeCurrency('PHP', '₱')" class="currency-option w-full text-left px-4 py-2 font-lora text-sm text-gray-700 hover:bg-gray-100 transition flex items-center justify-between">
                            <span>PHP</span>
                            <span class="text-gray-500">₱</span>
                        </button>
                        <button onclick="changeCurrency('CAD', 'C$')" class="currency-option w-full text-left px-4 py-2 font-lora text-sm text-gray-700 hover:bg-gray-100 transition flex items-center justify-between">
                            <span>CAD</span>
                            <span class="text-gray-500">C$</span>
                        </button>
                        <button onclick="changeCurrency('EUR', '€')" class="currency-option w-full text-left px-4 py-2 font-lora text-sm text-gray-700 hover:bg-gray-100 transition flex items-center justify-between">
                            <span>EUR</span>
                            <span class="text-gray-500">€</span>
                        </button>
                        <button onclick="changeCurrency('GBP', '£')" class="currency-option w-full text-left px-4 py-2 font-lora text-sm text-gray-700 hover:bg-gray-100 transition flex items-center justify-between">
                            <span>GBP</span>
                            <span class="text-gray-500">£</span>
                        </button>
                    </div>
                </li>
                <li class="nav-item">
                    <a href="#" class="font-lora text-black hover:opacity-70 transition">Search</a>
                </li>
                <li class="nav-item">
                    <a href="#" class="font-lora text-black hover:opacity-70 transition">Account</a>
                </li>
                <li class="nav-item">
                    <a href="#" class="font-lora text-black hover:opacity-70 transition">Cart</a>
                </li>
            </ul>
        </div>
    </div>
</nav>

<style>
.nav-item {
    position: relative;
}
.nav-item a, .nav-item button {
    position: relative;
    display: inline-block;
}
.nav-item a::after {
    content: '';
    position: absolute;
    bottom: -4px;
    left: 0;
    width: 0;
    height: 2px;
    background-color: #1fac99ff;
    transition: width 0.3s ease;
}
.nav-item a:hover::after {
    width: 100%;
}

/* Currency dropdown styles */
.currency-option:first-child {
    border-top-left-radius: 0.375rem;
    border-top-right-radius: 0.375rem;
}
.currency-option:last-child {
    border-bottom-left-radius: 0.375rem;
    border-bottom-right-radius: 0.375rem;
}
</style>

<script>
// Navbar scroll behavior
let lastScrollTop = 0;
const navbar = document.getElementById('navbar');
window.addEventListener('scroll', () => {
    const scrollTop = window.pageYOffset || document.documentElement.scrollTop;
    if(scrollTop > lastScrollTop && scrollTop > 100){
        navbar.style.transform = 'translateY(-115%)';
    } else {
        navbar.style.transform = 'translateY(0)';
    }
    lastScrollTop = scrollTop;
});

// Currency dropdown functionality
const currencyBtn = document.getElementById('currencyBtn');
const currencyDropdown = document.getElementById('currencyDropdown');
const currencyArrow = document.getElementById('currencyArrow');
let isDropdownOpen = false;

// Toggle dropdown
currencyBtn.addEventListener('click', (e) => {
    e.stopPropagation();
    isDropdownOpen = !isDropdownOpen;
    
    if (isDropdownOpen) {
        currencyDropdown.classList.remove('hidden');
        currencyArrow.style.transform = 'rotate(180deg)';
    } else {
        currencyDropdown.classList.add('hidden');
        currencyArrow.style.transform = 'rotate(0deg)';
    }
});

// Close dropdown when clicking outside
document.addEventListener('click', (e) => {
    if (!currencyBtn.contains(e.target) && !currencyDropdown.contains(e.target)) {
        currencyDropdown.classList.add('hidden');
        currencyArrow.style.transform = 'rotate(0deg)';
        isDropdownOpen = false;
    }
});

// Change currency function
function changeCurrency(code, symbol) {
    const currentCurrency = document.getElementById('currentCurrency');
    currentCurrency.textContent = `${code} ${symbol}`;
    
    // Store in localStorage
    localStorage.setItem('selectedCurrency', code);
    localStorage.setItem('selectedCurrencySymbol', symbol);
    
    // Close dropdown
    currencyDropdown.classList.add('hidden');
    currencyArrow.style.transform = 'rotate(0deg)';
    isDropdownOpen = false;
    
    // Optional: Send to backend
    fetch('/api/set-currency', {
        method: 'POST',
        headers: {
            'Content-Type': 'application/json',
            'X-CSRF-TOKEN': document.querySelector('meta[name="csrf-token"]').content
        },
        body: JSON.stringify({ currency: code })
    });
    
    // Optional: Reload page to update prices
    // window.location.reload();
}

// Load saved currency on page load
document.addEventListener('DOMContentLoaded', () => {
    const savedCurrency = localStorage.getItem('selectedCurrency');
    const savedSymbol = localStorage.getItem('selectedCurrencySymbol');
    
    if (savedCurrency && savedSymbol) {
        document.getElementById('currentCurrency').textContent = `${savedCurrency} ${savedSymbol}`;
    }
});
</script>