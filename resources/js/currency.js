/* ------------------------------
   CURRENCY SYSTEM
------------------------------ */
const CONVERSION_RATES = {
    'USD': 1,
    'PHP': 56.50,
    'CAD': 1.36,
    'EUR': 0.92,
    'GBP': 0.79
};

document.addEventListener('DOMContentLoaded', () => {
    const currencyBtn = document.getElementById('currencyBtn');
    const currencyDropdown = document.getElementById('currencyDropdown');
    let isDropdownOpen = false;

    currencyBtn?.addEventListener('click', (e) => {
        e.stopPropagation();
        isDropdownOpen = !isDropdownOpen;
        currencyDropdown.classList.toggle('hidden', !isDropdownOpen);
    });

    document.addEventListener('click', (e) => {
        if (!currencyBtn.contains(e.target) && !currencyDropdown.contains(e.target)) {
            currencyDropdown.classList.add('hidden');
            isDropdownOpen = false;
        }
    });

    // Restore saved currency
    let storedCurrency = sessionStorage.getItem('selectedCurrency');
    let storedSymbol = sessionStorage.getItem('selectedCurrencySymbol');

    window.selectedCurrency = storedCurrency || 'USD';
    window.selectedCurrencySymbol = storedSymbol || '$';
    document.getElementById('currentCurrency').textContent = `${window.selectedCurrency} ${window.selectedCurrencySymbol}`;
    updateAllPrices(window.selectedCurrency);
});

window.changeCurrency = function (code, symbol) {
    const currentCurrency = document.getElementById('currentCurrency');
    currentCurrency.textContent = `${code} ${symbol}`;
    sessionStorage.setItem('selectedCurrency', code);
    sessionStorage.setItem('selectedCurrencySymbol', symbol);
    window.selectedCurrency = code;
    window.selectedCurrencySymbol = symbol;
    updateAllPrices(code);

    const csrfToken = document.querySelector('meta[name="csrf-token"]');
    if (csrfToken) {
        fetch('/api/set-currency', {
            method: 'POST',
            headers: {
                'Content-Type': 'application/json',
                'X-CSRF-TOKEN': csrfToken.content
            },
            body: JSON.stringify({ currency: code })
        }).catch(() => {});
    }
};

window.updateAllPrices = function (currency) {
    const rate = CONVERSION_RATES[currency] || 1;
    document.querySelectorAll('[data-original-price]').forEach(el => {
        const originalPrice = parseFloat(el.dataset.originalPrice);
        const converted = (originalPrice * rate).toFixed(2);
        el.textContent = `${window.selectedCurrencySymbol}${converted}`;
    });
};
