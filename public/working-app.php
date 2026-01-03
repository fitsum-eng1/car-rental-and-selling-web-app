<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="utf-8">
    <meta name="viewport" content="width=device-width, initial-scale=1">
    <title>Working App Test - Car Rental System</title>
    
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
            min-height: 100vh;
        }
        .hero-title { animation: fadeInUp 1s ease-out; }
        .hero-subtitle { animation: fadeInUp 1s ease-out 0.3s both; }
        .hero-cta { animation: fadeInUp 1s ease-out 0.6s both; }
        .btn-animated { transition: all 0.3s ease; }
        .btn-animated:hover { transform: translateY(-2px); box-shadow: 0 10px 25px rgba(0,0,0,0.2); }
        .vehicle-card { transition: all 0.3s ease; }
        .vehicle-card:hover { transform: translateY(-8px) scale(1.02); }
        .stagger-item { animation: fadeInUp 0.6s ease-out both; }
        .stagger-item:nth-child(1) { animation-delay: 0.1s; }
        .stagger-item:nth-child(2) { animation-delay: 0.2s; }
        .stagger-item:nth-child(3) { animation-delay: 0.3s; }
        
        @keyframes fadeInUp {
            from { opacity: 0; transform: translate3d(0, 100%, 0); }
            to { opacity: 1; transform: translate3d(0, 0, 0); }
        }
    </style>
