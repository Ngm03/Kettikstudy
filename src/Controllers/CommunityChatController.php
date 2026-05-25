<?php

namespace App\Controllers;

use App\Core\Database;
use App\Services\AuthService;
use App\Services\Chat\ChatRoomService;
use App\Services\Chat\MessageService;
use App\Services\Chat\FileAttachmentService;
use App\Services\Chat\AiBotService;

/**
 * CommunityChatController — тонкий HTTP-контроллер.
 *
 * Ответственность: парсинг HTTP-запроса → вызов сервиса → JSON-ответ.
 * Вся бизнес-логика находится в src/Services/Chat/*.
 *
 * Авторизация (auth JWT) — на уровне Router (AuthMiddleware).
 * Enrolled-проверка — остаётся здесь (специфична для чата).
 */
class CommunityChatController
{
    private \PDO $db;
    private AuthService $authService;
    private ChatRoomService $roomService;
    private MessageService $messageService;
    private AiBotService $botService;

    public function __construct()
    {
        if (session_status() === PHP_SESSION_NONE) {
            session_start();
        }

        $this->db             = Database::getInstance()->getConnection();
        $this->authService    = new AuthService();
        $this->roomService    = new ChatRoomService($this->db);
        $this->messageService = new MessageService($this->db);
        $this->botService     = new AiBotService($this->db);
    }

    // -------------------------------------------------------------------------
    // Rooms
    // -------------------------------------------------------------------------

    public function getRooms(): void
    {
        header('Content-Type: application/json');

        try {
            $userId = $this->requireUser();
            $this->requireEnrolled($userId);

            $rooms = $this->roomService->getRoomsForUser($userId);
            echo json_encode(['rooms' => array_values($rooms)]);
        } catch (\RuntimeException $e) {
            $this->error($e->getMessage(), $e->getCode() ?: 403);
        } catch (\Exception $e) {
            $this->error('Server error', 500);
        }
    }

    public function getOrCreatePrivateRoom(): void
    {
        header('Content-Type: application/json');

        try {
            $userId    = $this->requireUser();
            $studentId = $this->parseInput()['student_id'] ?? null;

            if (!$studentId) {
                $this->error('student_id required', 400);
                return;
            }

            // Только менеджер или admin может инициировать приватный чат
            $userRole = $this->getUserRole($userId);
            if (!in_array($userRole, ['admin', 'manager'], true)) {
                $this->error('Only managers/admins can start private chats', 403);
                return;
            }

            // Проверяем, что студент существует
            $stmt = $this->db->prepare('SELECT id FROM study_users WHERE id = ?');
            $stmt->execute([$studentId]);
            if (!$stmt->fetch()) {
                $this->error('Student not found', 404);
                return;
            }

            $roomId = $this->roomService->getOrCreatePrivateRoom($userId, (int) $studentId);
            echo json_encode(['success' => true, 'room_id' => $roomId]);
        } catch (\Exception $e) {
            $this->error('Server error', 500);
        }
    }

    // -------------------------------------------------------------------------
    // Messages
    // -------------------------------------------------------------------------

    public function getMessages(): void
    {
        header('Content-Type: application/json');

        try {
            $userId  = $this->requireUser();
            $this->requireEnrolled($userId);

            $roomId  = (int) ($_GET['room_id'] ?? 0);
            $afterId = (int) ($_GET['after_id'] ?? 0);

            if (!$roomId) {
                $this->error('room_id required', 400);
                return;
            }

            $room = $this->roomService->findRoom($roomId);
            if (!$room) {
                $this->error('Room not found', 404);
                return;
            }

            $userRole = $this->getUserRole($userId);
            if (!$this->roomService->userCanAccessRoom($userId, $userRole, $room)) {
                $this->error('Access denied', 403);
                return;
            }

            $messages = $this->messageService->getMessages($roomId, $afterId, $userId);
            echo json_encode(['messages' => $messages]);
        } catch (\Exception $e) {
            $this->error('Server error', 500);
        }
    }

