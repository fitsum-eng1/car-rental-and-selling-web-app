<?php
echo "<!DOCTYPE html><html><head><title>Complete Laravel Test</title>";
echo "<style>body{font-family:Arial;margin:2rem;background:#f5f5f5;} .success{color:green;} .error{color:red;} .info{color:blue;}</style>";
echo "</head><body>";

echo "<h1>🔧 Complete Laravel Application Test</h1>";
echo "<p><strong>Time:</strong> " . date('Y-m-d H:i:s') . "</p>";

try {
    // 1. Test Composer autoload
    require_once __DIR__ . '/../vendor/autoload.php';
    echo "<p class='success'>✅ Composer autoload: OK</p>";
    
    // 2. Test Laravel bootstrap
    $app = require_once __DIR__ . '/../bootstrap/app.php';
    echo "<p class='success'>✅ Laravel bootstrap: OK</p>";
    
    // 3. Bootstrap Laravel kernel
    $kernel = $app->make(\Illuminate\Contracts\Console\Kernel::class);
    $kernel->bootstrap();
    echo "<p class='success'>✅ Laravel kernel bootstrap: OK</p>";
    
    // 4. Test database connection
    $pdo = \Illuminate\Support\Facades\DB::connection()->getPdo();
    echo "<p class='success'>✅ Database connection: OK</p>";
    
    // 5. Test if vehicles exist
    $vehicleCount = \App\Models\Vehicle::count();
    echo "<p class='success'>✅ Vehicles in database: {$vehicleCount}</p>";
    
    // 6. Test HomeController
    $homeController = new \App\Http\Controllers\HomeController();
    echo "<p class='success'>✅ HomeController instantiated: OK</p>";
    
    // 7. Test home route response
    $request = \Illuminate\Http\Request::create('/', 'GET');
    $response = $app->handle($request);
    
    echo "<p class='success'>✅ Home route response: Status " . $response->getStatusCode() . "</p>";
    echo "<p class='info'>📊 Response size: " . number_format(strlen($response->getContent())) . " characters</p>";
    
    // 8. Check if response contains expected content
    $content = $response->getContent();
    $hasHero = strpos($content, 'Car Rental & Sales') !== false;
    $hasNavigation = strpos($content, 'CarRental') !== false;
    $hasFooter = strpos($content, 'Contact Info') !== false;
    
    echo "<p class='" . ($hasHero ? 'success' : 'error') . "'>" . ($hasHero ? '✅' : '❌') . " Hero section: " . ($hasHero ? 'Found' : 'Missing') . "</p>";
    echo "<p class='" . ($hasNavigation ? 'success' : 'error') . "'>" . ($hasNavigation ? '✅' : '❌') . " Navigation: " . ($hasNavigation ? 'Found' : 'Missing') . "</p>";
    echo "<p class='" . ($hasFooter ? 'success' : 'error') . "'>" . ($hasFooter ? '✅' : '❌') . " Footer: " . ($hasFooter ? 'Found' : 'Missing') . "</p>";
    
    // 9. Check CSS files
    echo "<h3>Asset Files Status:</h3>";
    $cssFiles = [
        'build/assets/app-CBPnCLyN.css',
        'build/assets/app-DmuyVQv5.css',
        'build/assets/app-CFdEZBK1.js'
    ];
    
    foreach ($cssFiles as $file) {
        $path = __DIR__ . '/' . $file;
        if (file_exists($path)) {
            $size = number_format(filesize($path));
            echo "<p class='success'>✅ {$file}: {$size} bytes</p>";
        } else {
            echo "<p class='error'>❌ {$file}: NOT FOUND</p>";
        }
    }
    
    // 10. Test featured vehicles
    $featuredRentals = \App\Models\Vehicle::availableForRent()->take(3)->get();
    $featuredSales = \App\Models\Vehicle::availableForSale()->take(3)->get();
    
    echo "<p class='success'>✅ Featured rentals: " . $featuredRentals->count() . " vehicles</p>";
    echo "<p class='success'>✅ Featured sales: " . $featuredSales->count() . " vehicles</p>";
    
    // 11. Show sample vehicle data
    if ($featuredRentals->count() > 0) {
        $vehicle = $featuredRentals->first();
        echo "<h3>Sample Vehicle Data:</h3>";
        echo "<p><strong>Name:</strong> {$vehicle->full_name}</p>";
        echo "<p><strong>Price:</strong> \${$vehicle->rental_price_per_day}/day</p>";
        echo "<p><strong>Category:</strong> {$vehicle->category}</p>";
    }
    
    // 12. Test if the actual Laravel app works
    echo "<h3>🚀 Laravel Application Test:</h3>";
    echo "<iframe src='/' width='100%' height='600' style='border:1px solid #ccc; margin-top:1rem;'></iframe>";
    
} catch (Exception $e) {
    echo "<p class='error'>❌ Error: " . $e->getMessage() . "</p>";
    echo "<p><strong>File:</strong> " . $e->getFile() . "</p>";
    echo "<p><strong>Line:</strong> " . $e->getLine() . "</p>";
    echo "<pre>" . $e->getTraceAsString() . "</pre>";
}

echo "<hr>";
echo "<h3>Navigation Links:</h3>";
echo "<p><a href='/rental-project/public/' target='_blank'>🏠 Laravel Home (New Tab)</a></p>";
echo "<p><a href='working-app.php'>✅ Working App Demo</a></p>";
echo "<p><a href='css-test.php'>🎨 CSS Test</a></p>";
echo "<p><a href='debug-final.php'>🔧 Debug Final</a></p>";

echo "</body></html>";
?>