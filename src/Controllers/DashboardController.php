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
