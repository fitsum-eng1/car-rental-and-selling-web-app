<?php
// Live dashboard debugging
require_once __DIR__ . '/../vendor/autoload.php';

$app = require_once __DIR__ . '/../bootstrap/app.php';
$app->make(\Illuminate\Contracts\Console\Kernel::class)->bootstrap();

echo "=== LIVE DASHBOARD DEBUG ===\n";

// Check Laravel session files
$sessionFiles = glob(__DIR__ . '/../storage/framework/sessions/*');
echo "Laravel session files: " . count($sessionFiles) . "\n";

// Try to get the current authenticated user from Laravel session
try {
    // Check authentication without starting session
    if (auth()->check()) {
        $user = auth()->user();
        echo "✅ Authenticated user: {$user->name} (ID: {$user->id})\n";
        
        // Test statistics
        $stats = [
            'total_bookings' => $user->bookings()->count(),
            'active_bookings' => $user->bookings()->whereIn('status', ['confirmed', 'active', 'paid'])->count(),
            'completed_bookings' => $user->bookings()->where('status', 'completed')->count(),
            'total_purchases' => $user->purchases()->count(),
            'completed_purchases' => $user->purchases()->where('status', 'completed')->count(),
        ];
        
        echo "\nSTATISTICS FOR CURRENT USER:\n";
        foreach ($stats as $key => $value) {
            echo "- " . ucfirst(str_replace('_', ' ', $key)) . ": {$value}\n";
        }
        
        // Check bookings details
        $bookings = $user->bookings()->get();
        echo "\nBOOKINGS DETAILS:\n";
        foreach ($bookings as $booking) {
            echo "- ID: {$booking->id}, Ref: {$booking->booking_reference}, Status: {$booking->status}, User: {$booking->user_id}\n";
        }
        
    } else {
        echo "❌ No authenticated user\n";
        
        // Check all users and their bookings
        echo "\nALL USERS WITH BOOKINGS:\n";
        $users = \App\Models\User::whereHas('bookings')->with('bookings')->get();
        foreach ($users as $user) {
            echo "- User {$user->id} ({$user->name}): {$user->bookings->count()} bookings\n";
            foreach ($user->bookings as $booking) {
                echo "  - {$booking->booking_reference}: {$booking->status}\n";
            }
        }
    }
    
} catch (Exception $e) {
    echo "❌ ERROR: " . $e->getMessage() . "\n";
    echo "File: " . $e->getFile() . ":" . $e->getLine() . "\n";
}

// Check database directly
echo "\n=== DIRECT DATABASE CHECK ===\n";
$allBookings = \App\Models\Booking::all();
echo "Total bookings in database: " . $allBookings->count() . "\n";
foreach ($allBookings as $booking) {
    echo "- Booking {$booking->id}: User {$booking->user_id}, Status: {$booking->status}, Ref: {$booking->booking_reference}\n";
}

echo "\n=== DEBUG COMPLETE ===\n";