<?php

namespace App\Controllers;

use App\Services\AuthService;

class DashboardController
{
    private $authService;

    public function __construct()
    {
        $this->authService = new AuthService();
        
        // Prevent non-students from accessing the student dashboard
        $user = $this->authService->user();
        if ($user) {
            $role = strtolower(trim($user['role'] ?? ''));
            if ($role === 'admin') {
                header('Location: ' . BASE_URL . '/admin/dashboard');
                exit;
            } elseif ($role === 'manager') {
                header('Location: ' . BASE_URL . '/manager'); // Or /manager/dashboard if that exists
                exit;
            } elseif ($role === 'affiliate') {
                header('Location: ' . BASE_URL . '/affiliate');
                exit;
            }
            // If student, do nothing and allow access
        }
    }


    public function index()
    {
        $page = 'home';
        require __DIR__ . '/../../views/layouts/dashboard.php';
    }

    public function documents()
    {
        $page = 'documents';
        require __DIR__ . '/../../views/layouts/dashboard.php';
    }

    public function profile()
    {
        $page = 'profile';
        require __DIR__ . '/../../views/layouts/dashboard.php';
    }

    public function contract()
    {
        $page = 'contract';
        require __DIR__ . '/../../views/layouts/dashboard.php';
    }

    public function community()
    {
        $page = 'community';
        require __DIR__ . '/../../views/layouts/dashboard.php';
    }

    public function prices()
    {
        $page = 'prices';
        require __DIR__ . '/../../views/layouts/dashboard.php';
    }

    public function schedule()
    {
        $page = 'schedule';
        require __DIR__ . '/../../views/layouts/dashboard.php';
    }

    public function tasks()
    {
        $page = 'tasks';
        require __DIR__ . '/../../views/layouts/dashboard.php';
    }
}