    public function streamMessages(): void
    {
        header('Content-Type: text/event-stream');
        header('Cache-Control: no-cache');
        header('Connection: keep-alive');

        if (ob_get_level()) {
            ob_end_clean();
        }

        try {
            $userId  = $this->requireUser();
            $this->requireEnrolled($userId);

            $roomId  = (int) ($_GET['room_id'] ?? 0);
            $afterId = (int) ($_GET['after_id'] ?? 0);

            if (!$roomId) {
                echo "event: error\ndata: " . json_encode(['error' => 'room_id required']) . "\n\n";
                flush();
                exit;
            }

            $room = $this->roomService->findRoom($roomId);
            if (!$room) {
                echo "event: error\ndata: " . json_encode(['error' => 'Room not found']) . "\n\n";
                flush();
                exit;
            }

            $userRole = $this->getUserRole($userId);
            if (!$this->roomService->userCanAccessRoom($userId, $userRole, $room)) {
                echo "event: error\ndata: " . json_encode(['error' => 'Access denied']) . "\n\n";
                flush();
                exit;
            }

            session_write_close();
            ignore_user_abort(true);

            $lastId = $afterId;

            while (true) {
                if (connection_aborted()) {
                    break;
                }

                $messages = $this->messageService->getMessages($roomId, $lastId, $userId);
                
                if (!empty($messages)) {
                    foreach ($messages as $msg) {
                        if ($msg['id'] > $lastId) {
                            $lastId = $msg['id'];
                        }
                    }
                    echo "data: " . json_encode(['messages' => $messages]) . "\n\n";
                    if (ob_get_level() > 0) ob_flush();
                    flush();
                }

                sleep(2);
            }
        } catch (\Exception $e) {
            echo "event: error\ndata: " . json_encode(['error' => 'Server error']) . "\n\n";
            if (ob_get_level() > 0) ob_flush();
            flush();
            exit;
        }
    }

    public function sendMessage(): void
    {
        header('Content-Type: application/json');

        try {
            $userId = $this->requireUser();
            $this->requireEnrolled($userId);

            $data    = $this->parseInput();
            $roomId  = (int) ($data['room_id'] ?? 0);
            $message = trim($data['message'] ?? '');

            $hasAttachment = isset($_FILES['attachment']) && $_FILES['attachment']['error'] === UPLOAD_ERR_OK;

            if (!$roomId || (empty($message) && !$hasAttachment)) {
                $this->error('room_id and message or attachment required', 400);
                return;
            }

            $room = $this->roomService->findRoom($roomId);
            if (!$room) {
                $this->error('Room not found', 404);
                return;
            }

            $userRole = $this->getUserRole($userId);

            if (!$this->roomService->userCanAccessRoom($userId, $userRole, $room)) {
                $this->error('Access denied to this room', 403);
                return;
            }

            // Broadcast: только admin/manager могут писать
            if ($room['type'] === 'broadcast' && !in_array($userRole, ['admin', 'manager'], true)) {
                $this->error('Only admins/managers can post in broadcast channel', 403);
                return;
            }

            // Обработка вложения
            $attachmentUrl = null;
            if ($hasAttachment) {
                $uploadDir = __DIR__ . '/../../public/uploads/chat/';
                $baseUrl   = defined('BASE_URL') ? BASE_URL : '';
                $fileService = new FileAttachmentService($uploadDir, $baseUrl);

                try {
                    $attachmentUrl = $fileService->upload($_FILES['attachment']);
                } catch (\InvalidArgumentException $e) {
                    $this->error($e->getMessage(), 400);
                    return;
                }
            }

            $replyToId   = isset($data['reply_to_id']) ? (int) $data['reply_to_id'] : null;
            $replyToText = $data['reply_to_text'] ?? null;

            $this->messageService->saveMessage($roomId, $userId, $message, $attachmentUrl, $replyToId, $replyToText);

            echo json_encode(['success' => true]);

            // Отправляем ответ клиенту и продолжаем выполнение для AI-бота
            if (function_exists('fastcgi_finish_request')) {
                fastcgi_finish_request();
            } else {
                if (ob_get_level()) {
                    ob_end_flush();
                }
                flush();
            }

            // AI-бот (выполняется после ответа клиенту)
            if ($this->botService->shouldTrigger($message)) {
                $this->botService->respond($roomId);
            }
        } catch (\Exception $e) {
            error_log('CommunityChatController::sendMessage error: ' . $e->getMessage());
            $this->error('Server error', 500);
        }
    }

    public function editMessage(): void
    {
        header('Content-Type: application/json');

        try {
            $userId = $this->requireUser();
            $data   = $this->parseInput();

            $messageId = (int) ($data['message_id'] ?? 0);
            $newText   = trim($data['message'] ?? '');

            if (!$messageId || empty($newText)) {
                $this->error('message_id and message required', 400);
                return;
            }

            $this->messageService->editMessage($messageId, $userId, $newText);
            echo json_encode(['success' => true]);
        } catch (\RuntimeException $e) {
            $this->error($e->getMessage(), $e->getCode() ?: 403);
        } catch (\Exception $e) {
            $this->error('Server error', 500);
        }
    }

    public function deleteMessage(): void
    {
        header('Content-Type: application/json');

        try {
            $userId   = $this->requireUser();
            $userRole = $this->getUserRole($userId);
            $data     = $this->parseInput();

            $messageId = (int) ($data['message_id'] ?? 0);

            if (!$messageId) {
                $this->error('message_id required', 400);
                return;
            }

            $attachmentUrl = $this->messageService->deleteMessage($messageId, $userId, $userRole);

            // Удаляем файл вложения если был
            if ($attachmentUrl) {
                $uploadDir   = __DIR__ . '/../../public/uploads/chat/';
                $baseUrl     = defined('BASE_URL') ? BASE_URL : '';
                $fileService = new FileAttachmentService($uploadDir, $baseUrl);
                $fileService->delete($attachmentUrl);
            }

            echo json_encode(['success' => true]);
        } catch (\RuntimeException $e) {
            $this->error($e->getMessage(), $e->getCode() ?: 403);
        } catch (\Exception $e) {
            $this->error('Server error', 500);
        }
    }

