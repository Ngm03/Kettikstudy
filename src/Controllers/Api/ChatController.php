<?php

namespace App\Controllers\Api;

use App\Core\Database;
use App\Services\AuthService;

class ChatController
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

    private function isEnrolled($userId): bool
    {
        $stmt = $this->db->prepare("SELECT enrolled_role FROM study_users WHERE id = ?");
        $stmt->execute([$userId]);
        $user = $stmt->fetch();
        if ($user && $user['enrolled_role'] === 'enrolled') {
            return true;
        }

        $stmt = $this->db->prepare("SELECT status FROM study_contracts WHERE user_id = ? ORDER BY created_at DESC LIMIT 1");
        $stmt->execute([$userId]);
        $contract = $stmt->fetch();
        if ($contract && $contract['status'] === 'paid') {
            return true;
        }

        return false;
    }

    public function getRooms()
    {
        header('Content-Type: application/json');

        try {
            $userId = $this->getUserId();
            if (!$userId) {
                http_response_code(401);
                echo json_encode(['error' => 'Not authenticated']);
                return;
            }

            if (!$this->isEnrolled($userId)) {
                http_response_code(403);
                echo json_encode(['error' => 'Access denied. Enrolled students only.']);
                return;
            }

            $stmt = $this->db->prepare("SELECT id, type, name FROM study_chat_rooms WHERE type = 'general' LIMIT 1");
            $stmt->execute();
            $generalRoom = $stmt->fetch(\PDO::FETCH_ASSOC);
            
            if (!$generalRoom) {
                $this->db->exec("INSERT INTO study_chat_rooms (type, name) VALUES ('general', 'Kettik Study')");
                $generalId = $this->db->lastInsertId();
                $generalRoom = ['id' => $generalId, 'type' => 'general', 'name' => 'Kettik Study'];
            }

            $rooms = [$generalRoom];

            $stmt = $this->db->prepare("SELECT city_id FROM study_users WHERE id = ?");
            $stmt->execute([$userId]);
            $user = $stmt->fetch();

            if ($user && $user['city_id']) {
                $cityId = $user['city_id'];
                
                $stmt = $this->db->prepare("
                    SELECT cr.id, cr.type, cr.name, c.name as city_name 
                    FROM study_chat_rooms cr 
                    JOIN study_cities c ON cr.city_id = c.id
                    WHERE cr.type = 'city' AND cr.city_id = ?
                ");
                $stmt->execute([$cityId]);
                $cityRoom = $stmt->fetch(\PDO::FETCH_ASSOC);

                if ($cityRoom) {
                    $rooms[] = [
                        'id' => $cityRoom['id'],
                        'type' => 'city',
                        'name' => 'Чат ' . $cityRoom['city_name']
                    ];
                } else {
                    $stmt = $this->db->prepare("SELECT name FROM study_cities WHERE id = ?");
                    $stmt->execute([$cityId]);
                    $cityName = $stmt->fetchColumn();

                    if ($cityName) {
                        $insertStmt = $this->db->prepare("INSERT INTO study_chat_rooms (type, city_id, name) VALUES ('city', ?, ?)");
                        $insertStmt->execute([$cityId, 'Чат ' . $cityName]);
                        $newCityRoomId = $this->db->lastInsertId();

                        $rooms[] = [
                            'id' => $newCityRoomId,
                            'type' => 'city',
                            'name' => 'Чат ' . $cityName
                        ];
                    }
                }
            }

            echo json_encode(['rooms' => $rooms]);

        } catch (\PDOException $e) {
            http_response_code(500);
            error_log('Api\ChatController getRooms DB error: ' . $e->getMessage());
            echo json_encode(['error' => 'Database error']);
        } catch (\Exception $e) {
            http_response_code(500);
            error_log('Api\ChatController getRooms error: ' . $e->getMessage());
            echo json_encode(['error' => 'Internal server error']);
        }
    }

    public function getMessages()
    {
        header('Content-Type: application/json');

        $userId = $this->getUserId();
        if (!$userId) {
            http_response_code(401);
            echo json_encode(['error' => 'Not authenticated']);
            return;
        }

        if (!$this->isEnrolled($userId)) {
            http_response_code(403);
            echo json_encode(['error' => 'Access denied']);
            return;
        }

        $roomId = $_GET['room_id'] ?? null;
        $afterId = $_GET['after_id'] ?? 0;

        if (!$roomId) {
            http_response_code(400);
            echo json_encode(['error' => 'Room ID is required']);
            return;
        }

        $stmt = $this->db->prepare("SELECT type, city_id FROM study_chat_rooms WHERE id = ?");
        $stmt->execute([$roomId]);
        $room = $stmt->fetch();

        if (!$room) {
            http_response_code(404);
            echo json_encode(['error' => 'Room not found']);
            return;
        }

        if ($room['type'] === 'city') {
            $stmt = $this->db->prepare("SELECT city_id FROM study_users WHERE id = ?");
            $stmt->execute([$userId]);
            $userCity = $stmt->fetchColumn();

            if ($userCity != $room['city_id']) {
                http_response_code(403);
                echo json_encode(['error' => 'Access denied to this city room']);
                return;
            }
        }

        $stmt = $this->db->prepare("
            SELECT m.id, m.message, m.created_at, u.full_name as author_name, m.user_id
            FROM study_chat_messages m
            JOIN study_users u ON m.user_id = u.id
            WHERE m.room_id = ? AND m.id > ?
            ORDER BY m.id ASC
            LIMIT 100
        ");
        
        $stmt->execute([$roomId, $afterId]);
        $messages = $stmt->fetchAll(\PDO::FETCH_ASSOC);

        foreach ($messages as &$msg) {
            $msg['is_mine'] = ((int)$msg['user_id'] === (int)$userId);
            $msg['time'] = date('H:i', strtotime($msg['created_at']));
            unset($msg['user_id']);
        }

        echo json_encode(['messages' => $messages]);
    }

    public function sendMessage()
    {
        header('Content-Type: application/json');

        $userId = $this->getUserId();
        if (!$userId) {
            http_response_code(401);
            echo json_encode(['error' => 'Not authenticated']);
            return;
        }

        if (!$this->isEnrolled($userId)) {
            http_response_code(403);
            echo json_encode(['error' => 'Access denied']);
            return;
        }

        $data = json_decode(file_get_contents('php://input'), true);
        $roomId = $data['room_id'] ?? null;
        $message = trim($data['message'] ?? '');

        if (!$roomId || empty($message)) {
            http_response_code(400);
            echo json_encode(['error' => 'Room ID and non-empty message are required']);
            return;
        }

        $stmt = $this->db->prepare("SELECT type, city_id FROM study_chat_rooms WHERE id = ?");
        $stmt->execute([$roomId]);
        $room = $stmt->fetch();

        if (!$room) {
            http_response_code(404);
            echo json_encode(['error' => 'Room not found']);
            return;
        }

        if ($room['type'] === 'city') {
            $stmt = $this->db->prepare("SELECT city_id FROM study_users WHERE id = ?");
            $stmt->execute([$userId]);
            $userCity = $stmt->fetchColumn();

            if ($userCity != $room['city_id']) {
                http_response_code(403);
                echo json_encode(['error' => 'Access denied to this city room']);
                return;
            }
        }

        $stmt = $this->db->prepare("INSERT INTO study_chat_messages (room_id, user_id, message) VALUES (?, ?, ?)");
        $success = $stmt->execute([$roomId, $userId, htmlspecialchars($message)]);

        if ($success) {
            echo json_encode(['success' => true]);
        } else {
            http_response_code(500);
            echo json_encode(['error' => 'Failed to send message']);
        }
    }
}
