<?php

namespace App\Controllers;

use App\Core\Database;
use App\Models\Manager;

class ManagerController
{
    private $db;
    private $managerModel;

    public function __construct()
    {
        $this->db = Database::getInstance()->getConnection();
        $this->managerModel = new Manager();
    }

    private function checkAdmin()
    {
        $token = $_COOKIE['auth_token'] ?? null;
        if (!$token) {
            http_response_code(403);
            echo json_encode(['error' => 'Access Denied']);
            exit;
        }

        $authService = new \App\Services\AuthService();
        $decoded = $authService->validateToken($token);
        if (!$decoded || ($decoded['role'] ?? '') !== 'admin') {
            http_response_code(403);
            echo json_encode(['error' => 'Access Denied: Admin only']);
            exit;
        }
    }

    public function index()
    {
        $managers = $this->managerModel->getAll();
        
        $stmt = $this->db->query("SELECT id, full_name, email, phone FROM study_users WHERE role = 'student' ORDER BY full_name ASC");
        $students = $stmt->fetchAll(\PDO::FETCH_ASSOC);

        $page = 'managers';
        require __DIR__ . '/../../views/layouts/admin.php'; 
    }

    public function create()
    {
        $this->checkAdmin();
        header('Content-Type: application/json');

        $userId = $_POST['user_id'] ?? null;
        
        if (empty($userId)) {
            echo json_encode(['error' => 'Пользователь не выбран']);
            return;
        }

        if ($this->managerModel->create((int)$userId)) {
            echo json_encode(['success' => true]);
        } else {
            echo json_encode(['error' => 'Ошибка базы данных']);
        }
    }

    public function delete()
    {
        $this->checkAdmin();
        header('Content-Type: application/json');
        
        $input = json_decode(file_get_contents('php://input'), true);
        $id = $input['id'] ?? null;

        if (!$id) {
            echo json_encode(['error' => 'ID не передан']);
            return;
        }

        if ($this->managerModel->delete($id)) {
            echo json_encode(['success' => true]);
        } else {
            echo json_encode(['error' => 'Ошибка удаления']);
        }
    }

    public function toggle()
    {
        $this->checkAdmin();
        header('Content-Type: application/json');
        
        $input = json_decode(file_get_contents('php://input'), true);
        $id = $input['id'] ?? null;

        if ($this->managerModel->toggleActive($id)) {
            echo json_encode(['success' => true]);
        } else {
            echo json_encode(['error' => 'Ошибка обновления']);
        }
    }
}
