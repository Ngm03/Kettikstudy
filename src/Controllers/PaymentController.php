<?php

namespace App\Controllers;

use App\Core\Database;
use App\Core\RateLimiter;
use App\Services\AuthService;
use App\Services\FileAttachmentService; // Reusing chat file attachment service logic if possible, or just finfo
use Exception;
use PDO;

class PaymentController
{
    private $db;
    private $authService;
    private $uploadDir;

    public function __construct()
    {
        $this->db = Database::getInstance()->getConnection();
        $this->authService = new AuthService();
        $this->uploadDir = __DIR__ . '/../../uploads/receipts';
        
        if (!is_dir($this->uploadDir)) {
            mkdir($this->uploadDir, 0777, true);
        }
    }

    private function getUserId()
    {
        $token = $_COOKIE['auth_token'] ?? null;
        if (!$token) {
            http_response_code(401);
            echo json_encode(['error' => 'Unauthorized']);
            exit;
        }
        $decoded = $this->authService->validateToken($token);
        if (!$decoded) {
            http_response_code(401);
            echo json_encode(['error' => 'Invalid token']);
            exit;
        }
        return $decoded['sub'];
    }

    private function getUserRole()
    {
        $token = $_COOKIE['auth_token'] ?? null;
        if (!$token) return null;
        $decoded = $this->authService->validateToken($token);
        return $decoded ? ($decoded['role'] ?? null) : null;
    }

