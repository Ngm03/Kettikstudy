<?php

require_once __DIR__ . '/../src/Core/Database.php';

use App\Core\Database;

try {
    $db = Database::getInstance()->getConnection();
    
    // Создаём таблицу городов
    $db->exec("
        CREATE TABLE IF NOT EXISTS study_cities (
            id INT AUTO_INCREMENT PRIMARY KEY,
            name_ru VARCHAR(100) NOT NULL,
            name_en VARCHAR(100) NOT NULL,
            name_pl VARCHAR(100) NOT NULL,
            description TEXT,
            created_at TIMESTAMP DEFAULT CURRENT_TIMESTAMP
        ) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_unicode_ci
    ");
    
    // Вставляем города Польши
    $db->exec("
        INSERT INTO study_cities (name_ru, name_en, name_pl, description) VALUES
        ('Кельце', 'Kielce', 'Kielce', 'Столица Свентокшиского воеводства'),
        ('Радом', 'Radom', 'Radom', 'Крупный город в Мазовецком воеводстве'),
        ('Краков', 'Krakow', 'Kraków', 'Культурная столица Польши'),
        ('Новы Сонч', 'Nowy Sacz', 'Nowy Sącz', 'Город в Малопольском воеводстве'),
        ('Люблин', 'Lublin', 'Lublin', 'Столица Люблинского воеводства')
        ON DUPLICATE KEY UPDATE name_ru=name_ru
    ");
    
    // Проверяем существует ли таблица study_users
    $result = $db->query("SHOW TABLES LIKE 'study_users'");
    if ($result->rowCount() > 0) {
        // Добавляем поля в таблицу пользователей
        $db->exec("
            ALTER TABLE study_users 
            ADD COLUMN IF NOT EXISTS city_id INT NULL,
            ADD COLUMN IF NOT EXISTS enrolled_role VARCHAR(50) DEFAULT NULL
        ");
        
        echo "✅ Migration 015: Cities table created and user fields added successfully\n";
    } else {
        echo "✅ Migration 015: Cities table created (study_users table will be updated later)\n";
    }
    
} catch (PDOException $e) {
    echo "❌ Migration failed: " . $e->getMessage() . "\n";
    exit(1);
}
