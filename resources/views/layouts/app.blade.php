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
    
    <!-- Tailwind CSS CDN -->
    <script src="https://cdn.tailwindcss.com"></script>
    
    <!-- Animate.css CDN -->
    <link rel="stylesheet" href="https://cdnjs.cloudflare.com/ajax/libs/animate.css/4.1.1/animate.min.css">
    
    <style>
        body { 
            font-family: 'Figtree', sans-serif; 
            background-color: #f9fafb; 
            margin: 0; 
            padding: 0; 
        }
        .hero-gradient {
            background: linear-gradient(135deg, #2563eb 0%, #1e40af 100%);
        }
        .card-hover:hover {
            transform: translateY(-4px);
            box-shadow: 0 20px 25px -5px rgba(0, 0, 0, 0.1);
        }
        .btn-hover:hover {
            transform: translateY(-2px);
        }
        .animate-fade-in {
            animation: fadeIn 1s ease-out;
        }
        @keyframes fadeIn {
            from { opacity: 0; transform: translateY(20px); }
            to { opacity: 1; transform: translateY(0); }
        }
    </style>
    
    @stack('styles')
</head>
<body class="bg-gray-50">
    <!-- Navigation -->
    <nav class="bg-white shadow-lg">
        <div class="max-w-7xl mx-auto px-4 sm:px-6 lg:px-8">
            <div class="flex justify-between h-16">
                <div class="flex items-center">
                    <a href="{{ route('home') }}" class="flex-shrink-0 flex items-center">
                        <h1 class="text-xl font-bold text-blue-600">CarRental</h1>
                    </a>
                    
                    <div class="hidden md:ml-6 md:flex md:space-x-8">
                        <a href="{{ route('home') }}" class="text-gray-900 hover:text-blue-600 px-3 py-2 text-sm font-medium transition-colors duration-200">
                            {{ app()->getLocale() === 'am' ? 'ቤት' : 'Home' }}
                        </a>
                        <a href="{{ route('vehicles.rentals') }}" class="text-gray-900 hover:text-blue-600 px-3 py-2 text-sm font-medium transition-colors duration-200">
                            {{ app()->getLocale() === 'am' ? 'ኪራይ' : 'Rent a Car' }}
                        </a>
                        <a href="{{ route('vehicles.sales') }}" class="text-gray-900 hover:text-blue-600 px-3 py-2 text-sm font-medium transition-colors duration-200">
                            {{ app()->getLocale() === 'am' ? 'ግዢ' : 'Buy a Car' }}
                        </a>
                        <a href="{{ route('contact.show') }}" class="text-gray-900 hover:text-blue-600 px-3 py-2 text-sm font-medium transition-colors duration-200">
                            {{ app()->getLocale() === 'am' ? 'ያግኙን' : 'Contact' }}
                        </a>
                    </div>
                </div>
                
                <div class="flex items-center space-x-4">
                    <!-- Language Switcher -->
                    <div class="flex space-x-2">
                        <a href="{{ route('language.set', 'en') }}" 
                           class="px-2 py-1 text-xs {{ app()->getLocale() === 'en' ? 'bg-blue-600 text-white' : 'text-gray-600 hover:text-blue-600' }} rounded transition-all duration-200">
                            EN
                        </a>
                        <a href="{{ route('language.set', 'am') }}" 
                           class="px-2 py-1 text-xs {{ app()->getLocale() === 'am' ? 'bg-blue-600 text-white' : 'text-gray-600 hover:text-blue-600' }} rounded transition-all duration-200">
                            አማ
                        </a>
                    </div>
                    
                    @auth
                        <div class="relative">
                            <button class="flex items-center text-sm text-gray-700 hover:text-blue-600 transition-colors duration-200" onclick="toggleDropdown()">
                                {{ auth()->user()->name }}
                                <svg class="ml-1 h-4 w-4" fill="currentColor" viewBox="0 0 20 20">
                                    <path fill-rule="evenodd" d="M5.293 7.293a1 1 0 011.414 0L10 10.586l3.293-3.293a1 1 0 111.414 1.414l-4 4a1 1 0 01-1.414 0l-4-4a1 1 0 010-1.414z" clip-rule="evenodd" />
                                </svg>
                            </button>
                            <div id="dropdown" class="hidden absolute right-0 mt-2 w-48 bg-white rounded-md shadow-lg py-1 z-50">
                                <a href="{{ route('dashboard') }}" class="block px-4 py-2 text-sm text-gray-700 hover:bg-gray-100">
                                    {{ app()->getLocale() === 'am' ? 'ዳሽቦርድ' : 'Dashboard' }}
                                </a>
                                @if(auth()->user()->isAdmin())
                                    <a href="{{ route('admin.dashboard') }}" class="block px-4 py-2 text-sm text-gray-700 hover:bg-gray-100">
                                        {{ app()->getLocale() === 'am' ? 'አስተዳዳሪ' : 'Admin Panel' }}
                                    </a>
                                @endif
                                <form method="POST" action="{{ route('logout') }}">
                                    @csrf
                                    <button type="submit" class="block w-full text-left px-4 py-2 text-sm text-gray-700 hover:bg-gray-100">
                                        {{ app()->getLocale() === 'am' ? 'ውጣ' : 'Logout' }}
                                    </button>
                                </form>
                            </div>
                        </div>
                    @else
                        <a href="{{ route('login') }}" class="text-gray-700 hover:text-blue-600 px-3 py-2 text-sm font-medium transition-colors duration-200">
                            {{ app()->getLocale() === 'am' ? 'ግባ' : 'Login' }}
                        </a>
                        <a href="{{ route('register') }}" class="bg-blue-600 text-white hover:bg-blue-700 px-4 py-2 rounded-md text-sm font-medium btn-hover transition-all">
                            {{ app()->getLocale() === 'am' ? 'ተመዝገብ' : 'Register' }}
                        </a>
                    @endauth
                </div>
            </div>
        </div>
    </nav>

    <!-- Flash Messages -->
    @if(session('success'))
        <div class="bg-green-100 border border-green-400 text-green-700 px-4 py-3 rounded mx-4 mt-4">
            <span class="block sm:inline">{{ session('success') }}</span>
        </div>
    @endif

    @if(session('error'))
        <div class="bg-red-100 border border-red-400 text-red-700 px-4 py-3 rounded mx-4 mt-4">
            <span class="block sm:inline">{{ session('error') }}</span>
        </div>
    @endif

    <!-- Main Content -->
    <main>
        @yield('content')
    </main>

    <!-- Footer -->
    <footer class="bg-gray-800 text-white mt-12">
        <div class="max-w-7xl mx-auto py-8 px-4 sm:px-6 lg:px-8">
            <div class="grid grid-cols-1 md:grid-cols-4 gap-8">
                <div>
                    <h3 class="text-lg font-semibold mb-4">CarRental</h3>
                    <p class="text-gray-300 text-sm">
                        {{ app()->getLocale() === 'am' ? 'የተሽከርካሪ ኪራይ እና ሽያጭ አገልግሎት' : 'Your trusted vehicle rental and sales service' }}
                    </p>
                </div>
                <div>
                    <h4 class="text-md font-semibold mb-4">{{ app()->getLocale() === 'am' ? 'አገልግሎቶች' : 'Services' }}</h4>
                    <ul class="space-y-2 text-sm text-gray-300">
                        <li><a href="{{ route('vehicles.rentals') }}" class="hover:text-white transition-colors duration-200">{{ app()->getLocale() === 'am' ? 'የመኪና ኪራይ' : 'Car Rental' }}</a></li>
                        <li><a href="{{ route('vehicles.sales') }}" class="hover:text-white transition-colors duration-200">{{ app()->getLocale() === 'am' ? 'የመኪና ሽያጭ' : 'Car Sales' }}</a></li>
                    </ul>
                </div>
                <div>
                    <h4 class="text-md font-semibold mb-4">{{ app()->getLocale() === 'am' ? 'ድጋፍ' : 'Support' }}</h4>
                    <ul class="space-y-2 text-sm text-gray-300">
                        <li><a href="{{ route('contact.show') }}" class="hover:text-white transition-colors duration-200">{{ app()->getLocale() === 'am' ? 'ያግኙን' : 'Contact Us' }}</a></li>
                    </ul>
                </div>
                <div>
                    <h4 class="text-md font-semibold mb-4">{{ app()->getLocale() === 'am' ? 'ያግኙን' : 'Contact Info' }}</h4>
                    <div class="text-sm text-gray-300 space-y-2">
                        <p>📞 +251-911-000-000</p>
                        <p>✉️ info@carrental.com</p>
                        <p>📍 Addis Ababa, Ethiopia</p>
                    </div>
                </div>
            </div>
            <div class="border-t border-gray-700 mt-8 pt-8 text-center text-sm text-gray-300">
                <p>&copy; {{ date('Y') }} CarRental. {{ app()->getLocale() === 'am' ? 'ሁሉም መብቶች የተጠበቁ ናቸው።' : 'All rights reserved.' }}</p>
            </div>
        </div>
    </footer>

    <script>
        function toggleDropdown() {
            const dropdown = document.getElementById('dropdown');
            dropdown.classList.toggle('hidden');
        }
        
        // Close dropdown when clicking outside
        window.onclick = function(event) {
            if (!event.target.matches('button')) {
                var dropdown = document.getElementById('dropdown');
                if (!dropdown.classList.contains('hidden')) {
                    dropdown.classList.add('hidden');
                }
            }
        }

        // Auto-hide notifications
        setTimeout(() => {
            document.querySelectorAll('.bg-green-100, .bg-red-100').forEach(notification => {
                notification.style.opacity = '0';
                setTimeout(() => notification.remove(), 300);
            });
        }, 5000);
        
        console.log('Car Rental System loaded successfully!');
    </script>
    
    @stack('scripts')
</body>
</html>