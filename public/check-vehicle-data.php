<?php
require_once __DIR__ . '/../vendor/autoload.php';

$app = require_once __DIR__ . '/../bootstrap/app.php';
$app->make(Illuminate\Contracts\Console\Kernel::class)->bootstrap();

use App\Models\Vehicle;

echo "<h2>Vehicle Data Check</h2>";

$vehicles = Vehicle::all();
echo "<p>Total vehicles: " . $vehicles->count() . "</p>";

foreach ($vehicles as $vehicle) {
    echo "<div style='border: 1px solid #ccc; margin: 10px; padding: 10px;'>";
    echo "<h3>{$vehicle->full_name}</h3>";
    echo "<p>ID: {$vehicle->id}</p>";
    echo "<p>Status: {$vehicle->status}</p>";
    echo "<p>Sale Price: $" . number_format($vehicle->sale_price ?? 0, 2) . "</p>";
    echo "<p>Rental Price: $" . number_format($vehicle->rental_price_per_day ?? 0, 2) . "/day</p>";
    echo "</div>";
}