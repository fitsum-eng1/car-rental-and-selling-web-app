<!DOCTYPE html>
<html lang="{{ str_replace('_', '-', app()->getLocale()) }}">
<head>
    <meta charset="utf-8">
    <meta name="viewport" content="width=device-width, initial-scale=1">
    <meta name="csrf-token" content="{{ csrf_token() }}">
    
    <title>@yield('title', 'Car Rental & Sales System')</title>
    
    <!-- Fonts -->
    <link rel="preconnect" href="https://fonts.bunny.net">
    <link href="https://fonts.bunny.net/css?family=figtree:400,500,600&display=swap" rel="stylesheet" />
    
    <!-- Tailwind CSS CDN as fallback -->
    <script src="https://cdn.tailwindcss.com"></script>
    
    <!-- Animate.css CDN -->
    <link rel="stylesheet" href="https://cdnjs.cloudflare.com/ajax/libs/animate.css/4.1.1/animate.min.css">
    
    <!-- Local Compiled Assets -->
    <link rel="stylesheet" href="{{ asset('build/assets/app-HUF5mJBU.css') }}">
    <link rel="stylesheet" href="{{ asset('build/assets/app-DmuyVQv5.css') }}">
    <script type="module" src="{{ asset('build/assets/app-CFdEZBK1.js') }}"></script>
    
    <!-- Custom Animation Styles -->
    <style>
        /* Ensure animations work */
        .hero-title { animation: fadeInUp 1s ease-out; }
        .hero-subtitle { animation: fadeInUp 1s ease-out 0.3s both; }
        .hero-cta { animation: fadeInUp 1s ease-out 0.6s both; }
        .btn-animated { transition: all 0.3s ease; }
        .btn-animated:hover { transform: translateY(-2px); box-shadow: 0 10px 25px rgba(0,0,0,0.2); }
        .vehicle-card { transition: all 0.3s ease; }
        .vehicle-card:hover { transform: translateY(-8px) scale(1.02); }
        .animate-ripple { position: relative; overflow: hidden; }
        .scroll-reveal { opacity: 1; transform: translateY(0); }
        .stagger-item { animation: fadeInUp 0.6s ease-out both; }
        .stagger-item:nth-child(1) { animation-delay: 0.1s; }
        .stagger-item:nth-child(2) { animation-delay: 0.2s; }
        .stagger-item:nth-child(3) { animation-delay: 0.3s; }
        .stagger-item:nth-child(4) { animation-delay: 0.4s; }
        .stagger-item:nth-child(5) { animation-delay: 0.5s; }
        .stagger-item:nth-child(6) { animation-delay: 0.6s; }
        
        @keyframes fadeInUp {
            from { opacity: 0; transform: translate3d(0, 100%, 0); }
            to { opacity: 1; transform: translate3d(0, 0, 0); }
        }
        
        /* Floating animations */
        .animate-bounce-subtle {
            animation: bounceSubtle 3s ease-in-out infinite;
        }
        
        .animate-pulse-slow {
            animation: pulseGlow 2s ease-in-out infinite;
        }
        
        @keyframes bounceSubtle {
            0%, 100% { transform: translateY(0px); }
            50% { transform: translateY(-10px); }
        }
        
        @keyframes pulseGlow {
            0%, 100% { opacity: 0.1; transform: scale(1); }
            50% { opacity: 0.2; transform: scale(1.05); }
        }
        
        /* Ensure proper spacing and layout */
        .smooth-scroll { scroll-behavior: smooth; }
        .gpu-accelerated { transform: translateZ(0); }
        .page-transition-enter { animation: pageEnter 0.5s ease-out; }
        
        @keyframes pageEnter {
            from { opacity: 0; transform: translateY(20px); }
            to { opacity: 1; transform: translateY(0); }
        }
    </style>
    
    @stack('styles')
