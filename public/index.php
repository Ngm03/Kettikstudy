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

ini_set('display_errors', 0);
error_reporting(E_ALL);

header('X-Content-Type-Options: nosniff');
header('X-Frame-Options: SAMEORIGIN');
header('X-XSS-Protection: 1; mode=block');
header('Referrer-Policy: strict-origin-when-cross-origin');
header("Content-Security-Policy: default-src 'self'; script-src 'self' 'unsafe-inline' https://cdn.jsdelivr.net https://cdnjs.cloudflare.com https://cdn.tailwindcss.com https://unpkg.com; style-src 'self' 'unsafe-inline' https://cdn.jsdelivr.net https://cdnjs.cloudflare.com https://fonts.googleapis.com https://unpkg.com; font-src 'self' https://fonts.gstatic.com https://cdnjs.cloudflare.com data:; img-src 'self' data: blob: https://images.unsplash.com https://source.unsplash.com; connect-src 'self'; frame-ancestors 'self';");

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
// ПУБЛИЧНЫЕ МАРШРУТЫ (без middleware)
// ============================================================

$router->get('/', function () {
    try {
        $universityModel = new \App\Models\University();
        $universities    = $universityModel->getAll();
    } catch (Exception $e) {
        $universities = [];
    }
    require __DIR__ . '/../views/home.php';
});

$router->get('/login', function () {
    require __DIR__ . '/../views/auth/login.php';
});

$router->get('/register', function () {
    require __DIR__ . '/../views/auth/register.php';
});

$router->post('/api/auth/register', [\App\Controllers\AuthController::class, 'register']);
$router->post('/api/auth/login',    [\App\Controllers\AuthController::class, 'login']);
$router->post('/api/auth/logout',   [\App\Controllers\AuthController::class, 'logout']);

// Восстановление пароля
$router->post('/api/auth/forgot-password', [\App\Controllers\PasswordResetController::class, 'forgotPassword']);
$router->post('/api/auth/reset-password',  [\App\Controllers\PasswordResetController::class, 'resetPassword']);

// Публичный AI-чат на лендинге (до регистрации)
$router->post('/api/chat/send', [\App\Controllers\ChatController::class, 'send']);

$router->post('/api/set-lang', function () {
    $data = json_decode(file_get_contents('php://input'), true);
    $lang = $data['lang'] ?? 'ru';
    if (in_array($lang, ['ru', 'kk'])) {
        setcookie('lang', $lang, time() + (86400 * 365), '/');
        echo json_encode(['success' => true]);
    } else {
        http_response_code(400);
        echo json_encode(['success' => false, 'error' => 'Invalid language']);
    }
});

$router->post('/api/leads/request-call', [\App\Controllers\LeadController::class, 'requestCall']);

// ============================================================
// АУТЕНТИФИЦИРОВАННЫЕ МАРШРУТЫ (только авторизован)
// ============================================================

$router->get('/api/auth/me', [\App\Controllers\AuthController::class, 'me'], ['auth']);

// Личный кабинет студента
$router->get('/dashboard',            [\App\Controllers\DashboardController::class, 'index'],     ['auth']);
$router->get('/dashboard/documents',  [\App\Controllers\DashboardController::class, 'documents'], ['auth']);
$router->get('/dashboard/profile',    [\App\Controllers\DashboardController::class, 'profile'],   ['auth']);
$router->get('/dashboard/community',  [\App\Controllers\DashboardController::class, 'community'], ['auth']);
$router->get('/dashboard/prices',     [\App\Controllers\DashboardController::class, 'prices'],    ['auth']);
$router->get('/dashboard/schedule',   [\App\Controllers\DashboardController::class, 'schedule'],  ['auth']);
$router->get('/dashboard/tasks',      [\App\Controllers\DashboardController::class, 'tasks'],     ['auth']);

