@extends('layouts.app')
@section('title', 'Size Guide | Jauxsh')
@section('content')
<div class="min-h-screen">
    <!-- Breadcrumb -->
    <div class="px-6 md:px-20 lg:px-40 pt-32 pb-8">
        <nav class="text-sm text-gray-600 font-lora">
            <a href="/" class="hover:text-gray-900 transition-colors">HOME</a>
            <span class="mx-2">/</span>
            <span class="text-gray-900">SIZE GUIDE</span>
        </nav>
    </div>

    <!-- Main Content -->
    <div class="px-6 md:px-20 lg:px-40 pb-20">
        <!-- Title -->
        <div class="mb-12">
            <h1 class="font-cg font-bold text-4xl md:text-5xl uppercase text-gray-900 mb-4 tracking-tight">
                Size Guide
            </h1>
            <p class="font-lora text-gray-600 text-base">
                Find your perfect fit with our comprehensive sizing information.
            </p>
        </div>

        <!-- Content -->
        <div class="max-w-6xl space-y-12">
            
            <!-- Important Notice -->
            <div class="bg-[#1fac99ff] bg-opacity-10 p-8 rounded-sm border-l-4 border-[#1fac99ff]">
                <h3 class="font-cg font-bold text-xl uppercase text-gray-900 mb-3 tracking-wide">Our Products Are True to Size</h3>
                <p class="font-lora text-gray-700 text-base leading-relaxed">
                    All Jauxsh garments are designed to fit true to size. Simply order your regular size for the perfect fit. 
                    If you're between sizes or prefer a looser fit, we recommend sizing up.
                </p>
            </div>

            <!-- How to Measure -->
            <div>
                <h2 class="font-cg font-bold text-2xl uppercase text-gray-900 mb-6 tracking-wide">How to Measure</h2>
                <p class="font-lora text-gray-700 text-base leading-relaxed mb-6">
                    For the most accurate measurements, have someone help you measure while wearing fitted clothing. 
                    Use a soft measuring tape and keep it parallel to the floor.
                </p>
                
                <div class="grid grid-cols-1 md:grid-cols-2 gap-6">
                    <div class="bg-gray-50 p-6 rounded-sm">
                        <h3 class="font-cg font-semibold text-lg uppercase text-gray-900 mb-3">Chest</h3>
                        <p class="font-lora text-gray-700 text-base leading-relaxed">
                            Measure around the fullest part of your chest, keeping the tape measure under your arms 
                            and around your shoulder blades.
                        </p>
                    </div>
                    
                    <div class="bg-gray-50 p-6 rounded-sm">
                        <h3 class="font-cg font-semibold text-lg uppercase text-gray-900 mb-3">Waist</h3>
                        <p class="font-lora text-gray-700 text-base leading-relaxed">
                            Measure around your natural waistline, keeping one finger between the tape and your body 
                            for a comfortable fit.
                        </p>
                    </div>
                    
                    <div class="bg-gray-50 p-6 rounded-sm">
                        <h3 class="font-cg font-semibold text-lg uppercase text-gray-900 mb-3">Hips</h3>
                        <p class="font-lora text-gray-700 text-base leading-relaxed">
                            Measure around the fullest part of your hips, approximately 8 inches below your natural 
                            waistline.
                        </p>
                    </div>
                    
                    <div class="bg-gray-50 p-6 rounded-sm">
                        <h3 class="font-cg font-semibold text-lg uppercase text-gray-900 mb-3">Sleeve Length</h3>
                        <p class="font-lora text-gray-700 text-base leading-relaxed">
                            Measure from the center back of your neck to your shoulder, then down to your wrist 
                            with your arm slightly bent.
                        </p>
                    </div>
                </div>
            </div>

            <!-- Men's T-Shirts -->
            <div>
                <h2 class="font-cg font-bold text-2xl uppercase text-gray-900 mb-6 tracking-wide">Men's T-Shirts</h2>
                <div class="overflow-x-auto">
                    <table class="w-full border-collapse">
                        <thead>
                            <tr class="bg-gray-900 text-white">
                                <th class="font-cg uppercase text-sm py-4 px-6 text-left">Size</th>
                                <th class="font-cg uppercase text-sm py-4 px-6 text-center">Chest (inches)</th>
                                <th class="font-cg uppercase text-sm py-4 px-6 text-center">Length (inches)</th>
                                <th class="font-cg uppercase text-sm py-4 px-6 text-center">Shoulder (inches)</th>
                            </tr>
                        </thead>
                        <tbody class="font-lora">
                            <tr class="border-b border-gray-200">
                                <td class="py-4 px-6 font-semibold">XS</td>
                                <td class="py-4 px-6 text-center">34-36</td>
                                <td class="py-4 px-6 text-center">27</td>
                                <td class="py-4 px-6 text-center">17</td>
                            </tr>
                            <tr class="border-b border-gray-200 bg-gray-50">
                                <td class="py-4 px-6 font-semibold">S</td>
                                <td class="py-4 px-6 text-center">36-38</td>
                                <td class="py-4 px-6 text-center">28</td>
                                <td class="py-4 px-6 text-center">18</td>
                            </tr>
                            <tr class="border-b border-gray-200">
                                <td class="py-4 px-6 font-semibold">M</td>
                                <td class="py-4 px-6 text-center">38-40</td>
                                <td class="py-4 px-6 text-center">29</td>
                                <td class="py-4 px-6 text-center">19</td>
                            </tr>
                            <tr class="border-b border-gray-200 bg-gray-50">
                                <td class="py-4 px-6 font-semibold">L</td>
                                <td class="py-4 px-6 text-center">40-42</td>
                                <td class="py-4 px-6 text-center">30</td>
                                <td class="py-4 px-6 text-center">20</td>
                            </tr>
                            <tr class="border-b border-gray-200">
                                <td class="py-4 px-6 font-semibold">XL</td>
                                <td class="py-4 px-6 text-center">42-44</td>
                                <td class="py-4 px-6 text-center">31</td>
                                <td class="py-4 px-6 text-center">21</td>
                            </tr>
                            <tr class="border-b border-gray-200 bg-gray-50">
                                <td class="py-4 px-6 font-semibold">2XL</td>
                                <td class="py-4 px-6 text-center">44-46</td>
                                <td class="py-4 px-6 text-center">32</td>
                                <td class="py-4 px-6 text-center">22</td>
                            </tr>
                        </tbody>
                    </table>
                </div>
            </div>

            <!-- Women's T-Shirts -->
            <div>
                <h2 class="font-cg font-bold text-2xl uppercase text-gray-900 mb-6 tracking-wide">Women's T-Shirts</h2>
                <div class="overflow-x-auto">
                    <table class="w-full border-collapse">
                        <thead>
                            <tr class="bg-gray-900 text-white">
                                <th class="font-cg uppercase text-sm py-4 px-6 text-left">Size</th>
                                <th class="font-cg uppercase text-sm py-4 px-6 text-center">Bust (inches)</th>
                                <th class="font-cg uppercase text-sm py-4 px-6 text-center">Length (inches)</th>
                                <th class="font-cg uppercase text-sm py-4 px-6 text-center">Shoulder (inches)</th>
                            </tr>
                        </thead>
                        <tbody class="font-lora">
                            <tr class="border-b border-gray-200">
                                <td class="py-4 px-6 font-semibold">XS</td>
                                <td class="py-4 px-6 text-center">32-34</td>
                                <td class="py-4 px-6 text-center">25</td>
                                <td class="py-4 px-6 text-center">14</td>
                            </tr>
                            <tr class="border-b border-gray-200 bg-gray-50">
                                <td class="py-4 px-6 font-semibold">S</td>
                                <td class="py-4 px-6 text-center">34-36</td>
                                <td class="py-4 px-6 text-center">26</td>
                                <td class="py-4 px-6 text-center">15</td>
                            </tr>
                            <tr class="border-b border-gray-200">
                                <td class="py-4 px-6 font-semibold">M</td>
                                <td class="py-4 px-6 text-center">36-38</td>
                                <td class="py-4 px-6 text-center">27</td>
                                <td class="py-4 px-6 text-center">16</td>
                            </tr>
                            <tr class="border-b border-gray-200 bg-gray-50">
                                <td class="py-4 px-6 font-semibold">L</td>
                                <td class="py-4 px-6 text-center">38-40</td>
                                <td class="py-4 px-6 text-center">28</td>
                                <td class="py-4 px-6 text-center">17</td>
                            </tr>
                            <tr class="border-b border-gray-200">
                                <td class="py-4 px-6 font-semibold">XL</td>
                                <td class="py-4 px-6 text-center">40-42</td>
                                <td class="py-4 px-6 text-center">29</td>
                                <td class="py-4 px-6 text-center">18</td>
                            </tr>
                            <tr class="border-b border-gray-200 bg-gray-50">
                                <td class="py-4 px-6 font-semibold">2XL</td>
                                <td class="py-4 px-6 text-center">42-44</td>
                                <td class="py-4 px-6 text-center">30</td>
                                <td class="py-4 px-6 text-center">19</td>
                            </tr>
                        </tbody>
                    </table>
                </div>
            </div>

            <!-- Hoodies & Sweatshirts -->
            <div>
                <h2 class="font-cg font-bold text-2xl uppercase text-gray-900 mb-6 tracking-wide">Hoodies & Sweatshirts</h2>
                <div class="overflow-x-auto">
                    <table class="w-full border-collapse">
                        <thead>
                            <tr class="bg-gray-900 text-white">
                                <th class="font-cg uppercase text-sm py-4 px-6 text-left">Size</th>
                                <th class="font-cg uppercase text-sm py-4 px-6 text-center">Chest (inches)</th>
                                <th class="font-cg uppercase text-sm py-4 px-6 text-center">Length (inches)</th>
                                <th class="font-cg uppercase text-sm py-4 px-6 text-center">Sleeve (inches)</th>
                            </tr>
                        </thead>
                        <tbody class="font-lora">
                            <tr class="border-b border-gray-200">
                                <td class="py-4 px-6 font-semibold">S</td>
                                <td class="py-4 px-6 text-center">38-40</td>
                                <td class="py-4 px-6 text-center">27</td>
                                <td class="py-4 px-6 text-center">33</td>
                            </tr>
                            <tr class="border-b border-gray-200 bg-gray-50">
                                <td class="py-4 px-6 font-semibold">M</td>
                                <td class="py-4 px-6 text-center">40-42</td>
                                <td class="py-4 px-6 text-center">28</td>
                                <td class="py-4 px-6 text-center">34</td>
                            </tr>
                            <tr class="border-b border-gray-200">
                                <td class="py-4 px-6 font-semibold">L</td>
                                <td class="py-4 px-6 text-center">42-44</td>
                                <td class="py-4 px-6 text-center">29</td>
                                <td class="py-4 px-6 text-center">35</td>
                            </tr>
                            <tr class="border-b border-gray-200 bg-gray-50">
                                <td class="py-4 px-6 font-semibold">XL</td>
                                <td class="py-4 px-6 text-center">44-46</td>
                                <td class="py-4 px-6 text-center">30</td>
                                <td class="py-4 px-6 text-center">36</td>
                            </tr>
                            <tr class="border-b border-gray-200">
                                <td class="py-4 px-6 font-semibold">2XL</td>
                                <td class="py-4 px-6 text-center">46-48</td>
                                <td class="py-4 px-6 text-center">31</td>
                                <td class="py-4 px-6 text-center">37</td>
                            </tr>
                        </tbody>
                    </table>
                </div>
            </div>

            <!-- Fit Guide -->
            <div>
                <h2 class="font-cg font-bold text-2xl uppercase text-gray-900 mb-6 tracking-wide">Fit Guide</h2>
                <div class="grid grid-cols-1 md:grid-cols-3 gap-6">
                    <div class="bg-gray-50 p-6 rounded-sm">
                        <h3 class="font-cg font-semibold text-lg uppercase text-gray-900 mb-3">Regular Fit</h3>
                        <p class="font-lora text-gray-700 text-base leading-relaxed">
                            Our standard fit that's neither too loose nor too tight. Perfect for everyday wear with 
                            comfortable room through the body.
                        </p>
                    </div>
                    
                    <div class="bg-gray-50 p-6 rounded-sm">
                        <h3 class="font-cg font-semibold text-lg uppercase text-gray-900 mb-3">Relaxed Fit</h3>
                        <p class="font-lora text-gray-700 text-base leading-relaxed">
                            A looser, more casual fit with extra room throughout. Ideal for layering or a more 
                            laid-back look.
                        </p>
                    </div>
                    
                    <div class="bg-gray-50 p-6 rounded-sm">
                        <h3 class="font-cg font-semibold text-lg uppercase text-gray-900 mb-3">Oversized Fit</h3>
                        <p class="font-lora text-gray-700 text-base leading-relaxed">
                            Intentionally larger and boxier for a contemporary streetwear aesthetic. Consider sizing 
                            down for a less dramatic oversized look.
                        </p>
                    </div>
                </div>
            </div>

            <!-- Sizing Tips -->
            <div class="bg-gray-50 p-8 rounded-sm">
                <h2 class="font-cg font-bold text-2xl uppercase text-gray-900 mb-6 tracking-wide">Sizing Tips</h2>
                <ul class="space-y-4 font-lora text-gray-700 text-base leading-relaxed">
                    <li class="flex items-start">
                        <span class="text-[#1fac99ff] mr-3 mt-1">•</span>
                        <span><strong>Between sizes?</strong> If you're between sizes, we recommend sizing up for a more comfortable fit.</span>
                    </li>
                    <li class="flex items-start">
                        <span class="text-[#1fac99ff] mr-3 mt-1">•</span>
                        <span><strong>Shrinkage:</strong> Our garments are pre-shrunk, but minimal shrinkage (1-3%) may occur after the first wash.</span>
                    </li>
                    <li class="flex items-start">
                        <span class="text-[#1fac99ff] mr-3 mt-1">•</span>
                        <span><strong>Layering:</strong> If you plan to layer, consider sizing up for additional room.</span>
                    </li>
                    <li class="flex items-start">
                        <span class="text-[#1fac99ff] mr-3 mt-1">•</span>
                        <span><strong>Product-specific notes:</strong> Check individual product pages for any specific fit information.</span>
                    </li>
                </ul>
            </div>

            <!-- Need Help -->
            <div class="bg-[#1fac99ff] bg-opacity-10 p-8 rounded-sm border-l-4 border-[#1fac99ff]">
                <h3 class="font-cg font-bold text-xl uppercase text-gray-900 mb-4 tracking-wide">Need Help Finding Your Size?</h3>
                <p class="font-lora text-gray-700 text-base leading-relaxed mb-4">
                    Still unsure about sizing? Our customer service team is here to help you find the perfect fit.
                </p>
                <div class="font-lora text-gray-700 text-base leading-relaxed space-y-1">
                    <p><strong>Email:</strong> support@jauxsh.com</p>
                    <p><strong>Phone:</strong> +63 XXX XXX XXXX</p>
                </div>
            </div>

        </div>
    </div>
</div>
@endsection