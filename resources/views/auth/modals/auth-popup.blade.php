<!-- Auth Popup Modal -->
<div id="authPopupModal" 
     class="hidden fixed inset-0 bg-transparent z-50 flex items-center justify-center backdrop-blur-sm transition-opacity duration-300">
     
    <div class="bg-white/20 rounded-2xl shadow-xl max-w-md w-full mx-4 p-6 relative modal-slide-up border border-white/30 backdrop-blur-md">
        <!-- Close Button
        <button onclick="closeAuthPopup()"  class="absolute top-4 right-4 text-gray-200 hover:text-white">
            <svg class="w-6 h-6" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" 
                      d="M6 18L18 6M6 6l12 12"></path>
            </svg>
        </button>
         -->
        <!-- Modal Content -->
        <div class="text-center text-white drop-shadow-md">
            <h2 class="text-2xl font-bold mb-2">Enjoying Your Visit?</h2>
            <p class="text-gray-100 mb-6">Create an account to unlock exclusive deals and faster checkout!</p>
            
            <!-- Action Buttons -->
            <div class="space-y-3">
                <a href="{{ route('register') }}" 
                   class="block w-full bg-cyan-600 text-white py-3 rounded-lg hover:bg-cyan-500 transition">
                    Create Account
                </a>
                <a href="{{ route('login') }}" 
                   class="block w-full border border-white/50 text-white py-3 rounded-lg hover:bg-white/20 transition">
                    Log In
                </a>
                <button onclick="closeAuthPopup()" 
                        class="text-gray-200 hover:text-white text-sm">
                    Continue as Guest
                </button>
            </div>
        </div>
    </div>
</div>

<style>
    /* Slide-up animation */
    .modal-slide-up {
        transform: translateY(100%);
        opacity: 0;
        transition: transform 0.4s ease-out, opacity 0.4s ease-out;
    }

    #authPopupModal:not(.hidden) .modal-slide-up {
        transform: translateY(0);
        opacity: 1;
    }

    #authPopupModal.hidden .modal-slide-up {
        transform: translateY(100%);
        opacity: 0;
    }
</style>

<script>
    function openAuthPopup() {
        const popup = document.getElementById('authPopupModal');
        popup.classList.remove('hidden');
    }

    function closeAuthPopup() {
        const popup = document.getElementById('authPopupModal');
        popup.classList.add('hidden');
    }
    
    // Close on outside click
    document.getElementById('authPopupModal')?.addEventListener('click', function(e) {
        if (e.target === this) {
            closeAuthPopup();
        }
    });
    
</script>
