<?php
echo "SIMPLE PHP TEST - WORKING!<br>";
echo "Time: " . date('Y-m-d H:i:s') . "<br>";
echo "PHP Version: " . PHP_VERSION . "<br>";
echo "<hr>";
echo "<h2>Testing Database Connection</h2>";

try {
    $pdo = new PDO('mysql:host=127.0.0.1;dbname=rental_project', 'root', '');
    echo "✅ Database Connected!<br>";
    
    $stmt = $pdo->query('SELECT COUNT(*) as count FROM vehicles');
    $result = $stmt->fetch(PDO::FETCH_ASSOC);
    echo "✅ Vehicles: " . $result['count'] . "<br>";
    
} catch (Exception $e) {
    echo "❌ Database Error: " . $e->getMessage() . "<br>";
}

echo "<hr>";
echo "<h2>Navigation</h2>";
echo "<a href='debug.php'>Debug Page</a><br>";
echo "<a href='test.php'>Test Page</a><br>";
echo "<a href='index.php'>Laravel App</a><br>";
?>