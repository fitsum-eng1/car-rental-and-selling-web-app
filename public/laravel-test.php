<?php
// Enable error reporting
error_reporting(E_ALL);
ini_set('display_errors', 1);

echo "<h1>🔧 Laravel Direct Test</h1>";

try {
    // Load Laravel properly
    require_once __DIR__ . '/../vendor/autoload.php';
    echo "<p>✅ Autoloader loaded</p>";
    
    $app = require_once __DIR__ . '/../bootstrap/app.php';
    echo "<p>✅ Laravel app loaded</p>";
    
    // Bootstrap the application properly
    $app->make(\Illuminate\Contracts\Console\Kernel::class)->bootstrap();
    echo "<p>✅ Laravel bootstrapped</p>";
    
    // Test database through Laravel
    $vehicleCount = \App\Models\Vehicle::count();
    echo "<p>✅ Vehicle count via Laravel: {$vehicleCount}</p>";
    
    $userCount = \App\Models\User::count();
    echo "<p>✅ User count via Laravel: {$userCount}</p>";
    
    echo "<hr>";
    echo "<h2>🎯 Testing Routes</h2>";
    
    // Create a request to test the home route
    $request = \Illuminate\Http\Request::create('/', 'GET');
    
    try {
        $response = $app->handle($request);
        echo "<p>✅ Home route responds with status: " . $response->getStatusCode() . "</p>";
        
        if ($response->getStatusCode() === 200) {
            $content = $response->getContent();
            if (strlen($content) > 100) {
                echo "<p>✅ Response has content (" . strlen($content) . " characters)</p>";
                echo "<p>✅ First 200 characters: " . htmlspecialchars(substr($content, 0, 200)) . "...</p>";
            } else {
                echo "<p>❌ Response is too short: " . htmlspecialchars($content) . "</p>";
            }
        }
        
    } catch (Exception $e) {
        echo "<p>❌ Route error: " . $e->getMessage() . "</p>";
        echo "<p>❌ File: " . $e->getFile() . " Line: " . $e->getLine() . "</p>";
    }
    
} catch (Exception $e) {
    echo "<p>❌ Laravel loading error: " . $e->getMessage() . "</p>";
    echo "<p>❌ File: " . $e->getFile() . " Line: " . $e->getLine() . "</p>";
    echo "<pre>" . $e->getTraceAsString() . "</pre>";
}

echo "<hr>";
echo "<h2>🌐 Access Links</h2>";
echo "<p><a href='simple-test.php'>Simple Test</a></p>";
echo "<p><a href='debug.php'>Debug Info</a></p>";
echo "<p><a href='index.php'>Laravel Index</a></p>";
echo "<p><a href='/rental-project/public/'>Laravel Home</a></p>";
?>