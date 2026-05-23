<?php

namespace App\Models;

use App\Core\Database;
use PDO;

class Setting
{
    private $db;

    public function __construct()
    {
        $this->db = Database::getInstance()->getConnection();
    }

    public function get(string $key, $default = null): ?string
    {
        $stmt = $this->db->prepare("SELECT setting_value FROM study_settings WHERE setting_key = ?");
        $stmt->execute([$key]);
        $row = $stmt->fetch(PDO::FETCH_ASSOC);
        return $row ? $row['setting_value'] : $default;
    }

    public function set(string $key, ?string $value): void
    {
        $stmt = $this->db->prepare("INSERT INTO study_settings (setting_key, setting_value) VALUES (?, ?) ON DUPLICATE KEY UPDATE setting_value = VALUES(setting_value)");
        $stmt->execute([$key, $value]);
    }

    public function getAll(): array
    {
        $stmt = $this->db->query("SELECT setting_key, setting_value FROM study_settings ORDER BY id");
        $rows = $stmt->fetchAll(PDO::FETCH_ASSOC);
        $result = [];
        foreach ($rows as $row) {
            $result[$row['setting_key']] = $row['setting_value'];
        }
        return $result;
    }

    public function setMany(array $settings): void
    {
        $stmt = $this->db->prepare("INSERT INTO study_settings (setting_key, setting_value) VALUES (?, ?) ON DUPLICATE KEY UPDATE setting_value = VALUES(setting_value)");
        foreach ($settings as $key => $value) {
            $stmt->execute([$key, $value]);
        }
    }
}
