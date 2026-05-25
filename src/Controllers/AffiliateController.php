<?php

namespace App\Controllers;

use App\Core\Database;
use App\Services\AuthService;

class AffiliateController
{
    private $db;
    private $authService;

    public function __construct()
    {
        $this->db = Database::getInstance()->getConnection();
        $this->authService = new AuthService();
    }

    public function index()
    {
        $user = $this->authService->getUserFromCookie();
        if (!$user || $user['role'] !== 'affiliate') {
            header('Location: ' . BASE_URL . '/login');
            exit;
        }

        $stmt = $this->db->prepare("SELECT affiliate_code FROM study_users WHERE id = ?");
        $stmt->execute([$user['sub']]);
        $affiliateCode = $stmt->fetchColumn();

        $stmt2 = $this->db->prepare("
            SELECT u.id, u.full_name, u.created_at, u.enrolled_role,
                   (SELECT status FROM study_leads WHERE user_id = u.id ORDER BY updated_at DESC LIMIT 1) as lead_status
            FROM study_users u
            WHERE u.referred_by = ?
            ORDER BY u.created_at DESC
        ");
        $stmt2->execute([$user['sub']]);
        $referrals = $stmt2->fetchAll(\PDO::FETCH_ASSOC);

        require __DIR__ . '/../../views/affiliate/dashboard.php';
    }
}
