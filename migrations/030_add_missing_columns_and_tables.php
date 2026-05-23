<?php

if (!class_exists('App\Core\Database')) {
    require_once __DIR__ . '/../vendor/autoload.php';
    $dotenv = Dotenv\Dotenv::createImmutable(__DIR__ . '/../');
    $dotenv->safeLoad();
}

use App\Core\Database;

$db = Database::getInstance()->getConnection();
$isCli = (php_sapi_name() === 'cli');

$queries = [
    "ALTER TABLE study_chat_rooms ADD COLUMN IF NOT EXISTS avatar VARCHAR(255) NULL AFTER name",
    "ALTER TABLE study_chat_rooms ADD COLUMN IF NOT EXISTS student_id INT NULL",
    "ALTER TABLE study_chat_rooms ADD COLUMN IF NOT EXISTS manager_id INT NULL",

    "ALTER TABLE study_chat_rooms MODIFY COLUMN type ENUM('general', 'city', 'broadcast', 'private') NOT NULL DEFAULT 'general'",

    "ALTER TABLE study_chat_messages ADD COLUMN IF NOT EXISTS attachment_url VARCHAR(255) NULL AFTER message",
    "ALTER TABLE study_chat_messages ADD COLUMN IF NOT EXISTS is_edited TINYINT(1) DEFAULT 0",
    "ALTER TABLE study_chat_messages ADD COLUMN IF NOT EXISTS reply_to_id INT NULL",
    "ALTER TABLE study_chat_messages ADD COLUMN IF NOT EXISTS reply_to_text VARCHAR(255) NULL",

    "ALTER TABLE study_users ADD COLUMN IF NOT EXISTS last_active_at DATETIME NULL",

    "CREATE TABLE IF NOT EXISTS study_chat_read_status (
        id INT AUTO_INCREMENT PRIMARY KEY,
        user_id INT NOT NULL,
        room_id INT NOT NULL,
        last_read_at DATETIME NOT NULL DEFAULT NOW(),
        UNIQUE KEY user_room (user_id, room_id)
    ) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4",

    "CREATE TABLE IF NOT EXISTS study_chat_reactions (
        id INT AUTO_INCREMENT PRIMARY KEY,
        message_id INT NOT NULL,
        user_id INT NOT NULL,
        emoji VARCHAR(20) NOT NULL,
        created_at DATETIME DEFAULT NOW(),
        UNIQUE KEY user_msg_emoji (user_id, message_id, emoji)
    ) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4",

    "CREATE TABLE IF NOT EXISTS study_admin_logs (
        id INT AUTO_INCREMENT PRIMARY KEY,
        admin_id INT NOT NULL,
        action VARCHAR(50) NOT NULL,
        target_id INT DEFAULT NULL,
        details TEXT,
        ip_address VARCHAR(45),
        created_at TIMESTAMP DEFAULT CURRENT_TIMESTAMP
    ) ENGINE=InnoDB",

    "CREATE TABLE IF NOT EXISTS study_push_subscriptions (
        id INT AUTO_INCREMENT PRIMARY KEY,
        user_id INT NOT NULL,
        endpoint TEXT NOT NULL,
        p256dh TEXT,
        auth TEXT,
        created_at TIMESTAMP DEFAULT CURRENT_TIMESTAMP,
        INDEX idx_user_id (user_id)
    ) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4",
];

$success = 0;
$skipped = 0;

if ($isCli) echo "Running migration 030...\n";

foreach ($queries as $sql) {
    try {
        $db->exec($sql);
        $success++;
        if ($isCli) echo "[OK] " . substr(trim($sql), 0, 80) . "...\n";
    } catch (PDOException $e) {
        $skipped++;
        if ($isCli) echo "[SKIP] " . substr(trim($sql), 0, 80) . "... (" . $e->getMessage() . ")\n";
    }
}

if ($isCli) echo "\nDone: {$success} applied, {$skipped} skipped.\n";
