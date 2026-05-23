<?php

namespace App\Controllers;

use App\Core\Database;
use App\Services\AuthService;
use App\Services\StudentStageService;
use App\Models\UserDetails;

class ProfileController
{
    private $db;
    private $authService;

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
            return $_SESSION['user_id'];
        }

        $token = $_COOKIE['auth_token'] ?? null;
        if ($token) {
            $decoded = $this->authService->validateToken($token);
            if ($decoded && isset($decoded['sub'])) {
                return $decoded['sub'];
            }
        }

        return null;
    }

    public function getProgress()
    {
        header('Content-Type: application/json');
        
        $userId = $this->getUserId();
        if (!$userId) {
            http_response_code(401);
            echo json_encode(['error' => 'Not authenticated']);
            return;
        }

        $stage = $this->calculateStudentStage($userId);
        
        echo json_encode(['stage' => $stage]);
    }

    private function calculateStudentStage($studentId)
    {
        return (new StudentStageService())->calculate($studentId);
    }

    public function getDetails()
    {
        header('Content-Type: application/json');
        
        $userId = $this->getUserId();
        if (!$userId) {
            http_response_code(401);
            echo json_encode(['error' => 'Not authenticated']);
            return;
        }

        $stmt = $this->db->prepare("SELECT id, full_name, email, phone, enrolled_role, city_id FROM study_users WHERE id = ?");
        $stmt->execute([$userId]);
        $user = $stmt->fetch(\PDO::FETCH_ASSOC);

        if (!$user) {
            http_response_code(404);
            echo json_encode(['error' => 'User not found']);
            return;
        }

        $stmt = $this->db->prepare("
            SELECT ud.*, su.name as university_name 
            FROM study_user_details ud 
            LEFT JOIN study_universities su ON ud.desired_university_id = su.id 
            WHERE ud.user_id = ?
        ");
        $stmt->execute([$userId]);
        $details = $stmt->fetch(\PDO::FETCH_ASSOC);

        $stmt = $this->db->prepare("SELECT * FROM study_leads WHERE user_id = ? ORDER BY created_at DESC LIMIT 1");
        $stmt->execute([$userId]);
        $lead = $stmt->fetch(\PDO::FETCH_ASSOC);

        $manager = null;
        if ($lead && !empty($lead['manager_id'])) {
            $stmt = $this->db->prepare("SELECT full_name as name, phone, null as photo FROM study_users WHERE id = ?");
            $stmt->execute([$lead['manager_id']]);
            $manager = $stmt->fetch(\PDO::FETCH_ASSOC);
        }

        if (!$manager) {
            $managerModel = new \App\Models\Manager();
            $manager = $managerModel->getRandomActive();

            if ($lead && empty($lead['manager_id']) && $manager) {
                $stmt = $this->db->prepare("UPDATE study_leads SET manager_id = ? WHERE id = ?");
                $stmt->execute([$manager['id'], $lead['id']]);
            }
        }

        if ($manager) {
            if (!$details) $details = [];
            $details['manager_name'] = $manager['name'];
            $details['manager_phone'] = $manager['phone'];
            $details['manager_photo'] = $manager['photo'];
        } else {
             if (!$details) $details = [];
             $details['manager_name'] = 'Алина';
             $details['manager_phone'] = '+77016314121';
             $details['manager_photo'] = null;
        }

        if (empty($details)) {
            $details = new \stdClass();
        }

        echo json_encode(['user' => $user, 'details' => $details, 'lead' => $lead ?: null]);
    }

    public function updateDetails()
    {
        header('Content-Type: application/json');
        
        $userId = $this->getUserId();
        if (!$userId) {
            http_response_code(401);
            echo json_encode(['error' => 'Not authenticated']);
            return;
        }

        $input = json_decode(file_get_contents('php://input'), true);

        if (isset($input['full_name']) || isset($input['phone'])) {
            $updates = [];
            $params = [];
            if (isset($input['full_name'])) { $updates[] = "full_name = ?"; $params[] = $input['full_name']; }
            if (isset($input['phone'])) { $updates[] = "phone = ?"; $params[] = $input['phone']; }
            if (!empty($updates)) {
                $sql = "UPDATE study_users SET " . implode(", ", $updates) . " WHERE id = ?";
                $params[] = $userId;
                $this->db->prepare($sql)->execute($params);
            }
        }

        $detailFields = [
            'iin', 'passport_number', 'passport_authority', 'passport_issue_date',
            'address_registration', 'desired_country', 'desired_university_id', 'desired_program'
        ];
        $detailData = [];
        foreach ($detailFields as $field) {
            if (isset($input[$field])) {
                $detailData[$field] = $input[$field];
            }
        }

        if (!empty($detailData)) {
            $userDetails = new UserDetails($this->db);
            $existing = $userDetails->findByUserId($userId);
            if ($existing) {
                $userDetails->update($userId, $detailData);
            } else {
                $detailData['user_id'] = $userId;
                $userDetails->create($detailData);
            }
        }

        echo json_encode(['success' => true]);
    }

    public function getUniversitiesList()
    {
        header('Content-Type: application/json');
        $stmt = $this->db->query("SELECT id, name, website_url FROM study_universities ORDER BY name ASC");
        $universities = $stmt->fetchAll(\PDO::FETCH_ASSOC);
        echo json_encode(['universities' => $universities]);
    }
}
