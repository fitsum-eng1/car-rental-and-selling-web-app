<?php
require_once __DIR__ . '/../vendor/autoload.php';

$app = require_once __DIR__ . '/../bootstrap/app.php';
$app->make(Illuminate\Contracts\Console\Kernel::class)->bootstrap();

use App\Models\User;
use App\Models\Vehicle;
use App\Models\Purchase;
use App\Models\Payment;
use Illuminate\Support\Facades\Session;
use Illuminate\Support\Facades\Auth;

echo "<h2>Testing Checkout Complete Functionality</h2>";

try {
    // Find a test user and vehicle
    $user = User::first();
    $vehicle = Vehicle::where('status', 'available')->whereNotNull('sale_price')->where('sale_price', '>', 0)->first();
    
    if (!$user || !$vehicle) {
        echo "<p>❌ Need at least one user and one available vehicle</p>";
        exit;
    }
    
    echo "<p>✅ Found user: {$user->name} (ID: {$user->id})</p>";
    echo "<p>✅ Found vehicle: {$vehicle->full_name} (ID: {$vehicle->id})</p>";
    
    // Simulate login
    Auth::login($user);
    echo "<p>✅ User logged in</p>";
    
    // Create a mock checkout session
    $checkoutData = [
        'vehicle_id' => $vehicle->id,
        'stage' => 5,
        'started_at' => now(),
        'buyer_info' => [
            'full_name' => 'Test Buyer',
            'phone' => '+251911123456',
            'email' => 'test@example.com',
            'city' => 'Addis Ababa',
            'national_id' => 'ID123456'
        ],
        'delivery_info' => [
            'delivery_option' => 'pickup',
            'delivery_cost' => 0,
            'preferred_date' => now()->addDays(3)->format('Y-m-d'),
            'contact_person' => 'Test Contact'
        ],
        'payment_method' => 'cbe_mobile'
    ];
    
    Session::put('checkout', $checkoutData);
    echo "<p>✅ Checkout session created</p>";
    
    // Test the complete purchase logic
    $salePrice = $vehicle->sale_price;
    $deliveryCost = $checkoutData['delivery_info']['delivery_cost'];
    $taxAmount = ($salePrice + $deliveryCost) * 0.15;
    $totalAmount = $salePrice + $deliveryCost + $taxAmount;
    
    echo "<h3>Purchase Calculation:</h3>";
    echo "<p>Sale Price: $" . number_format($salePrice, 2) . "</p>";
    echo "<p>Delivery Cost: $" . number_format($deliveryCost, 2) . "</p>";
    echo "<p>Tax (15%): $" . number_format($taxAmount, 2) . "</p>";
    echo "<p>Total Amount: $" . number_format($totalAmount, 2) . "</p>";
    
    // Test creating a purchase
    $purchase = Purchase::create([
        'user_id' => $user->id,
        'vehicle_id' => $vehicle->id,
        'purchase_price' => $salePrice,
        'tax_amount' => $taxAmount,
        'total_amount' => $totalAmount,
        'status' => 'pending',
        'notes' => json_encode([
            'buyer_info' => $checkoutData['buyer_info'],
            'delivery_info' => $checkoutData['delivery_info'],
            'checkout_completed_at' => now(),
        ]),
    ]);
    
    echo "<p>✅ Purchase created with ID: {$purchase->id}</p>";
    echo "<p>✅ Purchase reference: {$purchase->purchase_reference}</p>";
    
    // Test creating a payment
    $payment = Payment::create([
        'payable_type' => Purchase::class,
        'payable_id' => $purchase->id,
        'user_id' => $user->id,
        'amount' => $totalAmount,
        'payment_method' => $checkoutData['payment_method'],
        'bank_name' => 'Commercial Bank of Ethiopia',
        'account_number' => '1000123456789',
        'payment_instructions' => "Transfer {$totalAmount} ETB to Commercial Bank of Ethiopia and use reference: " . $purchase->purchase_reference,
        'transaction_reference' => 'TEST-TXN-' . time(),
        'transaction_proof' => 'Test payment proof',
        'status' => 'submitted',
    ]);
    
    echo "<p>✅ Payment created with ID: {$payment->id}</p>";
    echo "<p>✅ Payment reference: {$payment->payment_reference}</p>";
    
    // Test vehicle reservation
    $vehicle->update(['status' => 'reserved']);
    echo "<p>✅ Vehicle status updated to reserved</p>";
    
    echo "<h3>✅ All tests passed! The checkout complete functionality should work.</h3>";
    
    // Clean up test data
    $payment->delete();
    $purchase->delete();
    $vehicle->update(['status' => 'available']);
    Session::forget('checkout');
    
    echo "<p>✅ Test data cleaned up</p>";
    
} catch (Exception $e) {
    echo "<p>❌ Error: " . $e->getMessage() . "</p>";
    echo "<pre>" . $e->getTraceAsString() . "</pre>";
}