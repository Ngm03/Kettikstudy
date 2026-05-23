<?php

namespace App\Core;

use App\Middleware\AuthMiddleware;
use App\Middleware\RoleMiddleware;

/**
 * Router — фронт-контроллер маршрутизации.
 *
 * Поддерживает middleware-цепочки на уровне маршрутов.
 *
 * Регистрация маршрутов:
 *   // Публичный маршрут:
 *   $router->get('/login', [AuthController::class, 'loginPage']);
 *
 *   // Только для авторизованных:
 *   $router->get('/dashboard', [DashboardController::class, 'index'], ['auth']);
 *
 *   // Только для admin:
 *   $router->get('/admin/dashboard', [AdminController::class, 'dashboard'], ['auth', 'role:admin']);
 *
 *   // Для admin или manager:
 *   $router->get('/manager', [ManagerController::class, 'index'], ['auth', 'role:admin,manager']);
 */
class Router
{
    protected array $routes = [];

    /**
     * Регистрирует GET-маршрут.
     *
     * @param string          $path       URI path
     * @param callable|array  $callback   Callable или [ControllerClass, 'method']
     * @param array           $middleware Список middleware: 'auth', 'role:admin', 'role:admin,manager'
     */
    public function get(string $path, $callback, array $middleware = []): void
    {
        $this->routes['GET'][$path] = ['callback' => $callback, 'middleware' => $middleware];
    }

    /**
     * Регистрирует POST-маршрут.
     */
    public function post(string $path, $callback, array $middleware = []): void
    {
        $this->routes['POST'][$path] = ['callback' => $callback, 'middleware' => $middleware];
    }

    public function dispatch(string $uri, string $method): void
    {
        $path   = parse_url($uri, PHP_URL_PATH);
        $method = strtoupper($method);

        $scriptName = str_replace('\\', '/', dirname($_SERVER['SCRIPT_NAME']));

        if (strpos($path, $scriptName) === 0) {
            $path = substr($path, strlen($scriptName));
        }

        if (empty($path) || $path[0] !== '/') {
            $path = '/' . $path;
        }

        if ($path !== '/' && str_ends_with($path, '/')) {
            $path = rtrim($path, '/');
        }

        // CSRF-защита для всех POST-запросов
        if ($method === 'POST') {
            try {
                Csrf::check();
            } catch (\Exception $e) {
                error_log('CSRF check error: ' . $e->getMessage());
                http_response_code(403);
                header('Content-Type: application/json');
                echo json_encode(['error' => 'Security check failed']);
                return;
            }
        }

        if (!isset($this->routes[$method][$path])) {
            http_response_code(404);
            echo '404 Not Found';
            return;
        }

        $route    = $this->routes[$method][$path];
        $callback = $route['callback'];
        $middlewares = $route['middleware'];

        // --- Выполнение middleware-цепочки ---
        $decodedToken = null;

        foreach ($middlewares as $mw) {
            if ($mw === 'auth') {
                $authMiddleware = new AuthMiddleware();
                $decodedToken   = $authMiddleware->handle(); // exit если не авторизован
                continue;
            }

            if (str_starts_with($mw, 'role:')) {
                // Формат: 'role:admin' или 'role:admin,manager'
                $rolesStr = substr($mw, 5);
                $roles    = array_map('trim', explode(',', $rolesStr));

                // RoleMiddleware требует, чтобы перед ним был 'auth'
                if ($decodedToken === null) {
                    error_log("Router: RoleMiddleware used without AuthMiddleware on path {$path}");
                    $authMiddleware = new AuthMiddleware();
                    $decodedToken   = $authMiddleware->handle();
                }

                $roleMiddleware = new RoleMiddleware($roles);
                $roleMiddleware->handle($decodedToken); // exit если не та роль
                continue;
            }
        }
        // --- Конец middleware-цепочки ---

        try {
            if (is_array($callback)) {
                [$controllerName, $actionName] = $callback;

                if (!class_exists($controllerName)) {
                    throw new \Exception("Controller not found: {$controllerName}");
                }

                $controller = new $controllerName();

                if (!method_exists($controller, $actionName)) {
                    throw new \Exception("Method not found: {$actionName}");
                }

                call_user_func([$controller, $actionName]);
                return;
            }

            call_user_func($callback);
        } catch (\Exception $e) {
            error_log('Router error: ' . $e->getMessage());
            http_response_code(500);
            header('Content-Type: application/json');
            echo json_encode(['error' => 'Internal server error']);
        }
    }
}
