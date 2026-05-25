<?php

namespace App\Controllers;

use App\Core\Database;
use App\Core\RateLimiter;
use App\Core\Csrf;
use App\Services\AuthService;

class AuthController
{
    private $db;
    private $authService;

    public function __construct()
    {
        $this->db = Database::getInstance()->getConnection();
        $this->authService = new AuthService();
    }

    private function isSecure(): bool
    {
        return (!empty($_SERVER['HTTPS']) && $_SERVER['HTTPS'] !== 'off')
            || ($_SERVER['SERVER_PORT'] ?? 0) == 443;
    }

    public function register()
    {
        header('Content-Type: application/json');
        RateLimiter::enforce('register', 3, 60);
        $input = json_decode(file_get_contents('php://input'), true);

        $email = trim($input['email'] ?? '');
        $password = $input['password'] ?? '';
        $name = trim($input['full_name'] ?? '');

        if (empty($email) || empty($password)) {
            http_response_code(400);
            echo json_encode(['error' => __('error_email_password_required')]);
            return;
        }

        if (!filter_var($email, FILTER_VALIDATE_EMAIL)) {
            http_response_code(400);
            echo json_encode(['error' => __('error_invalid_email')]);
            return;
        }

        if (mb_strlen($password) < 6) {
            http_response_code(400);
            echo json_encode(['error' => __('error_password_min_length')]);
            return;
        }

        $stmt = $this->db->prepare("SELECT id FROM study_users WHERE email = ?");
        $stmt->execute([$email]);
        if ($stmt->fetch()) {
            http_response_code(409);
            echo json_encode(['error' => __('error_user_exists')]);
            return;
        }

        $hashedPassword = password_hash($password, PASSWORD_BCRYPT);

        $managerId = null;
        try {
            $managerModel = new \App\Models\Manager();
            $manager = $managerModel->getRandomActive();
            $managerId = $manager ? $manager['id'] : null;
        } catch (\Exception $e) {
            error_log('Registration Random Manager Fetch Error: ' . $e->getMessage());
        }

        $referredBy = null;
        if (isset($_COOKIE['ref_code'])) {
            try {
                $refStmt = $this->db->prepare("SELECT id FROM study_users WHERE affiliate_code = ? AND role = 'affiliate'");
                $refStmt->execute([$_COOKIE['ref_code']]);
                $referredBy = $refStmt->fetchColumn() ?: null;
            } catch (\Exception $e) {
                // Ignore DB errors related to new field if migration not run
            }
        }

        try {
            $this->db->beginTransaction();

            $stmt = $this->db->prepare("INSERT INTO study_users (email, password, full_name, role, manager_id, referred_by) VALUES (?, ?, ?, 'student', ?, ?)");
            $stmt->execute([$email, $hashedPassword, $name, $managerId, $referredBy]);
            $userId = $this->db->lastInsertId();

            $leadStmt = $this->db->prepare("INSERT INTO study_leads (user_id, status, manager_id, score, details) VALUES (?, 'new', ?, 0, '{}')");
            $leadStmt->execute([$userId, $managerId]);

            $this->db->commit();

            echo json_encode(['success' => true, 'message' => __('register_success')]);
        } catch (\PDOException $e) {
            if ($this->db->inTransaction()) {
                $this->db->rollBack();
            }
            error_log('Registration DB Error: ' . $e->getMessage() . "\n" . $e->getTraceAsString());
            http_response_code(500);
            echo json_encode(['error' => __('error_registration_failed')]);
        } catch (\Exception $e) {
            if ($this->db->inTransaction()) {
                $this->db->rollBack();
            }
            error_log('Registration Error: ' . $e->getMessage() . "\n" . $e->getTraceAsString());
            http_response_code(500);
            echo json_encode(['error' => __('error_registration_failed')]);
        }
    }

    public function login()
    {
        header('Content-Type: application/json');
        RateLimiter::enforce('login', 5, 60);
        $input = json_decode(file_get_contents('php://input'), true);

        $email = trim($input['email'] ?? '');
        $password = $input['password'] ?? '';

        if (empty($email) || empty($password)) {
            http_response_code(400);
            echo json_encode(['error' => __('error_email_password_required')]);
            return;
        }

        $stmt = $this->db->prepare("SELECT * FROM study_users WHERE email = ?");
        $stmt->execute([$email]);
        $user = $stmt->fetch();

        if ($user && password_verify($password, $user['password'])) {
            $token = $this->authService->generateToken($user['id'], $user['role']);

            setcookie('auth_token', $token, [
                'expires' => time() + 86400,
                'path' => '/',
                'secure' => $this->isSecure(),
                'httponly' => true,
                'samesite' => 'Strict'
            ]);

            echo json_encode(['success' => true, 'message' => 'Login successful', 'user' => [
                'id' => $user['id'],
                'name' => $user['full_name'],
                'email' => $user['email'],
                'role' => $user['role']
            ]]);
        } else {
            http_response_code(401);
            echo json_encode(['error' => __('invalid_credentials')]);
        }
    }

    public function logout()
    {
        header('Content-Type: application/json');

        setcookie('auth_token', '', [
            'expires' => time() - 3600,
            'path' => '/',
            'secure' => $this->isSecure(),
            'httponly' => true,
            'samesite' => 'Strict'
        ]);

        echo json_encode(['success' => true, 'message' => 'Logged out']);
    }

    public function me()
    {
        header('Content-Type: application/json');

        $token = $_COOKIE['auth_token'] ?? null;
        if (!$token) {
            http_response_code(401);
            echo json_encode(['error' => 'Not authenticated']);
            return;
        }

        $decoded = $this->authService->validateToken($token);
        if (!$decoded) {
            http_response_code(401);
            echo json_encode(['error' => 'Invalid token']);
            return;
        }

        $userId = $decoded['sub'];
        $stmt = $this->db->prepare("SELECT id, email, full_name, role FROM study_users WHERE id = ?");
        $stmt->execute([$userId]);
        $user = $stmt->fetch(\PDO::FETCH_ASSOC);

        if ($user) {
            echo json_encode(['user' => $user]);
        } else {
            http_response_code(404);
            echo json_encode(['error' => 'User not found']);
        }
    }
}
