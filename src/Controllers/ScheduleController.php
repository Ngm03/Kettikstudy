<?php

declare(strict_types=1);

namespace App\Controllers;

use App\Core\Database;
use App\Services\AuthService;

class ScheduleController
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

    private function jsonResponse(array $data, int $code = 200): void
    {
        http_response_code($code);
        header('Content-Type: application/json');
        echo json_encode($data);
    }

    public function create(): void
    {
        $userId = $this->getUserId();
        if (!$userId) {
            $this->jsonResponse(['error' => 'Not authenticated'], 401);
            return;
        }

        $stmt = $this->db->prepare("SELECT role FROM study_users WHERE id = ?");
        $stmt->execute([$userId]);
        $user = $stmt->fetch(\PDO::FETCH_ASSOC);

        if (!$user || $user['role'] !== 'admin') {
            $this->jsonResponse(['error' => 'Admin only'], 403);
            return;
        }

        $data = json_decode(file_get_contents('php://input'), true) ?? [];

        if (empty($data['title']) || empty($data['starts_at']) || empty($data['ends_at'])) {
            $this->jsonResponse(['error' => 'Missing fields'], 400);
            return;
        }

        $stmt = $this->db->prepare(
            "INSERT INTO study_schedule (city_id, title, location, starts_at, ends_at, color, created_by) VALUES (?, ?, ?, ?, ?, ?, ?)"
        );
        $ok = $stmt->execute([
            $data['city_id'] ?: null,
            $data['title'],
            $data['location'] ?? null,
            $data['starts_at'],
            $data['ends_at'],
            $data['color'] ?? 'blue',
            $userId,
        ]);

        $this->jsonResponse(['success' => $ok]);
    }
}
