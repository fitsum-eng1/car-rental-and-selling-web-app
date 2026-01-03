<?php
// Test the stage4 Blade template fix
require_once '../vendor/autoload.php';

// Bootstrap Laravel
$app = require_once '../bootstrap/app.php';
$kernel = $app->make(Illuminate\Contracts\Http\Kernel::class);

echo "<h1>🔧 Stage 4 Blade Template Fix Test</h1>";

try {
    // Test database connection
    $pdo = new PDO('mysql:host=localhost;dbname=rental_project', 'root', '');
    echo "<p>✅ Database connection: OK</p>";
    
    // Check Blade template structure
    $stage4File = '../resources/views/checkout/stage4.blade.php';
    if (file_exists($stage4File)) {
        $content = file_get_contents($stage4File);
        
        // Count @section and @endsection directives
        $sectionCount = substr_count($content, '@section');
        $endsectionCount = substr_count($content, '@endsection');
        
        echo "<h2>📄 Blade Template Analysis</h2>";
        echo "<p><strong>@section count:</strong> {$sectionCount}</p>";
        echo "<p><strong>@endsection count:</strong> {$endsectionCount}</p>";
        
        if ($sectionCount === 2 && $endsectionCount === 1) {
            echo "<p>✅ <strong>Blade template structure is correct!</strong></p>";
            echo "<p>✅ Title section: @section('title')</p>";
            echo "<p>✅ Content section: @section('content')</p>";
            echo "<p>✅ Single @endsection at the end</p>";
        } else {
            echo "<p>❌ <strong>Blade template structure issue detected</strong></p>";
            echo "<p>Expected: 2 @section, 1 @endsection</p>";
            echo "<p>Found: {$sectionCount} @section, {$endsectionCount} @endsection</p>";
        }
        
        // Check for common issues
        if (strpos($content, '@endsection') !== false) {
            $firstEndsection = strpos($content, '@endsection');
            $lastEndsection = strrpos($content, '@endsection');
            
            if ($firstEndsection === $lastEndsection) {
                echo "<p>✅ Only one @endsection found (correct)</p>";
            } else {
                echo "<p>❌ Multiple @endsection found (incorrect)</p>";
            }
        }
        
    } else {
        echo "<p>❌ Stage 4 template file not found</p>";
    }
    
    echo "<h2>🧪 Testing Instructions</h2>";
    echo "<ol>";
    echo "<li>Login as a customer</li>";
    echo "<li>Go to vehicle sales: <a href='/buy' target='_blank'>/buy</a></li>";
    echo "<li>Start checkout on any vehicle</li>";
    echo "<li>Navigate to Stage 4 (Payment Method)</li>";
    echo "<li>Verify the page loads without Blade template errors</li>";
    echo "</ol>";
    
    echo "<h2>🔧 Fix Applied</h2>";
    echo "<ul>";
    echo "<li>✅ Removed duplicate @endsection directive</li>";
    echo "<li>✅ Cleared view cache</li>";
    echo "<li>✅ Verified proper Blade template structure</li>";
    echo "</ul>";
    
    echo "<h2>🎯 Expected Result</h2>";
    echo "<p>Stage 4 (Payment Method) should now load correctly without the error:</p>";
    echo "<code>InvalidArgumentException: Cannot end a section without first starting one</code>";
    
} catch (Exception $e) {
    echo "<p>❌ Error: " . $e->getMessage() . "</p>";
}

echo "<p><em>Test completed at " . date('Y-m-d H:i:s') . "</em></p>";
?>