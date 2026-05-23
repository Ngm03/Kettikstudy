<?php

namespace App\Controllers;

use App\Core\Database;
use App\Services\AuthService;

class ManagerPanelController
{
    private $db;
    private $authService;
    private $managerId = null;

    public function __construct()
    {
        $this->db = Database::getInstance()->getConnection();
        $this->authService = new AuthService();
        $this->checkAuth();
    }

    private function checkAuth()
    {
        $user = $this->authService->getUserFromCookie();
        if (!$user) {
            header('Location: ' . BASE_URL . '/login');
            exit;
        }
        
        if ($user['role'] !== 'manager' && $user['role'] !== 'admin') {
            http_response_code(403);
            echo 'Access Denied: Managers or Admins only';
            exit;
        }

        $this->managerId = $user['sub'];
    }

    public function dashboard()
    {
        $page = 'manager_dashboard';
        $pageTitle = 'Дашборд Менеджера';
        require __DIR__ . '/../../views/layouts/manager.php';
    }

    public function leads()
    {
        $page = 'manager_leads';
        $pageTitle = 'Мои Заявки';
        require __DIR__ . '/../../views/layouts/manager.php';
    }

    public function students()
    {
        $page = 'manager_students';
        $pageTitle = 'Мои Студенты';
        require __DIR__ . '/../../views/layouts/manager.php';
    }

    public function chat()
    {
        $page = 'manager_chat';
        $pageTitle = 'Чат со студентами';
        require __DIR__ . '/../../views/layouts/manager.php';
    }

    public function studentProfile()
    {
        $page = 'student';
        $pageTitle = 'Профиль Студента';
        require __DIR__ . '/../../views/layouts/manager.php';
    }

    public function getDashboardStats()
    {
        header('Content-Type: application/json');
        
        try {
            $stats = [
                'new_leads' => 0,
                'my_leads' => 0,
                'my_students' => 0,
                'unread_messages' => 0
            ];

            $stmt = $this->db->query("SELECT COUNT(*) FROM study_leads WHERE manager_id IS NULL");
            $stats['new_leads'] = $stmt->fetchColumn();

            $stmt = $this->db->prepare("SELECT COUNT(*) FROM study_leads WHERE manager_id = ? AND status != 'converted'");
            $stmt->execute([$this->managerId]);
            $stats['my_leads'] = $stmt->fetchColumn();

            $stmt = $this->db->prepare("SELECT COUNT(*) FROM study_users WHERE manager_id = ? AND role = 'student'");
            $stmt->execute([$this->managerId]);
            $stats['my_students'] = $stmt->fetchColumn();

            $stats['unread_messages'] = 0;

            echo json_encode(['success' => true, 'stats' => $stats]);
        } catch (\Exception $e) {
            http_response_code(500);
            echo json_encode(['error' => 'Internal server error']);
        }
    }

    public function getLeads()
    {
        header('Content-Type: application/json');
        try {
            $stmt = $this->db->prepare("
                SELECT id, name, phone, city, notes, status, created_at, manager_id 
                FROM study_leads 
                WHERE manager_id IS NULL OR manager_id = ?
                ORDER BY created_at DESC
            ");
            $stmt->execute([$this->managerId]);
            $leads = $stmt->fetchAll(\PDO::FETCH_ASSOC);

            echo json_encode(['success' => true, 'leads' => $leads]);
        } catch (\Exception $e) {
            http_response_code(500);
            echo json_encode(['error' => 'Internal server error']);
        }
    }

    public function claimLead()
    {
        header('Content-Type: application/json');
        $data = json_decode(file_get_contents('php://input'), true);
        $leadId = $data['id'] ?? null;

        if (!$leadId) {
            http_response_code(400);
            echo json_encode(['error' => 'Lead ID required']);
            return;
        }

        try {
            $stmt = $this->db->prepare("UPDATE study_leads SET manager_id = ?, status = 'contacted' WHERE id = ? AND manager_id IS NULL");
            $stmt->execute([$this->managerId, $leadId]);
            
            if ($stmt->rowCount() > 0) {
                echo json_encode(['success' => true, 'message' => 'Заявка взята в работу']);
            } else {
                echo json_encode(['error' => 'Заявка уже занята другим менеджером или не существует']);
            }
        } catch (\Exception $e) {
            http_response_code(500);
            echo json_encode(['error' => 'Internal server error']);
        }
    }

    public function updateLeadStatus()
    {
        header('Content-Type: application/json');
        $data = json_decode(file_get_contents('php://input'), true);
        $leadId = $data['id'] ?? null;
        $status = $data['status'] ?? null;

        if (!$leadId || !$status) {
            http_response_code(400);
            echo json_encode(['error' => 'Missing data']);
            return;
        }

        try {
            $stmt = $this->db->prepare("UPDATE study_leads SET status = ? WHERE id = ? AND manager_id = ?");
            $stmt->execute([$status, $leadId, $this->managerId]);
            echo json_encode(['success' => true]);
        } catch (\Exception $e) {
            http_response_code(500);
            echo json_encode(['error' => 'Internal server error']);
        }
    }

    public function getStudents()
    {
        header('Content-Type: application/json');
        try {
            $stmt = $this->db->prepare("
                SELECT u.id, u.email, u.full_name, u.phone, u.created_at,
                       d.status as document_status 
                FROM study_users u
                LEFT JOIN study_documents d ON d.user_id = u.id AND d.type = 'passport'
                WHERE u.manager_id = ? AND u.role = 'student'
                GROUP BY u.id
                ORDER BY u.created_at DESC
            ");
            $stmt->execute([$this->managerId]);
            $students = $stmt->fetchAll(\PDO::FETCH_ASSOC);

            echo json_encode(['success' => true, 'students' => $students]);
        } catch (\Exception $e) {
            http_response_code(500);
            echo json_encode(['error' => 'Internal server error']);
        }
    }
}
