<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <meta http-equiv="Cache-Control" content="no-cache, no-store, must-revalidate">
    <meta http-equiv="Pragma" content="no-cache">
    <meta http-equiv="Expires" content="0">
    <meta name="csrf-token" content="{{ csrf_token() }}">
    <link rel="icon" href="{{ asset('images/jau.png') }}">
    @vite(['resources/css/app.css', 'resources/js/app.js'])

    <title>@yield('title', 'My E-Commerce Store')</title>
    @stack('styles')
    <style>
        .noise-overlay {
            background-image: url("data:image/svg+xml,%3Csvg viewBox='0 0 400 400' xmlns='http://www.w3.org/2000/svg'%3E%3Cfilter id='noiseFilter'%3E%3CfeTurbulence type='fractalNoise' baseFrequency='0.9' numOctaves='4' stitchTiles='stitch'/%3E%3C/filter%3E%3Crect width='100%25' height='100%25' filter='url(%23noiseFilter)' opacity='0.05'/%3E%3C/svg%3E");
        }
    </style>
</head>
<body class="relative min-h-screen bg-cover bg-center bg-no-repeat scroll-smooth">

        <!-- Background overlays -->
        <div class="absolute inset-0 bg-[#4d9b91]/20 pointer-events-none z-0"></div>
        <div class="absolute inset-0 noise-overlay pointer-events-none z-0"></div>
        
        <!-- Navbar -->
        @include('layouts.navbar')
       
        <!-- Main Content -->
        <main class="relative z-10 container mx-auto px-8 py-5">
            @yield('content')
        </main>
       
        <!-- Footer -->
        @include('layouts.footer')
    
    
    <!-- Auth Popup Modal (only for guests) -->
    @guest
        @include('auth.modals.auth-popup')
    @endguest
   
    @stack('scripts')

    <!-- Page Transitions Script -->
</body>
</html>