    /**
     * Студент: Загрузка чека об оплате
     */
    public function uploadReceipt()
    {
        header('Content-Type: application/json');
        RateLimiter::enforce('upload_receipt', 10, 60);

        if ($_SERVER['REQUEST_METHOD'] !== 'POST') {
            http_response_code(405);
            echo json_encode(['error' => 'Method not allowed']);
            return;
        }

        $userId = $this->getUserId();

        if (!isset($_FILES['file']) || $_FILES['file']['error'] !== UPLOAD_ERR_OK) {
            http_response_code(400);
            echo json_encode(['error' => 'File upload failed or missing file']);
            return;
        }

        $amount = $_POST['amount'] ?? 0;
        $currency = $_POST['currency'] ?? 'KZT';
        $comment = trim($_POST['comment'] ?? '');
        $contractId = $_POST['contract_id'] ?? null;

        $file = $_FILES['file'];
        
        // Strict MIME check
        $finfo = finfo_open(FILEINFO_MIME_TYPE);
        $mimeType = finfo_file($finfo, $file['tmp_name']);
        finfo_close($finfo);

        $allowedMimes = [
            'image/jpeg', 'image/png', 'application/pdf'
        ];

        if (!in_array($mimeType, $allowedMimes)) {
            http_response_code(400);
            echo json_encode(['error' => 'Invalid file format. Only JPG, PNG, and PDF are allowed.']);
            return;
        }

        if ($file['size'] > 5 * 1024 * 1024) { // 5MB
            http_response_code(400);
            echo json_encode(['error' => 'File too large (max 5MB)']);
            return;
        }

        $safeExt = match($mimeType) {
            'image/jpeg' => 'jpg',
            'image/png' => 'png',
            'application/pdf' => 'pdf',
            default => 'bin'
        };
        $filename = uniqid('receipt_') . '_' . bin2hex(random_bytes(4)) . '.' . $safeExt;
        
        $userDir = $this->uploadDir . '/' . $userId;
        if (!is_dir($userDir)) {
            mkdir($userDir, 0777, true);
        }

        $destination = $userDir . '/' . $filename;

        if (move_uploaded_file($file['tmp_name'], $destination)) {
            $stmt = $this->db->prepare("
                INSERT INTO study_payment_receipts 
                (user_id, contract_id, file_path, original_name, amount, currency, comment, status) 
                VALUES (?, ?, ?, ?, ?, ?, ?, 'pending')
            ");
            $filePathToSave = $userId . '/' . $filename;
            
            if ($stmt->execute([$userId, $contractId, $filePathToSave, $file['name'], $amount, $currency, $comment])) {
                echo json_encode(['success' => true, 'message' => 'Receipt uploaded successfully']);
            } else {
                unlink($destination);
                http_response_code(500);
                echo json_encode(['error' => 'Failed to save to database']);
            }
        } else {
            http_response_code(500);
            echo json_encode(['error' => 'Failed to move uploaded file']);
        }
    }

    /**
     * Студент: Получить свои чеки
     */
    public function myReceipts()
    {
        header('Content-Type: application/json');
        $userId = $this->getUserId();

        $stmt = $this->db->prepare("
            SELECT id, original_name, amount, currency, status, rejection_reason, uploaded_at 
            FROM study_payment_receipts 
            WHERE user_id = ? 
            ORDER BY uploaded_at DESC
        ");
        $stmt->execute([$userId]);
        $receipts = $stmt->fetchAll(PDO::FETCH_ASSOC);

        echo json_encode(['success' => true, 'receipts' => $receipts]);
    }

    /**
     * Просмотр файла (доступно студенту и менеджеру)
     */
    public function viewReceipt()
    {
        $userId = $this->getUserId();
        $role = $this->getUserRole();
        $receiptId = $_GET['id'] ?? 0;

        $stmt = $this->db->prepare("SELECT user_id, file_path, original_name FROM study_payment_receipts WHERE id = ?");
        $stmt->execute([$receiptId]);
        $receipt = $stmt->fetch(PDO::FETCH_ASSOC);

        if (!$receipt) {
            http_response_code(404);
            die('Receipt not found');
        }

        // Check permissions: either owner or manager/admin
        if ($receipt['user_id'] != $userId && !in_array($role, ['manager', 'admin'])) {
            http_response_code(403);
            die('Access denied');
        }

        $fullPath = $this->uploadDir . '/' . $receipt['file_path'];

        if (!file_exists($fullPath)) {
            http_response_code(404);
            die('File missing on disk');
        }

        $finfo = finfo_open(FILEINFO_MIME_TYPE);
        $mimeType = finfo_file($finfo, $fullPath);
        finfo_close($finfo);

        header('Content-Type: ' . $mimeType);
        header('Content-Disposition: inline; filename="' . basename($receipt['original_name']) . '"');
        header('Content-Length: ' . filesize($fullPath));
        readfile($fullPath);
        exit;
    }

    /**
     * Менеджер: Очередь чеков на проверку
     */
    public function pendingReceipts()
    {
        header('Content-Type: application/json');
        $role = $this->getUserRole();
        if (!in_array($role, ['manager', 'admin'])) {
            http_response_code(403);
            echo json_encode(['error' => 'Access denied']);
            return;
        }

        $managerId = $this->getUserId();
        
        // Fetch pending receipts for students of this manager (or all if admin)
        $query = "
            SELECT r.id, r.user_id, r.amount, r.currency, r.uploaded_at, r.original_name, u.full_name as student_name
            FROM study_payment_receipts r
            JOIN study_users u ON r.user_id = u.id
            WHERE r.status = 'pending'
        ";
        
        $params = [];
        if ($role === 'manager') {
            $query .= " AND u.manager_id = ?";
            $params[] = $managerId;
        }
        
        $query .= " ORDER BY r.uploaded_at ASC";

        $stmt = $this->db->prepare($query);
        $stmt->execute($params);
        $receipts = $stmt->fetchAll(PDO::FETCH_ASSOC);

        echo json_encode(['success' => true, 'receipts' => $receipts]);
    }

    /**
     * Менеджер: Одобрить чек
     */
    public function approveReceipt()
    {
        header('Content-Type: application/json');
        $role = $this->getUserRole();
        if (!in_array($role, ['manager', 'admin'])) {
            http_response_code(403);
            echo json_encode(['error' => 'Access denied']);
            return;
        }

        $managerId = $this->getUserId();
        $input = json_decode(file_get_contents('php://input'), true);
        $receiptId = $input['id'] ?? 0;

        try {
            $this->db->beginTransaction();

            $stmt = $this->db->prepare("SELECT user_id, contract_id, status FROM study_payment_receipts WHERE id = ? FOR UPDATE");
            $stmt->execute([$receiptId]);
            $receipt = $stmt->fetch(PDO::FETCH_ASSOC);

            if (!$receipt || $receipt['status'] !== 'pending') {
                throw new Exception("Invalid receipt or already processed");
            }

            // 1. Update receipt status
            $stmtUpdateReceipt = $this->db->prepare("
                UPDATE study_payment_receipts 
                SET status = 'approved', reviewed_at = CURRENT_TIMESTAMP, reviewed_by = ? 
                WHERE id = ?
            ");
            $stmtUpdateReceipt->execute([$managerId, $receiptId]);

            // 2. Change student status to enrolled
            $stmtUpdateUser = $this->db->prepare("
                UPDATE study_users 
                SET enrolled_role = 'enrolled' 
                WHERE id = ?
            ");
            $stmtUpdateUser->execute([$receipt['user_id']]);

            // 3. (Optional) update contract if provided or find the latest contract
            $contractId = $receipt['contract_id'];
            if (!$contractId) {
                $stmtFindContract = $this->db->prepare("SELECT id FROM study_contracts WHERE user_id = ? ORDER BY id DESC LIMIT 1");
                $stmtFindContract->execute([$receipt['user_id']]);
                $contractId = $stmtFindContract->fetchColumn();
            }

            if ($contractId) {
                $stmtUpdateContract = $this->db->prepare("
                    UPDATE study_contracts 
                    SET status = 'paid', receipt_id = ? 
                    WHERE id = ?
                ");
                $stmtUpdateContract->execute([$receiptId, $contractId]);
            }

            $this->db->commit();
            echo json_encode(['success' => true, 'message' => 'Receipt approved and student is now enrolled.']);
        } catch (Exception $e) {
            $this->db->rollBack();
            http_response_code(500);
            echo json_encode(['error' => $e->getMessage()]);
        }
    }

    /**
     * Менеджер: Отклонить чек
     */
    public function rejectReceipt()
    {
        header('Content-Type: application/json');
        $role = $this->getUserRole();
        if (!in_array($role, ['manager', 'admin'])) {
            http_response_code(403);
            echo json_encode(['error' => 'Access denied']);
            return;
        }

        $managerId = $this->getUserId();
        $input = json_decode(file_get_contents('php://input'), true);
        $receiptId = $input['id'] ?? 0;
        $reason = trim($input['reason'] ?? '');

        if (empty($reason)) {
            http_response_code(400);
            echo json_encode(['error' => 'Rejection reason is required']);
            return;
        }

        $stmt = $this->db->prepare("
            UPDATE study_payment_receipts 
            SET status = 'rejected', rejection_reason = ?, reviewed_at = CURRENT_TIMESTAMP, reviewed_by = ? 
            WHERE id = ? AND status = 'pending'
        ");
        
        if ($stmt->execute([$reason, $managerId, $receiptId])) {
            echo json_encode(['success' => true, 'message' => 'Receipt rejected']);
        } else {
            http_response_code(500);
            echo json_encode(['error' => 'Failed to update receipt']);
        }
    }
}
