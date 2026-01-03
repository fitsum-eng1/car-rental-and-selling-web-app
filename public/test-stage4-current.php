<?php
// Test current Stage 4 Payment Method functionality
require_once __DIR__ . '/../vendor/autoload.php';

// Load Laravel
$app = require_once __DIR__ . '/../bootstrap/app.php';
$kernel = $app->make(Illuminate\Contracts\Http\Kernel::class);

// Create a test request
$request = Illuminate\Http\Request::create('/test-stage4-current', 'GET');
$response = $kernel->handle($request);

// Start session
session_start();

echo "<!DOCTYPE html>
<html lang='en'>
<head>
    <meta charset='UTF-8'>
    <meta name='viewport' content='width=device-width, initial-scale=1.0'>
    <title>Stage 4 Payment Method - Current Issues Analysis</title>
    <script src='https://cdn.tailwindcss.com'></script>
</head>
<body class='bg-gray-100'>
    <div class='max-w-6xl mx-auto py-8 px-4'>
        <h1 class='text-3xl font-bold text-gray-900 mb-8'>🔍 Stage 4 Payment Method - Current Issues Analysis</h1>";

// Test database connection
try {
    $pdo = new PDO(
        'mysql:host=' . ($_ENV['DB_HOST'] ?? 'localhost') . ';dbname=' . ($_ENV['DB_DATABASE'] ?? 'vehicle_rental'),
        $_ENV['DB_USERNAME'] ?? 'root',
        $_ENV['DB_PASSWORD'] ?? '',
        [PDO::ATTR_ERRMODE => PDO::ERRMODE_EXCEPTION]
    );
    
    echo "<div class='bg-green-50 border border-green-200 rounded-lg p-4 mb-6'>
            <h2 class='text-lg font-bold text-green-800 mb-2'>✅ Database Connection</h2>
            <p class='text-green-700'>Successfully connected to database</p>
          </div>";
    
    // Get a sample vehicle for testing
    $stmt = $pdo->query("SELECT * FROM vehicles WHERE status = 'available' LIMIT 1");
    $vehicle = $stmt->fetch(PDO::FETCH_ASSOC);
    
    if ($vehicle) {
        echo "<div class='bg-blue-50 border border-blue-200 rounded-lg p-4 mb-6'>
                <h2 class='text-lg font-bold text-blue-800 mb-2'>🚗 Sample Vehicle Data</h2>
                <div class='grid grid-cols-2 gap-4 text-sm'>
                    <div><strong>Name:</strong> {$vehicle['name']}</div>
                    <div><strong>Price:</strong> $" . number_format($vehicle['sale_price'], 2) . "</div>
                    <div><strong>Type:</strong> {$vehicle['type']}</div>
                    <div><strong>Year:</strong> {$vehicle['year']}</div>
                </div>
              </div>";
        
        // Simulate checkout session
        $_SESSION['checkout'] = [
            'vehicle_id' => $vehicle['id'],
            'stage' => 4,
            'buyer_info' => [
                'full_name' => 'Test User',
                'email' => 'test@example.com',
                'phone' => '+251911234567'
            ],
            'delivery_info' => [
                'delivery_method' => 'pickup',
                'delivery_cost' => 0
            ]
        ];
        
        echo "<div class='bg-yellow-50 border border-yellow-200 rounded-lg p-4 mb-6'>
                <h2 class='text-lg font-bold text-yellow-800 mb-2'>⚙️ Simulated Checkout Session</h2>
                <pre class='text-xs text-yellow-700 bg-yellow-100 p-2 rounded'>" . 
                json_encode($_SESSION['checkout'], JSON_PRETTY_PRINT) . "</pre>
              </div>";
    }
    
    // Test current issues with Stage 4
    echo "<div class='bg-red-50 border border-red-200 rounded-lg p-6 mb-6'>
            <h2 class='text-xl font-bold text-red-800 mb-4'>❌ Identified Issues with Current Stage 4</h2>
            <div class='space-y-4'>
                <div class='bg-white p-4 rounded border-l-4 border-red-500'>
                    <h3 class='font-bold text-red-700 mb-2'>1. UI/UX Issues</h3>
                    <ul class='text-red-600 text-sm space-y-1 ml-4'>
                        <li>• Payment options are not clearly differentiated</li>
                        <li>• No clear indication of processing times</li>
                        <li>• Missing payment method descriptions</li>
                        <li>• Terms checkbox is not prominent enough</li>
                        <li>• No payment security badges or trust indicators</li>
                    </ul>
                </div>
                
                <div class='bg-white p-4 rounded border-l-4 border-orange-500'>
                    <h3 class='font-bold text-orange-700 mb-2'>2. Functionality Issues</h3>
                    <ul class='text-orange-600 text-sm space-y-1 ml-4'>
                        <li>• No validation feedback for payment method selection</li>
                        <li>• Missing payment method specific instructions</li>
                        <li>• No clear next steps after selection</li>
                        <li>• Terms modal content is too generic</li>
                        <li>• No payment amount confirmation</li>
                    </ul>
                </div>
                
                <div class='bg-white p-4 rounded border-l-4 border-purple-500'>
                    <h3 class='font-bold text-purple-700 mb-2'>3. Missing Features</h3>
                    <ul class='text-purple-600 text-sm space-y-1 ml-4'>
                        <li>• No payment method recommendations</li>
                        <li>• Missing bank account details preview</li>
                        <li>• No estimated processing time display</li>
                        <li>• Missing payment security information</li>
                        <li>• No payment method help/FAQ</li>
                    </ul>
                </div>
            </div>
          </div>";
    
    // Proposed improvements
    echo "<div class='bg-green-50 border border-green-200 rounded-lg p-6 mb-6'>
            <h2 class='text-xl font-bold text-green-800 mb-4'>✅ Proposed Improvements</h2>
            <div class='grid grid-cols-1 md:grid-cols-2 gap-6'>
                <div class='bg-white p-4 rounded-lg shadow'>
                    <h3 class='font-bold text-green-700 mb-3'>🎨 UI Enhancements</h3>
                    <ul class='text-green-600 text-sm space-y-2'>
                        <li>✓ Better visual hierarchy for payment options</li>
                        <li>✓ Clear processing time indicators</li>
                        <li>✓ Enhanced payment method cards with icons</li>
                        <li>✓ Prominent security badges</li>
                        <li>✓ Better mobile responsiveness</li>
                    </ul>
                </div>
                
                <div class='bg-white p-4 rounded-lg shadow'>
                    <h3 class='font-bold text-blue-700 mb-3'>⚙️ Functionality Improvements</h3>
                    <ul class='text-blue-600 text-sm space-y-2'>
                        <li>✓ Real-time validation feedback</li>
                        <li>✓ Payment method specific instructions</li>
                        <li>✓ Enhanced terms and conditions</li>
                        <li>✓ Payment confirmation summary</li>
                        <li>✓ Better error handling</li>
                    </ul>
                </div>
            </div>
          </div>";
    
    // Test payment methods
    $paymentMethods = [
        'cbe_mobile' => 'Commercial Bank of Ethiopia - Mobile Banking',
        'telebirr' => 'Telebirr - Mobile Payment',
        'abyssinia_mobile' => 'Bank of Abyssinia - Mobile Banking',
        'dashen_mobile' => 'Dashen Bank - Mobile Banking',
        'cbe_transfer' => 'CBE - Bank Transfer',
        'abyssinia_transfer' => 'Abyssinia - Bank Transfer',
        'dashen_transfer' => 'Dashen - Bank Transfer'
    ];
    
    echo "<div class='bg-blue-50 border border-blue-200 rounded-lg p-6'>
            <h2 class='text-xl font-bold text-blue-800 mb-4'>💳 Available Payment Methods</h2>
            <div class='grid grid-cols-1 md:grid-cols-2 gap-4'>";
    
    foreach ($paymentMethods as $key => $name) {
        $type = strpos($key, 'mobile') !== false || $key === 'telebirr' ? 'Mobile/Digital' : 'Bank Transfer';
        $time = strpos($key, 'mobile') !== false || $key === 'telebirr' ? 'Instant' : '1-2 Business Days';
        
        echo "<div class='bg-white p-4 rounded-lg border'>
                <h3 class='font-bold text-gray-900'>{$name}</h3>
                <div class='text-sm text-gray-600 mt-2'>
                    <div>Type: {$type}</div>
                    <div>Processing: {$time}</div>
                </div>
              </div>";
    }
    
    echo "</div></div>";
    
} catch (Exception $e) {
    echo "<div class='bg-red-50 border border-red-200 rounded-lg p-4 mb-6'>
            <h2 class='text-lg font-bold text-red-800 mb-2'>❌ Database Connection Error</h2>
            <p class='text-red-700'>Error: " . htmlspecialchars($e->getMessage()) . "</p>
          </div>";
}

echo "    </div>
</body>
</html>";
?>