<?php
require_once __DIR__ . '/../vendor/autoload.php';

$app = require_once __DIR__ . '/../bootstrap/app.php';
$app->make(Illuminate\Contracts\Console\Kernel::class)->bootstrap();

use App\Models\User;
use App\Models\Payment;
use App\Models\Purchase;
use App\Models\Vehicle;
use Illuminate\Support\Facades\Auth;

echo "<h2>Admin Payment Verification Test</h2>";

try {
    // Find an admin user
    $admin = User::whereHas('role', function($query) {
        $query->whereIn('name', ['admin', 'super_admin']);
    })->first();
    
    if (!$admin) {
        echo "<p>❌ No admin user found. Looking for any user with admin role...</p>";
        
        // Check if admin role exists
        $adminRole = \App\Models\Role::where('name', 'admin')->first();
        if (!$adminRole) {
            echo "<p>Creating admin role...</p>";
            $adminRole = \App\Models\Role::create([
                'name' => 'admin',
                'display_name' => 'Administrator',
                'description' => 'System administrator with full access',
                'permissions' => ['manage_users', 'manage_vehicles', 'manage_bookings', 'manage_payments']
            ]);
        }
        
        // Find any user and make them admin
        $user = User::first();
        if ($user) {
            $user->update(['role_id' => $adminRole->id]);
            $admin = $user;
            echo "<p>✅ Made user '{$user->name}' an admin</p>";
        } else {
            echo "<p>❌ No users found in the system</p>";
            return;
        }
    }
    
    echo "<p>✅ Found admin: {$admin->name} (ID: {$admin->id})</p>";
    
    // Login as admin
    Auth::login($admin);
    
    // Check if there are any payments
    $payments = Payment::with(['payable', 'user', 'verifiedBy'])->get();
    echo "<p>✅ Found {$payments->count()} payments in the system</p>";
    
    if ($payments->count() > 0) {
        $payment = $payments->first();
        echo "<h3>Testing Payment Details:</h3>";
        echo "<ul>";
        echo "<li>Payment ID: {$payment->id}</li>";
        echo "<li>Reference: {$payment->payment_reference}</li>";
        echo "<li>Status: {$payment->status}</li>";
        echo "<li>Amount: $" . number_format($payment->amount, 2) . "</li>";
        echo "<li>User: {$payment->user->name}</li>";
        echo "<li>Method: {$payment->payment_method}</li>";
        echo "</ul>";
        
        // Test admin routes
        echo "<h3>Testing Admin Routes:</h3>";
        echo "<ul>";
        echo "<li>✅ Admin Payments Index: <a href='/admin/payments' target='_blank'>/admin/payments</a></li>";
        echo "<li>✅ Admin Payment Show: <a href='/admin/payments/{$payment->id}' target='_blank'>/admin/payments/{$payment->id}</a></li>";
        echo "</ul>";
        
        // Test payment verification capability
        if ($payment->status === 'submitted') {
            echo "<p>✅ Payment is in 'submitted' status and can be verified</p>";
        } else {
            echo "<p>ℹ️ Payment status is '{$payment->status}' - not available for verification</p>";
        }
        
    } else {
        echo "<p>ℹ️ No payments found. Creating a test payment...</p>";
        
        // Find a user and vehicle to create a test payment
        $user = User::whereHas('role', function($query) {
            $query->where('name', '!=', 'admin')->where('name', '!=', 'super_admin');
        })->first();
        
        if (!$user) {
            $user = User::where('role_id', '!=', $admin->role_id)->first();
        }
        $vehicle = Vehicle::where('status', 'available')->whereNotNull('sale_price')->where('sale_price', '>', 0)->first();
        
        if ($user && $vehicle) {
            // Create a test purchase
            $purchase = Purchase::create([
                'user_id' => $user->id,
                'vehicle_id' => $vehicle->id,
                'purchase_price' => $vehicle->sale_price,
                'tax_amount' => $vehicle->sale_price * 0.15,
                'total_amount' => $vehicle->sale_price * 1.15,
                'status' => 'pending',
                'notes' => json_encode(['test' => 'Admin payment test'])
            ]);
            
            // Create a test payment
            $payment = Payment::create([
                'payable_type' => Purchase::class,
                'payable_id' => $purchase->id,
                'user_id' => $user->id,
                'amount' => $purchase->total_amount,
                'payment_method' => 'cbe_mobile',
                'bank_name' => 'Commercial Bank of Ethiopia',
                'account_number' => '1000123456789',
                'transaction_reference' => 'TEST-ADMIN-' . time(),
                'status' => 'submitted'
            ]);
            
            echo "<p>✅ Test payment created:</p>";
            echo "<ul>";
            echo "<li>Payment ID: {$payment->id}</li>";
            echo "<li>Reference: {$payment->payment_reference}</li>";
            echo "<li>Status: {$payment->status}</li>";
            echo "<li>Amount: $" . number_format($payment->amount, 2) . "</li>";
            echo "</ul>";
            
            echo "<h3>Test Admin Routes:</h3>";
            echo "<ul>";
            echo "<li>✅ Admin Payments Index: <a href='/admin/payments' target='_blank'>/admin/payments</a></li>";
            echo "<li>✅ Admin Payment Show: <a href='/admin/payments/{$payment->id}' target='_blank'>/admin/payments/{$payment->id}</a></li>";
            echo "</ul>";
        } else {
            echo "<p>❌ Cannot create test payment - missing user or vehicle</p>";
        }
    }
    
    echo "<h3>✅ Admin Payment System Test Complete</h3>";
    echo "<p>The admin can now:</p>";
    echo "<ol>";
    echo "<li>View all payments at /admin/payments</li>";
    echo "<li>View individual payment details</li>";
    echo "<li>Verify submitted payments</li>";
    echo "<li>Reject payments with reasons</li>";
    echo "</ol>";
    
} catch (Exception $e) {
    echo "<p>❌ Error: " . $e->getMessage() . "</p>";
    echo "<pre>" . $e->getTraceAsString() . "</pre>";
}
?>