</head>
<body class="font-sans antialiased bg-gray-50 smooth-scroll">
    <!-- Navigation -->
    <nav class="bg-white shadow-lg scroll-reveal">
        <div class="max-w-7xl mx-auto px-4 sm:px-6 lg:px-8">
            <div class="flex justify-between h-16">
                <div class="flex items-center">
                    <a href="{{ route('home') }}" class="flex-shrink-0 flex items-center brand-logo">
                        <h1 class="text-xl font-bold text-blue-600">CarRental</h1>
                    </a>
                    
                    <div class="hidden md:ml-6 md:flex md:space-x-8">
                        <a href="{{ route('home') }}" class="text-gray-900 hover:text-blue-600 px-3 py-2 text-sm font-medium transition-colors duration-200">
                            @if(app()->getLocale() === 'am')
                                ቤት
                            @else
                                Home
                            @endif
                        </a>
                        <a href="{{ route('vehicles.rentals') }}" class="text-gray-900 hover:text-blue-600 px-3 py-2 text-sm font-medium transition-colors duration-200">
                            @if(app()->getLocale() === 'am')
                                ኪራይ
                            @else
                                Rent a Car
                            @endif
                        </a>
                        <a href="{{ route('vehicles.sales') }}" class="text-gray-900 hover:text-blue-600 px-3 py-2 text-sm font-medium transition-colors duration-200">
                            @if(app()->getLocale() === 'am')
                                ሽያጭ
                            @else
                                Buy a Car
                            @endif
                        </a>
                        <a href="{{ route('contact.show') }}" class="text-gray-900 hover:text-blue-600 px-3 py-2 text-sm font-medium transition-colors duration-200">
                            @if(app()->getLocale() === 'am')
                                ግንኙነት
                            @else
                                Contact
                            @endif
                        </a>
                    </div>
                </div>
                
                <div class="flex items-center space-x-4">
                    <!-- Language Switcher -->
                    <div class="flex space-x-2">
                        <a href="{{ route('language.set', 'en') }}"
                           class="language-switch px-2 py-1 text-xs {{ app()->getLocale() === 'en' ? 'bg-blue-600 text-white' : 'text-gray-600 hover:text-blue-600' }} rounded transition-all duration-200">
                            EN
                        </a>
                        <a href="{{ route('language.set', 'am') }}"
                           class="language-switch px-2 py-1 text-xs {{ app()->getLocale() === 'am' ? 'bg-blue-600 text-white' : 'text-gray-600 hover:text-blue-600' }} rounded transition-all duration-200">
                            አማ
                        </a>
                    </div>
                    
                    @auth
                        <div class="relative">
                            <button onclick="toggleDropdown()" class="dropdown-button flex items-center text-gray-700 hover:text-blue-600 px-3 py-2 text-sm font-medium transition-colors duration-200">
                                {{ auth()->user()->name }}
                                <svg class="ml-1 h-4 w-4" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                                    <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M19 9l-7 7-7-7"></path>
                                </svg>
                            </button>
                            <div id="dropdown" class="hidden absolute right-0 mt-2 w-48 bg-white rounded-md shadow-lg py-1 z-50">
                                <a href="{{ route('dashboard') }}" class="block px-4 py-2 text-sm text-gray-700 hover:bg-gray-100">
                                    @if(app()->getLocale() === 'am')
                                        ዳሽቦርድ
                                    @else
                                        Dashboard
                                    @endif
                                </a>
                                <a href="{{ route('dashboard.profile') }}" class="block px-4 py-2 text-sm text-gray-700 hover:bg-gray-100">
                                    @if(app()->getLocale() === 'am')
                                        መገለጫ
                                    @else
                                        Profile
                                    @endif
                                </a>
                                <form method="POST" action="{{ route('logout') }}" class="block">
                                    @csrf
                                    <button type="submit" class="w-full text-left px-4 py-2 text-sm text-gray-700 hover:bg-gray-100">
                                        @if(app()->getLocale() === 'am')
                                            ውጣ
                                        @else
                                            Logout
                                        @endif
                                    </button>
                                </form>
                            </div>
                        </div>
                    @else
                        <a href="{{ route('login') }}" class="text-gray-700 hover:text-blue-600 px-3 py-2 text-sm font-medium transition-colors duration-200">
                            @if(app()->getLocale() === 'am')
                                ግባ
                            @else
                                Login
                            @endif
                        </a>
                        <a href="{{ route('register') }}" class="btn-animated bg-blue-600 text-white hover:bg-blue-700 px-4 py-2 rounded-md text-sm font-medium">
                            @if(app()->getLocale() === 'am')
                                ተመዝገብ
                            @else
                                Register
                            @endif
                        </a>
                    @endauth
                </div>
            </div>
        </div>
    </nav>
    
    <!-- Flash Messages -->
    @if(session('success'))
        <div class="notification show bg-green-100 border border-green-400 text-green-700 px-4 py-3 rounded mx-4 mt-4">
            {{ session('success') }}
        </div>
    @endif
    
    @if(session('error'))
        <div class="notification show bg-red-100 border border-red-400 text-red-700 px-4 py-3 rounded mx-4 mt-4">
            {{ session('error') }}
        </div>
    @endif
    
    <!-- Main Content -->
    <main class="page-transition-enter">
        @yield('content')
    </main>
    
    <!-- Footer -->
    <footer class="bg-gray-800 text-white mt-12 scroll-reveal">
        <div class="max-w-7xl mx-auto py-8 px-4 sm:px-6 lg:px-8">
            <div class="grid grid-cols-1 md:grid-cols-4 gap-8 stagger-container">
                <div class="stagger-item">
                    <h3 class="text-lg font-semibold mb-4">CarRental</h3>
                    <p class="text-gray-300 text-sm">
                        @if(app()->getLocale() === 'am')
                            የታመነ የተሽከርካሪ ኪራይ እና ሽያጭ አገልግሎት
                        @else
                            Your trusted vehicle rental and sales service
                        @endif
                    </p>
                </div>
                <div class="stagger-item">
                    <h4 class="text-md font-semibold mb-4">
                        @if(app()->getLocale() === 'am')
                            አገልግሎቶች
                        @else
                            Services
                        @endif
                    </h4>
                    <ul class="space-y-2 text-sm text-gray-300">
                        <li><a href="{{ route('vehicles.rentals') }}" class="hover:text-white transition-colors duration-200">
                            @if(app()->getLocale() === 'am')
                                የመኪና ኪራይ
                            @else
                                Car Rental
                            @endif
                        </a></li>
                        <li><a href="{{ route('vehicles.sales') }}" class="hover:text-white transition-colors duration-200">
                            @if(app()->getLocale() === 'am')
                                የመኪና ሽያጭ
                            @else
                                Car Sales
                            @endif
                        </a></li>
                    </ul>
                </div>
                <div class="stagger-item">
                    <h4 class="text-md font-semibold mb-4">
                        @if(app()->getLocale() === 'am')
                            ድጋፍ
                        @else
                            Support
                        @endif
                    </h4>
                    <ul class="space-y-2 text-sm text-gray-300">
                        <li><a href="{{ route('contact.show') }}" class="hover:text-white transition-colors duration-200">
                            @if(app()->getLocale() === 'am')
                                አግኙን
                            @else
                                Contact Us
                            @endif
                        </a></li>
                    </ul>
                </div>
                <div class="stagger-item">
                    <h4 class="text-md font-semibold mb-4">
                        @if(app()->getLocale() === 'am')
                            የመገናኛ መረጃ
                        @else
                            Contact Info
                        @endif
                    </h4>
                    <div class="text-sm text-gray-300 space-y-2">
                        <p>📞 +251-911-000-000</p>
                        <p>✉️ info@carrental.com</p>
                        <p>📍 Addis Ababa, Ethiopia</p>
                    </div>
                </div>
            </div>
            <div class="border-t border-gray-700 mt-8 pt-8 text-center text-sm text-gray-300">
                <p>&copy; 2025 CarRental. All rights reserved.</p>
            </div>
        </div>
    </footer>
    
    <script>
        function toggleDropdown() {
            const dropdown = document.getElementById('dropdown');
            dropdown.classList.toggle('hidden');
            dropdown.classList.toggle('show');
        }
        
        // Close dropdown when clicking outside
        window.onclick = function(event) {
            if (!event.target.matches('.dropdown-button')) {
                var dropdown = document.getElementById('dropdown');
                if (!dropdown.classList.contains('hidden')) {
                    dropdown.classList.add('hidden');
                    dropdown.classList.remove('show');
                }
            }
        }
        
        // Auto-hide notifications
        setTimeout(() => {
            document.querySelectorAll('.notification').forEach(notification => {
                notification.classList.remove('show');
                setTimeout(() => notification.remove(), 300);
            });
        }, 5000);
    </script>
    
    @stack('scripts')
</body>
</html>