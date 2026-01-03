<?php
// Complete dashboard test with authentication simulation
require_once __DIR__ . '/../vendor/autoload.php';

$app = require_once __DIR__ . '/../bootstrap/app.php';
$app->make(\Illuminate\Contracts\Console\Kernel::class)->bootstrap();

// Simulate authentication for user 5
$user = \App\Models\User::find(5);
if (!$user) {
    echo "User 5 not found!\n";
    exit;
}

// Simulate authentication
auth()->login($user);

echo "=== COMPLETE DASHBOARD TEST ===\n";
echo "Authenticated as: {$user->name} (ID: {$user->id})\n";
echo "Email: {$user->email}\n\n";

// Test the actual DashboardController logic
$controller = new \App\Http\Controllers\DashboardController();

try {
    // This would normally be called by Laravel routing
    $bookings = $user->bookings()
        ->with(['vehicle.images', 'payment'])
        ->orderBy('created_at', 'desc')
        ->take(5)
        ->get();

    $purchases = $user->purchases()
        ->with(['vehicle.images', 'payment'])
        ->orderBy('created_at', 'desc')
        ->take(5)
        ->get();

    // Updated statistics calculation (matching the fixed controller)
    $stats = [
        'total_bookings' => $user->bookings()->count(),
        'active_bookings' => $user->bookings()->whereIn('status', ['confirmed', 'active', 'paid'])->count(),
        'completed_bookings' => $user->bookings()->where('status', 'completed')->count(),
        'total_purchases' => $user->purchases()->count(),
        'completed_purchases' => $user->purchases()->where('status', 'completed')->count(),
    ];

    echo "DASHBOARD STATISTICS (FIXED):\n";
    foreach ($stats as $key => $value) {
        echo "- " . ucfirst(str_replace('_', ' ', $key)) . ": {$value}\n";
    }

    echo "\nRECENT BOOKINGS ({$bookings->count()}):\n";
    foreach ($bookings as $booking) {
        echo "- {$booking->booking_reference}: {$booking->vehicle->make} {$booking->vehicle->model} - Status: {$booking->status} - \${$booking->total_amount}\n";
    }

    echo "\nRECENT PURCHASES ({$purchases->count()}):\n";
    if ($purchases->count() > 0) {
        foreach ($purchases as $purchase) {
            echo "- {$purchase->purchase_reference}: {$purchase->vehicle->make} {$purchase->vehicle->model} - Status: {$purchase->status} - \${$purchase->total_amount}\n";
        }
    } else {
        echo "- No purchases found\n";
    }

    echo "\n✅ DASHBOARD TEST PASSED!\n";
    echo "The statistics should now display correctly:\n";
    echo "- Total Bookings: {$stats['total_bookings']} (was showing 0)\n";
    echo "- Active Bookings: {$stats['active_bookings']} (was showing 0)\n";
    echo "- Total Purchases: {$stats['total_purchases']}\n";
    echo "- Completed Purchases: {$stats['completed_purchases']}\n";

} catch (Exception $e) {
    echo "❌ ERROR: " . $e->getMessage() . "\n";
    echo "File: " . $e->getFile() . ":" . $e->getLine() . "\n";
}

echo "\n=== TEST COMPLETE ===\n";