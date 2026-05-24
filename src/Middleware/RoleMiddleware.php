<?php

namespace App\Middleware;

/**
 * RoleMiddleware — проверяет, что аутентифицированный пользователь
 * имеет одну из разрешённых ролей.
 *
 * Всегда используется ПОСЛЕ AuthMiddleware.
 * Получает decoded JWT payload от AuthMiddleware через Router.
 */
class RoleMiddleware
{
    private array $allowedRoles;

    /**
     * @param array $allowedRoles Список ролей, которым разрешён доступ.
     *                            Например: ['admin'] или ['admin', 'manager']
     */
    public function __construct(array $allowedRoles)
    {
        $this->allowedRoles = $allowedRoles;
    }

    /**
     * Проверяет роль из декодированного JWT payload.
     * При отказе — отвечает 403 и завершает выполнение.
     *
     * @param array $decodedToken Результат AuthMiddleware::handle()
     */
    public function handle(array $decodedToken): void
    {
        $role = strtolower(trim($decodedToken['role'] ?? ''));

        // Приводим все разрешённые роли к нижнему регистру и обрезаем пробелы для максимальной надежности
        $allowed = array_map(function ($r) {
            return strtolower(trim($r));
        }, $this->allowedRoles);

        if (!in_array($role, $allowed, true)) {
            $this->deny($role);
        }
    }

    private function deny(string $actualRole): void
    {
        $acceptsJson = isset($_SERVER['HTTP_ACCEPT'])
            && str_contains($_SERVER['HTTP_ACCEPT'], 'application/json');

        $isApiRequest = str_starts_with($_SERVER['REQUEST_URI'] ?? '', '/api/');

        http_response_code(403);

        if ($acceptsJson || $isApiRequest) {
            header('Content-Type: application/json');
            echo json_encode([
                'error' => 'Access denied',
                'required_roles' => $this->allowedRoles,
            ]);
        } else {
            echo '<h1>403 — Access Denied</h1>';
            echo '<p>Required role: ' . implode(' or ', $this->allowedRoles) . '</p>';
        }

        exit;
    }
}
