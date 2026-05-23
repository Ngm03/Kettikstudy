<?php

namespace App\Controllers;

use App\Services\AuthService;

class DashboardController
{
    private $authService;

    public function __construct()
    {
        $this->authService = new AuthService();
    }

    private function checkAuth()
    {
        $token = $_COOKIE['auth_token'] ?? null;
        if (!$token || !$this->authService->validateToken($token)) {
            $redirect = defined('BASE_URL') ? BASE_URL . '/login' : '/login';
            header("Location: $redirect");
            exit;
        }
    }

    public function index()
    {
        $this->checkAuth();
        $page = 'home';
        require __DIR__ . '/../../views/layouts/dashboard.php';
    }

    public function documents()
    {
        $this->checkAuth();
        $page = 'documents';
        require __DIR__ . '/../../views/layouts/dashboard.php';
    }

    public function profile()
    {
        $this->checkAuth();
        $page = 'profile';
        require __DIR__ . '/../../views/layouts/dashboard.php';
    }

    public function contract()
    {
        $this->checkAuth();
        $page = 'contract';
        require __DIR__ . '/../../views/layouts/dashboard.php';
    }

    public function community()
    {
        $this->checkAuth();
        $page = 'community';
        require __DIR__ . '/../../views/layouts/dashboard.php';
    }

    public function prices()
    {
        $this->checkAuth();
        $page = 'prices';
        require __DIR__ . '/../../views/layouts/dashboard.php';
    }

    public function schedule()
    {
        $this->checkAuth();
        $page = 'schedule';
        require __DIR__ . '/../../views/layouts/dashboard.php';
    }

    public function tasks()
    {
        $this->checkAuth();
        $page = 'tasks';
        require __DIR__ . '/../../views/layouts/dashboard.php';
    }
}
