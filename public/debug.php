<?php
// Enable error reporting
error_reporting(E_ALL);
ini_set('display_errors', 1);

echo "=== PHP DEBUG INFORMATION ===<br><br>";

echo "<strong>1. PHP Version:</strong> " . PHP_VERSION . "<br>";
echo "<strong>2. Current Time:</strong> " . date('Y-m-d H:i:s') . "<br>";
echo "<strong>3. Current Directory:</strong> " . __DIR__ . "<br>";
echo "<strong>4. Document Root:</strong> " . $_SERVER['DOCUMENT_ROOT'] . "<br>";
echo "<strong>5. Script Name:</strong> " . $_SERVER['SCRIPT_NAME'] . "<br>";
echo "<strong>6. Request URI:</strong> " . $_SERVER['REQUEST_URI'] . "<br>";

echo "<br>=== TESTING BASIC FUNCTIONALITY ===<br><br>";

// Test basic PHP
echo "<strong>✅ PHP is working!</strong><br>";

// Test file system
if (is_readable(__DIR__ . '/../vendor/autoload.php')) {
    echo "<strong>✅ Vendor directory is accessible</strong><br>";
} else {
    echo "<strong>❌ Vendor directory is NOT accessible</strong><br>";
}

if (is_readable(__DIR__ . '/../.env')) {
    echo "<strong>✅ .env file is accessible</strong><br>";
} else {
    echo "<strong>❌ .env file is NOT accessible</strong><br>";
}

// Test database connection
echo "<br><strong>Testing Database Connection:</strong><br>";
try {
    $pdo = new PDO('mysql:host=127.0.0.1;dbname=rental_project', 'root', '');
    echo "✅ Database connection successful!<br>";
    
    $stmt = $pdo->query('SELECT COUNT(*) as count FROM vehicles');
    $result = $stmt->fetch(PDO::FETCH_ASSOC);
    echo "✅ Vehicles in database: " . $result['count'] . "<br>";
    
} catch (Exception $e) {
    echo "❌ Database error: " . $e->getMessage() . "<br>";
}

echo "<br>=== TESTING LARAVEL ===<br><br>";

// Test Laravel loading
try {
    require_once __DIR__ . '/../vendor/autoload.php';
    echo "✅ Composer autoloader loaded<br>";
    
    $app = require_once __DIR__ . '/../bootstrap/app.php';
    echo "✅ Laravel application loaded<br>";
    
    // Test if we can access Laravel classes
    if (class_exists('Illuminate\Foundation\Application')) {
        echo "✅ Laravel classes are available<br>";
    } else {
        echo "❌ Laravel classes are NOT available<br>";
    }
    
} catch (Exception $e) {
    echo "❌ Laravel loading error: " . $e->getMessage() . "<br>";
    echo "❌ Stack trace: " . $e->getTraceAsString() . "<br>";
}

echo "<br>=== NAVIGATION LINKS ===<br><br>";
echo "<a href='/rental-project/public/test.php' style='color: blue;'>🧪 Test Page</a><br>";
echo "<a href='/rental-project/public/index.php' style='color: green;'>🏠 Laravel Home (index.php)</a><br>";
echo "<a href='/rental-project/public/' style='color: orange;'>🏠 Laravel Home (directory)</a><br>";

echo "<br>=== SERVER INFORMATION ===<br><br>";
echo "<strong>Server Software:</strong> " . $_SERVER['SERVER_SOFTWARE'] . "<br>";
echo "<strong>Server Name:</strong> " . $_SERVER['SERVER_NAME'] . "<br>";
echo "<strong>Server Port:</strong> " . $_SERVER['SERVER_PORT'] . "<br>";

phpinfo();
?>