<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="utf-8">
    <meta name="viewport" content="width=device-width, initial-scale=1">
    <title>Test Login - Car Rental System</title>
    <script src="https://cdn.tailwindcss.com"></script>
</head>
<body class="bg-gray-50">
    <div class="max-w-4xl mx-auto py-8 px-4">
        <h1 class="text-3xl font-bold text-gray-900 mb-8">🔐 Test Login Credentials</h1>
        
        <?php
        try {
            require_once __DIR__ . '/../vendor/autoload.php';
            $app = require_once __DIR__ . '/../bootstrap/app.php';
            $kernel = $app->make(\Illuminate\Contracts\Console\Kernel::class);
            $kernel->bootstrap();
            
            echo "<div class='bg-white rounded-lg shadow-md p-6 mb-6'>";
            echo "<h2 class='text-xl font-bold mb-4'>👥 Available Test Accounts</h2>";
            
            $users = \App\Models\User::with('role')->get();
            
            foreach ($users as $user) {
                $roleColor = match($user->role->name) {
                    'super_admin' => 'bg-red-100 text-red-800',
                    'admin' => 'bg-yellow-100 text-yellow-800',
                    'customer' => 'bg-green-100 text-green-800',
                    default => 'bg-gray-100 text-gray-800'
                };
                
                echo "<div class='border rounded-lg p-4 mb-4'>";
                echo "<div class='flex justify-between items-start'>";
                echo "<div>";
                echo "<h3 class='text-lg font-semibold'>{$user->name}</h3>";
                echo "<p class='text-gray-600'>📧 {$user->email}</p>";
                echo "<p class='text-gray-600'>📱 {$user->phone}</p>";
                echo "<p class='text-sm text-gray-500 mt-2'>🔑 Password: <code class='bg-gray-100 px-2 py-1 rounded'>password123</code></p>";
                echo "</div>";
                echo "<span class='px-3 py-1 rounded-full text-sm font-medium {$roleColor}'>" . ucfirst(str_replace('_', ' ', $user->role->name)) . "</span>";
                echo "</div>";
                echo "</div>";
            }
            
            echo "</div>";
            
        } catch (Exception $e) {
            echo "<div class='bg-red-100 border border-red-400 text-red-700 px-4 py-3 rounded mb-6'>";
            echo "<h2 class='text-xl font-bold mb-2'>❌ Error</h2>";
            echo "<p>Could not load user data: " . $e->getMessage() . "</p>";
            echo "</div>";
        }
        ?>
        
        <!-- Quick Login Links -->
        <div class="bg-white rounded-lg shadow-md p-6 mb-6">
            <h2 class="text-xl font-bold mb-4">🚀 Quick Login</h2>
            <p class="text-gray-600 mb-4">Click the buttons below to go directly to the login page:</p>
            
            <div class="grid grid-cols-1 md:grid-cols-3 gap-4">
                <a href="/login" class="bg-red-600 text-white px-6 py-3 rounded-lg text-center hover:bg-red-700 transition-colors">
                    🔴 Login as Super Admin
                    <div class="text-sm opacity-75">superadmin@rental.com</div>
                </a>
                <a href="/login" class="bg-yellow-600 text-white px-6 py-3 rounded-lg text-center hover:bg-yellow-700 transition-colors">
                    🟡 Login as Admin
                    <div class="text-sm opacity-75">admin@rental.com</div>
                </a>
                <a href="/login" class="bg-green-600 text-white px-6 py-3 rounded-lg text-center hover:bg-green-700 transition-colors">
                    🟢 Login as Customer
                    <div class="text-sm opacity-75">customer@test.com</div>
                </a>
            </div>
            
            <div class="mt-4 p-4 bg-blue-50 rounded-lg">
                <p class="text-blue-800 text-sm">
                    <strong>💡 Tip:</strong> All accounts use the same password: <code class="bg-blue-100 px-2 py-1 rounded">password123</code>
                </p>
            </div>
        </div>
        
        <!-- Navigation -->
        <div class="bg-white rounded-lg shadow-md p-6">
            <h2 class="text-xl font-bold mb-4">🔗 Navigation</h2>
            <div class="grid grid-cols-2 md:grid-cols-4 gap-4">
                <a href="/" class="bg-blue-600 text-white px-4 py-2 rounded text-center hover:bg-blue-700 transition-colors">
                    🏠 Home
                </a>
                <a href="/login" class="bg-gray-600 text-white px-4 py-2 rounded text-center hover:bg-gray-700 transition-colors">
                    🔐 Login
                </a>
                <a href="/register" class="bg-purple-600 text-white px-4 py-2 rounded text-center hover:bg-purple-700 transition-colors">
                    📝 Register
                </a>
                <a href="/rent" class="bg-green-600 text-white px-4 py-2 rounded text-center hover:bg-green-700 transition-colors">
                    🚗 Rent Cars
                </a>
            </div>
        </div>
    </div>
</body>
</html>