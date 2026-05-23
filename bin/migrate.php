<?php

require_once __DIR__ . '/../vendor/autoload.php';

use App\Core\Database;
use Dotenv\Dotenv;

$dotenv = Dotenv::createImmutable(__DIR__ . '/../');
$dotenv->safeLoad();

$pdo = Database::getInstance()->getConnection();

// Create migrations table if not exists (with prefix study_)
$pdo->exec("CREATE TABLE IF NOT EXISTS study_migrations (
    id INT AUTO_INCREMENT PRIMARY KEY,
    migration VARCHAR(255),
    created_at TIMESTAMP DEFAULT CURRENT_TIMESTAMP
)  ENGINE=INNODB;");

$migrations = glob(__DIR__ . '/../migrations/*.php');
$executed = $pdo->query("SELECT migration FROM study_migrations")->fetchAll(PDO::FETCH_COLUMN);

foreach ($migrations as $file) {
    $migrationName = basename($file);
    
    if (!in_array($migrationName, $executed)) {
        echo "Migrating: $migrationName\n";
        $sql = require $file;
        
        try {
            $pdo->exec($sql);
            $stmt = $pdo->prepare("INSERT INTO study_migrations (migration) VALUES (?)");
            $stmt->execute([$migrationName]);
            echo "Applied: $migrationName\n";
        } catch (PDOException $e) {
            echo "Failed: $migrationName\nError: " . $e->getMessage() . "\n";
            exit(1);
        }
    }
}

echo "All migrations applied.\n";
