<?php

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

$router->get('/api/auth/me', [\App\Controllers\AuthController::class, 'me'], ['auth']);
