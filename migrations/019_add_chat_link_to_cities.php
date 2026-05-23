<?php

$host = 'localhost';
$dbname = 'broldru_ansar';
$username = 'broldru_ansar';
$password = 'ANsa4_nambeansa';

try {
    $db = new PDO("mysql:host=$host;dbname=$dbname;charset=utf8mb4", $username, $password);
    $db->setAttribute(PDO::ATTR_ERRMODE, PDO::ERRMODE_EXCEPTION);

    echo "=== МИГРАЦИЯ 019: Добавление ссылок на чаты в города ===\n";

    // 1. Проверяем наличие колонки
    $stmt = $db->query("SHOW COLUMNS FROM study_cities LIKE 'chat_link'");
    if ($stmt->rowCount() == 0) {
        // Добавляем колонку
        $db->exec("ALTER TABLE study_cities ADD COLUMN chat_link VARCHAR(255) DEFAULT NULL AFTER description");
        echo "✅ Колонка chat_link добавлена в таблицу study_cities\n";
    } else {
        echo "ℹ️ Колонка chat_link уже существует\n";
    }

    // 2. Обновляем данные (сидирование ссылок)
    // Примерные ссылки на чаты (заглушки)
    $chats = [
        'Kielce' => 'https://t.me/+ExampleKielceChat',
        'Radom' => 'https://t.me/+ExampleRadomChat',
        'Krakow' => 'https://t.me/+ExampleKrakowChat',
        'Nowy Sacz' => 'https://t.me/+ExampleNowySaczChat', 
        'Lublin' => 'https://t.me/+ExampleLublinChat'
    ];

    foreach ($chats as $city => $link) {
        $stmt = $db->prepare("UPDATE study_cities SET chat_link = ? WHERE name_en = ?");
        $stmt->execute([$link, $city]);
        if ($stmt->rowCount() > 0) {
            echo "   Updated chat link for $city\n";
        }
    }

    echo "✅ Данные городов обновлены ссылками на чаты\n";

} catch (PDOException $e) {
    die("❌ Ошибка базы данных: " . $e->getMessage() . "\n");
}
