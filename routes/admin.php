<?php

$router->get('/admin', function () {
    header('Location: ' . BASE_URL . '/admin/dashboard');
    exit;
}, ['auth', 'role:admin']);

$router->get('/admin/dashboard',      [\App\Controllers\AdminController::class, 'dashboard'],      ['auth', 'role:admin']);
$router->get('/admin/prices',         [\App\Controllers\AdminController::class, 'pricesPage'],     ['auth', 'role:admin']);
$router->get('/admin/student',        [\App\Controllers\AdminController::class, 'studentPage'],    ['auth', 'role:admin']);
$router->get('/admin/documents',      [\App\Controllers\AdminController::class, 'documentsPage'],  ['auth', 'role:admin']);
$router->get('/admin/settings',       [\App\Controllers\AdminController::class, 'settingsPage'],   ['auth', 'role:admin']);
$router->get('/admin/affiliates',     [\App\Controllers\AdminController::class, 'affiliatesPage'], ['auth', 'role:admin']);

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

// Admin API
$router->get('/api/admin/students',          [\App\Controllers\AdminController::class, 'listStudents'],       ['auth', 'role:admin']);
$router->get('/api/admin/student-details',   [\App\Controllers\AdminController::class, 'getStudentDetails'],  ['auth', 'role:admin,manager']);
$router->post('/api/admin/lead-status',      [\App\Controllers\AdminController::class, 'updateStatus'],       ['auth', 'role:admin,manager']);
$router->get('/api/admin/logs',              [\App\Controllers\AdminController::class, 'getLogs'],             ['auth', 'role:admin']);
$router->post('/api/admin/logs/clear',       [\App\Controllers\AdminController::class, 'clearLogs'],           ['auth', 'role:admin']);
$router->get('/api/admin/download-pdf',      [\App\Controllers\AdminController::class, 'downloadPdf'],        ['auth', 'role:admin,manager']);
$router->post('/api/admin/doc-status',       [\App\Controllers\AdminController::class, 'updateDocStatus'],    ['auth', 'role:admin,manager']);
$router->post('/api/admin/student-notes',    [\App\Controllers\AdminController::class, 'updateStudentNotes'], ['auth', 'role:admin,manager']);
$router->post('/api/admin/users/make-affiliate', [\App\Controllers\AdminController::class, 'makeAffiliate'], ['auth', 'role:admin']);
$router->post('/api/admin/users/remove-affiliate', [\App\Controllers\AdminController::class, 'removeAffiliate'], ['auth', 'role:admin']);

$router->get('/api/admin/fix-db', function() {
    $db = \App\Core\Database::getInstance()->getConnection();
    $db->exec("ALTER TABLE study_leads MODIFY COLUMN status VARCHAR(50) NOT NULL DEFAULT 'new'");
    echo "Fixed DB ENUM issue!";
});

$router->post('/api/admin/clear-urgent',     [\App\Controllers\AdminController::class, 'clearUrgent'],        ['auth', 'role:admin,manager']);

// Управление чеками об оплате (Менеджер/Админ)
$router->get('/api/admin/receipts/pending',  [\App\Controllers\PaymentController::class, 'pendingReceipts'], ['auth', 'role:admin,manager']);
$router->post('/api/admin/receipts/approve', [\App\Controllers\PaymentController::class, 'approveReceipt'],  ['auth', 'role:admin,manager']);
$router->post('/api/admin/receipts/reject',  [\App\Controllers\PaymentController::class, 'rejectReceipt'],   ['auth', 'role:admin,manager']);
$router->post('/api/admin/update-details',   [\App\Controllers\AdminController::class, 'updateStudentDetails'], ['auth', 'role:admin,manager']);
$router->get('/api/admin/documents',         [\App\Controllers\AdminController::class, 'getAllDocuments'],     ['auth', 'role:admin,manager']);
$router->get('/api/admin/settings',          [\App\Controllers\AdminController::class, 'getSettings'],        ['auth', 'role:admin']);
$router->post('/api/admin/settings',         [\App\Controllers\AdminController::class, 'updateSettings'],     ['auth', 'role:admin']);
$router->post('/api/admin/chat-rooms',       [\App\Controllers\AdminController::class, 'updateChatRoom'],     ['auth', 'role:admin']);

$router->get('/api/analytics/dashboard',     [\App\Controllers\AnalyticsController::class, 'getDashboardStats'], ['auth', 'role:admin']);