// Документы студента
$router->post('/api/documents/upload', [\App\Controllers\DocumentController::class, 'upload'], ['auth']);
$router->get('/api/documents/list',    [\App\Controllers\DocumentController::class, 'list'],   ['auth']);
$router->get('/api/documents/view',    [\App\Controllers\DocumentController::class, 'view'],   ['auth']);
$router->post('/api/documents/delete', [\App\Controllers\DocumentController::class, 'delete'], ['auth']);

// Чеки об оплате (Студент)
$router->post('/api/payments/upload-receipt', [\App\Controllers\PaymentController::class, 'uploadReceipt'], ['auth']);
$router->get('/api/payments/my-receipts',     [\App\Controllers\PaymentController::class, 'myReceipts'],    ['auth']);
$router->get('/api/payments/view-receipt',    [\App\Controllers\PaymentController::class, 'viewReceipt'],   ['auth']);

// Профиль студента
$router->get('/api/profile/details',     [\App\Controllers\ProfileController::class, 'getDetails'],        ['auth']);
$router->post('/api/profile/update',     [\App\Controllers\ProfileController::class, 'updateDetails'],     ['auth']);
$router->get('/api/profile/progress',    [\App\Controllers\ProfileController::class, 'getProgress'],       ['auth']);
$router->get('/api/universities/list',   [\App\Controllers\ProfileController::class, 'getUniversitiesList'], ['auth']);

// Уведомления
$router->get('/api/notifications/unread',       [\App\Controllers\NotificationController::class, 'getUnread'],    ['auth']);
$router->post('/api/notifications/mark-read',   [\App\Controllers\NotificationController::class, 'markAsRead'],  ['auth']);
$router->post('/api/notifications/mark-all-read', [\App\Controllers\NotificationController::class, 'markAllAsRead'], ['auth']);

// Push-уведомления
$router->post('/api/push/subscribe',   [\App\Controllers\PushController::class, 'subscribe'],   ['auth']);
$router->post('/api/push/unsubscribe', [\App\Controllers\PushController::class, 'unsubscribe'], ['auth']);

// Задачи и расписание
$router->post('/api/tasks',    [\App\Controllers\TaskController::class,     'handle'], ['auth']);
$router->post('/api/schedule', [\App\Controllers\ScheduleController::class, 'create'], ['auth']);

// Community (список городов, прайсы)
$router->get('/api/community/data',          [\App\Controllers\CommunityController::class, 'getData'],     ['auth']);
$router->get('/api/community/prices',        [\App\Controllers\CommunityController::class, 'getPrices'],   ['auth']);
$router->post('/api/community/prices',       [\App\Controllers\CommunityController::class, 'addPrice'],    ['auth']);
$router->post('/api/community/prices/delete', [\App\Controllers\CommunityController::class, 'deletePrice'], ['auth']);
$router->get('/api/community/market-search', [\App\Controllers\CommunityController::class, 'searchMarket'], ['auth']);

$router->get('/api/cities/list', [\App\Controllers\CityController::class, 'listCities'], ['auth']);

// Community Chat (только авторизованные; enrolled-проверка внутри контроллера)
$router->get('/api/chat/rooms',            [\App\Controllers\CommunityChatController::class, 'getRooms'],           ['auth']);
$router->get('/api/chat/messages',         [\App\Controllers\CommunityChatController::class, 'getMessages'],        ['auth']);
$router->post('/api/chat/messages',        [\App\Controllers\CommunityChatController::class, 'sendMessage'],        ['auth']);
$router->post('/api/chat/messages/edit',   [\App\Controllers\CommunityChatController::class, 'editMessage'],        ['auth']);
$router->post('/api/chat/messages/delete', [\App\Controllers\CommunityChatController::class, 'deleteMessage'],      ['auth']);
$router->get('/api/chat/unread',           [\App\Controllers\CommunityChatController::class, 'getUnreadCounts'],    ['auth']);
$router->post('/api/chat/read',            [\App\Controllers\CommunityChatController::class, 'markRead'],           ['auth']);
$router->post('/api/chat/messages/react',  [\App\Controllers\CommunityChatController::class, 'reactMessage'],       ['auth']);
$router->get('/api/chat/messages/search',  [\App\Controllers\CommunityChatController::class, 'searchMessages'],     ['auth']);
$router->post('/api/chat/ping',            [\App\Controllers\CommunityChatController::class, 'ping'],               ['auth']);
$router->post('/api/chat/start-private',   [\App\Controllers\CommunityChatController::class, 'getOrCreatePrivateRoom'], ['auth']);

