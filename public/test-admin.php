<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="utf-8">
    <meta name="viewport" content="width=device-width, initial-scale=1">
    <title>Test Admin Access - Car Rental System</title>
    <script src="https://cdn.tailwindcss.com"></script>
</head>
<body class="bg-gray-50">
    <div class="max-w-4xl mx-auto py-8 px-4">
        <h1 class="text-3xl font-bold text-gray-900 mb-8">🔧 Admin Access Test</h1>
        
        <?php
        try {
            require_once __DIR__ . '/../vendor/autoload.php';
            $app = require_once __DIR__ . '/../bootstrap/app.php';
            $kernel = $app->make(\Illuminate\Contracts\Console\Kernel::class);
            $kernel->bootstrap();
            
            echo "<div class='bg-white rounded-lg shadow-md p-6 mb-6'>";
            echo "<h2 class='text-xl font-bold mb-4'>🔐 Admin Route Test</h2>";
            
            // Test if admin middleware exists
            $middlewareExists = class_exists('App\Http\Middleware\AdminMiddleware');
            echo "<p class='" . ($middlewareExists ? 'text-green-600' : 'text-red-600') . "'>";
            echo ($middlewareExists ? '✅' : '❌') . " AdminMiddleware: " . ($middlewareExists ? 'Exists' : 'Missing');
            echo "</p>";
            
            // Test if admin controller exists
            $controllerExists = class_exists('App\Http\Controllers\Admin\AdminController');
            echo "<p class='" . ($controllerExists ? 'text-green-600' : 'text-red-600') . "'>";
            echo ($controllerExists ? '✅' : '❌') . " AdminController: " . ($controllerExists ? 'Exists' : 'Missing');
            echo "</p>";
            
            // Test admin users
            $adminUsers = \App\Models\User::whereHas('role', function($query) {
                $query->whereIn('name', ['admin', 'super_admin']);
            })->get();
            
            echo "<p class='text-blue-600'>👥 Admin Users Found: " . $adminUsers->count() . "</p>";
            
            foreach ($adminUsers as $user) {
                echo "<div class='ml-4 mt-2 p-2 bg-gray-50 rounded'>";
                echo "<p><strong>Name:</strong> {$user->name}</p>";
                echo "<p><strong>Email:</strong> {$user->email}</p>";
                echo "<p><strong>Role:</strong> {$user->role->name}</p>";
                echo "<p><strong>Can Access Admin:</strong> " . ($user->isAdmin() ? 'Yes' : 'No') . "</p>";
                echo "</div>";
            }
            
            echo "</div>";
            
            // Test route
            echo "<div class='bg-white rounded-lg shadow-md p-6 mb-6'>";
            echo "<h2 class='text-xl font-bold mb-4'>🛣️ Route Test</h2>";
            
            try {
                $routes = \Illuminate\Support\Facades\Route::getRoutes();
                $adminRoutes = [];
                
                foreach ($routes as $route) {
                    if (str_contains($route->uri(), 'admin')) {
                        $adminRoutes[] = $route->uri();
                    }
                }
                
                echo "<p class='text-green-600'>✅ Admin Routes Found: " . count($adminRoutes) . "</p>";
                echo "<div class='mt-2'>";
                foreach (array_slice($adminRoutes, 0, 5) as $route) {
                    echo "<p class='text-sm text-gray-600'>• {$route}</p>";
                }
                if (count($adminRoutes) > 5) {
                    echo "<p class='text-sm text-gray-500'>... and " . (count($adminRoutes) - 5) . " more</p>";
                }
                echo "</div>";
                
            } catch (Exception $e) {
                echo "<p class='text-red-600'>❌ Route test failed: " . $e->getMessage() . "</p>";
            }
            
            echo "</div>";
            
        } catch (Exception $e) {
            echo "<div class='bg-red-100 border border-red-400 text-red-700 px-4 py-3 rounded mb-6'>";
            echo "<h2 class='text-xl font-bold mb-2'>❌ Error</h2>";
            echo "<p><strong>Message:</strong> " . $e->getMessage() . "</p>";
            echo "<p><strong>File:</strong> " . $e->getFile() . "</p>";
            echo "<p><strong>Line:</strong> " . $e->getLine() . "</p>";
            echo "</div>";
        }
        ?>
        
        <!-- Login Instructions -->
        <div class="bg-white rounded-lg shadow-md p-6 mb-6">
            <h2 class="text-xl font-bold mb-4">🚀 How to Access Admin Panel</h2>
            
            <div class="space-y-4">
                <div class="p-4 bg-blue-50 rounded-lg">
                    <h3 class="font-semibold text-blue-800">Step 1: Login as Admin</h3>
                    <p class="text-blue-700">Go to <a href="/login" class="underline">/login</a> and use:</p>
                    <ul class="mt-2 text-sm text-blue-600">
                        <li>• <strong>Super Admin:</strong> superadmin@rental.com / password123</li>
                        <li>• <strong>Admin:</strong> admin@rental.com / password123</li>
                    </ul>
                </div>
                
                <div class="p-4 bg-green-50 rounded-lg">
                    <h3 class="font-semibold text-green-800">Step 2: Access Admin Dashboard</h3>
                    <p class="text-green-700">After login, go to <a href="/admin" class="underline">/admin</a></p>
                </div>
            </div>
        </div>
        
        <!-- Quick Links -->
        <div class="bg-white rounded-lg shadow-md p-6">
            <h2 class="text-xl font-bold mb-4">🔗 Quick Links</h2>
            <div class="grid grid-cols-2 md:grid-cols-4 gap-4">
                <a href="/" class="bg-blue-600 text-white px-4 py-2 rounded text-center hover:bg-blue-700 transition-colors">
                    🏠 Home
                </a>
                <a href="/login" class="bg-gray-600 text-white px-4 py-2 rounded text-center hover:bg-gray-700 transition-colors">
                    🔐 Login
                </a>
                <a href="/admin" class="bg-red-600 text-white px-4 py-2 rounded text-center hover:bg-red-700 transition-colors">
                    👑 Admin Panel
                </a>
                <a href="test-login.php" class="bg-green-600 text-white px-4 py-2 rounded text-center hover:bg-green-700 transition-colors">
                    🧪 Test Login
                </a>
            </div>
        </div>
    </div>
</body>
</html>