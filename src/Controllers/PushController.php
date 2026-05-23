<?php
namespace App\Controllers;

use App\Core\Database;
use PDO;

class PushController {
    private $db;

    public function __construct() {
        $this->db = Database::getInstance()->getConnection();
    }

    public function subscribe()
    {
        header('Content-Type: application/json');

        $token = $_COOKIE['auth_token'] ?? null;
        
        if (!$token) {
            http_response_code(401);
            echo json_encode(['error' => 'Unauthorized - No token']);
            return;
        }
        
        try {
            $authService = new \App\Services\AuthService();
            $decoded = $authService->validateToken($token);
            
            if (!$decoded) {
                http_response_code(401);
                echo json_encode(['error' => 'Unauthorized - Invalid token']);
                return;
            }
            
            $user = [
                'id' => $decoded['sub'],
                'role' => $decoded['role']
            ];
            
        } catch (\Exception $e) {
            http_response_code(500);
            echo json_encode(['error' => 'Authentication error']);
            return;
        }

        $data = json_decode(file_get_contents('php://input'), true);
        
        if (!isset($data['endpoint'])) {
            http_response_code(400);
            echo json_encode(['error' => 'Missing endpoint']);
            return;
        }

        try {
            $stmt = $this->db->prepare("SELECT id FROM study_push_subscriptions WHERE user_id = ? AND endpoint = ?");
            $stmt->execute([$user['id'], $data['endpoint']]);
            
            if ($stmt->fetch()) {
                echo json_encode(['success' => true, 'message' => 'Already subscribed']);
                return;
            }

            $stmt = $this->db->prepare("
                INSERT INTO study_push_subscriptions (user_id, endpoint, p256dh, auth) 
                VALUES (?, ?, ?, ?)
            ");
            $stmt->execute([
                $user['id'],
                $data['endpoint'],
                $data['keys']['p256dh'] ?? null,
                $data['keys']['auth'] ?? null
            ]);

            echo json_encode(['success' => true, 'message' => 'Subscribed successfully']);
        } catch (\Exception $e) {
            http_response_code(500);
            error_log('Push subscribe error: ' . $e->getMessage());
            echo json_encode(['error' => 'Database error']);
        }
    }

    public function unsubscribe() {
        header('Content-Type: application/json');
        
        $user = $this->getUserFromToken();
        if (!$user) {
            http_response_code(401);
            echo json_encode(['error' => 'Unauthorized']);
            return;
        }

        $data = json_decode(file_get_contents('php://input'), true);
        
        $stmt = $this->db->prepare("DELETE FROM study_push_subscriptions WHERE user_id = ? AND endpoint = ?");
        $stmt->execute([$user['id'], $data['endpoint'] ?? '']);

        echo json_encode(['success' => true]);
    }

    public function sendToAdmins($title, $body, $url = '/study/public/admin/dashboard', $tag = 'admin-notification') {
        $stmt = $this->db->prepare("
            SELECT s.endpoint, s.p256dh, s.auth 
            FROM study_push_subscriptions s
            JOIN study_users u ON s.user_id = u.id
            WHERE u.role = 'admin'
        ");
        $stmt->execute();
        $subscriptions = $stmt->fetchAll(PDO::FETCH_ASSOC);

        if (empty($subscriptions)) {
            return ['success' => false, 'message' => 'No admin subscriptions found'];
        }

        $sent = 0;
        $failed = 0;
        $errors = [];

        foreach ($subscriptions as $sub) {
            try {
                if (strpos($sub['endpoint'], 'fcm.googleapis.com') !== false) {
                    $payload = json_encode([
                        'title' => $title,
                        'body' => $body,
                        'url' => $url,
                        'tag' => $tag,
                        'icon' => '/study/public/favicon.ico'
                    ]);
                    
                    $ch = curl_init($sub['endpoint']);
                    curl_setopt($ch, CURLOPT_POST, true);
                    curl_setopt($ch, CURLOPT_POSTFIELDS, $payload);
                    curl_setopt($ch, CURLOPT_HTTPHEADER, [
                        'Content-Type: application/json',
                        'TTL: 3600'
                    ]);
                    curl_setopt($ch, CURLOPT_RETURNTRANSFER, true);
                    
                    $result = curl_exec($ch);
                    $httpCode = curl_getinfo($ch, CURLINFO_HTTP_CODE);
                    curl_close($ch);
                    
                    if ($httpCode >= 200 && $httpCode < 300) {
                        $sent++;
                    } else if ($httpCode == 404 || $httpCode == 410) {
                        $stmt = $this->db->prepare("DELETE FROM study_push_subscriptions WHERE endpoint = ?");
                        $stmt->execute([$sub['endpoint']]);
                        $failed++;
                    } else {
                        $failed++;
                        $errors[] = "HTTP $httpCode";
                    }
                } else {
                    $failed++;
                }
            } catch (\Exception $e) {
                $failed++;
                $errors[] = $e->getMessage();
                error_log('Push notification error: ' . $e->getMessage());
            }
        }

        return [
            'success' => $sent > 0 || $failed === 0,
            'sent' => $sent,
            'failed' => $failed,
            'errors' => array_slice($errors, 0, 3)
        ];
    }

    private function getUserFromToken() {
        if (!isset($_COOKIE['auth_token'])) {
            return null;
        }

        try {
            $authService = new \App\Services\AuthService();
            $decoded = $authService->validateToken($_COOKIE['auth_token']);
            if (!$decoded) return null;
            return ['id' => $decoded['sub'], 'role' => $decoded['role']];
        } catch (\Exception $e) {
            return null;
        }
    }

    public function sendToUsers(array $userIds, $title, $body, $url = '/study/public/dashboard', $tag = 'broadcast') {
        if (empty($userIds)) return ['success' => false, 'message' => 'No users specified'];

        $placeholders = str_repeat('?,', count($userIds) - 1) . '?';
        $stmt = $this->db->prepare("
            SELECT endpoint, p256dh, auth 
            FROM study_push_subscriptions 
            WHERE user_id IN ($placeholders)
        ");
        $stmt->execute($userIds);
        $subscriptions = $stmt->fetchAll(PDO::FETCH_ASSOC);

        if (empty($subscriptions)) {
            return ['success' => false, 'message' => 'No subscriptions found for users'];
        }

        $sent = 0;
        $failed = 0;
        $errors = [];

        foreach ($subscriptions as $sub) {
            try {
                if (strpos($sub['endpoint'], 'fcm.googleapis.com') !== false) {
                    $payload = json_encode([
                        'title' => $title,
                        'body' => $body,
                        'url' => $url,
                        'tag' => $tag,
                        'icon' => '/study/public/favicon.ico'
                    ]);
                    
                    $ch = curl_init($sub['endpoint']);
                    curl_setopt($ch, CURLOPT_POST, true);
                    curl_setopt($ch, CURLOPT_POSTFIELDS, $payload);
                    curl_setopt($ch, CURLOPT_HTTPHEADER, [
                        'Content-Type: application/json',
                        'TTL: 3600'
                    ]);
                    curl_setopt($ch, CURLOPT_RETURNTRANSFER, true);
                    
                    $result = curl_exec($ch);
                    $httpCode = curl_getinfo($ch, CURLINFO_HTTP_CODE);
                    curl_close($ch);
                    
                    if ($httpCode >= 200 && $httpCode < 300) {
                        $sent++;
                    } else if ($httpCode == 404 || $httpCode == 410) {
                        $stmt = $this->db->prepare("DELETE FROM study_push_subscriptions WHERE endpoint = ?");
                        $stmt->execute([$sub['endpoint']]);
                        $failed++;
                    } else {
                        $failed++;
                        $errors[] = "HTTP $httpCode";
                    }
                } else {
                    $failed++;
                    $errors[] = 'Non-FCM endpoint not supported';
                }
            } catch (\Exception $e) {
                $failed++;
                error_log('Push notification error: ' . $e->getMessage());
            }
        }

        return [
            'success' => $sent > 0 || $failed === 0,
            'sent' => $sent,
            'failed' => $failed
        ];
    }
}
