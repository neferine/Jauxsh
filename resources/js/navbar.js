/* ------------------------------
   NAVBAR SCROLL + SEARCH
------------------------------ */
let lastScrollTop = 0;
const navbar = document.getElementById('navbar');

window.addEventListener('scroll', () => {
    const scrollTop = window.pageYOffset || document.documentElement.scrollTop;
    if (scrollTop > lastScrollTop && scrollTop > 100) {
        navbar.style.transform = 'translateY(-115%)';
    } else {
        navbar.style.transform = 'translateY(0)';
    }
    lastScrollTop = scrollTop;
});

/* ------------------------------
   SEARCH DROPDOWN
------------------------------ */
document.addEventListener('DOMContentLoaded', () => {
    const searchBtn = document.querySelector('.nav-item a[href="#"]');
    const searchBarContainer = document.getElementById('searchBarContainer');
    let searchOpen = false;

    if (searchBtn && searchBarContainer) {
        searchBtn.addEventListener('click', (e) => {
            e.preventDefault();
            e.stopPropagation();
            searchOpen = !searchOpen;
            if (searchOpen) {
                searchBarContainer.classList.remove('opacity-0', 'invisible');
                searchBarContainer.classList.add('opacity-100', 'visible');
            } else {
                searchBarContainer.classList.add('opacity-0', 'invisible');
                searchBarContainer.classList.remove('opacity-100', 'visible');
            }
        });

        document.addEventListener('click', (e) => {
            if (!searchBarContainer.contains(e.target) && !searchBtn.contains(e.target)) {
                searchBarContainer.classList.add('opacity-0', 'invisible');
                searchBarContainer.classList.remove('opacity-100', 'visible');
                searchOpen = false;
            }
        });
    }
});
