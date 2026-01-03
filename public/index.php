<?php

use Illuminate\Foundation\Application;
use Illuminate\Http\Request;

define('LARAVEL_START', microtime(true));

// Determine if the application is in maintenance mode...
if (file_exists($maintenance = __DIR__.'/../storage/framework/maintenance.php')) {
    require $maintenance;
}

// Register the Composer autoloader...
require __DIR__.'/../vendor/autoload.php';

// Bootstrap Laravel and handle the request...
try {
    /** @var Application $app */
    $app = require_once __DIR__.'/../bootstrap/app.php';
    
    // Bootstrap the application properly
    $app->make(\Illuminate\Contracts\Console\Kernel::class)->bootstrap();
    
    $response = $app->handleRequest(Request::capture());
    
    // Send the response properly
    if ($response) {
        $response->send();
    }
    
} catch (Exception $e) {
    // If there's an error, show it
    echo "<h1>Laravel Error</h1>";
    echo "<p><strong>Error:</strong> " . $e->getMessage() . "</p>";
    echo "<p><strong>File:</strong> " . $e->getFile() . "</p>";
    echo "<p><strong>Line:</strong> " . $e->getLine() . "</p>";
    echo "<hr>";
    echo "<p><a href='simple-test.php'>Simple Test</a> | <a href='laravel-test.php'>Laravel Test</a></p>";
}
