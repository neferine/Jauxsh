@extends('layouts.app')
@section('title', 'About Us | Jauxsh')
@section('content')
<div class="min-h-screen ">
    <!-- Breadcrumb -->
    <div class="px-6 md:px-20 lg:px-40 pt-32 pb-8">
        <nav class="text-sm text-gray-600 font-lora">
            <a href="/" class="hover:text-gray-900 transition-colors">HOME</a>
            <span class="mx-2">/</span>
            <span class="text-gray-900">ABOUT</span>
        </nav>
    </div>

    <!-- Main Content -->
    <div class="px-6 md:px-20 lg:px-40 pb-20">
        <!-- Title -->
        <div class="text-center mb-16">
            <h1 class="font-cg font-bold text-4xl md:text-5xl lg:text-6xl uppercase text-gray-900 mb-8 tracking-tight">
                About
            </h1>
            <p class="font-lora text-gray-700 text-lg md:text-xl max-w-3xl mx-auto leading-relaxed">
                Jauxsh is a premium apparel brand, crafting exceptional t-shirts, fleece jackets, 
                and sweatpants for those who value comfort, quality, and effortless style.
            </p>
        </div>

        <!-- Image -->
        <div class="max-w-5xl mx-auto mb-20">
            <img src="{{ asset('images/about/about1.jpg') }}" 
                 alt="Jauxsh Apparel Collection" 
                 class="w-full h-auto object-cover rounded-sm shadow-2xl">
        </div>

        <!-- Story Section -->
        <div class="max-w-4xl mx-auto space-y-8">
            <div class="prose prose-lg max-w-none">
                <p class="font-lora text-gray-700 text-base md:text-lg leading-relaxed mb-6">
                    At <span class="font-semibold text-gray-900">Jauxsh</span>, we believe that everyday essentials 
                    deserve exceptional quality. We specialize in creating premium t-shirts, fleece jackets, and 
                    sweatpants that combine superior comfort with timeless design—pieces you'll reach for again 
                    and again.
                </p>
                
                <p class="font-lora text-gray-700 text-base md:text-lg leading-relaxed mb-6">
                    Every garment is crafted from carefully selected fabrics that feel incredible against your skin. 
                    Our t-shirts feature soft, breathable cotton. Our fleece jackets provide warmth without weight. 
                    Our sweatpants deliver unmatched comfort whether you're relaxing at home or out on the move.
                </p>

                <p class="font-lora text-gray-700 text-base md:text-lg leading-relaxed mb-6">
                    We work with skilled manufacturers who share our commitment to excellence, ensuring perfect 
                    fits, durable construction, and attention to every detail—from reinforced stitching to 
                    thoughtfully placed pockets and refined finishes.
                </p>

                <p class="font-lora text-gray-700 text-base md:text-lg leading-relaxed">
                    Welcome to <span class="font-semibold text-gray-900">Jauxsh</span> — where everyday comfort 
                    meets exceptional quality.
                </p>
            </div>
        </div>

        <!-- Values Section -->
        <div class="max-w-5xl mx-auto mt-24 grid grid-cols-1 md:grid-cols-3 gap-12">
            <div class="text-center">
                <h3 class="font-cg font-bold text-xl uppercase text-gray-900 mb-4 tracking-wide">Premium Fabrics</h3>
                <p class="font-lora text-gray-600 text-sm leading-relaxed">
                    Carefully sourced materials that feel incredible and last season after season.
                </p>
            </div>
            <div class="text-center">
                <h3 class="font-cg font-bold text-xl uppercase text-gray-900 mb-4 tracking-wide">Perfect Fit</h3>
                <p class="font-lora text-gray-600 text-sm leading-relaxed">
                    Thoughtfully designed cuts that flatter every body and move with you.
                </p>
            </div>
            <div class="text-center">
                <h3 class="font-cg font-bold text-xl uppercase text-gray-900 mb-4 tracking-wide">Everyday Essentials</h3>
                <p class="font-lora text-gray-600 text-sm leading-relaxed">
                    Versatile pieces that elevate your daily wardrobe with effortless style.
                </p>
            </div>
        </div>
    </div>
</div>
@endsection