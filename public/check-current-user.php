<!DOCTYPE html>
<html>
<head>
    <title>Current User Check</title>
    <style>
        body { font-family: Arial, sans-serif; margin: 40px; }
        .info { background: #f0f8ff; padding: 20px; border-radius: 8px; margin: 10px 0; }
        .error { background: #ffe6e6; padding: 20px; border-radius: 8px; margin: 10px 0; }
        .success { background: #e6ffe6; padding: 20px; border-radius: 8px; margin: 10px 0; }
    </style>
</head>
<body>
    <h1>Current User & Dashboard Statistics Check</h1>
    
    <?php
    require_once __DIR__ . '/../vendor/autoload.php';
    
    $app = require_once __DIR__ . '/../bootstrap/app.php';
    $kernel = $app->make(\Illuminate\Contracts\Http\Kernel::class);
    
    // Create a request
    $request = \Illuminate\Http\Request::createFromGlobals();
    
    // Handle the request to initialize session and auth
    $response = $kernel->handle($request);
    
    try {
        if (auth()->check()) {
            $user = auth()->user();
            echo "<div class='success'>";
            echo "<h2>✅ Authenticated User</h2>";
            echo "<p><strong>Name:</strong> {$user->name}</p>";
            echo "<p><strong>ID:</strong> {$user->id}</p>";
            echo "<p><strong>Email:</strong> {$user->email}</p>";
            echo "</div>";
            
            // Test statistics with current user
            $stats = [
                'total_bookings' => $user->bookings()->count(),
                'active_bookings' => $user->bookings()->whereIn('status', ['confirmed', 'active', 'paid'])->count(),
                'completed_bookings' => $user->bookings()->where('status', 'completed')->count(),
                'total_purchases' => $user->purchases()->count(),
                'completed_purchases' => $user->purchases()->where('status', 'completed')->count(),
            ];
            
            echo "<div class='info'>";
            echo "<h2>📊 Dashboard Statistics for Current User</h2>";
            foreach ($stats as $key => $value) {
                echo "<p><strong>" . ucfirst(str_replace('_', ' ', $key)) . ":</strong> {$value}</p>";
            }
            echo "</div>";
            
            // Show bookings details
            $bookings = $user->bookings()->get();
            echo "<div class='info'>";
            echo "<h2>📋 Bookings Details</h2>";
            if ($bookings->count() > 0) {
                foreach ($bookings as $booking) {
                    echo "<p>• Booking {$booking->booking_reference}: Status = {$booking->status}, Amount = \${$booking->total_amount}</p>";
                }
            } else {
                echo "<p>No bookings found for this user.</p>";
            }
            echo "</div>";
            
            // Show purchases details
            $purchases = $user->purchases()->get();
            echo "<div class='info'>";
            echo "<h2>🛒 Purchases Details</h2>";
            if ($purchases->count() > 0) {
                foreach ($purchases as $purchase) {
                    echo "<p>• Purchase {$purchase->purchase_reference}: Status = {$purchase->status}, Amount = \${$purchase->total_amount}</p>";
                }
            } else {
                echo "<p>No purchases found for this user.</p>";
            }
            echo "</div>";
            
        } else {
            echo "<div class='error'>";
            echo "<h2>❌ No Authenticated User</h2>";
            echo "<p>You are not logged in. Please <a href='/login'>login</a> first.</p>";
            echo "</div>";
        }
        
        // Show all users with bookings for reference
        echo "<div class='info'>";
        echo "<h2>👥 All Users with Bookings (for reference)</h2>";
        $users = \App\Models\User::whereHas('bookings')->with('bookings')->get();
        foreach ($users as $u) {
            echo "<p>• User {$u->id} ({$u->name}, {$u->email}): {$u->bookings->count()} bookings</p>";
            foreach ($u->bookings as $booking) {
                echo "<p>&nbsp;&nbsp;&nbsp;- {$booking->booking_reference}: {$booking->status}</p>";
            }
        }
        echo "</div>";
        
    } catch (Exception $e) {
        echo "<div class='error'>";
        echo "<h2>❌ Error</h2>";
        echo "<p>" . $e->getMessage() . "</p>";
        echo "<p>File: " . $e->getFile() . ":" . $e->getLine() . "</p>";
        echo "</div>";
    }
    ?>
    
    <div class="info">
        <h2>🔧 Next Steps</h2>
        <p>If you're not logged in as the user with bookings (User 5 - Fitsum Gashaw), please:</p>
        <ol>
            <li>Go to <a href="/login">/login</a></li>
            <li>Login with: <strong>fitsumgashaw11@gmail.com</strong> / <strong>password123</strong></li>
            <li>Then check the dashboard again</li>
        </ol>
    </div>
</body>
</html>