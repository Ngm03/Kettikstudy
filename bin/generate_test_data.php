<?php
// Test Data Generator for Analytics
require_once __DIR__ . '/../vendor/autoload.php';

use App\Core\Database;

$dotenv = Dotenv\Dotenv::createImmutable(__DIR__ . '/../');
$dotenv->safeLoad();

$db = Database::getInstance()->getConnection();

echo "Creating test analytics data...\n\n";

// Generate test visitors
$sources = ['google', 'facebook', 'instagram', 'direct', null];
$devices = ['mobile', 'desktop', 'tablet'];

for ($i = 0; $i < 50; $i++) {
    $sessionId = bin2hex(random_bytes(16));
    $source = $sources[array_rand($sources)];
    $device = $devices[array_rand($devices)];
    $daysAgo = rand(0, 7);
    
    $stmt = $db->prepare("
        INSERT INTO study_visitors 
        (session_id, ip_address, device_type, utm_source, first_visit)
        VALUES (?, ?, ?, ?, DATE_SUB(NOW(), INTERVAL ? DAY))
    ");
    $stmt->execute([$sessionId, '127.0.0.1', $device, $source, $daysAgo]);
}

echo "✓ Created 50 test visitors\n";

// Generate test leads (if table exists)
try {
    $fields = ['Computer Science', 'Medicine', 'Engineering', 'Business', 'Law'];
    
    for ($i = 0; $i < 20; $i++) {
        $field = $fields[array_rand($fields)];
        $status = rand(0, 1) ? 'new' : 'qualified';
        $daysAgo = rand(0, 30);
        
        $details = json_encode([
            'field' => $field,
            'country' => 'Kazakhstan',
            'budget' => rand(5000, 20000) . ' USD'
        ]);
        
        $stmt = $db->prepare("
            INSERT INTO study_leads 
            (user_id, status, score, details, created_at)
            VALUES (1, ?, 75, ?, DATE_SUB(NOW(), INTERVAL ? DAY))
        ");
        $stmt->execute([$status, $details, $daysAgo]);
    }
    
    echo "✓ Created 20 test leads\n";
} catch (Exception $e) {
    echo "⚠ Could not create leads: " . $e->getMessage() . "\n";
}

echo "\n✅ Test data created successfully!\n";
echo "Visit /study/public/admin/analytics to see the dashboard.\n";
