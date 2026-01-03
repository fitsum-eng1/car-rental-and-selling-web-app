<?php
// Test booking relationships
require_once __DIR__ . '/../vendor/autoload.php';

$app = require_once __DIR__ . '/../bootstrap/app.php';
$app->make(\Illuminate\Contracts\Console\Kernel::class)->bootstrap();

echo "=== TESTING BOOKING RELATIONSHIPS ===\n";

$booking = \App\Models\Booking::first();
if ($booking) {
    echo "Booking ID: {$booking->id}\n";
    echo "Booking user_id: {$booking->user_id}\n";
    echo "Booking user name: {$booking->user->name}\n";
    echo "Booking reference: {$booking->booking_reference}\n";
    echo "Booking status: {$booking->status}\n";
} else {
    echo "No bookings found!\n";
}

echo "\n=== USER 5 BOOKINGS ===\n";
$user5 = \App\Models\User::find(5);
if ($user5) {
    echo "User 5 name: {$user5->name}\n";
    echo "User 5 email: {$user5->email}\n";
    echo "User 5 bookings count (relationship): " . $user5->bookings()->count() . "\n";
    echo "User 5 bookings count (direct query): " . \App\Models\Booking::where('user_id', 5)->count() . "\n";
    
    $bookings = $user5->bookings()->get();
    foreach ($bookings as $b) {
        echo "- Booking {$b->id}: {$b->booking_reference}, Status: {$b->status}\n";
    }
} else {
    echo "User 5 not found!\n";
}

echo "\n=== ALL USERS ===\n";
$users = \App\Models\User::all();
foreach ($users as $user) {
    $bookingCount = $user->bookings()->count();
    if ($bookingCount > 0) {
        echo "User {$user->id} ({$user->name}): {$bookingCount} bookings\n";
    }
}

echo "\n=== TEST COMPLETE ===\n";