</head>
<body class="bg-gray-50 font-sans">
    <!-- Navigation -->
    <nav class="bg-white shadow-lg">
        <div class="max-w-7xl mx-auto px-4 sm:px-6 lg:px-8">
            <div class="flex justify-between h-16">
                <div class="flex items-center">
                    <h1 class="text-xl font-bold text-blue-600">CarRental</h1>
                    <div class="hidden md:ml-6 md:flex md:space-x-8">
                        <a href="#" class="text-gray-900 hover:text-blue-600 px-3 py-2 text-sm font-medium transition-colors duration-200">Home</a>
                        <a href="#" class="text-gray-900 hover:text-blue-600 px-3 py-2 text-sm font-medium transition-colors duration-200">Rent a Car</a>
                        <a href="#" class="text-gray-900 hover:text-blue-600 px-3 py-2 text-sm font-medium transition-colors duration-200">Buy a Car</a>
                        <a href="#" class="text-gray-900 hover:text-blue-600 px-3 py-2 text-sm font-medium transition-colors duration-200">Contact</a>
                    </div>
                </div>
                <div class="flex items-center space-x-4">
                    <a href="#" class="text-gray-700 hover:text-blue-600 px-3 py-2 text-sm font-medium transition-colors duration-200">Login</a>
                    <a href="#" class="btn-animated bg-blue-600 text-white hover:bg-blue-700 px-4 py-2 rounded-md text-sm font-medium">Register</a>
                </div>
            </div>
        </div>
    </nav>

    <!-- Hero Section -->
    <div class="bg-gradient-to-r from-blue-600 to-blue-800 text-white relative overflow-hidden">
        <div class="absolute inset-0 bg-black opacity-10"></div>
        <div class="max-w-7xl mx-auto px-4 sm:px-6 lg:px-8 py-20 relative z-10">
            <div class="text-center">
                <h1 class="hero-title text-4xl md:text-6xl font-bold mb-6">Car Rental & Sales</h1>
                <p class="hero-subtitle text-xl md:text-2xl mb-8 text-blue-100">Rent or buy quality vehicles at affordable prices</p>
                <div class="flex flex-col sm:flex-row gap-4 justify-center">
                    <a href="#" class="hero-cta btn-animated bg-white text-blue-600 hover:bg-gray-100 px-8 py-3 rounded-lg font-semibold text-lg">Rent a Car</a>
                    <a href="#" class="hero-cta btn-animated border-2 border-white text-white hover:bg-white hover:text-blue-600 px-8 py-3 rounded-lg font-semibold text-lg">Buy a Car</a>
                </div>
            </div>
        </div>
    </div>

    <!-- Features Section -->
    <div class="py-16 bg-white">
        <div class="max-w-7xl mx-auto px-4 sm:px-6 lg:px-8">
            <div class="text-center mb-12">
                <h2 class="text-3xl font-bold text-gray-900 mb-4">Why Choose Us?</h2>
            </div>
            
            <div class="grid grid-cols-1 md:grid-cols-3 gap-8">
                <div class="text-center stagger-item">
                    <div class="bg-blue-100 w-16 h-16 rounded-full flex items-center justify-center mx-auto mb-4">
                        <svg class="w-8 h-8 text-blue-600" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                            <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M9 12l2 2 4-4m6 2a9 9 0 11-18 0 9 9 0 0118 0z"></path>
                        </svg>
                    </div>
                    <h3 class="text-xl font-semibold mb-2">Affordable Prices</h3>
                    <p class="text-gray-600">Best service at competitive prices</p>
                </div>
                
                <div class="text-center stagger-item">
                    <div class="bg-blue-100 w-16 h-16 rounded-full flex items-center justify-center mx-auto mb-4">
                        <svg class="w-8 h-8 text-blue-600" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                            <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M12 15v2m-6 4h12a2 2 0 002-2v-6a2 2 0 00-2-2H6a2 2 0 00-2 2v6a2 2 0 002 2zm10-10V7a4 4 0 00-8 0v4h8z"></path>
                        </svg>
                    </div>
                    <h3 class="text-xl font-semibold mb-2">Safe & Secure</h3>
                    <p class="text-gray-600">Complete safety and security guaranteed</p>
                </div>
                
                <div class="text-center stagger-item">
                    <div class="bg-blue-100 w-16 h-16 rounded-full flex items-center justify-center mx-auto mb-4">
                        <svg class="w-8 h-8 text-blue-600" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                            <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M13 10V3L4 14h7v7l9-11h-7z"></path>
                        </svg>
                    </div>
                    <h3 class="text-xl font-semibold mb-2">Quick Service</h3>
                    <p class="text-gray-600">Fast and efficient service delivery</p>
                </div>
            </div>
        </div>
    </div>

    <!-- Featured Rentals -->
    <div class="py-16 bg-gray-50">
        <div class="max-w-7xl mx-auto px-4 sm:px-6 lg:px-8">
            <div class="text-center mb-12">
                <h2 class="text-3xl font-bold text-gray-900 mb-4">Featured Rental Cars</h2>
            </div>
            
            <div class="grid grid-cols-1 md:grid-cols-2 lg:grid-cols-3 gap-8">
                <div class="vehicle-card bg-white rounded-lg shadow-md overflow-hidden stagger-item">
                    <div class="h-48 bg-gray-200 flex items-center justify-center">
                        <svg class="w-16 h-16 text-gray-400" fill="currentColor" viewBox="0 0 20 20">
                            <path fill-rule="evenodd" d="M4 3a2 2 0 00-2 2v10a2 2 0 002 2h12a2 2 0 002-2V5a2 2 0 00-2-2H4zm12 12H4l4-8 3 6 2-4 3 6z" clip-rule="evenodd" />
                        </svg>
                    </div>
                    <div class="p-6">
                        <h3 class="text-xl font-semibold mb-2">2023 Toyota Camry</h3>
                        <p class="text-gray-600 mb-4">Sedan • Automatic</p>
                        <div class="flex justify-between items-center">
                            <span class="text-2xl font-bold text-blue-600">$45.00/day</span>
                            <a href="#" class="btn-animated bg-blue-600 text-white px-4 py-2 rounded hover:bg-blue-700">View Details</a>
                        </div>
                    </div>
                </div>
                
                <div class="vehicle-card bg-white rounded-lg shadow-md overflow-hidden stagger-item">
                    <div class="h-48 bg-gray-200 flex items-center justify-center">
                        <svg class="w-16 h-16 text-gray-400" fill="currentColor" viewBox="0 0 20 20">
                            <path fill-rule="evenodd" d="M4 3a2 2 0 00-2 2v10a2 2 0 002 2h12a2 2 0 002-2V5a2 2 0 00-2-2H4zm12 12H4l4-8 3 6 2-4 3 6z" clip-rule="evenodd" />
                        </svg>
                    </div>
                    <div class="p-6">
                        <h3 class="text-xl font-semibold mb-2">2022 Honda CR-V</h3>
                        <p class="text-gray-600 mb-4">Suv • Automatic</p>
                        <div class="flex justify-between items-center">
                            <span class="text-2xl font-bold text-blue-600">$65.00/day</span>
                            <a href="#" class="btn-animated bg-blue-600 text-white px-4 py-2 rounded hover:bg-blue-700">View Details</a>
                        </div>
                    </div>
                </div>
                
                <div class="vehicle-card bg-white rounded-lg shadow-md overflow-hidden stagger-item">
                    <div class="h-48 bg-gray-200 flex items-center justify-center">
                        <svg class="w-16 h-16 text-gray-400" fill="currentColor" viewBox="0 0 20 20">
                            <path fill-rule="evenodd" d="M4 3a2 2 0 00-2 2v10a2 2 0 002 2h12a2 2 0 002-2V5a2 2 0 00-2-2H4zm12 12H4l4-8 3 6 2-4 3 6z" clip-rule="evenodd" />
                        </svg>
                    </div>
                    <div class="p-6">
                        <h3 class="text-xl font-semibold mb-2">2023 Ford F-150</h3>
                        <p class="text-gray-600 mb-4">Pickup • Automatic</p>
                        <div class="flex justify-between items-center">
                            <span class="text-2xl font-bold text-blue-600">$75.00/day</span>
                            <a href="#" class="btn-animated bg-blue-600 text-white px-4 py-2 rounded hover:bg-blue-700">View Details</a>
                        </div>
                    </div>
                </div>
            </div>
            
            <div class="text-center mt-8">
                <a href="#" class="btn-animated bg-blue-600 text-white px-8 py-3 rounded-lg hover:bg-blue-700">View All Rentals</a>
            </div>
        </div>
    </div>

    <!-- Footer -->
    <footer class="bg-gray-800 text-white mt-12">
        <div class="max-w-7xl mx-auto py-8 px-4 sm:px-6 lg:px-8">
            <div class="grid grid-cols-1 md:grid-cols-4 gap-8">
                <div>
                    <h3 class="text-lg font-semibold mb-4">CarRental</h3>
                    <p class="text-gray-300 text-sm">Your trusted vehicle rental and sales service</p>
                </div>
                <div>
                    <h4 class="text-md font-semibold mb-4">Services</h4>
                    <ul class="space-y-2 text-sm text-gray-300">
                        <li><a href="#" class="hover:text-white transition-colors duration-200">Car Rental</a></li>
                        <li><a href="#" class="hover:text-white transition-colors duration-200">Car Sales</a></li>
                    </ul>
                </div>
                <div>
                    <h4 class="text-md font-semibold mb-4">Support</h4>
                    <ul class="space-y-2 text-sm text-gray-300">
                        <li><a href="#" class="hover:text-white transition-colors duration-200">Contact Us</a></li>
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
                <p>&copy; 2025 CarRental. All rights reserved.</p>
            </div>
        </div>
    </footer>

    <script>
        console.log('✅ Working App loaded successfully!');
        
        // Add hover effects to vehicle cards
        document.querySelectorAll('.vehicle-card').forEach(card => {
            card.addEventListener('mouseenter', function() {
                this.style.transform = 'translateY(-8px) scale(1.02)';
            });
            
            card.addEventListener('mouseleave', function() {
                this.style.transform = 'translateY(0) scale(1)';
            });
        });
        
        // Test animations
        setTimeout(() => {
            console.log('✅ Animations should be visible now');
        }, 2000);
    </script>
</body>
</html>