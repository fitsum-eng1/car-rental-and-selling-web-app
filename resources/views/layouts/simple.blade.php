<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="utf-8">
    <meta name="viewport" content="width=device-width, initial-scale=1">
    <title>@yield('title', 'Car Rental & Sales System')</title>
    
    <!-- Tailwind CSS CDN -->
    <script src="https://cdn.tailwindcss.com"></script>
    
    <!-- Animate.css CDN -->
    <link rel="stylesheet" href="https://cdnjs.cloudflare.com/ajax/libs/animate.css/4.1.1/animate.min.css">
    
    <style>
        body { 
            font-family: system-ui, -apple-system, sans-serif; 
            background-color: #f9fafb; 
            margin: 0; 
            padding: 0; 
        }
        .hero-gradient {
            background: linear-gradient(135deg, #667eea 0%, #764ba2 100%);
        }
        .card-hover:hover {
            transform: translateY(-4px);
            box-shadow: 0 20px 25px -5px rgba(0, 0, 0, 0.1);
        }
        .btn-hover:hover {
            transform: translateY(-2px);
        }
    </style>
</head>
<body class="bg-gray-50">
    <!-- Navigation -->
    <nav class="bg-white shadow-lg">
        <div class="max-w-7xl mx-auto px-4">
            <div class="flex justify-between h-16">
                <div class="flex items-center">
                    <h1 class="text-xl font-bold text-blue-600">CarRental</h1>
                    <div class="hidden md:ml-6 md:flex md:space-x-8">
                        <a href="{{ route('home') }}" class="text-gray-900 hover:text-blue-600 px-3 py-2 text-sm font-medium">Home</a>
                        <a href="{{ route('vehicles.rentals') }}" class="text-gray-900 hover:text-blue-600 px-3 py-2 text-sm font-medium">Rent a Car</a>
                        <a href="{{ route('vehicles.sales') }}" class="text-gray-900 hover:text-blue-600 px-3 py-2 text-sm font-medium">Buy a Car</a>
                        <a href="{{ route('contact.show') }}" class="text-gray-900 hover:text-blue-600 px-3 py-2 text-sm font-medium">Contact</a>
                    </div>
                </div>
                <div class="flex items-center space-x-4">
                    @auth
                        <a href="{{ route('dashboard') }}" class="text-gray-700 hover:text-blue-600 px-3 py-2 text-sm font-medium">Dashboard</a>
                        <form method="POST" action="{{ route('logout') }}" class="inline">
                            @csrf
                            <button type="submit" class="text-gray-700 hover:text-blue-600 px-3 py-2 text-sm font-medium">Logout</button>
                        </form>
                    @else
                        <a href="{{ route('login') }}" class="text-gray-700 hover:text-blue-600 px-3 py-2 text-sm font-medium">Login</a>
                        <a href="{{ route('register') }}" class="bg-blue-600 text-white hover:bg-blue-700 px-4 py-2 rounded-md text-sm font-medium btn-hover transition-all">Register</a>
                    @endauth
                </div>
            </div>
        </div>
    </nav>

    <!-- Flash Messages -->
    @if(session('success'))
        <div class="bg-green-100 border border-green-400 text-green-700 px-4 py-3 rounded mx-4 mt-4">
            {{ session('success') }}
        </div>
    @endif

    @if(session('error'))
        <div class="bg-red-100 border border-red-400 text-red-700 px-4 py-3 rounded mx-4 mt-4">
            {{ session('error') }}
        </div>
    @endif

    <!-- Main Content -->
    <main>
        @yield('content')
    </main>

    <!-- Footer -->
    <footer class="bg-gray-800 text-white mt-12">
        <div class="max-w-7xl mx-auto py-8 px-4">
            <div class="grid grid-cols-1 md:grid-cols-4 gap-8">
                <div>
                    <h3 class="text-lg font-semibold mb-4">CarRental</h3>
                    <p class="text-gray-300 text-sm">Your trusted vehicle rental and sales service</p>
                </div>
                <div>
                    <h4 class="text-md font-semibold mb-4">Services</h4>
                    <ul class="space-y-2 text-sm text-gray-300">
                        <li><a href="{{ route('vehicles.rentals') }}" class="hover:text-white">Car Rental</a></li>
                        <li><a href="{{ route('vehicles.sales') }}" class="hover:text-white">Car Sales</a></li>
                    </ul>
                </div>
                <div>
                    <h4 class="text-md font-semibold mb-4">Support</h4>
                    <ul class="space-y-2 text-sm text-gray-300">
                        <li><a href="{{ route('contact.show') }}" class="hover:text-white">Contact Us</a></li>
                    </ul>
                </div>
                <div>
                    <h4 class="text-md font-semibold mb-4">Contact Info</h4>
                    <div class="text-sm text-gray-300 space-y-2">
                        <p>📞 +251-911-000-000</p>
                        <p>✉️ info@carrental.com</p>
                        <p>📍 Addis Ababa, Ethiopia</p>
                    </div>
                </div>
            </div>
            <div class="border-t border-gray-700 mt-8 pt-8 text-center text-sm text-gray-300">
                <p>&copy; {{ date('Y') }} CarRental. All rights reserved.</p>
            </div>
        </div>
    </footer>

    <script>
        console.log('Simple layout loaded successfully!');
    </script>
</body>
</html>