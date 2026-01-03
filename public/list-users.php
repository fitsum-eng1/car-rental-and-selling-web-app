<?php
// List all users
require_once __DIR__ . '/../vendor/autoload.php';

$app = require_once __DIR__ . '/../bootstrap/app.php';
$app->make(\Illuminate\Contracts\Console\Kernel::class)->bootstrap();

echo "=== ALL USERS ===\n";
$users = \App\Models\User::with('role')->get();
foreach ($users as $user) {
    $roleName = $user->role ? $user->role->name : 'No role';
    $bookingCount = $user->bookings()->count();
    echo "ID: {$user->id}\n";
    echo "Name: {$user->name}\n";
    echo "Email: {$user->email}\n";
    echo "Role: {$roleName}\n";
    echo "Bookings: {$bookingCount}\n";
    echo "---\n";
}
echo "\n=== CREDENTIALS FOR TESTING ===\n";
echo "To test the dashboard with the user who has bookings:\n";
echo "Email: fitsumgashaw11@gmail.com\n";
echo "Password: password123\n";
echo "This user (ID: 5) has 1 booking that should show in statistics.\n";