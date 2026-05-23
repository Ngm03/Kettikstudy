<?php

namespace App\Models;

use App\Core\Database;

class Manager
{
    private \PDO $db;

    public function __construct()
    {
        $this->db = Database::getInstance()->getConnection();
    }

    public function getAll(): array
    {
        $stmt = $this->db->query("SELECT id, full_name as name, phone, email, created_at, role, 1 as is_active FROM study_users WHERE role = 'manager' ORDER BY created_at DESC");
        return $stmt->fetchAll(\PDO::FETCH_ASSOC);
    }

    public function getActive(): array
    {
        return $this->getAll();
    }

    public function getRandomActive(): ?array
    {
        $active = $this->getActive();
        if (empty($active)) return null;
        return $active[array_rand($active)];
    }

    public function create(int $userId): bool
    {
        $stmt = $this->db->prepare("UPDATE study_users SET role = 'manager' WHERE id = ?");
        return $stmt->execute([$userId]);
    }

    public function delete(int $id): bool
    {
        $stmt = $this->db->prepare("UPDATE study_users SET role = 'student' WHERE id = ?");
        return $stmt->execute([$id]);
    }

    public function toggleActive(int $id): bool
    {
        return true;
    }
}