// ============================================================
// МАРШРУТЫ МЕНЕДЖЕРА (auth + role: admin или manager)
// ============================================================

$router->get('/manager',                   [\App\Controllers\ManagerPanelController::class, 'dashboard'],      ['auth', 'role:admin,manager']);
$router->get('/manager/leads',             [\App\Controllers\ManagerPanelController::class, 'leads'],          ['auth', 'role:admin,manager']);
$router->get('/manager/students',          [\App\Controllers\ManagerPanelController::class, 'students'],       ['auth', 'role:admin,manager']);
$router->get('/manager/student',           [\App\Controllers\ManagerPanelController::class, 'studentProfile'], ['auth', 'role:admin,manager']);
$router->get('/manager/chat',              [\App\Controllers\ManagerPanelController::class, 'chat'],           ['auth', 'role:admin,manager']);

$router->get('/api/manager/dashboard-stats',   [\App\Controllers\ManagerPanelController::class, 'getDashboardStats'], ['auth', 'role:admin,manager']);
$router->get('/api/manager/leads',             [\App\Controllers\ManagerPanelController::class, 'getLeads'],          ['auth', 'role:admin,manager']);
$router->post('/api/manager/leads/claim',      [\App\Controllers\ManagerPanelController::class, 'claimLead'],         ['auth', 'role:admin,manager']);
$router->post('/api/manager/leads/status',     [\App\Controllers\ManagerPanelController::class, 'updateLeadStatus'],  ['auth', 'role:admin,manager']);
$router->get('/api/manager/students',          [\App\Controllers\ManagerPanelController::class, 'getStudents'],       ['auth', 'role:admin,manager']);
$router->get('/api/manager/action-queue',      [\App\Controllers\ManagerPanelController::class, 'getActionQueue'],    ['auth', 'role:admin,manager']);

// ============================================================
// МАРШРУТЫ АДМИНИСТРАТОРА (auth + role: admin only)
// ============================================================

$router->get('/admin', function () {
    header('Location: ' . BASE_URL . '/admin/dashboard');
    exit;
}, ['auth', 'role:admin']);

$router->get('/admin/dashboard',      [\App\Controllers\AdminController::class, 'dashboard'],      ['auth', 'role:admin']);
$router->get('/admin/community',      [\App\Controllers\AdminController::class, 'communityPage'],  ['auth', 'role:admin']);
$router->get('/admin/prices',         [\App\Controllers\AdminController::class, 'pricesPage'],     ['auth', 'role:admin']);
$router->get('/admin/student',        [\App\Controllers\AdminController::class, 'studentPage'],    ['auth', 'role:admin']);
$router->get('/admin/documents',      [\App\Controllers\AdminController::class, 'documentsPage'],  ['auth', 'role:admin']);
$router->get('/admin/notifications',  [\App\Controllers\AdminController::class, 'notificationsPage'], ['auth', 'role:admin']);
$router->get('/admin/logs',           [\App\Controllers\AdminController::class, 'logsPage'],       ['auth', 'role:admin']);
$router->get('/admin/settings',       [\App\Controllers\AdminController::class, 'settingsPage'],   ['auth', 'role:admin']);

