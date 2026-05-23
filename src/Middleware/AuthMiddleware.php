<?php

namespace App\Middleware;

use App\Services\AuthService;

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

    public function __construct()
    {
        $this->authService = new AuthService();
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
