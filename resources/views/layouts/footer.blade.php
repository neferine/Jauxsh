<footer class="bg-[#1D433F] text-gray-200 border-t border-gray-700 py-12 font-lora">
    <div class="container mx-auto px-8 grid grid-cols-1 md:grid-cols-3 gap-8">

        <!-- Brand Info -->
        <div class="flex flex-col space-y-4">
            <img src="{{ asset('images/Jauxsh.png') }}" alt="Jauxsh Logo" class="h-10 w-30">
            <p class="text-gray-300 text-base">
                Your personal branding & style companion. High-quality products made with care.
            </p>
            <div>
                <span class="font-semibold text-white text-base font-pf">Social</span>
                <div class="mt-2 flex flex-col">
                    <a href="#" class="hover:underline text-gray-200 text-base hover:text-white font-cg">Instagram</a>
                    <a href="#" class="hover:underline text-gray-200 text-base hover:text-white font-cg">Facebook</a>
                </div>
            </div>
        </div>

        <!-- Information Links -->
        <div class="flex flex-col space-y-2">
            <span class="font-semibold text-white text-base font-pf">Information</span>
            <a href="/size-guide" class="text-gray-200 text-base hover:text-white hover:underline font-cg">Size Guide</a>
            <a href="/faq" class="text-gray-200 text-base hover:text-white hover:underline font-cg">FAQ</a>
            <a href="/contact" class="text-gray-200 text-base hover:text-white hover:underline font-cg">Contact</a>
            <a href="/shipping-returns" class="text-gray-200 text-base hover:text-white hover:underline font-cg">Shipping & Returns</a>
        </div>

        <!-- Newsletter Subscription -->
       <div class="flex flex-col space-y-2">
            <span class="font-semibold text-white text-base font-pf">Join our newsletter</span>
            <p class="text-gray-300 text-base font-cg">Stay up to date on features and releases.</p>
            
            <form action="" method="POST" class="flex w-full max-w-sm mt-2 items-end">
                @csrf
                <!-- Input with only bottom border -->
                <input type="email" name="email" placeholder="Enter your email"
                    class="flex-1 text-gray-900 text-base font-cg placeholder-gray-400 border-b-2 border-gray-600 focus:border-[#1FAC99] focus:outline-none" required>
                
                <!-- Text-only Subscribe button -->
                <button type="submit" 
                        class="ml-4 text-[#1FAC99] text-base font-cg hover:underline transition-colors">
                    Subscribe
                </button>
            </form>

            <!-- Terms line -->
            <div class="text-sm text-gray-400 mt-1 font-cg">
                <label class="flex items-center cursor-pointer space-x-2">
                    <!-- Custom checkbox wrapper -->
                    <div class="relative">
                        <input type="checkbox" class="sr-only peer">
                        <div class="w-5 h-5 border border-gray-400 rounded peer-checked:bg-[#1FAC99] peer-checked:border-[#1FAC99] transition-colors"></div>
                        <!-- Checkmark -->
                        <svg class="absolute top-0.5 left-0.5 w-4 h-4 text-white hidden peer-checked:block pointer-events-none" fill="none" stroke="currentColor" stroke-width="3" viewBox="0 0 24 24">
                            <path stroke-linecap="round" stroke-linejoin="round" d="M5 13l4 4L19 7"/>
                        </svg>
                    </div>
                    <span>
                        I agree to the 
                        <a href="/terms" class="text-gray-400 hover:text-white underline">terms and conditions</a>.
                    </span>
                </label>
            </div>


        </div>
    </div>

    <!-- Bottom Bar -->
    <div class="border-t border-gray-700 mt-8 pt-4">
        <div class="container mx-auto px-8 flex flex-col md:flex-row justify-between text-gray-400 text-sm font-cg">
            <span>&copy; {{ date('Y') }} Jauxsh. All Rights Reserved</span>
            <div class="flex space-x-4 mt-2 md:mt-0">
                <a href="/terms" class="hover:text-white hover:underline font-cg">Terms of Service</a>
                <a href="/privacy" class="hover:text-white hover:underline font-cg">Privacy Policy</a>
            </div>
        </div>
    </div>
</footer>