    public function reactMessage(): void
    {
        header('Content-Type: application/json');

        try {
            $userId = $this->requireUser();
            $data   = $this->parseInput();

            $messageId = (int) ($data['message_id'] ?? 0);
            $emoji     = $data['emoji'] ?? '';

            if (!$messageId || empty($emoji)) {
                $this->error('message_id and emoji required', 400);
                return;
            }

            $action = $this->messageService->toggleReaction($messageId, $userId, $emoji);
            echo json_encode(['action' => $action]);
        } catch (\Exception $e) {
            $this->error('Server error', 500);
        }
    }

    public function searchMessages(): void
    {
        header('Content-Type: application/json');

        $userId = $this->requireUser();
        $query  = trim($_GET['q'] ?? '');
        $roomId = (int) ($_GET['room_id'] ?? 0);

        if (mb_strlen($query) < 2 || !$roomId) {
            echo json_encode(['results' => []]);
            return;
        }

        $results = $this->messageService->searchMessages($roomId, $query);
        echo json_encode(['results' => $results]);
    }

    // -------------------------------------------------------------------------
    // Read status / ping
    // -------------------------------------------------------------------------

    public function getUnreadCounts(): void
    {
        header('Content-Type: application/json');
        $userId = $this->requireUser();
        $counts = $this->messageService->getUnreadCounts($userId);
        echo json_encode(['unread' => $counts]);
    }

    public function markRead(): void
    {
        header('Content-Type: application/json');
        $userId = $this->requireUser();
        $data   = $this->parseInput();
        $roomId = (int) ($data['room_id'] ?? 0);

        if (!$roomId) {
            $this->error('room_id required', 400);
            return;
        }

        $this->messageService->markRoomAsRead($userId, $roomId);
        echo json_encode(['success' => true]);
    }

    public function ping(): void
    {
        header('Content-Type: application/json');
        $userId = $this->requireUser();
        $this->messageService->ping($userId);
        echo json_encode(['ok' => true]);
    }

    // -------------------------------------------------------------------------
    // Private helpers
    // -------------------------------------------------------------------------

    /**
     * Возвращает ID текущего пользователя. При отсутствии — отвечает 401 и exit.
     */
    private function requireUser(): int
    {
        // Сначала проверяем сессию (legacy)
        if (isset($_SESSION['user_id'])) {
            return (int) $_SESSION['user_id'];
        }

        // Затем JWT из cookie (основной способ)
        $token = $_COOKIE['auth_token'] ?? null;
        if ($token) {
            $decoded = $this->authService->validateToken($token);
            if ($decoded && isset($decoded['sub'])) {
                return (int) $decoded['sub'];
            }
        }

        // Router должен был поймать это через AuthMiddleware,
        // но на случай прямого вызова контроллера — защита здесь
        http_response_code(401);
        echo json_encode(['error' => 'Not authenticated']);
        exit;
    }

    /**
     * Проверяет, является ли студент enrolled (оплатил/зачислен).
     * При отказе — отвечает 403 и exit.
     */
    private function requireEnrolled(int $userId): void
    {
        $stmt = $this->db->prepare('SELECT role, enrolled_role FROM study_users WHERE id = ?');
        $stmt->execute([$userId]);
        $user = $stmt->fetch();

        if ($user && in_array($user['role'], ['admin', 'manager'], true)) {
            return; // staff всегда имеет доступ
        }

        if ($user && $user['enrolled_role'] === 'enrolled') {
            return;
        }

        $stmt = $this->db->prepare("SELECT status FROM study_contracts WHERE user_id = ? AND status = 'paid' LIMIT 1");
        $stmt->execute([$userId]);
        if ($stmt->fetch()) {
            return;
        }

        http_response_code(403);
        echo json_encode(['error' => 'Access denied. Enrolled students only.']);
        exit;
    }

    private function getUserRole(int $userId): string
    {
        $stmt = $this->db->prepare('SELECT role FROM study_users WHERE id = ?');
        $stmt->execute([$userId]);
        return (string) $stmt->fetchColumn();
    }

    /**
     * Универсальный парсер тела запроса (JSON или form-data).
     */
    private function parseInput(): array
    {
        $contentType = $_SERVER['CONTENT_TYPE'] ?? '';
        if (str_contains($contentType, 'application/json')) {
            return json_decode(file_get_contents('php://input'), true) ?? [];
        }
        return array_merge($_POST, $_GET);
    }

    private function error(string $message, int $code = 400): void
    {
        http_response_code($code);
        echo json_encode(['error' => $message]);
        exit;
    }
}
