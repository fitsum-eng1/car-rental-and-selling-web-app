<?php
// Test dashboard statistics
require_once __DIR__ . '/../vendor/autoload.php';

$app = require_once __DIR__ . '/../bootstrap/app.php';
$app->make(\Illuminate\Contracts\Console\Kernel::class)->bootstrap();

// Test with user ID 5 (the one with bookings)
$user = \App\Models\User::find(5);

if (!$user) {
    echo "User 5 not found!\n";
    exit;
}

echo "=== DASHBOARD STATISTICS TEST ===\n";
echo "User: {$user->name} (ID: {$user->id})\n";
echo "Email: {$user->email}\n\n";

// Test statistics calculation
$stats = [
    'total_bookings' => $user->bookings()->count(),
    'active_bookings' => $user->bookings()->whereIn('status', ['confirmed', 'active', 'paid'])->count(),
    'completed_bookings' => $user->bookings()->where('status', 'completed')->count(),
    'total_purchases' => $user->purchases()->count(),
    'completed_purchases' => $user->purchases()->where('status', 'completed')->count(),
];

echo "STATISTICS:\n";
foreach ($stats as $key => $value) {
    echo "- " . ucfirst(str_replace('_', ' ', $key)) . ": {$value}\n";
}

echo "\nBOOKINGS DETAILS:\n";
$bookings = $user->bookings()->get();
foreach ($bookings as $booking) {
    echo "- Booking {$booking->booking_reference}: Status = {$booking->status}, Amount = \${$booking->total_amount}\n";
}

echo "\nPURCHASES DETAILS:\n";
$purchases = $user->purchases()->get();
if ($purchases->count() > 0) {
    foreach ($purchases as $purchase) {
        echo "- Purchase {$purchase->purchase_reference}: Status = {$purchase->status}, Amount = \${$purchase->total_amount}\n";
    }
} else {
    echo "- No purchases found\n";
}

echo "\n=== TEST COMPLETE ===\n";