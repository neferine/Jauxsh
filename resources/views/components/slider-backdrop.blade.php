{{-- Slider Backdrop Component --}}
<div id="sliderBackdrop" 
     class="fixed inset-0 bg-black/30 backdrop-blur-sm z-40 opacity-0 pointer-events-none transition-opacity duration-300">
</div>

<script>
// Global functions to manage backdrop
window.showBackdrop = function() {
    const backdrop = document.getElementById('sliderBackdrop');
    backdrop.classList.remove('pointer-events-none', 'opacity-0');
    backdrop.classList.add('pointer-events-auto', 'opacity-100');
    document.body.style.overflow = 'hidden';
};

window.hideBackdrop = function() {
    const backdrop = document.getElementById('sliderBackdrop');
    backdrop.classList.add('pointer-events-none', 'opacity-0');
    backdrop.classList.remove('pointer-events-auto', 'opacity-100');
    document.body.style.overflow = '';
};

// Close sliders when clicking backdrop
document.addEventListener('DOMContentLoaded', function() {
    const backdrop = document.getElementById('sliderBackdrop');
    backdrop?.addEventListener('click', function() {
        closeShopSlider();
        closeCartSlider();
    });
});
</script>