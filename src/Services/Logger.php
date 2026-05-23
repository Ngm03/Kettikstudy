<?php

namespace App\Services;

use App\Core\Database;

class Logger
{
    private $db;

    public function __construct()
    {
        $this->db = Database::getInstance()->getConnection();
    }

    public function log(int $adminId, string $action, ?int $targetId = null, ?string $details = null)
    {
        $ip = $_SERVER['REMOTE_ADDR'] ?? null;
        
        $stmt = $this->db->prepare("INSERT INTO study_admin_logs (admin_id, action, target_id, details, ip_address) VALUES (?, ?, ?, ?, ?)");
        $stmt->execute([$adminId, $action, $targetId, $details, $ip]);
    }
}
