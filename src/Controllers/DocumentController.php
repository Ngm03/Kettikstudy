<?php

namespace App\Controllers;

use App\Core\Database;
use App\Services\AuthService;

class DocumentController
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

    public function upload()
    {
        header('Content-Type: application/json');
        
        $userId = $this->getUserId();
        if (!$userId) {
            http_response_code(401);
            echo json_encode(['error' => 'Unauthorized']);
            return;
        }

        if (!isset($_FILES['file']) || !isset($_POST['type'])) {
            http_response_code(400);
            echo json_encode(['error' => 'No file or type provided']);
            return;
        }

        $file = $_FILES['file'];
        $type = $_POST['type'];

        $finfo = finfo_open(FILEINFO_MIME_TYPE);
        $mimeType = finfo_file($finfo, $file['tmp_name']);
        finfo_close($finfo);

        $allowedMimes = ['application/pdf', 'image/jpeg', 'image/png'];
        if (!in_array($mimeType, $allowedMimes)) {
            http_response_code(400);
            echo json_encode(['error' => 'Invalid file format. Only PDF, JPG, PNG allowed.']);
            return;
        }

        if ($file['size'] > 5 * 1024 * 1024) {
            http_response_code(400);
            echo json_encode(['error' => 'File too large. Max 5MB.']);
            return;
        }

        $uploadDir = __DIR__ . '/../../uploads/docs/' . $userId . '/';
        if (!is_dir($uploadDir)) {
            mkdir($uploadDir, 0755, true);
        }

        $filename = time() . '_' . basename($file['name']);
        $destination = $uploadDir . $filename;
        $relativePath = 'uploads/docs/' . $userId . '/' . $filename;

        if (move_uploaded_file($file['tmp_name'], $destination)) {
            if ($type !== 'other') {
                $stmt = $this->db->prepare("SELECT id, file_path FROM study_documents WHERE user_id = ? AND type = ?");
                $stmt->execute([$userId, $type]);
                $existing = $stmt->fetch(\PDO::FETCH_ASSOC);

                if ($existing) {
                    $oldPath = __DIR__ . '/../../' . $existing['file_path'];
                    if (file_exists($oldPath)) @unlink($oldPath);

                    $stmt = $this->db->prepare("
                        UPDATE study_documents 
                        SET file_path = ?, original_name = ?, status = 'pending', rejection_reason = NULL, created_at = CURRENT_TIMESTAMP 
                        WHERE id = ?
                    ");
                    $stmt->execute([$relativePath, $file['name'], $existing['id']]);
                } else {
                    $stmt = $this->db->prepare("INSERT INTO study_documents (user_id, type, file_path, original_name, status) VALUES (?, ?, ?, ?, 'pending')");
                    $stmt->execute([$userId, $type, $relativePath, $file['name']]);
                }
            } else {
                $stmt = $this->db->prepare("INSERT INTO study_documents (user_id, type, file_path, original_name, status) VALUES (?, ?, ?, ?, 'pending')");
                $stmt->execute([$userId, $type, $relativePath, $file['name']]);
            }

            $stmt = $this->db->prepare("SELECT full_name FROM study_users WHERE id = ?");
            $stmt->execute([$userId]);
            $user = $stmt->fetch(\PDO::FETCH_ASSOC);

            $typeLabels = [
                'passport' => 'Паспорт',
                'transcript' => 'Аттестат',
                'certificate' => 'Сертификат'
            ];
            NotificationController::notifyAdmins(
                '📄 Новый документ',
                ($user['full_name'] ?? 'Студент') . ' загрузил документ: ' . ($typeLabels[$type] ?? $type),
                '/study/public/admin/student?id=' . $userId,
                'document'
            );

            echo json_encode(['success' => true, 'message' => 'File uploaded successfully']);
        } else {
            http_response_code(500);
            echo json_encode(['error' => 'Failed to save file']);
        }
    }

    public function list()
    {
        header('Content-Type: application/json');
        
        $userId = $this->getUserId();
        if (!$userId) {
            http_response_code(401);
            echo json_encode(['error' => 'Unauthorized']);
            return;
        }

        $stmt = $this->db->prepare("SELECT id, type, original_name, status, comment, rejection_reason, created_at FROM study_documents WHERE user_id = ? ORDER BY created_at DESC");
        $stmt->execute([$userId]);
        $docs = $stmt->fetchAll(\PDO::FETCH_ASSOC);

        $status = 'waiting_upload';
        $step = 2;
        $statusLabel = 'Ожидает загрузки';
        $statusDesc = 'Загрузите необходимые документы список.';

        if (count($docs) > 0) {
            $hasRejected = false;
            $hasPending = false;
            $approvedCount = 0;
            $requiredTypes = ['passport', 'transcript', 'certificate'];
            $uploadedTypes = [];

            foreach ($docs as $doc) {
                if ($doc['status'] === 'rejected') $hasRejected = true;
                if ($doc['status'] === 'pending') $hasPending = true;
                if ($doc['status'] === 'approved') {
                    $approvedCount++;
                    if (in_array($doc['type'], $requiredTypes)) {
                        $uploadedTypes[] = $doc['type'];
                    }
                }
            }

            $uploadedTypes = array_unique($uploadedTypes);

            if ($hasRejected) {
                $status = 'action_required';
                $step = 2;
                $statusLabel = 'Требует внимания';
                $statusDesc = 'Некоторые документы были отклонены. Проверьте комментарии.';
            } elseif ($hasPending) {
                $status = 'under_review';
                $step = 3;
                $statusLabel = 'На проверке';
                $statusDesc = 'Ваши документы проверяются менеджером.';
            } elseif (count($uploadedTypes) >= 3) {
                $status = 'approved';
                $step = 4;
                $statusLabel = 'Документы приняты';
                $statusDesc = 'Все документы одобрены. Готовим подачу в ВУЗ.';
            } else {
                 $status = 'uploading';
                 $step = 2;
                 $statusLabel = 'Продолжайте загрузку';
                 $statusDesc = 'Загрузите оставшиеся документы.';
            }
        }

        echo json_encode(['documents' => $docs, 'status' => $status, 'step' => $step, 'label' => $statusLabel, 'desc' => $statusDesc]);
    }

    public function delete()
    {
        header('Content-Type: application/json');
        
        $userId = $this->getUserId();
        if (!$userId) {
            http_response_code(401);
            echo json_encode(['error' => 'Unauthorized']);
            return;
        }

        $input = json_decode(file_get_contents('php://input'), true);
        $docId = $input['id'] ?? null;

        if (!$docId) {
            http_response_code(400);
            echo json_encode(['error' => 'Missing document ID']);
            return;
        }

        $stmt = $this->db->prepare("SELECT * FROM study_documents WHERE id = ? AND user_id = ?");
        $stmt->execute([$docId, $userId]);
        $doc = $stmt->fetch();

        if (!$doc) {
            http_response_code(404);
            echo json_encode(['error' => 'Document not found']);
            return;
        }

        $filePath = $doc['file_path'];
        // Support both relative and absolute paths
        if (!str_starts_with($filePath, '/') && !preg_match('/^[A-Z]:/i', $filePath)) {
            $filePath = __DIR__ . '/../../' . $filePath;
        }

        if (file_exists($filePath)) {
            unlink($filePath);
        }

        $stmt = $this->db->prepare("DELETE FROM study_documents WHERE id = ?");
        $stmt->execute([$docId]);

        echo json_encode(['success' => true, 'message' => 'Document deleted']);
    }

    public function view()
    {
        $token = $_COOKIE['auth_token'] ?? null;
        if (!$token) {
            http_response_code(403);
            echo 'Forbidden';
            return;
        }
        $decoded = $this->authService->validateToken($token);
        if (!$decoded) {
            http_response_code(403);
            echo 'Forbidden';
            return;
        }

        $userId = $decoded['sub'];
        $role = $decoded['role'];
        $docId = $_GET['id'] ?? null;

        if (!$docId) {
            http_response_code(400);
            echo 'No ID';
            return;
        }

        $stmt = $this->db->prepare("SELECT * FROM study_documents WHERE id = ?");
        $stmt->execute([$docId]);
        $doc = $stmt->fetch();

        if (!$doc) {
            http_response_code(404);
            echo 'Not Found';
            return;
        }

        $roleStr = strtolower($role ?? '');
        if (!str_contains($roleStr, 'admin') && $doc['user_id'] != $userId) {
            http_response_code(403);
            echo 'Access Denied';
            return;
        }

        $filePath = $doc['file_path'];
        // Support both relative and absolute paths
        if (!str_starts_with($filePath, '/') && !preg_match('/^[A-Z]:/i', $filePath)) {
            $filePath = __DIR__ . '/../../' . $filePath;
        }

        if (file_exists($filePath)) {
            $mime = mime_content_type($filePath);
            header('Content-Type: ' . $mime);
            header('Content-Length: ' . filesize($filePath));
            header('Content-Disposition: inline; filename="' . $doc['original_name'] . '"');
            readfile($filePath);
        } else {
            http_response_code(404);
            echo 'File missing on server';
        }
    }
}
