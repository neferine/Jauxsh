@extends('layouts.app')
@section('title', 'Contact Us | Jauxsh')
@section('content')
<div class="min-h-screen">
    <!-- Breadcrumb -->
    <div class="px-6 md:px-20 lg:px-40 pt-32 pb-8">
        <nav class="text-sm text-gray-600 font-lora">
            <a href="/" class="hover:text-gray-900 transition-colors">HOME</a>
            <span class="mx-2">/</span>
            <span class="text-gray-900">CONTACT</span>
        </nav>
    </div>

    <!-- Main Content -->
    <div class="px-6 md:px-20 lg:px-40 pb-20">
        <!-- Title -->
        <div class="mb-12">
            <h1 class="font-cg font-bold text-4xl md:text-5xl uppercase text-gray-900 mb-4 tracking-tight">
                Get In Touch
            </h1>
            <p class="font-lora text-gray-600 text-base">
                We're here to help. Reach out to us with any questions or concerns.
            </p>
        </div>

        <!-- Content -->
        <div class="max-w-6xl">
            <div class="grid grid-cols-1 lg:grid-cols-2 gap-12">
                
                <!-- Contact Form -->
                <div>
                    <h2 class="font-cg font-bold text-2xl uppercase text-gray-900 mb-6 tracking-wide">Send Us A Message</h2>
                    
                    <form action="/contact" method="POST" class="space-y-6">
                        @csrf
                        
                        <!-- Name -->
                        <div>
                            <label for="name" class="block font-cg text-sm uppercase tracking-wide text-gray-900 mb-2">
                                Full Name <span class="text-red-500">*</span>
                            </label>
                            <input 
                                type="text" 
                                id="name" 
                                name="name" 
                                required
                                class="w-full px-4 py-3 border border-gray-300 rounded-sm focus:outline-none focus:border-[#1fac99ff] font-lora text-gray-900"
                                placeholder="John Doe"
                            >
                        </div>

                        <!-- Email -->
                        <div>
                            <label for="email" class="block font-cg text-sm uppercase tracking-wide text-gray-900 mb-2">
                                Email Address <span class="text-red-500">*</span>
                            </label>
                            <input 
                                type="email" 
                                id="email" 
                                name="email" 
                                required
                                class="w-full px-4 py-3 border border-gray-300 rounded-sm focus:outline-none focus:border-[#1fac99ff] font-lora text-gray-900"
                                placeholder="john@example.com"
                            >
                        </div>

                        <!-- Phone (Optional) -->
                        <div>
                            <label for="phone" class="block font-cg text-sm uppercase tracking-wide text-gray-900 mb-2">
                                Phone Number <span class="text-gray-500 text-xs">(Optional)</span>
                            </label>
                            <input 
                                type="tel" 
                                id="phone" 
                                name="phone"
                                class="w-full px-4 py-3 border border-gray-300 rounded-sm focus:outline-none focus:border-[#1fac99ff] font-lora text-gray-900"
                                placeholder="+63 XXX XXX XXXX"
                            >
                        </div>

                        <!-- Subject -->
                        <div>
                            <label for="subject" class="block font-cg text-sm uppercase tracking-wide text-gray-900 mb-2">
                                Subject <span class="text-red-500">*</span>
                            </label>
                            <select 
                                id="subject" 
                                name="subject" 
                                required
                                class="w-full px-4 py-3 border border-gray-300 rounded-sm focus:outline-none focus:border-[#1fac99ff] font-lora text-gray-900"
                            >
                                <option value="">Select a subject</option>
                                <option value="order-inquiry">Order Inquiry</option>
                                <option value="product-question">Product Question</option>
                                <option value="shipping">Shipping & Delivery</option>
                                <option value="returns">Returns & Exchanges</option>
                                <option value="sizing">Sizing Help</option>
                                <option value="wholesale">Wholesale Inquiry</option>
                                <option value="partnership">Partnership Opportunity</option>
                                <option value="feedback">Feedback & Suggestions</option>
                                <option value="other">Other</option>
                            </select>
                        </div>

                        <!-- Order Number (Optional) -->
                        <div>
                            <label for="order_number" class="block font-cg text-sm uppercase tracking-wide text-gray-900 mb-2">
                                Order Number <span class="text-gray-500 text-xs">(If applicable)</span>
                            </label>
                            <input 
                                type="text" 
                                id="order_number" 
                                name="order_number"
                                class="w-full px-4 py-3 border border-gray-300 rounded-sm focus:outline-none focus:border-[#1fac99ff] font-lora text-gray-900"
                                placeholder="#12345"
                            >
                        </div>

                        <!-- Message -->
                        <div>
                            <label for="message" class="block font-cg text-sm uppercase tracking-wide text-gray-900 mb-2">
                                Message <span class="text-red-500">*</span>
                            </label>
                            <textarea 
                                id="message" 
                                name="message" 
                                rows="6" 
                                required
                                class="w-full px-4 py-3 border border-gray-300 rounded-sm focus:outline-none focus:border-[#1fac99ff] font-lora text-gray-900 resize-none"
                                placeholder="Tell us how we can help you..."
                            ></textarea>
                        </div>

                        <!-- Submit Button -->
                        <button 
                            type="submit"
                            class="w-full bg-gray-900 text-white font-cg uppercase tracking-wide py-4 rounded-sm hover:bg-[#1fac99ff] transition-colors duration-300"
                        >
                            Send Message
                        </button>

                        <p class="font-lora text-sm text-gray-600">
                            We'll get back to you within 24-48 hours during business days.
                        </p>
                    </form>
                </div>

                <!-- Contact Information -->
                <div class="space-y-8">
                    
                    <!-- Contact Details -->
                    <div>
                        <h2 class="font-cg font-bold text-2xl uppercase text-gray-900 mb-6 tracking-wide">Contact Information</h2>
                        
                        <div class="space-y-6">
                            <!-- Email -->
                            <div class="flex items-start space-x-4">
                                <div class="flex-shrink-0 w-12 h-12  bg-opacity-10 rounded-full flex items-center justify-center">
                                    <svg class="w-7 h-7" viewBox="0 0 24 24" fill="none" stroke="#1fac99ff" stroke-width="2" stroke-linecap="round" stroke-linejoin="round">
                                        <rect x="2" y="4" width="20" height="16" rx="2"/>
                                        <path d="m22 7-8.97 5.7a1.94 1.94 0 0 1-2.06 0L2 7"/>
                                    </svg>
                                </div>
                                <div>
                                    <h3 class="font-cg font-semibold text-base uppercase text-gray-900 mb-1">Email</h3>
                                    <a href="mailto:support@jauxsh.com" class="font-lora text-gray-700 hover:text-[#1fac99ff] transition-colors">
                                        support@jauxsh.com
                                    </a>
                                </div>
                            </div>

                            <!-- Phone -->
                            <div class="flex items-start space-x-4">
                                <div class="flex-shrink-0 w-12 h-12  bg-opacity-10 rounded-full flex items-center justify-center">
                                    <svg class="w-7 h-7" viewBox="0 0 24 24" fill="none" stroke="#1fac99ff" stroke-width="2" stroke-linecap="round" stroke-linejoin="round">
                                        <path d="M22 16.92v3a2 2 0 0 1-2.18 2 19.79 19.79 0 0 1-8.63-3.07 19.5 19.5 0 0 1-6-6 19.79 19.79 0 0 1-3.07-8.67A2 2 0 0 1 4.11 2h3a2 2 0 0 1 2 1.72 12.84 12.84 0 0 0 .7 2.81 2 2 0 0 1-.45 2.11L8.09 9.91a16 16 0 0 0 6 6l1.27-1.27a2 2 0 0 1 2.11-.45 12.84 12.84 0 0 0 2.81.7A2 2 0 0 1 22 16.92z"/>
                                    </svg>
                                </div>
                                <div>
                                    <h3 class="font-cg font-semibold text-base uppercase text-gray-900 mb-1">Phone</h3>
                                    <a href="tel:+63XXXXXXXXXX" class="font-lora text-gray-700 hover:text-[#1fac99ff] transition-colors">
                                        +63 (XXX) XXX-XXXX
                                    </a>
                                </div>
                            </div>

                            <!-- Address -->
                            <div class="flex items-start space-x-4">
                                <div class="flex-shrink-0 w-12 h-12  bg-opacity-10 rounded-full flex items-center justify-center">
                                    <svg class="w-7 h-7" viewBox="0 0 24 24" fill="none" stroke="#1fac99ff" stroke-width="2" stroke-linecap="round" stroke-linejoin="round">
                                        <path d="M21 10c0 7-9 13-9 13s-9-6-9-13a9 9 0 0 1 18 0z"/>
                                        <circle cx="12" cy="10" r="3"/>
                                    </svg>
                                </div>
                                <div>
                                    <h3 class="font-cg font-semibold text-base uppercase text-gray-900 mb-1">Address</h3>
                                    <a href="https://www.google.com/maps/place/Jauxsh/@14.1036746,122.9797122,17.35z/data=!4m10!1m2!2m1!1sjauxsh!3m6!1s0x3398afa5290e3895:0x444e16ed257e7da7!8m2!3d14.1038796!4d122.9808879!15sCgZqYXV4c2iSAQ5jbG90aGluZ19zdG9yZeABAA!16s%2Fg%2F11zk7ns_q3?hl=en&entry=ttu&g_ep=EgoyMDI1MTAxNC4wIKXMDSoASAFQAw%3D%3D" target="_blank" class="font-lora text-gray-700 hover:text-[#1fac99ff] transition-colors">
                                        Barangay San Isidro, Daet<br>
                                        Camarines Norte, Philippines
                                    </a>
                                </div>
                            </div>

                            <!-- Hours -->
                            <div class="flex items-start space-x-4">
                                <div class="flex-shrink-0 w-12 h-12  bg-opacity-10 rounded-full flex items-center justify-center">
                                    <svg class="w-7 h-7" viewBox="0 0 24 24" fill="none" stroke="#1fac99ff" stroke-width="2" stroke-linecap="round" stroke-linejoin="round">
                                        <circle cx="12" cy="12" r="10"/>
                                        <polyline points="12 6 12 12 16 14"/>
                                    </svg>
                                </div>
                                <div>
                                    <h3 class="font-cg font-semibold text-base uppercase text-gray-900 mb-1">Business Hours</h3>
                                    <p class="font-lora text-gray-700">
                                        Monday - Friday: 9:00 AM - 6:00 PM<br>
                                        Saturday: 10:00 AM - 4:00 PM<br>
                                        Sunday: Closed
                                    </p>
                                </div>
                            </div>
                        </div>
                    </div>

                    <!-- FAQ Section -->
                    <div class="border-t pt-8 mt-8">
                        <h2 class="font-cg font-bold text-2xl uppercase text-gray-900 mb-6 tracking-wide">Frequently Asked Questions</h2>
                        
                        <div class="space-y-4">
                            <details class="group cursor-pointer">
                                <summary class="flex items-center justify-between font-cg font-semibold uppercase text-gray-900 py-3 px-4 bg-gray-100 rounded-sm hover:bg-gray-200 transition-colors">
                                    <span>What's your shipping timeframe?</span>
                                    <svg class="w-5 h-5 transform group-open:rotate-180 transition-transform" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                                        <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M19 14l-7 7m0 0l-7-7m7 7V3"/>
                                    </svg>
                                </summary>
                                <p class="font-lora text-gray-700 px-4 py-3">
                                    We typically ship within 3-5 business days. Delivery times vary by location, usually 5-10 business days domestically.
                                </p>
                            </details>

                            <details class="group cursor-pointer">
                                <summary class="flex items-center justify-between font-cg font-semibold uppercase text-gray-900 py-3 px-4 bg-gray-100 rounded-sm hover:bg-gray-200 transition-colors">
                                    <span>Do you accept returns?</span>
                                    <svg class="w-5 h-5 transform group-open:rotate-180 transition-transform" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                                        <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M19 14l-7 7m0 0l-7-7m7 7V3"/>
                                    </svg>
                                </summary>
                                <p class="font-lora text-gray-700 px-4 py-3">
                                    Yes! We offer a 30-day return policy for unworn items with original tags attached. Please contact us to initiate a return.
                                </p>
                            </details>

                            <details class="group cursor-pointer">
                                <summary class="flex items-center justify-between font-cg font-semibold uppercase text-gray-900 py-3 px-4 bg-gray-100 rounded-sm hover:bg-gray-200 transition-colors">
                                    <span>How can I track my order?</span>
                                    <svg class="w-5 h-5 transform group-open:rotate-180 transition-transform" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                                        <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M19 14l-7 7m0 0l-7-7m7 7V3"/>
                                    </svg>
                                </summary>
                                <p class="font-lora text-gray-700 px-4 py-3">
                                    You'll receive a tracking number via email once your order ships. You can use it to monitor your package in real-time.
                                </p>
                            </details>
                        </div>
                    </div>
                </div>
            </div>
        </div>
    </div>
</div>
@endsection