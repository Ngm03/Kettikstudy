<?php

declare(strict_types=1);

namespace App\Controllers;

use App\Core\Database;
use App\Services\AuthService;

class TaskController
{
    private \PDO $db;
    private AuthService $authService;

    public function __construct()
    {
        if (session_status() === PHP_SESSION_NONE) {
            session_start();
        }
        $this->db = Database::getInstance()->getConnection();
        $this->authService = new AuthService();
    }

    private function getUserId(): ?int
    {
        if (isset($_SESSION['user_id'])) {
            return (int) $_SESSION['user_id'];
        }

        $token = $_COOKIE['auth_token'] ?? null;
        if ($token) {
            $decoded = $this->authService->validateToken($token);
            if ($decoded && isset($decoded['sub'])) {
                return (int) $decoded['sub'];
            }
        }

        return null;
    }

    private function getUserRole(int $userId): ?string
    {
        $stmt = $this->db->prepare("SELECT role FROM study_users WHERE id = ?");
        $stmt->execute([$userId]);
        $user = $stmt->fetch(\PDO::FETCH_ASSOC);

        return $user['role'] ?? null;
    }

    private function jsonResponse(array $data, int $code = 200): void
    {
        http_response_code($code);
        header('Content-Type: application/json');
        echo json_encode($data);
    }

    public function handle(): void
    {
        $userId = $this->getUserId();
        if (!$userId) {
            $this->jsonResponse(['error' => 'Not authenticated'], 401);
            return;
        }

        $isAdmin = $this->getUserRole($userId) === 'admin';
        $data = json_decode(file_get_contents('php://input'), true) ?? [];
        $action = $data['action'] ?? 'create';

        match ($action) {
            'delete' => $this->delete($data, $isAdmin),
            'complete' => $this->complete($data, $userId),
            'uncomplete' => $this->uncomplete($data, $userId),
            default => $this->create($data, $userId, $isAdmin),
        };
    }

    private function delete(array $data, bool $isAdmin): void
    {
        if (!$isAdmin) {
            $this->jsonResponse(['error' => 'Admin only'], 403);
            return;
        }

        $this->db->prepare("DELETE FROM study_tasks WHERE id = ?")->execute([$data['id']]);
        $this->jsonResponse(['success' => true]);
    }

    private function complete(array $data, int $userId): void
    {
        $this->db->prepare(
            "INSERT IGNORE INTO study_task_completions (task_id, user_id) VALUES (?, ?)"
        )->execute([$data['id'], $userId]);

        $this->jsonResponse(['success' => true]);
    }

    private function uncomplete(array $data, int $userId): void
    {
        $this->db->prepare(
            "DELETE FROM study_task_completions WHERE task_id = ? AND user_id = ?"
        )->execute([$data['id'], $userId]);

        $this->jsonResponse(['success' => true]);
    }

    private function create(array $data, int $userId, bool $isAdmin): void
    {
        if (!$isAdmin) {
            $this->jsonResponse(['error' => 'Admin only'], 403);
            return;
        }

        if (empty($data['title'])) {
            $this->jsonResponse(['error' => 'Title required'], 400);
            return;
        }

        $stmt = $this->db->prepare(
            "INSERT INTO study_tasks (city_id, title, description, due_date, priority, created_by) VALUES (?, ?, ?, ?, ?, ?)"
        );
        $ok = $stmt->execute([
            $data['city_id'] ?: null,
            $data['title'],
            $data['description'] ?? null,
            $data['due_date'] ?: null,
            $data['priority'] ?? 'medium',
            $userId,
        ]);

        $this->jsonResponse(['success' => $ok]);
    }
}
