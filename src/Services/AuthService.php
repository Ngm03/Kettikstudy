<?php

namespace App\Services;

use Dotenv\Dotenv;
use Firebase\JWT\JWT;
use Firebase\JWT\Key;

class AuthService
{
    private string $secretKey;

    public function __construct()
    {
        if (!isset($_ENV['JWT_SECRET'])) {
            $dotenv = Dotenv::createImmutable(__DIR__ . '/../../');
            $dotenv->safeLoad();
        }

        if (empty($_ENV['JWT_SECRET'])) {
            error_log('FATAL: JWT_SECRET is not set in .env — application cannot start securely.');
            http_response_code(500);
            // Do not leak details to the client
            exit('Server configuration error. Please contact the administrator.');
        }

        $this->secretKey = $_ENV['JWT_SECRET'];
    }

    public function generateToken(int $userId, string $role): string
    {
        $payload = [
            'iss' => 'study-app',
            'aud' => 'study-app',
            'iat' => time(),
            'exp' => time() + 86400,
            'sub' => $userId,
            'role' => $role
        ];

        return JWT::encode($payload, $this->secretKey, 'HS256');
    }

    public function validateToken(string $token): ?array
    {
        $parts = explode('.', $token);
        if (count($parts) !== 3) {
            return null;
        }

        try {
            $decoded = JWT::decode($token, new Key($this->secretKey, 'HS256'));
            return (array) $decoded;
        } catch (\Exception $e) {
            return null;
        }
    }

    public function getUserFromCookie()
    {
        if (!isset($_COOKIE['auth_token'])) return null;
        return $this->validateToken($_COOKIE['auth_token']);
    }

    public function check()
    {
        return $this->getUserFromCookie() !== null;
    }

    public function user()
    {
        return $this->getUserFromCookie();
    }
}
