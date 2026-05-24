<?php

namespace App\Middleware;

use App\Services\AuthService;
use App\Core\Database;

/**
 * AuthMiddleware — проверяет наличие и валидность JWT-токена.
 *
 * Если токен отсутствует или невалиден:
 *  - Для HTML-запросов (браузер) — редирект на /login
 *  - Для API-запросов (Accept: application/json) — JSON 401
 */
class AuthMiddleware
{
    private AuthService $authService;
    private \PDO $db;

    public function __construct()
    {
        $this->authService = new AuthService();
        $this->db = Database::getInstance()->getConnection();
    }

    /**
     * Выполняет проверку. Возвращает массив данных токена при успехе.
     * При неудаче — отвечает и завершает выполнение (exit).
     *
     * @return array Декодированный payload JWT
     */
    public function handle(): array
    {
        $token = $_COOKIE['auth_token'] ?? null;
        $decoded = $token ? $this->authService->validateToken($token) : null;

        if (!$decoded) {
            $this->deny();
        }

        // --- Session Hydration (Global State Sync) ---
        $userId = $decoded['sub'] ?? null;
        if ($userId) {
            try {
                $stmt = $this->db->prepare("SELECT role FROM study_users WHERE id = ?");
                $stmt->execute([$userId]);
                $user = $stmt->fetch(\PDO::FETCH_ASSOC);

                if ($user) {
                    // Нормализуем роль (пробелы и регистр)
                    $role = strtolower(trim($user['role']));
                    $decoded['role'] = $role;

                    // Запускаем сессию PHP, если она ещё не запущена, для безопасности синхронизации
                    if (session_status() === PHP_SESSION_NONE && !headers_sent()) {
                        session_start();
                    }

                    // Перезаписываем сессионные переменные свежими данными
                    $_SESSION['user_id'] = $userId;
                    if (!isset($_SESSION['user']) || !is_array($_SESSION['user'])) {
                        $_SESSION['user'] = [];
                    }
                    $_SESSION['user']['id'] = $userId;
                    $_SESSION['user']['role'] = $role;
                } else {
                    // Если пользователь был удален из БД, лишаем доступа
                    $this->deny();
                }
            } catch (\Exception $e) {
                error_log('AuthMiddleware Hydration Error: ' . $e->getMessage());
            }
        }

        return $decoded;
    }

    private function deny(): void
    {
        $acceptsJson = isset($_SERVER['HTTP_ACCEPT'])
            && str_contains($_SERVER['HTTP_ACCEPT'], 'application/json');

        $isApiRequest = str_starts_with($_SERVER['REQUEST_URI'] ?? '', '/api/');

        if ($acceptsJson || $isApiRequest) {
            http_response_code(401);
            header('Content-Type: application/json');
            echo json_encode(['error' => 'Authentication required']);
        } else {
            $baseUrl = defined('BASE_URL') ? BASE_URL : '';
            header('Location: ' . $baseUrl . '/login');
        }

        exit;
    }
}
