<?php

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
$router->get('/api/manager/urgent-leads',      [\App\Controllers\ManagerPanelController::class, 'getUrgentLeads'],    ['auth', 'role:admin,manager']);
$router->get('/api/manager/action-queue',      [\App\Controllers\ManagerPanelController::class, 'getActionQueue'],    ['auth', 'role:admin,manager']);
