<?php

require_once __DIR__ . '/../src/Core/Database.php';

use App\Core\Database;

try {
    $db = Database::getInstance()->getConnection();
    
    // Проверяем существует ли таблица study_users
    $result = $db->query("SHOW TABLES LIKE 'study_users'");
    $hasUsersTable = $result->rowCount() > 0;
    
    if ($hasUsersTable) {
        // Создаём таблицу оценок цен с FK
        $db->exec("
            CREATE TABLE IF NOT EXISTS study_price_reviews (
                id INT AUTO_INCREMENT PRIMARY KEY,
                city_id INT NOT NULL,
                user_id INT NOT NULL,
                category VARCHAR(50) NOT NULL,
                item_name VARCHAR(200) NOT NULL,
                price DECIMAL(10,2) NOT NULL,
                currency VARCHAR(10) DEFAULT 'PLN',
                comment TEXT,
                rating INT DEFAULT 3,
                created_at TIMESTAMP DEFAULT CURRENT_TIMESTAMP,
                FOREIGN KEY (city_id) REFERENCES study_cities(id) ON DELETE CASCADE,
                FOREIGN KEY (user_id) REFERENCES study_users(id) ON DELETE CASCADE,
                INDEX idx_category (category),
                INDEX idx_city_category (city_id, category)
            ) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_unicode_ci
        ");
    } else {
        // Создаём таблицу оценок цен без FK на users
        $db->exec("
            CREATE TABLE IF NOT EXISTS study_price_reviews (
                id INT AUTO_INCREMENT PRIMARY KEY,
                city_id INT NOT NULL,
                user_id INT NOT NULL,
                category VARCHAR(50) NOT NULL,
                item_name VARCHAR(200) NOT NULL,
                price DECIMAL(10,2) NOT NULL,
                currency VARCHAR(10) DEFAULT 'PLN',
                comment TEXT,
                rating INT DEFAULT 3,
                created_at TIMESTAMP DEFAULT CURRENT_TIMESTAMP,
                FOREIGN KEY (city_id) REFERENCES study_cities(id) ON DELETE CASCADE,
                INDEX idx_category (category),
                INDEX idx_city_category (city_id, category)
            ) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_unicode_ci
        ");
    }
    
    echo "✅ Migration 017: Price reviews table created successfully\n";
    
} catch (PDOException $e) {
    echo "❌ Migration failed: " . $e->getMessage() . "\n";
    exit(1);
}
