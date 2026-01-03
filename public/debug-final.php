<?php
echo "<h1>🔧 Final Debug Test</h1>";
echo "<p><strong>Time:</strong> " . date('Y-m-d H:i:s') . "</p>";

// Test if Laravel can be loaded
try {
    require_once __DIR__ . '/../vendor/autoload.php';
    echo "<p>✅ Composer autoload: OK</p>";
    
    $app = require_once __DIR__ . '/../bootstrap/app.php';
    echo "<p>✅ Laravel bootstrap: OK</p>";
    
    // Test database connection
    $app->make(\Illuminate\Contracts\Console\Kernel::class)->bootstrap();
    echo "<p>✅ Laravel kernel bootstrap: OK</p>";
    
    // Test if we can access the home route
    $request = \Illuminate\Http\Request::create('/', 'GET');
    $response = $app->handle($request);
    
    echo "<p>✅ Laravel application: OK</p>";
    echo "<p><strong>Response Status:</strong> " . $response->getStatusCode() . "</p>";
    echo "<p><strong>Response Size:</strong> " . strlen($response->getContent()) . " characters</p>";
    
    // Check if CSS files exist
    $cssFiles = [
        'build/assets/app-CBPnCLyN.css',
        'build/assets/app-DmuyVQv5.css',
        'build/assets/app-CFdEZBK1.js'
    ];
    
    echo "<h3>Asset Files Check:</h3>";
    foreach ($cssFiles as $file) {
        $path = __DIR__ . '/' . $file;
        if (file_exists($path)) {
            echo "<p>✅ {$file}: " . number_format(filesize($path)) . " bytes</p>";
        } else {
            echo "<p>❌ {$file}: NOT FOUND</p>";
        }
    }
    
} catch (Exception $e) {
    echo "<p>❌ Error: " . $e->getMessage() . "</p>";
    echo "<p><strong>File:</strong> " . $e->getFile() . "</p>";
    echo "<p><strong>Line:</strong> " . $e->getLine() . "</p>";
}

echo "<hr>";
echo "<h3>Navigation Links:</h3>";
echo "<p><a href='/rental-project/public/'>🏠 Laravel Home</a></p>";
echo "<p><a href='working-app.php'>✅ Working App Demo</a></p>";
echo "<p><a href='css-test.php'>🎨 CSS Test</a></p>";
echo "<p><a href='simple-test.php'>🧪 Simple Test</a></p>";
?>

<style>
body { font-family: Arial, sans-serif; margin: 2rem; background: #f5f5f5; }
h1 { color: #2563eb; }
p { margin: 0.5rem 0; }
a { color: #2563eb; text-decoration: none; }
a:hover { text-decoration: underline; }
</style>