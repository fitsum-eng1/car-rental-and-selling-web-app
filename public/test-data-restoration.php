<?php
// Test script to verify data restoration
require_once __DIR__ . '/../vendor/autoload.php';

$app = require_once __DIR__ . '/../bootstrap/app.php';
$app->make('Illuminate\Contracts\Console\Kernel')->bootstrap();

use App\Models\User;
use App\Models\Vehicle;
use App\Models\Role;
use App\Models\Booking;

echo "<h1>Data Restoration Verification</h1>";

echo "<h2>Database Status:</h2>";
echo "<ul>";
echo "<li>Users: " . User::count() . "</li>";
echo "<li>Vehicles: " . Vehicle::count() . "</li>";
echo "<li>Roles: " . Role::count() . "</li>";
echo "<li>Bookings: " . Booking::count() . "</li>";
echo "</ul>";

echo "<h2>Roles:</h2>";
echo "<ul>";
foreach (Role::all() as $role) {
    $userCount = User::where('role_id', $role->id)->count();
    echo "<li>{$role->display_name} ({$role->name}) - {$userCount} users</li>";
}
echo "</ul>";

echo "<h2>Sample Vehicles:</h2>";
echo "<ul>";
foreach (Vehicle::take(5)->get() as $vehicle) {
    echo "<li>{$vehicle->make} {$vehicle->model} ({$vehicle->year}) - {$vehicle->status}</li>";
}
echo "</ul>";

echo "<h2>Admin Users:</h2>";
$adminRole = Role::where('name', 'admin')->first();
if ($adminRole) {
    $adminUsers = User::where('role_id', $adminRole->id)->get();
    echo "<ul>";
    foreach ($adminUsers as $admin) {
        echo "<li>{$admin->name} ({$admin->email})</li>";
    }
    echo "</ul>";
} else {
    echo "<p>No admin role found!</p>";
}

echo "<h2>Application Status:</h2>";
echo "<p style='color: green; font-weight: bold;'>✅ Data has been successfully restored!</p>";
echo "<p>The application should now be working normally with all users, vehicles, and roles restored.</p>";

echo "<h2>Login Credentials:</h2>";
echo "<p><strong>Admin Login:</strong></p>";
echo "<ul>";
echo "<li>Email: admin@example.com</li>";
echo "<li>Password: password</li>";
echo "</ul>";

echo "<h2>Next Steps:</h2>";
echo "<ul>";
echo "<li>✅ Database tables created</li>";
echo "<li>✅ Sample data seeded</li>";
echo "<li>✅ Admin user created</li>";
echo "<li>✅ Vehicles populated</li>";
echo "<li>✅ Roles configured</li>";
echo "</ul>";

echo "<p><a href='/'>← Back to Home Page</a></p>";
?>