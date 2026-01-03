<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="utf-8">
    <meta name="viewport" content="width=device-width, initial-scale=1">
    <title>Final Verification - Car Rental System</title>
    <script src="https://cdn.tailwindcss.com"></script>
    <style>
        .success { color: #16a34a; }
        .error { color: #dc2626; }
        .info { color: #2563eb; }
    </style>
</head>
<body class="bg-gray-50 font-sans">
    <div class="max-w-4xl mx-auto py-8 px-4">
        <h1 class="text-3xl font-bold text-gray-900 mb-8">🎯 Final Verification - Car Rental System</h1>
        
        <?php
        try {
            // Test Laravel Application
            require_once __DIR__ . '/../vendor/autoload.php';
            $app = require_once __DIR__ . '/../bootstrap/app.php';
            $kernel = $app->make(\Illuminate\Contracts\Console\Kernel::class);
            $kernel->bootstrap();
            
            echo "<div class='bg-white rounded-lg shadow-md p-6 mb-6'>";
            echo "<h2 class='text-xl font-bold mb-4'>✅ Laravel Application Status</h2>";
            
            // Test home route
            $request = \Illuminate\Http\Request::create('/', 'GET');
            $response = $app->handle($request);
            $content = $response->getContent();
            
            echo "<p class='success'>✅ Status Code: " . $response->getStatusCode() . "</p>";
            echo "<p class='info'>📊 Content Length: " . number_format(strlen($content)) . " characters</p>";
            
            // Check for key content
            $checks = [
                'Car Rental & Sales' => strpos($content, 'Car Rental & Sales') !== false,
                'Navigation Menu' => strpos($content, 'CarRental') !== false,
                'Hero Section' => strpos($content, 'hero-gradient') !== false,
                'Features Section' => strpos($content, 'Why Choose Us') !== false,
                'Footer' => strpos($content, 'Contact Info') !== false,
                'Tailwind CSS' => strpos($content, 'tailwindcss.com') !== false,
                'Animate.css' => strpos($content, 'animate.css') !== false
            ];
            
            foreach ($checks as $name => $passed) {
                $class = $passed ? 'success' : 'error';
                $icon = $passed ? '✅' : '❌';
                echo "<p class='{$class}'>{$icon} {$name}: " . ($passed ? 'Found' : 'Missing') . "</p>";
            }
            
            // Test database
            $vehicleCount = \App\Models\Vehicle::count();
            echo "<p class='success'>✅ Database Connection: OK</p>";
            echo "<p class='info'>🚗 Vehicles in Database: {$vehicleCount}</p>";
            
            // Test featured vehicles
            $featuredRentals = \App\Models\Vehicle::availableForRent()->take(3)->get();
            $featuredSales = \App\Models\Vehicle::availableForSale()->take(3)->get();
            
            echo "<p class='success'>✅ Featured Rentals: " . $featuredRentals->count() . " vehicles</p>";
            echo "<p class='success'>✅ Featured Sales: " . $featuredSales->count() . " vehicles</p>";
            
            echo "</div>";
            
            // Show sample vehicle if available
            if ($featuredRentals->count() > 0) {
                $vehicle = $featuredRentals->first();
                echo "<div class='bg-white rounded-lg shadow-md p-6 mb-6'>";
                echo "<h2 class='text-xl font-bold mb-4'>🚗 Sample Vehicle Data</h2>";
                echo "<div class='grid grid-cols-2 gap-4'>";
                echo "<div><strong>Name:</strong> {$vehicle->full_name}</div>";
                echo "<div><strong>Price:</strong> \${$vehicle->rental_price_per_day}/day</div>";
                echo "<div><strong>Category:</strong> " . ucfirst($vehicle->category) . "</div>";
                echo "<div><strong>Transmission:</strong> " . ucfirst($vehicle->transmission) . "</div>";
                echo "</div>";
                echo "</div>";
            }
            
        } catch (Exception $e) {
            echo "<div class='bg-red-100 border border-red-400 text-red-700 px-4 py-3 rounded mb-6'>";
            echo "<h2 class='text-xl font-bold mb-2'>❌ Error</h2>";
            echo "<p><strong>Message:</strong> " . $e->getMessage() . "</p>";
            echo "<p><strong>File:</strong> " . $e->getFile() . "</p>";
            echo "<p><strong>Line:</strong> " . $e->getLine() . "</p>";
            echo "</div>";
        }
        ?>
        
        <!-- Live Application Preview -->
        <div class="bg-white rounded-lg shadow-md p-6 mb-6">
            <h2 class="text-xl font-bold mb-4">🚀 Live Application Preview</h2>
            <div class="border rounded-lg overflow-hidden">
                <iframe src="/" width="100%" height="600" class="w-full"></iframe>
            </div>
        </div>
        
        <!-- Navigation Links -->
        <div class="bg-white rounded-lg shadow-md p-6">
            <h2 class="text-xl font-bold mb-4">🔗 Quick Links</h2>
            <div class="grid grid-cols-2 md:grid-cols-4 gap-4">
                <a href="/" class="bg-blue-600 text-white px-4 py-2 rounded text-center hover:bg-blue-700 transition-colors" target="_blank">
                    🏠 Home Page
                </a>
                <a href="/rent" class="bg-green-600 text-white px-4 py-2 rounded text-center hover:bg-green-700 transition-colors" target="_blank">
                    🚗 Rent Cars
                </a>
                <a href="/buy" class="bg-purple-600 text-white px-4 py-2 rounded text-center hover:bg-purple-700 transition-colors" target="_blank">
                    🛒 Buy Cars
                </a>
                <a href="/contact" class="bg-gray-600 text-white px-4 py-2 rounded text-center hover:bg-gray-700 transition-colors" target="_blank">
                    📞 Contact
                </a>
            </div>
        </div>
    </div>
    
    <script>
        console.log('✅ Final verification page loaded successfully!');
        
        // Test if the iframe loads properly
        const iframe = document.querySelector('iframe');
        iframe.onload = function() {
            console.log('✅ Laravel application iframe loaded successfully!');
        };
        
        iframe.onerror = function() {
            console.error('❌ Laravel application iframe failed to load!');
        };
    </script>
</body>
</html>