<?php

namespace App\Controllers;

use App\Core\Database;
use App\Services\AuthService;

class LeadController
{
    private $db;
    private $authService;

    public function __construct()
    {
        $this->db = Database::getInstance()->getConnection();
        $this->authService = new AuthService();
    }

    private function getUserId()
    {
        $token = $_COOKIE['auth_token'] ?? null;
        if (!$token) return null;
        $decoded = $this->authService->validateToken($token);
        return $decoded ? $decoded['sub'] : null;
    }

    public function requestCall()
    {
        header('Content-Type: application/json');
        $userId = $this->getUserId();
        
        if (!$userId) {
            http_response_code(401);
            echo json_encode(['error' => 'Unauthorized']);
            return;
        }

        try {
            $stmt = $this->db->prepare("UPDATE study_users SET admin_notes = CONCAT(COALESCE(admin_notes, ''), '\n[SYSTEM]: CLIENT REQUESTED CALL AT " . date('Y-m-d H:i') . "') WHERE id = ?");
            $stmt->execute([$userId]);
            
            $stmt = $this->db->prepare("SELECT id FROM study_leads WHERE user_id = ?");
            $stmt->execute([$userId]);
            $lead = $stmt->fetch();

            if ($lead) {
                $stmt = $this->db->prepare("UPDATE study_leads SET details = JSON_SET(COALESCE(details, '{}'), '$.is_urgent', true), updated_at = NOW() WHERE id = ?");
                $stmt->execute([$lead['id']]);
            } else {
                $managerModel = new \App\Models\Manager();
                $manager = $managerModel->getRandomActive();
                $managerId = $manager ? $manager['id'] : null;

                $stmt = $this->db->prepare("INSERT INTO study_leads (user_id, status, score, details, manager_id) VALUES (?, 'new', 0, '{\"is_urgent\":true}', ?)");
                $stmt->execute([$userId, $managerId]);

                if ($managerId) {
                    $userStmt = $this->db->prepare("UPDATE study_users SET manager_id = ? WHERE id = ? AND manager_id IS NULL");
                    $userStmt->execute([$managerId, $userId]);
                }
            }
            
            echo json_encode(['success' => true]);

        } catch (\Exception $e) {
            http_response_code(500);
            echo json_encode(['error' => 'Internal server error']);
        }
    }
}
