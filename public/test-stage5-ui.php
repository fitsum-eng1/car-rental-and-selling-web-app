<?php
require_once __DIR__ . '/../vendor/autoload.php';

$app = require_once __DIR__ . '/../bootstrap/app.php';
$app->make(Illuminate\Contracts\Console\Kernel::class)->bootstrap();

use App\Models\User;
use App\Models\Vehicle;
use Illuminate\Support\Facades\Session;
use Illuminate\Support\Facades\Auth;

// Find a test user and vehicle with sale price
$user = User::first();
$vehicle = Vehicle::where('status', 'available')->whereNotNull('sale_price')->where('sale_price', '>', 0)->first();

if ($user && $vehicle) {
    // Simulate login
    Auth::login($user);
    
    // Create a complete checkout session for Stage 5
    $checkoutData = [
        'vehicle_id' => $vehicle->id,
        'stage' => 5,
        'started_at' => now(),
        'buyer_info' => [
            'full_name' => 'Test User',
            'phone' => '+251911123456',
            'email' => 'test@example.com',
            'city' => 'Addis Ababa',
            'national_id' => 'ID123456789'
        ],
        'delivery_info' => [
            'delivery_option' => 'pickup',
            'delivery_cost' => 0,
            'preferred_date' => now()->addDays(3)->format('Y-m-d'),
            'contact_person' => 'Test User'
        ],
        'payment_method' => 'cbe_mobile'
    ];
    
    Session::put('checkout', $checkoutData);
}

// Redirect to Stage 5
header('Location: /checkout/payment-instructions');
exit;