<?php

namespace App\Controllers;

use App\Core\Database;
use App\Services\AuthService;
use App\Services\MarketPriceService;

class CommunityController
{
    private $db;
    private $authService;
    private $marketService;

    public function __construct()
    {
        if (session_status() === PHP_SESSION_NONE) {
            session_start();
        }
        $this->db = Database::getInstance()->getConnection();
        $this->authService = new AuthService();
        $this->marketService = new MarketPriceService();
    }

    private function getUserId(): ?int
    {
        if (isset($_SESSION['user_id'])) {
            return $_SESSION['user_id'];
        }

        $token = $_COOKIE['auth_token'] ?? null;
        if ($token) {
            $decoded = $this->authService->validateToken($token);
            if ($decoded && isset($decoded['sub'])) {
                return $decoded['sub'];
            }
        }

        return null;
    }

    private function isEnrolled($userId)
    {
        $stmt = $this->db->prepare("SELECT role, enrolled_role FROM study_users WHERE id = ?");
        $stmt->execute([$userId]);
        $user = $stmt->fetch(\PDO::FETCH_ASSOC);
        if ($user) {
            if ($user['role'] === 'admin') return true;
            if ($user['enrolled_role'] === 'enrolled') return true;
        }
        return false;
    }

    public function getData()
    {
        header('Content-Type: application/json');
        
        $userId = $this->getUserId();
        if (!$userId) {
            http_response_code(401);
            echo json_encode(['error' => 'Not authenticated']);
            return;
        }

        if (!$this->isEnrolled($userId)) {
            http_response_code(403);
            echo json_encode(['error' => 'Access denied. Only enrolled students can access community features.']);
            return;
        }

        $stmt = $this->db->prepare("
            SELECT u.city_id, c.name_ru, c.name_en, c.chat_link 
            FROM study_users u 
            JOIN study_cities c ON u.city_id = c.id 
            WHERE u.id = ?
        ");
        $stmt->execute([$userId]);
        $cityInfo = $stmt->fetch(\PDO::FETCH_ASSOC);

        $response = [
            'general_chat' => 'https://t.me/+ExampleGeneralKettikChat',
            'city_chat' => null
        ];

        if ($cityInfo) {
            $response['city_chat'] = [
                'name' => $cityInfo['name_ru'] ?? $cityInfo['name_en'],
                'link' => $cityInfo['chat_link']
            ];
        }

        echo json_encode($response);
    }

    public function getPrices()
    {
        header('Content-Type: application/json');
        
        $userId = $this->getUserId();
        if (!$userId) {
            http_response_code(401);
            echo json_encode(['error' => 'Not authenticated']);
            return;
        }

        $stmt = $this->db->prepare("SELECT role, city_id FROM study_users WHERE id = ?");
        $stmt->execute([$userId]);
        $user = $stmt->fetch(\PDO::FETCH_ASSOC);

        $isAdmin = ($user && $user['role'] === 'admin');
        $userCity = $user ? $user['city_id'] : null;

        if (!$userCity && !$isAdmin) {
             echo json_encode(['prices' => []]);
             return;
        }

        if ($isAdmin && !$userCity) {
            $stmt = $this->db->prepare("
                SELECT pr.*, u.full_name as author, c.name_ru as city_name
                FROM study_price_reviews pr
                JOIN study_users u ON pr.user_id = u.id
                LEFT JOIN study_cities c ON pr.city_id = c.id
                ORDER BY pr.created_at DESC
            ");
            $stmt->execute();
        } else {
            $stmt = $this->db->prepare("
                SELECT pr.*, u.full_name as author 
                FROM study_price_reviews pr
                JOIN study_users u ON pr.user_id = u.id
                WHERE pr.city_id = ?
                ORDER BY pr.created_at DESC
            ");
            $stmt->execute([$userCity]);
        }
        
        $prices = $stmt->fetchAll(\PDO::FETCH_ASSOC);

        echo json_encode(['prices' => $prices, 'currency' => 'PLN', 'is_admin' => $isAdmin]);
    }

    public function addPrice()
    {
        header('Content-Type: application/json');
        
        $userId = $this->getUserId();
        if (!$userId) {
            http_response_code(401);
            echo json_encode(['error' => 'Not authenticated']);
            return;
        }

        $input = json_decode(file_get_contents('php://input'), true);
        
        if (empty($input['item_name']) || empty($input['price']) || empty($input['category'])) {
            http_response_code(400);
            echo json_encode(['error' => 'Missing required fields']);
            return;
        }

        $stmt = $this->db->prepare("SELECT role, city_id FROM study_users WHERE id = ?");
        $stmt->execute([$userId]);
        $user = $stmt->fetch(\PDO::FETCH_ASSOC);
        
        $cityId = $user ? $user['city_id'] : null;
        $isAdmin = ($user && $user['role'] === 'admin');

        if (!$cityId) {
            if ($isAdmin && !empty($input['city_id'])) {
                $cityId = $input['city_id'];
            } else {
                http_response_code(400);
                echo json_encode(['error' => 'You must be assigned to a city to add prices']);
                return;
            }
        }

        $stmt = $this->db->prepare("
            INSERT INTO study_price_reviews (city_id, user_id, category, item_name, price, comment, rating)
            VALUES (?, ?, ?, ?, ?, ?, ?)
        ");
        
        $success = $stmt->execute([
            $cityId,
            $userId,
            $input['category'],
            $input['item_name'],
            $input['price'],
            $input['comment'] ?? '',
            $input['rating'] ?? 3
        ]);

        if ($success) {
            echo json_encode(['success' => true]);
        } else {
            http_response_code(500);
            echo json_encode(['error' => 'Database error']);
        }
    }

    public function searchMarket()
    {
        header('Content-Type: application/json');
        
        $userId = $this->getUserId();
        if (!$userId) {
            http_response_code(401);
            echo json_encode(['error' => 'Not authenticated']);
            return;
        }

        $query = $_GET['q'] ?? '';
        if (strlen($query) < 2) {
             echo json_encode(['results' => []]);
             return;
        }

        $results = $this->marketService->searchItems($query);
        echo json_encode(['results' => $results]);
    }

    public function deletePrice()
    {
        header('Content-Type: application/json');

        $userId = $this->getUserId();
        if (!$userId) {
            http_response_code(401);
            echo json_encode(['error' => 'Not authenticated']);
            return;
        }

        $stmt = $this->db->prepare("SELECT role FROM study_users WHERE id = ?");
        $stmt->execute([$userId]);
        $user = $stmt->fetch(\PDO::FETCH_ASSOC);

        if (!$user || $user['role'] !== 'admin') {
            http_response_code(403);
            echo json_encode(['error' => 'Admin only']);
            return;
        }

        $data = json_decode(file_get_contents('php://input'), true);
        $id = intval($data['id'] ?? 0);

        if (!$id) {
            http_response_code(400);
            echo json_encode(['error' => 'Missing id']);
            return;
        }

        $this->db->prepare("DELETE FROM study_price_reviews WHERE id = ?")->execute([$id]);
        echo json_encode(['success' => true]);
    }
}
