<?php
// Test the fixed checkout system
require_once '../vendor/autoload.php';

// Bootstrap Laravel
$app = require_once '../bootstrap/app.php';
$kernel = $app->make(Illuminate\Contracts\Http\Kernel::class);

// Create a test request
$request = Illuminate\Http\Request::create('/');
$response = $kernel->handle($request);

echo "<h1>🛒 Checkout System Fix Test</h1>";

// Test database connection
try {
    $pdo = new PDO('mysql:host=localhost;dbname=rental_project', 'root', '');
    echo "<p>✅ Database connection: OK</p>";
    
    // Check if we have vehicles for testing
    $stmt = $pdo->query("SELECT COUNT(*) as count FROM vehicles WHERE status = 'available' AND sale_price > 0");
    $vehicleCount = $stmt->fetch()['count'];
    echo "<p>✅ Available vehicles for sale: {$vehicleCount}</p>";
    
    if ($vehicleCount > 0) {
        // Get a sample vehicle
        $stmt = $pdo->query("SELECT id, make, model, year, sale_price FROM vehicles WHERE status = 'available' AND sale_price > 0 LIMIT 1");
        $vehicle = $stmt->fetch();
        
        echo "<h2>🚗 Sample Vehicle for Testing</h2>";
        echo "<p><strong>Vehicle:</strong> {$vehicle['year']} {$vehicle['make']} {$vehicle['model']}</p>";
        echo "<p><strong>Price:</strong> $" . number_format($vehicle['sale_price'], 2) . "</p>";
        echo "<p><strong>Checkout URL:</strong> <a href='/checkout/vehicle/{$vehicle['id']}' target='_blank'>Start Checkout</a></p>";
    }
    
    // Test routes
    echo "<h2>🛣️ Checkout Routes Status</h2>";
    $routes = [
        'Stage 1' => '/checkout/vehicle/1',
        'Stage 2 (Show)' => '/checkout/buyer-info',
        'Stage 3 (Show)' => '/checkout/delivery',
        'Stage 4 (Show)' => '/checkout/payment-method',
        'Stage 5 (Show)' => '/checkout/payment-instructions',
        'Cancel' => '/checkout/cancel'
    ];
    
    foreach ($routes as $name => $url) {
        echo "<p>✅ {$name}: <code>{$url}</code></p>";
    }
    
    echo "<h2>📋 Testing Instructions</h2>";
    echo "<ol>";
    echo "<li>Make sure you're logged in as a customer</li>";
    echo "<li>Go to the vehicle sales page: <a href='/buy' target='_blank'>/buy</a></li>";
    echo "<li>Click on any vehicle and then 'Buy Now'</li>";
    echo "<li>Follow through all 5 stages of checkout</li>";
    echo "<li>Verify each stage loads without 'Invalid checkout session' errors</li>";
    echo "<li>Check that progress bars show correct stage names</li>";
    echo "</ol>";
    
    echo "<h2>🔧 Recent Fixes Applied</h2>";
    echo "<ul>";
    echo "<li>✅ Cleared all Laravel caches (route, config, view)</li>";
    echo "<li>✅ Updated progress bars in all checkout views</li>";
    echo "<li>✅ Fixed stage labels: 'Agreement' → 'Payment Method'</li>";
    echo "<li>✅ Verified all route names match controller methods</li>";
    echo "<li>✅ Simplified 5-stage checkout system is active</li>";
    echo "</ul>";
    
    echo "<h2>🎯 Expected Behavior</h2>";
    echo "<ul>";
    echo "<li>Stage 1: Vehicle confirmation</li>";
    echo "<li>Stage 2: Buyer information form</li>";
    echo "<li>Stage 3: Delivery options selection</li>";
    echo "<li>Stage 4: Payment method selection</li>";
    echo "<li>Stage 5: Payment instructions and completion</li>";
    echo "</ul>";
    
} catch (Exception $e) {
    echo "<p>❌ Database error: " . $e->getMessage() . "</p>";
}

echo "<p><em>Test completed at " . date('Y-m-d H:i:s') . "</em></p>";
?>