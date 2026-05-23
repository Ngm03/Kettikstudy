<?php

namespace App\Controllers;

use App\Core\Database;
use App\Core\RateLimiter;
use PDO;

class PasswordResetController
{
    private $db;

    public function __construct()
    {
        $this->db = Database::getInstance()->getConnection();
    }

    /**
     * POST /api/auth/forgot-password
     * Generates a reset token and logs it (MVP instead of email)
     */
    public function forgotPassword()
    {
        header('Content-Type: application/json');
        RateLimiter::enforce('forgot_password', 3, 60);

        $input = json_decode(file_get_contents('php://input'), true);
        $email = trim($input['email'] ?? '');

        if (empty($email) || !filter_var($email, FILTER_VALIDATE_EMAIL)) {
            http_response_code(400);
            echo json_encode(['error' => 'Invalid email address']);
            return;
        }

        $stmt = $this->db->prepare("SELECT id, full_name FROM study_users WHERE email = ?");
        $stmt->execute([$email]);
        $user = $stmt->fetch(PDO::FETCH_ASSOC);

        if (!$user) {
            // Do not reveal if email exists or not for security reasons
            echo json_encode(['success' => true, 'message' => 'If this email exists, a reset link has been sent.']);
            return;
        }

        $token = bin2hex(random_bytes(32));
        $expiresAt = date('Y-m-d H:i:s', time() + 3600); // 1 hour

        $stmt = $this->db->prepare("
            INSERT INTO study_password_resets (email, token, expires_at) 
            VALUES (?, ?, ?)
        ");
        $stmt->execute([$email, $token, $expiresAt]);

        // MVP: Log the token instead of sending an email
        $resetLink = BASE_URL . "/login?reset_token=" . $token;
        error_log("PASSWORD RESET LINK for {$email}: {$resetLink}");

        echo json_encode([
            'success' => true, 
            'message' => 'Reset link generated. (MVP: Check server logs or study_password_resets table)',
            'debug_token' => $token // MVP only: output to UI for easy testing
        ]);
    }

    /**
     * POST /api/auth/reset-password
     * Verifies token and updates password
     */
    public function resetPassword()
    {
        header('Content-Type: application/json');
        RateLimiter::enforce('reset_password', 5, 60);

        $input = json_decode(file_get_contents('php://input'), true);
        $token = trim($input['token'] ?? '');
        $newPassword = $input['password'] ?? '';

        if (empty($token) || mb_strlen($newPassword) < 6) {
            http_response_code(400);
            echo json_encode(['error' => 'Invalid token or password must be at least 6 characters']);
            return;
        }

        $stmt = $this->db->prepare("
            SELECT id, email, expires_at 
            FROM study_password_resets 
            WHERE token = ? AND used = 0
        ");
        $stmt->execute([$token]);
        $resetRequest = $stmt->fetch(PDO::FETCH_ASSOC);

        if (!$resetRequest) {
            http_response_code(400);
            echo json_encode(['error' => 'Invalid or already used token']);
            return;
        }

        if (strtotime($resetRequest['expires_at']) < time()) {
            http_response_code(400);
            echo json_encode(['error' => 'Token has expired']);
            return;
        }

        $hashedPassword = password_hash($newPassword, PASSWORD_BCRYPT);

        try {
            $this->db->beginTransaction();

            $stmtUpdatePassword = $this->db->prepare("UPDATE study_users SET password = ? WHERE email = ?");
            $stmtUpdatePassword->execute([$hashedPassword, $resetRequest['email']]);

            $stmtMarkUsed = $this->db->prepare("UPDATE study_password_resets SET used = 1 WHERE id = ?");
            $stmtMarkUsed->execute([$resetRequest['id']]);

            $this->db->commit();
            echo json_encode(['success' => true, 'message' => 'Password has been reset successfully']);
        } catch (\Exception $e) {
            $this->db->rollBack();
            http_response_code(500);
            echo json_encode(['error' => 'Database error while resetting password']);
        }
    }
}
