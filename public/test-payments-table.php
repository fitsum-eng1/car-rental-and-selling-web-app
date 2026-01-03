<?php
require_once __DIR__ . '/../vendor/autoload.php';

$app = require_once __DIR__ . '/../bootstrap/app.php';
$app->make(Illuminate\Contracts\Console\Kernel::class)->bootstrap();

use Illuminate\Support\Facades\Schema;
use Illuminate\Support\Facades\DB;

echo "<h2>Payments Table Structure</h2>";

try {
    if (Schema::hasTable('payments')) {
        echo "<p>✅ Payments table exists</p>";
        
        $columns = Schema::getColumnListing('payments');
        echo "<h3>Columns:</h3><ul>";
        foreach ($columns as $column) {
            echo "<li>$column</li>";
        }
        echo "</ul>";
        
        // Check payment_method enum values
        $result = DB::select("SHOW COLUMNS FROM payments WHERE Field = 'payment_method'");
        if (!empty($result)) {
            echo "<h3>Payment Method Enum Values:</h3>";
            echo "<pre>" . $result[0]->Type . "</pre>";
        }
        
    } else {
        echo "<p>❌ Payments table does not exist</p>";
    }
} catch (Exception $e) {
    echo "<p>Error: " . $e->getMessage() . "</p>";
}