<?php

// ПУБЛИЧНЫЕ МАРШРУТЫ (без middleware)
$router->get('/', function () {
    try {
        $universityModel = new \App\Models\University();
        $universities    = $universityModel->getAll();
    } catch (Exception $e) {
        $universities = [];
    }
    require __DIR__ . '/../views/home.php';
});

// Установка языка
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

// Личный кабинет студента
$router->get('/dashboard',            [\App\Controllers\DashboardController::class, 'index'],     ['auth']);
$router->get('/dashboard/documents',  [\App\Controllers\DashboardController::class, 'documents'], ['auth']);
$router->get('/dashboard/profile',    [\App\Controllers\DashboardController::class, 'profile'],   ['auth']);
$router->get('/dashboard/community',  [\App\Controllers\DashboardController::class, 'community'], ['auth']);
$router->get('/dashboard/prices',     [\App\Controllers\DashboardController::class, 'prices'],    ['auth']);
$router->get('/dashboard/schedule',   [\App\Controllers\DashboardController::class, 'schedule'],  ['auth']);
$router->get('/dashboard/tasks',      [\App\Controllers\DashboardController::class, 'tasks'],     ['auth']);

// Панель партнера (SMM)
$router->get('/affiliate',            [\App\Controllers\AffiliateController::class, 'index'],     ['auth', 'role:affiliate']);
