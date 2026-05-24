<?php

namespace App\Controllers;

use App\Core\Database;
use App\Services\AuthService;
use App\Services\Logger;
use App\Services\StudentStageService;

class AdminController
{
    private $db;
    private $authService;
    private $logger;

    public function __construct()
    {
        $this->db = Database::getInstance()->getConnection();
        $this->authService = new AuthService();
        $this->logger = new Logger();
    }

    private function canAccessStudent($studentId): bool
    {
        $user = $this->authService->getUserFromCookie();
        if (!$user) return false;
        if ($user['role'] === 'admin') return true;
        if ($user['role'] === 'manager') {
            $stmt = $this->db->prepare("SELECT manager_id FROM study_users WHERE id = ?");
            $stmt->execute([$studentId]);
            $managerId = $stmt->fetchColumn();
            return $managerId == $user['sub'];
        }
        return false;
    }

    private function canAccessDocument($docId): bool
    {
        $user = $this->authService->getUserFromCookie();
        if (!$user) return false;
        if ($user['role'] === 'admin') return true;
        if ($user['role'] === 'manager') {
            $stmt = $this->db->prepare("
                SELECT u.manager_id 
                FROM study_documents d 
                JOIN study_users u ON d.user_id = u.id 
                WHERE d.id = ?
            ");
            $stmt->execute([$docId]);
            $managerId = $stmt->fetchColumn();
            return $managerId == $user['sub'];
        }
        return false;
    }

    // Auth/Role checks removed — handled by Router middleware (AuthMiddleware + RoleMiddleware)

    public function documentsPage()
    {
        $page = 'documents';
        require __DIR__ . '/../../views/layouts/admin.php';
    }

    public function contractsPage()
    {
        $page = 'contracts';
        require __DIR__ . '/../../views/layouts/admin.php';
    }

    public function analyticsPage()
    {
        require __DIR__ . '/../../views/admin/analytics.php';
    }

    public function listContracts()
    {
        header('Content-Type: application/json');

        $sql = "SELECT 
                    c.id, c.user_id, c.status, c.created_at,
                    u.full_name, u.email
                FROM study_contracts c
                JOIN study_users u ON c.user_id = u.id
                ORDER BY c.created_at DESC";
        
        $stmt = $this->db->query($sql);
        $contracts = $stmt->fetchAll(\PDO::FETCH_ASSOC);

        echo json_encode(['contracts' => $contracts]);
    }

    public function getAllDocuments()
    {
        header('Content-Type: application/json');
        
        $user = $this->authService->getUserFromCookie();
        $isAdmin = ($user['role'] === 'admin');
        $managerId = $user['sub'];

        $sql = "
            SELECT d.*, u.full_name, u.email 
            FROM study_documents d 
            JOIN study_users u ON d.user_id = u.id 
            WHERE 1=1
        ";
        $params = [];

        if (!$isAdmin) {
            $sql .= " AND u.manager_id = ?";
            $params[] = $managerId;
        }
        
        $sql .= " ORDER BY d.created_at DESC";

        $stmt = $this->db->prepare($sql);
        $stmt->execute($params);
        $documents = $stmt->fetchAll(\PDO::FETCH_ASSOC);
        
        echo json_encode(['documents' => $documents]);
    }

    public function dashboard()
    {
        $page = 'home';
        require __DIR__ . '/../../views/layouts/admin.php';
    }


    public function pricesPage()
    {
        $page = 'prices';
        require __DIR__ . '/../../views/layouts/admin.php';
    }

    public function studentPage()
    {
        $page = 'student';
        require __DIR__ . '/../../views/layouts/admin.php';
    }

    public function listStudents()
    {
        header('Content-Type: application/json');

        $sql = "SELECT 
                    u.id, u.full_name, u.email, u.phone, u.created_at,
                    (SELECT status FROM study_leads WHERE user_id = u.id ORDER BY updated_at DESC LIMIT 1) as lead_status,
                    (SELECT score FROM study_leads WHERE user_id = u.id ORDER BY updated_at DESC LIMIT 1) as lead_score,
                    (SELECT JSON_UNQUOTE(JSON_EXTRACT(details, '$.is_urgent')) FROM study_leads WHERE user_id = u.id ORDER BY updated_at DESC LIMIT 1) as is_urgent,
                    (SELECT updated_at FROM study_leads WHERE user_id = u.id ORDER BY updated_at DESC LIMIT 1) as last_interaction
                FROM study_users u
                WHERE u.role = 'student' 
                ORDER BY last_interaction DESC, u.created_at DESC";
        
        $stmt = $this->db->query($sql);
        $students = $stmt->fetchAll(\PDO::FETCH_ASSOC);

        echo json_encode(['students' => $students]);
    }

    public function getStudentDetails()
    {
        header('Content-Type: application/json');

        $id = $_GET['id'] ?? null;
        if (!$id) {
            http_response_code(400);
            echo json_encode(['error' => 'Missing ID']);
            return;
        }

        if (!$this->canAccessStudent($id)) {
            http_response_code(403);
            echo json_encode(['error' => 'Access Denied: Not your student']);
            return;
        }

        $stmt = $this->db->prepare("SELECT id, manager_id, full_name, email, phone, enrolled_role, city_id, admin_notes, created_at FROM study_users WHERE id = ?");
        $stmt->execute([$id]);
        $user = $stmt->fetch(\PDO::FETCH_ASSOC);

        $stmt = $this->db->prepare("SELECT id, type, original_name, status, file_path, comment, rejection_reason FROM study_documents WHERE user_id = ?");
        $stmt->execute([$id]);
        $documents = $stmt->fetchAll(\PDO::FETCH_ASSOC);

        $stmt = $this->db->prepare("SELECT * FROM study_leads WHERE user_id = ? ORDER BY created_at DESC LIMIT 1");
        $stmt->execute([$id]);
        $lead = $stmt->fetch(\PDO::FETCH_ASSOC);

        if (!$lead && ($user['phone'] || $user['email'])) {
            $sql = "SELECT * FROM study_leads WHERE (1=0";
            $params = [];
            if ($user['phone']) {
                $sql .= " OR phone = ?";
                $params[] = $user['phone'];
            }
            if ($user['email']) {
                $sql .= " OR email = ?";
                $params[] = $user['email'];
            }
            $sql .= ") AND user_id IS NULL ORDER BY created_at DESC LIMIT 1";
            
            $stmt = $this->db->prepare($sql);
            $stmt->execute($params);
            $lead = $stmt->fetch(\PDO::FETCH_ASSOC);
        }

        $stage = $this->calculateStudentStage($id);

        $stmt = $this->db->query("SELECT id, full_name as name FROM study_users WHERE role = 'manager'");
        $managers = $stmt->fetchAll(\PDO::FETCH_ASSOC);
        
        echo json_encode(['user' => $user, 'documents' => $documents, 'lead' => $lead, 'stage' => $stage, 'managers' => $managers]);
    }

    private function calculateStudentStage($studentId)
    {
        return (new StudentStageService())->calculate($studentId);
    }

    public function updateStudentNotes()
    {
        header('Content-Type: application/json');

        $input = json_decode(file_get_contents('php://input'), true);
        $userId = $input['id'] ?? null;
        $notes = $input['notes'] ?? '';

        if (!$userId) {
            http_response_code(400);
            echo json_encode(['error' => 'Missing ID']);
            return;
        }

        if (!$this->canAccessStudent($userId)) {
            http_response_code(403);
            echo json_encode(['error' => 'Access Denied']);
            return;
        }

        $stmt = $this->db->prepare("UPDATE study_users SET admin_notes = ? WHERE id = ?");
        $stmt->execute([$notes, $userId]);
        
        $admin = $this->authService->validateToken($_COOKIE['auth_token']);
        $this->logger->log($admin['sub'], 'update_notes', $userId, "Notes updated");

        echo json_encode(['success' => true]);
    }

    public function updateDocStatus()
    {
        header('Content-Type: application/json');

        $input = json_decode(file_get_contents('php://input'), true);
        $docId = $input['id'] ?? null;
        $status = $input['status'] ?? null;
        $reason = $input['reason'] ?? null;

        if (!$docId || !in_array($status, ['approved', 'rejected'])) {
             echo json_encode(['error' => 'Invalid data']);
             return;
        }

        if (!$this->canAccessDocument($docId)) {
            http_response_code(403);
            echo json_encode(['error' => 'Access Denied']);
            return;
        }

        $sql = "UPDATE study_documents SET status = ?, rejection_reason = ? WHERE id = ?";
        $params = [$status, $reason, $docId];

        if ($status === 'approved') {
            $params[1] = null;
        }

        $stmt = $this->db->prepare($sql);
        $stmt->execute($params);
        
        $admin = $this->authService->validateToken($_COOKIE['auth_token']);
        $this->logger->log($admin['sub'], 'update_document_status', $docId, "Status changed to $status" . ($reason ? ". Reason: $reason" : ""));

        echo json_encode(['success' => true]);
    }

    public function updateStatus()
    {
        header('Content-Type: application/json');

        $input = json_decode(file_get_contents('php://input'), true);
        $studentId = $input['id'] ?? null;
        $status = $input['status'] ?? null;

        if (!$studentId || !$status) {
            echo json_encode(['error' => 'Missing data']);
            return;
        }

        try {
            $stmt = $this->db->prepare("SELECT id FROM study_leads WHERE user_id = ?");
            $stmt->execute([$studentId]);
            $lead = $stmt->fetch();

            if ($lead) {
                $stmt = $this->db->prepare("UPDATE study_leads SET status = ?, updated_at = NOW() WHERE user_id = ?");
                $stmt->execute([$status, $studentId]);
            } else {
                $managerModel = new \App\Models\Manager();
                $manager = $managerModel->getRandomActive();
                $managerId = $manager ? $manager['id'] : null;

                $stmt = $this->db->prepare("INSERT INTO study_leads (user_id, status, manager_id, score, details) VALUES (?, ?, ?, 0, '{}')");
                $stmt->execute([$studentId, $status, $managerId]);
            }

            $admin = $this->authService->validateToken($_COOKIE['auth_token']);
        echo json_encode(['success' => true]);
        } catch (\Exception $e) {
            http_response_code(500);
            echo json_encode(['error' => 'Internal server error', 'success' => false]);
        }
    }

    public function clearUrgent()
    {
        header('Content-Type: application/json');
        $input = json_decode(file_get_contents('php://input'), true);
        $studentId = $input['id'] ?? null;
        if ($studentId) {
            $stmt = $this->db->prepare("UPDATE study_leads SET details = JSON_REMOVE(details, '$.is_urgent') WHERE user_id = ?");
            $stmt->execute([$studentId]);
        }
        echo json_encode(['success' => true]);
    }

    public function updateChatRoom()
    {
        $token = $_COOKIE['auth_token'] ?? null;
        if (!$token) {
            http_response_code(401);
            echo json_encode(['error' => 'No token provided']);
            return;
        }

        $decoded = $this->authService->validateToken($token);
        if (!$decoded || ($decoded['role'] ?? '') !== 'admin') {
            http_response_code(403);
            echo json_encode(['error' => 'Access Denied']);
            return;
        }
        
        header('Content-Type: application/json');

        $roomId = $_POST['id'] ?? null;
        $name = trim($_POST['name'] ?? '');

        if (!$roomId || empty($name)) {
            http_response_code(400);
            echo json_encode(['error' => 'ID and Name are required']);
            return;
        }

        $avatarUrl = trim($_POST['avatar_url'] ?? '');

        if (isset($_FILES['avatar']) && $_FILES['avatar']['error'] === UPLOAD_ERR_OK) {
            $uploadDir = __DIR__ . '/../../public/uploads/avatars/';
            if (!is_dir($uploadDir)) {
                mkdir($uploadDir, 0755, true);
            }
            $ext = pathinfo($_FILES['avatar']['name'], PATHINFO_EXTENSION);
            $filename = uniqid('avatar_') . '.' . $ext;
            $destination = $uploadDir . $filename;
            
            if (move_uploaded_file($_FILES['avatar']['tmp_name'], $destination)) {
                $baseUrl = defined('BASE_URL') ? BASE_URL : '';
                $avatarUrl = $baseUrl . '/uploads/avatars/' . $filename;
            }
        }

        $finalAvatar = $avatarUrl !== '' ? $avatarUrl : null;

        try {
            $stmt = $this->db->prepare("UPDATE study_chat_rooms SET name = ?, avatar = ? WHERE id = ?");
            if ($stmt->execute([$name, $finalAvatar, $roomId])) {
                echo json_encode(['success' => true]);
            } else {
                http_response_code(500);
                echo json_encode(['error' => 'Failed to update chat room']);
            }
        } catch (\PDOException $e) {
            http_response_code(500);
            echo json_encode(['error' => 'Database error']);
        }
    }

    public function logsPage()
    {
        $page = 'logs';
        require __DIR__ . '/../../views/layouts/admin.php';
    }

    public function getLogs()
    {
        header('Content-Type: application/json');
        
        $logPath = __DIR__ . '/../../logs/app.log';
        if (!file_exists($logPath)) {
            echo json_encode(['logs' => []]);
            return;
        }

        $fileSize = filesize($logPath);
        if ($fileSize > 10 * 1024 * 1024) { // 10MB limit
            $f = fopen($logPath, 'r+');
            if ($f) {
                ftruncate($f, 0);
                fclose($f);
            }
            echo json_encode(['logs' => []]);
            return;
        }

        $lines = file($logPath, FILE_IGNORE_NEW_LINES | FILE_SKIP_EMPTY_LINES);
        if ($lines === false) {
            echo json_encode(['logs' => []]);
            return;
        }

        $lines = array_slice($lines, -150);
        $parsedLogs = [];

        foreach ($lines as $line) {
            $timestamp = '';
            $message = $line;
            
            if (strpos($line, '[') === 0 && ($pos = strpos($line, ']')) !== false) {
                $timestamp = substr($line, 1, $pos - 1);
                $message = trim(substr($line, $pos + 1));
            }

            $message = str_replace(PHP_EOL, ' ', $message);

            $level = 'info';
            $lowerMessage = strtolower($message);
            
            if (strpos($lowerMessage, 'fatal') !== false || 
                strpos($lowerMessage, 'error') !== false || 
                strpos($lowerMessage, 'exception') !== false || 
                strpos($lowerMessage, 'db error') !== false ||
                strpos($lowerMessage, 'app error') !== false) {
                $level = 'error';
            } elseif (strpos($lowerMessage, 'warning') !== false || 
                      strpos($lowerMessage, 'notice') !== false || 
                      strpos($lowerMessage, 'deprecated') !== false) {
                $level = 'warning';
            }

            $parsedLogs[] = [
                'timestamp' => $timestamp ?: date('Y-m-d H:i:s'),
                'level'     => $level,
                'message'   => $message
            ];
        }

        $parsedLogs = array_reverse($parsedLogs);

        echo json_encode(['logs' => $parsedLogs]);
    }

    public function clearLogs()
    {
        header('Content-Type: application/json');
        
        $user = $this->authService->getUserFromCookie();
        if (!$user || $user['role'] !== 'admin') {
            http_response_code(403);
            echo json_encode(['error' => 'Access Denied']);
            return;
        }

        $logPath = __DIR__ . '/../../logs/app.log';
        if (file_exists($logPath)) {
            $f = fopen($logPath, 'r+');
            if ($f) {
                ftruncate($f, 0);
                fclose($f);
            } else {
                unlink($logPath);
            }
        }

        $adminId = $user['sub'];
        $this->logger->log($adminId, 'clear_logs', null, "System error logs cleared");

        echo json_encode(['success' => true]);
    }


    public function updateStudentDetails()
    {
        header('Content-Type: application/json');

        $input = json_decode(file_get_contents('php://input'), true);
        $userId = $input['id'] ?? null;
        
        if (!$userId) {
            http_response_code(400);
            echo json_encode(['error' => 'Missing ID']);
            return;
        }

        if (!$this->canAccessStudent($userId)) {
            http_response_code(403);
            echo json_encode(['error' => 'Access Denied']);
            return;
        }

        $user = $this->authService->getUserFromCookie();
        $isAdmin = ($user['role'] === 'admin');

        // Managers cannot reassign students to other managers or change their own assigned leads to another manager
        if (array_key_exists('manager_id', $input) && !$isAdmin) {
            unset($input['manager_id']);
        }

        if (isset($input['full_name']) || isset($input['phone']) || isset($input['email']) || isset($input['enrolled_role']) || isset($input['city_id']) || array_key_exists('manager_id', $input)) {
            $sql = "UPDATE study_users SET ";
            $params = [];
            $updates = [];

            if (isset($input['full_name'])) { $updates[] = "full_name = ?"; $params[] = $input['full_name']; }
            if (isset($input['phone'])) { $updates[] = "phone = ?"; $params[] = $input['phone']; }
            if (isset($input['email'])) { $updates[] = "email = ?"; $params[] = $input['email']; }
            if (isset($input['enrolled_role'])) { $updates[] = "enrolled_role = ?"; $params[] = $input['enrolled_role'] ?: null; }
            if (isset($input['city_id'])) { $updates[] = "city_id = ?"; $params[] = $input['city_id'] ?: null; }
            if (array_key_exists('manager_id', $input)) { $updates[] = "manager_id = ?"; $params[] = $input['manager_id'] ?: null; }
            
            if (!empty($updates)) {
                $sql .= implode(", ", $updates) . " WHERE id = ?";
                $params[] = $userId;
                $this->db->prepare($sql)->execute($params);
            }
        }

        if (isset($input['budget']) || isset($input['gpa']) || isset($input['status']) || isset($input['score']) || isset($input['currency']) || array_key_exists('manager_id', $input)) {
            $stmt = $this->db->prepare("SELECT id FROM study_leads WHERE user_id = ?");
            $stmt->execute([$userId]);
            $lead = $stmt->fetch();

            if ($lead) {
                $sql = "UPDATE study_leads SET ";
                $params = [];
                $updates = [];

                if (isset($input['budget'])) { $updates[] = "budget = ?"; $params[] = $input['budget']; }
                if (isset($input['currency'])) { $updates[] = "currency = ?"; $params[] = $input['currency']; }
                if (isset($input['gpa'])) { $updates[] = "gpa = ?"; $params[] = $input['gpa']; }
                if (isset($input['status'])) { $updates[] = "status = ?"; $params[] = $input['status']; }
                if (isset($input['score'])) { $updates[] = "score = ?"; $params[] = $input['score']; }
                if (array_key_exists('manager_id', $input)) { $updates[] = "manager_id = ?"; $params[] = $input['manager_id'] ?: null; }

                if (!empty($updates)) {
                    $sql .= implode(", ", $updates) . " WHERE id = ?";
                    $params[] = $lead['id'];
                    $this->db->prepare($sql)->execute($params);
                }
            }
        }

        echo json_encode(['success' => true]);
    }

    public function updateLeadStatus()
    {
        header('Content-Type: application/json');

        $input = json_decode(file_get_contents('php://input'), true);
        $leadId = $input['id'] ?? null;
        $status = $input['status'] ?? null;

        if (!$leadId || !$status) {
            http_response_code(400);
            echo json_encode(['error' => 'Invalid input']);
            return;
        }

        $stmt = $this->db->prepare("UPDATE study_leads SET status = ?, updated_at = NOW() WHERE user_id = ?");
        $stmt->execute([$status, $leadId]);

        echo json_encode(['success' => true]);
    }

    public function downloadPdf()
    {
        $id = $_GET['id'] ?? null;
        if (!$id) {
            http_response_code(400);
            echo 'No ID';
            return;
        }

        if (!$this->canAccessStudent($id)) {
            http_response_code(403);
            echo 'Access Denied';
            return;
        }

        $stmt = $this->db->prepare("SELECT id, full_name, email, phone, created_at FROM study_users WHERE id = ?");
        $stmt->execute([$id]);
        $student = $stmt->fetch(\PDO::FETCH_ASSOC);

        $stmt = $this->db->prepare("SELECT type, original_name, status FROM study_documents WHERE user_id = ?");
        $stmt->execute([$id]);
        $documents = $stmt->fetchAll(\PDO::FETCH_ASSOC);

        if (!$student) {
            http_response_code(404);
            echo 'Student not found';
            return;
        }

        $progStmt = $this->db->prepare("
            SELECT ud.desired_country, ud.desired_program, su.name as university_name 
            FROM study_user_details ud 
            LEFT JOIN study_universities su ON ud.desired_university_id = su.id 
            WHERE ud.user_id = ?
        ");
        $progStmt->execute([$id]);
        $programData = $progStmt->fetch(\PDO::FETCH_ASSOC);

        $pdfService = new \App\Services\PdfService();
        $pdfService->generateStudentApplication($student, $documents, $programData ?: null);
    }

    public function settingsPage()
    {
        $page = 'settings';
        require __DIR__ . '/../../views/layouts/admin.php';
    }

    public function getSettings()
    {
        header('Content-Type: application/json');

        $settingModel = new \App\Models\Setting();

        // Seed default values for required keys if they don't exist yet
        $defaults = [
            'maintenance_mode' => '0',
            'terms_url'        => '',
            'company_email'    => '',
        ];
        foreach ($defaults as $key => $defaultVal) {
            $existing = $settingModel->get($key);
            if ($existing === null) {
                $settingModel->set($key, $defaultVal);
            }
        }

        $settings = $settingModel->getAll();

        echo json_encode(['settings' => $settings]);
    }

    public function updateSettings()
    {
        header('Content-Type: application/json');

        $input = json_decode(file_get_contents('php://input'), true);
        $settings = $input['settings'] ?? [];

        if (empty($settings)) {
            echo json_encode(['success' => false, 'error' => 'No settings provided']);
            return;
        }

        $settingModel = new \App\Models\Setting();
        $settingModel->setMany($settings);

        echo json_encode(['success' => true]);
    }
}
