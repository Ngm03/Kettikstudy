<?php

require_once __DIR__ . '/../src/Core/Database.php';

use App\Core\Database;

try {
    $db = Database::getInstance()->getConnection();
    
    // Проверяем существует ли таблица study_users
    $result = $db->query("SHOW TABLES LIKE 'study_users'");
    if ($result->rowCount() > 0) {
        // Проверяем существуют ли уже эти колонки
        $stmt = $db->query("SHOW COLUMNS FROM study_users LIKE 'enrolled_role'");
        $hasEnrolledRole = $stmt->rowCount() > 0;
        
        $stmt = $db->query("SHOW COLUMNS FROM study_users LIKE 'city_id'");
        $hasCityId = $stmt->rowCount() > 0;
        
        $updates = [];
        
        if (!$hasEnrolledRole) {
            $updates[] = "ADD COLUMN enrolled_role VARCHAR(50) DEFAULT NULL";
        }
        
        if (!$hasCityId) {
            $updates[] = "ADD COLUMN city_id INT NULL";
        }
        
        if (!empty($updates)) {
            $sql = "ALTER TABLE study_users " . implode(", ", $updates);
            $db->exec($sql);
            echo "✅ Migration 018: Added enrolled_role and city_id columns to study_users\n";
        } else {
            echo "✅ Migration 018: Columns already exist, skipping\n";
        }
    } else {
        echo "❌ Migration 018: study_users table doesn't exist\n";
        exit(1);
    }
    
} catch (PDOException $e) {
    echo "❌ Migration failed: " . $e->getMessage() . "\n";
    exit(1);
}
