<?php

namespace App\Controllers;

use App\Core\Database;
use App\Services\AuthService;

class NotificationController
{
    private $db;
    private $authService;

    public function __construct()
    {
        $this->db = Database::getInstance()->getConnection();
        $this->authService = new AuthService();
    }

    private function getUserId(): ?int
    {
        $token = $_COOKIE['auth_token'] ?? null;
        if (!$token) return null;
        
        $decoded = $this->authService->validateToken($token);
        return $decoded['sub'] ?? null;
    }

    public function getUnread()
    {
        header('Content-Type: application/json');
        
        $userId = $this->getUserId();
        if (!$userId) {
            http_response_code(401);
            echo json_encode(['error' => 'Unauthorized']);
            return;
        }

        try {
            $stmt = $this->db->prepare("
                SELECT id, title, body, url, type, created_at
                FROM study_notifications
                WHERE user_id = ? AND is_read = FALSE
                ORDER BY created_at DESC
                LIMIT 10
            ");
            $stmt->execute([$userId]);
            $notifications = $stmt->fetchAll(\PDO::FETCH_ASSOC);

            echo json_encode([
                'success' => true,
                'notifications' => $notifications,
                'count' => count($notifications)
            ]);
        } catch (\Exception $e) {
            http_response_code(500);
            echo json_encode(['error' => 'Database error']);
        }
    }

    public function markAsRead()
    {
        header('Content-Type: application/json');
        
        $userId = $this->getUserId();
        if (!$userId) {
            http_response_code(401);
            echo json_encode(['error' => 'Unauthorized']);
            return;
        }

        $data = json_decode(file_get_contents('php://input'), true);
        $notificationId = $data['id'] ?? null;

        if (!$notificationId) {
            http_response_code(400);
            echo json_encode(['error' => 'Missing notification ID']);
            return;
        }

        try {
            $stmt = $this->db->prepare("
                UPDATE study_notifications
                SET is_read = TRUE
                WHERE id = ? AND user_id = ?
            ");
            $stmt->execute([$notificationId, $userId]);

            echo json_encode(['success' => true]);
        } catch (\Exception $e) {
            http_response_code(500);
            echo json_encode(['error' => 'Database error']);
        }
    }

    public function markAllAsRead()
    {
        header('Content-Type: application/json');
        
        $userId = $this->getUserId();
        if (!$userId) {
            http_response_code(401);
            echo json_encode(['error' => 'Unauthorized']);
            return;
        }

        try {
            $stmt = $this->db->prepare("
                UPDATE study_notifications
                SET is_read = TRUE
                WHERE user_id = ? AND is_read = FALSE
            ");
            $stmt->execute([$userId]);

            echo json_encode(['success' => true]);
        } catch (\Exception $e) {
            http_response_code(500);
            echo json_encode(['error' => 'Database error']);
        }
    }

    public static function notifyAdmins($title, $body, $url = null, $type = 'system')
    {
        $db = Database::getInstance()->getConnection();
        
        try {
            $stmt = $db->query("SELECT id FROM study_users WHERE role = 'admin'");
            $admins = $stmt->fetchAll(\PDO::FETCH_ASSOC);

            $insertStmt = $db->prepare("
                INSERT INTO study_notifications (user_id, title, body, url, type)
                VALUES (?, ?, ?, ?, ?)
            ");

            foreach ($admins as $admin) {
                $insertStmt->execute([$admin['id'], $title, $body, $url, $type]);
            }

            return true;
        } catch (\Exception $e) {
            error_log('Failed to create notification: ' . $e->getMessage());
            return false;
        }
    }
}
