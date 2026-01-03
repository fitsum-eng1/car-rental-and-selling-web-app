<?php
require_once __DIR__ . '/../vendor/autoload.php';

$app = require_once __DIR__ . '/../bootstrap/app.php';
$app->make(Illuminate\Contracts\Console\Kernel::class)->bootstrap();

use App\Models\User;
use App\Models\Vehicle;
use Illuminate\Support\Facades\Session;
use Illuminate\Support\Facades\Auth;

echo "<h2>Stage 5 Complete Purchase Test</h2>";

try {
    // Find a test user and vehicle with sale price
    $user = User::first();
    $vehicle = Vehicle::where('status', 'available')->whereNotNull('sale_price')->where('sale_price', '>', 0)->first();
    
    if (!$user || !$vehicle) {
        echo "<p>❌ Need at least one user and one available vehicle with sale price</p>";
        exit;
    }
    
    echo "<p>✅ Found user: {$user->name} (ID: {$user->id})</p>";
    echo "<p>✅ Found vehicle: {$vehicle->full_name} (ID: {$vehicle->id}) - Price: $" . number_format($vehicle->sale_price, 2) . "</p>";
    
    // Simulate login
    Auth::login($user);
    
    // Create a complete checkout session (all stages completed)
    $checkoutData = [
        'vehicle_id' => $vehicle->id,
        'stage' => 5,
        'started_at' => now(),
        'buyer_info' => [
            'full_name' => 'John Doe',
            'phone' => '+251911123456',
            'email' => 'john.doe@example.com',
            'city' => 'Addis Ababa',
            'national_id' => 'ID123456789'
        ],
        'delivery_info' => [
            'delivery_option' => 'pickup',
            'delivery_cost' => 0,
            'preferred_date' => now()->addDays(3)->format('Y-m-d'),
            'contact_person' => 'John Doe'
        ],
        'payment_method' => 'cbe_mobile'
    ];
    
    Session::put('checkout', $checkoutData);
    echo "<p>✅ Complete checkout session created</p>";
    
    // Calculate totals
    $salePrice = $vehicle->sale_price;
    $deliveryCost = $checkoutData['delivery_info']['delivery_cost'];
    $taxAmount = ($salePrice + $deliveryCost) * 0.15;
    $totalAmount = $salePrice + $deliveryCost + $taxAmount;
    
    echo "<h3>Purchase Summary:</h3>";
    echo "<ul>";
    echo "<li>Vehicle: {$vehicle->full_name}</li>";
    echo "<li>Sale Price: $" . number_format($salePrice, 2) . "</li>";
    echo "<li>Delivery Cost: $" . number_format($deliveryCost, 2) . "</li>";
    echo "<li>Tax (15%): $" . number_format($taxAmount, 2) . "</li>";
    echo "<li><strong>Total Amount: $" . number_format($totalAmount, 2) . "</strong></li>";
    echo "</ul>";
    
    echo "<h3>Checkout Session Data:</h3>";
    echo "<pre>" . json_encode($checkoutData, JSON_PRETTY_PRINT) . "</pre>";
    
    echo "<h3>✅ Ready for Stage 5 Testing</h3>";
    echo "<p>You can now:</p>";
    echo "<ol>";
    echo "<li>Visit the Stage 5 page: <a href='/checkout/payment-instructions' target='_blank'>/checkout/payment-instructions</a></li>";
    echo "<li>Fill in a test transaction reference (e.g., 'TEST-TXN-12345')</li>";
    echo "<li>Click 'Complete Purchase' to test the functionality</li>";
    echo "</ol>";
    
    echo "<p><strong>Note:</strong> The checkout session is now active and ready for testing.</p>";
    
} catch (Exception $e) {
    echo "<p>❌ Error: " . $e->getMessage() . "</p>";
    echo "<pre>" . $e->getTraceAsString() . "</pre>";
}
?>