<?php

use App\Core\Database;

$db = Database::getInstance()->getConnection();

$db->exec("
    CREATE TABLE IF NOT EXISTS study_broadcasts (
        id INT AUTO_INCREMENT PRIMARY KEY,
        title VARCHAR(255) NOT NULL,
        body TEXT NOT NULL,
        filter VARCHAR(50) DEFAULT 'all',
        recipient_count INT DEFAULT 0,
        admin_id INT NULL,
        created_at TIMESTAMP DEFAULT CURRENT_TIMESTAMP
    )
");

echo "Migration 023: broadcasts table created.\n";
