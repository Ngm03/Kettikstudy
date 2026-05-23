<?php

namespace App\Core;

class RateLimiter
{
    private $db;
    private static bool $tableChecked = false;

    public function __construct()
    {
        try {
            $this->db = Database::getInstance()->getConnection();
        } catch (\Exception $e) {
            error_log('RateLimiter DB error: ' . $e->getMessage());
            $this->db = null;
        }
    }

    private function ensureTable(): void
    {
        if (self::$tableChecked || $this->db === null) return;
        self::$tableChecked = true;

        try {
            $this->db->exec("CREATE TABLE IF NOT EXISTS study_rate_limits (
                id INT AUTO_INCREMENT PRIMARY KEY,
                ip_address VARCHAR(45) NOT NULL,
                endpoint VARCHAR(255) NOT NULL,
                attempts INT DEFAULT 1,
                first_attempt_at DATETIME NOT NULL,
                INDEX idx_ip_endpoint (ip_address, endpoint)
            ) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4");
        } catch (\PDOException $e) {
            error_log('RateLimiter table error: ' . $e->getMessage());
        }
    }

    public function check(string $endpoint, int $maxAttempts = 10, int $windowSeconds = 60): bool
    {
        if ($this->db === null) {
            return true;
        }

        $this->ensureTable();
        $ip = $_SERVER['REMOTE_ADDR'] ?? '0.0.0.0';

        try {
            $this->db->prepare(
                "DELETE FROM study_rate_limits WHERE first_attempt_at < DATE_SUB(NOW(), INTERVAL ? SECOND)"
            )->execute([$windowSeconds]);

            $stmt = $this->db->prepare(
                "SELECT attempts, first_attempt_at FROM study_rate_limits WHERE ip_address = ? AND endpoint = ?"
            );
            $stmt->execute([$ip, $endpoint]);
            $row = $stmt->fetch(\PDO::FETCH_ASSOC);

            if (!$row) {
                $this->db->prepare(
                    "INSERT INTO study_rate_limits (ip_address, endpoint, attempts, first_attempt_at) VALUES (?, ?, 1, NOW())"
                )->execute([$ip, $endpoint]);
                return true;
            }

            if ($row['attempts'] >= $maxAttempts) {
                return false;
            }

            $this->db->prepare(
                "UPDATE study_rate_limits SET attempts = attempts + 1 WHERE ip_address = ? AND endpoint = ?"
            )->execute([$ip, $endpoint]);

            return true;
        } catch (\PDOException $e) {
            error_log('RateLimiter error: ' . $e->getMessage());
            return true;
        }
    }

    public static function enforce(string $endpoint, int $maxAttempts = 10, int $windowSeconds = 60): void
    {
        $limiter = new self();
        if (!$limiter->check($endpoint, $maxAttempts, $windowSeconds)) {
            http_response_code(429);
            header('Content-Type: application/json');
            header('Retry-After: ' . $windowSeconds);
            echo json_encode(['error' => 'Too many requests. Try again later.']);
            exit;
        }
    }
}
