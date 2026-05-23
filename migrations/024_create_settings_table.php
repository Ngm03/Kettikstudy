<?php
require_once __DIR__ . '/../vendor/autoload.php';
use App\Core\Database;

$db = Database::getInstance()->getConnection();

$db->exec("CREATE TABLE IF NOT EXISTS study_settings (
    id INT AUTO_INCREMENT PRIMARY KEY,
    setting_key VARCHAR(100) UNIQUE NOT NULL,
    setting_value TEXT DEFAULT NULL,
    updated_at TIMESTAMP DEFAULT CURRENT_TIMESTAMP ON UPDATE CURRENT_TIMESTAMP
)");

// Дефолтные настройки
$defaults = [
    ['company_name', 'Kettik Study'],
    ['company_description', 'Образовательное агентство — помогаем поступить в Польшу'],
    ['company_email', ''],
    ['company_phone', ''],
    ['company_whatsapp', ''],
    ['company_website', 'kettik.kz'],
    ['company_instagram', ''],
    ['company_telegram', ''],
    ['company_youtube', ''],
    ['company_address', 'Онлайн по всему Казахстану'],
    ['ai_bot_name', 'Абай'],
    ['ai_bot_enabled', '1'],
    ['primary_color', '#dc2626'],
    ['logo_url', ''],
    ['maintenance_mode', '0'],
];

$stmt = $db->prepare("INSERT IGNORE INTO study_settings (setting_key, setting_value) VALUES (?, ?)");
foreach ($defaults as $row) {
    $stmt->execute($row);
}

echo "Migration 024: study_settings table created with defaults.\n";
