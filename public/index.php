<?php

require_once __DIR__ . '/../vendor/autoload.php';
require_once __DIR__ . '/../src/Helpers/I18n.php';

\App\Helpers\I18n::load();

if (!function_exists('__')) {
    function __($key) {
        return \App\Helpers\I18n::translate($key);
    }
}

use App\Core\Database;
use App\Core\Router;
use App\Core\Csrf;
use App\Core\RateLimiter;
use Dotenv\Dotenv;

$dotenv = Dotenv::createImmutable(__DIR__ . '/../');
$dotenv->safeLoad();

// Configure local error logging directory and file
$logDir = __DIR__ . '/../logs';
if (!is_dir($logDir)) {
    mkdir($logDir, 0755, true);
}
ini_set('log_errors', 1);
ini_set('error_log', $logDir . '/app.log');

ini_set('display_errors', 0);
error_reporting(E_ALL);

header('X-Content-Type-Options: nosniff');
header('X-Frame-Options: SAMEORIGIN');
header('X-XSS-Protection: 1; mode=block');
header('Referrer-Policy: strict-origin-when-cross-origin');
// header("Content-Security-Policy: default-src 'self'; script-src 'self' 'unsafe-inline' 'unsafe-eval' https://cdn.jsdelivr.net https://cdnjs.cloudflare.com https://cdn.tailwindcss.com https://unpkg.com; style-src 'self' 'unsafe-inline' https://cdn.jsdelivr.net https://cdnjs.cloudflare.com https://fonts.googleapis.com https://unpkg.com; font-src 'self' https://fonts.gstatic.com https://cdnjs.cloudflare.com data:; img-src * data: blob:; connect-src *; frame-ancestors 'self';");

// NOTE: Migrations removed from HTTP lifecycle. Run via CLI: php bin/migrate.php

try {
    if (session_status() === PHP_SESSION_NONE && !headers_sent()) {
        session_start();
    }
    Csrf::init();
} catch (\Exception $e) {
    error_log('CSRF init error: ' . $e->getMessage());
}

if (isset($_ENV['APP_URL']) && $_ENV['APP_URL'] !== '') {
    $baseUrl = $_ENV['APP_URL'];
} else {
    $scriptDir = dirname($_SERVER['SCRIPT_NAME']);
    $baseUrl = ($scriptDir === '/' || $scriptDir === '\\') ? '' : $scriptDir;
}
define('BASE_URL', $baseUrl);

$router = new Router();

// ============================================================
// ЗАГРУЗКА МАРШРУТОВ
// ============================================================

require_once __DIR__ . '/../routes/web.php';
require_once __DIR__ . '/../routes/auth.php';
require_once __DIR__ . '/../routes/api.php';
require_once __DIR__ . '/../routes/manager.php';
require_once __DIR__ . '/../routes/admin.php';

// ============================================================
// Диспетчеризация
// ============================================================

try {
    $router->dispatch($_SERVER['REQUEST_URI'], $_SERVER['REQUEST_METHOD']);
} catch (Throwable $e) {
    error_log('APP ERROR: ' . $e->getMessage() . "\n" . $e->getTraceAsString());
    http_response_code(500);
    header('Content-Type: application/json');
    echo json_encode(['error' => 'Internal server error']);
}
