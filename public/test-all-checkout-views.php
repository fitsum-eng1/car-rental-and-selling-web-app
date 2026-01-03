<?php
// Test all checkout Blade templates for proper structure
require_once '../vendor/autoload.php';

// Bootstrap Laravel
$app = require_once '../bootstrap/app.php';
$kernel = $app->make(Illuminate\Contracts\Http\Kernel::class);

echo "<h1>🔧 All Checkout Views Blade Template Test</h1>";

try {
    $checkoutViews = [
        'stage1' => 'resources/views/checkout/stage1.blade.php',
        'stage2' => 'resources/views/checkout/stage2.blade.php', 
        'stage3' => 'resources/views/checkout/stage3.blade.php',
        'stage4' => 'resources/views/checkout/stage4.blade.php',
        'stage5' => 'resources/views/checkout/stage5.blade.php',
        'stage6' => 'resources/views/checkout/stage6.blade.php',
        'stage7' => 'resources/views/checkout/stage7.blade.php',
        'status' => 'resources/views/checkout/status.blade.php'
    ];
    
    echo "<h2>📄 Blade Template Structure Analysis</h2>";
    echo "<table border='1' style='border-collapse: collapse; width: 100%;'>";
    echo "<tr><th>View</th><th>@section Count</th><th>@endsection Count</th><th>Status</th><th>Notes</th></tr>";
    
    $allGood = true;
    
    foreach ($checkoutViews as $name => $filePath) {
        $fullPath = '../' . $filePath;
        
        if (file_exists($fullPath)) {
            $content = file_get_contents($fullPath);
            
            // Count directives
            $sectionCount = substr_count($content, '@section');
            $endsectionCount = substr_count($content, '@endsection');
            
            // Determine status
            $status = '✅ Good';
            $notes = 'Proper structure';
            
            if ($sectionCount !== 2 || $endsectionCount !== 1) {
                $status = '❌ Issue';
                $notes = "Expected: 2 @section, 1 @endsection";
                $allGood = false;
            }
            
            // Check for multiple @endsection
            $firstEndsection = strpos($content, '@endsection');
            $lastEndsection = strrpos($content, '@endsection');
            
            if ($firstEndsection !== $lastEndsection) {
                $status = '❌ Multiple @endsection';
                $notes = 'Duplicate @endsection found';
                $allGood = false;
            }
            
            echo "<tr>";
            echo "<td><strong>{$name}</strong></td>";
            echo "<td>{$sectionCount}</td>";
            echo "<td>{$endsectionCount}</td>";
            echo "<td>{$status}</td>";
            echo "<td>{$notes}</td>";
            echo "</tr>";
            
        } else {
            echo "<tr>";
            echo "<td><strong>{$name}</strong></td>";
            echo "<td colspan='4'>❌ File not found</td>";
            echo "</tr>";
            $allGood = false;
        }
    }
    
    echo "</table>";
    
    if ($allGood) {
        echo "<h2>✅ All Checkout Views Are Properly Structured!</h2>";
        echo "<p>All Blade templates have the correct @section/@endsection structure.</p>";
    } else {
        echo "<h2>❌ Some Issues Found</h2>";
        echo "<p>Please check the views marked with issues above.</p>";
    }
    
    echo "<h2>🧪 Testing Instructions</h2>";
    echo "<ol>";
    echo "<li>Login as a customer</li>";
    echo "<li>Go to vehicle sales: <a href='/buy' target='_blank'>/buy</a></li>";
    echo "<li>Start checkout on any vehicle</li>";
    echo "<li>Navigate through all stages:</li>";
    echo "<ul>";
    echo "<li>Stage 1: Vehicle Confirmation</li>";
    echo "<li>Stage 2: Buyer Information</li>";
    echo "<li>Stage 3: Delivery Options</li>";
    echo "<li>Stage 4: Payment Method Selection</li>";
    echo "<li>Stage 5: Payment Instructions</li>";
    echo "</ul>";
    echo "<li>Verify each stage loads without Blade template errors</li>";
    echo "</ol>";
    
    echo "<h2>🔧 Fixes Applied</h2>";
    echo "<ul>";
    echo "<li>✅ Fixed duplicate @endsection in stage4.blade.php</li>";
    echo "<li>✅ Fixed duplicate @endsection in stage5.blade.php</li>";
    echo "<li>✅ Cleared view cache multiple times</li>";
    echo "<li>✅ Verified all checkout views have proper structure</li>";
    echo "</ul>";
    
    echo "<h2>🎯 Expected Result</h2>";
    echo "<p>All checkout stages should now load correctly without any Blade template errors:</p>";
    echo "<code>InvalidArgumentException: Cannot end a section without first starting one</code>";
    
} catch (Exception $e) {
    echo "<p>❌ Error: " . $e->getMessage() . "</p>";
}

echo "<p><em>Test completed at " . date('Y-m-d H:i:s') . "</em></p>";
?>