$router->get('/admin/analytics', function () {
    $page      = 'analytics';
    $pageTitle = 'Аналитика';
    require __DIR__ . '/../views/layouts/admin.php';
}, ['auth', 'role:admin']);

// Университеты
$router->get('/admin/universities',           [\App\Controllers\UniversityController::class, 'index'],  ['auth', 'role:admin']);
$router->post('/admin/universities/create',   [\App\Controllers\UniversityController::class, 'create'], ['auth', 'role:admin']);
$router->post('/admin/universities/delete',   [\App\Controllers\UniversityController::class, 'delete'], ['auth', 'role:admin']);

// Менеджеры
$router->get('/admin/managers',          [\App\Controllers\ManagerController::class, 'index'],  ['auth', 'role:admin']);
$router->post('/admin/managers/create',  [\App\Controllers\ManagerController::class, 'create'], ['auth', 'role:admin']);
$router->post('/admin/managers/delete',  [\App\Controllers\ManagerController::class, 'delete'], ['auth', 'role:admin']);
$router->post('/admin/managers/toggle',  [\App\Controllers\ManagerController::class, 'toggle'], ['auth', 'role:admin']);

// Admin API — только admin
$router->get('/api/admin/students',          [\App\Controllers\AdminController::class, 'listStudents'],       ['auth', 'role:admin']);
$router->get('/api/admin/student-details',   [\App\Controllers\AdminController::class, 'getStudentDetails'],  ['auth', 'role:admin,manager']);
$router->post('/api/admin/lead-status',      [\App\Controllers\AdminController::class, 'updateStatus'],       ['auth', 'role:admin,manager']);
$router->get('/api/admin/logs',              [\App\Controllers\AdminController::class, 'getLogs'],             ['auth', 'role:admin']);
$router->get('/api/admin/download-pdf',      [\App\Controllers\AdminController::class, 'downloadPdf'],        ['auth', 'role:admin,manager']);
$router->post('/api/admin/doc-status',       [\App\Controllers\AdminController::class, 'updateDocStatus'],    ['auth', 'role:admin,manager']);
$router->post('/api/admin/student-notes',    [\App\Controllers\AdminController::class, 'updateStudentNotes'], ['auth', 'role:admin,manager']);

// Управление чеками об оплате (Менеджер/Админ)
$router->get('/api/admin/receipts/pending',  [\App\Controllers\PaymentController::class, 'pendingReceipts'], ['auth', 'role:admin,manager']);
$router->post('/api/admin/receipts/approve', [\App\Controllers\PaymentController::class, 'approveReceipt'],  ['auth', 'role:admin,manager']);
$router->post('/api/admin/receipts/reject',  [\App\Controllers\PaymentController::class, 'rejectReceipt'],   ['auth', 'role:admin,manager']);
$router->post('/api/admin/update-details',   [\App\Controllers\AdminController::class, 'updateStudentDetails'], ['auth', 'role:admin,manager']);
$router->get('/api/admin/documents',         [\App\Controllers\AdminController::class, 'getAllDocuments'],     ['auth', 'role:admin,manager']);
$router->post('/api/admin/broadcast',        [\App\Controllers\AdminController::class, 'sendBroadcast'],      ['auth', 'role:admin']);
$router->get('/api/admin/broadcast-history', [\App\Controllers\AdminController::class, 'getBroadcastHistory'], ['auth', 'role:admin']);
$router->get('/api/admin/settings',          [\App\Controllers\AdminController::class, 'getSettings'],        ['auth', 'role:admin']);
$router->post('/api/admin/settings',         [\App\Controllers\AdminController::class, 'updateSettings'],     ['auth', 'role:admin']);
$router->post('/api/admin/chat-rooms',       [\App\Controllers\AdminController::class, 'updateChatRoom'],     ['auth', 'role:admin']);

$router->get('/api/analytics/dashboard',     [\App\Controllers\AnalyticsController::class, 'getDashboardStats'], ['auth', 'role:admin']);

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
