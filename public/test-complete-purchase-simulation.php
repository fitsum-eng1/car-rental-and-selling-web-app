<?php
require_once __DIR__ . '/../vendor/autoload.php';

$app = require_once __DIR__ . '/../bootstrap/app.php';
$app->make(Illuminate\Contracts\Console\Kernel::class)->bootstrap();

use App\Models\User;
use App\Models\Vehicle;
use App\Models\Purchase;
use App\Models\Payment;
use App\Http\Controllers\CheckoutController;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Session;
use Illuminate\Support\Facades\Auth;

echo "<h2>Complete Purchase Process Simulation</h2>";

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
            'full_name' => 'Jane Smith',
            'phone' => '+251911987654',
            'email' => 'jane.smith@example.com',
            'city' => 'Addis Ababa',
            'national_id' => 'ID987654321'
        ],
        'delivery_info' => [
            'delivery_option' => 'company_delivery',
            'delivery_cost' => 500,
            'preferred_date' => now()->addDays(5)->format('Y-m-d'),
            'contact_person' => 'Jane Smith',
            'delivery_address' => '123 Main Street, Addis Ababa'
        ],
        'payment_method' => 'abyssinia_mobile'
    ];
    
    Session::put('checkout', $checkoutData);
    echo "<p>✅ Complete checkout session created</p>";
    
    // Simulate the complete purchase request
    $controller = new CheckoutController();
    
    // Create a mock request with transaction reference
    $request = new Request();
    $request->merge([
        'transaction_reference' => 'ABYS-TXN-' . time(),
        'transaction_proof' => 'Payment completed via Abyssinia Mobile Banking app. Screenshot saved.'
    ]);
    
    echo "<h3>Simulating Complete Purchase Request...</h3>";
    echo "<p>Transaction Reference: {$request->transaction_reference}</p>";
    echo "<p>Transaction Proof: {$request->transaction_proof}</p>";
    
    // Call the complete method
    $response = $controller->complete($request);
    
    // Check if it's a redirect response
    if ($response instanceof \Illuminate\Http\RedirectResponse) {
        $targetUrl = $response->getTargetUrl();
        echo "<p>✅ Purchase completed successfully!</p>";
        echo "<p>Redirect URL: {$targetUrl}</p>";
        
        // Check if there are any session messages
        $sessionData = Session::all();
        if (isset($sessionData['success'])) {
            echo "<p>✅ Success Message: {$sessionData['success']}</p>";
        }
        if (isset($sessionData['error'])) {
            echo "<p>❌ Error Message: {$sessionData['error']}</p>";
        }
        
        // Check if checkout session was cleared
        $checkoutSession = Session::get('checkout');
        if (!$checkoutSession) {
            echo "<p>✅ Checkout session cleared successfully</p>";
        } else {
            echo "<p>⚠️ Checkout session still exists</p>";
        }
        
        // Find the created purchase
        $latestPurchase = Purchase::latest()->first();
        if ($latestPurchase && $latestPurchase->user_id == $user->id && $latestPurchase->vehicle_id == $vehicle->id) {
            echo "<h3>✅ Purchase Record Created:</h3>";
            echo "<ul>";
            echo "<li>Purchase ID: {$latestPurchase->id}</li>";
            echo "<li>Reference: {$latestPurchase->purchase_reference}</li>";
            echo "<li>Status: {$latestPurchase->status}</li>";
            echo "<li>Total Amount: $" . number_format($latestPurchase->total_amount, 2) . "</li>";
            echo "</ul>";
            
            // Check payment record
            $payment = $latestPurchase->payment;
            if ($payment) {
                echo "<h3>✅ Payment Record Created:</h3>";
                echo "<ul>";
                echo "<li>Payment ID: {$payment->id}</li>";
                echo "<li>Reference: {$payment->payment_reference}</li>";
                echo "<li>Method: {$payment->payment_method}</li>";
                echo "<li>Bank: {$payment->bank_name}</li>";
                echo "<li>Status: {$payment->status}</li>";
                echo "<li>Transaction Ref: {$payment->transaction_reference}</li>";
                echo "</ul>";
            } else {
                echo "<p>❌ Payment record not found</p>";
            }
            
            // Check vehicle status
            $vehicle->refresh();
            echo "<h3>Vehicle Status Update:</h3>";
            echo "<p>Vehicle Status: {$vehicle->status}</p>";
            if ($vehicle->status === 'reserved') {
                echo "<p>✅ Vehicle successfully reserved</p>";
            } else {
                echo "<p>❌ Vehicle status not updated correctly</p>";
            }
            
            // Clean up test data
            echo "<h3>Cleaning up test data...</h3>";
            $payment->delete();
            $latestPurchase->delete();
            $vehicle->update(['status' => 'available']);
            echo "<p>✅ Test data cleaned up</p>";
            
        } else {
            echo "<p>❌ Purchase record not found or doesn't match expected criteria</p>";
        }
        
    } else {
        echo "<p>❌ Unexpected response type: " . get_class($response) . "</p>";
        if (method_exists($response, 'getContent')) {
            echo "<pre>" . $response->getContent() . "</pre>";
        }
    }
    
    echo "<h3>🎉 Complete Purchase Simulation Finished</h3>";
    
} catch (Exception $e) {
    echo "<p>❌ Error during simulation: " . $e->getMessage() . "</p>";
    echo "<pre>" . $e->getTraceAsString() . "</pre>";
}
?>