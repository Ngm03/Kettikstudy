<?php

namespace App\Services;

use Dotenv\Dotenv;

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
        $header = json_encode(['typ' => 'JWT', 'alg' => 'HS256']);
        $payload = json_encode([
            'iss' => 'study-app',
            'aud' => 'study-app',
            'iat' => time(),
            'exp' => time() + 86400,
            'sub' => $userId,
            'role' => $role
        ]);

        $base64UrlHeader = $this->base64UrlEncode($header);
        $base64UrlPayload = $this->base64UrlEncode($payload);

        $signature = hash_hmac('sha256', $base64UrlHeader . "." . $base64UrlPayload, $this->secretKey, true);
        $base64UrlSignature = $this->base64UrlEncode($signature);

        return $base64UrlHeader . "." . $base64UrlPayload . "." . $base64UrlSignature;
    }

    public function validateToken(string $token): ?array
    {
        $parts = explode('.', $token);
        if (count($parts) !== 3) {
            return null;
        }

        [$header, $payload, $signature] = $parts;

        $validSignature = hash_hmac('sha256', $header . "." . $payload, $this->secretKey, true);
        $base64UrlSignature = $this->base64UrlEncode($validSignature);

        if (!hash_equals($signature, $base64UrlSignature)) {
            return null;
        }

        $decodedPayload = json_decode($this->base64UrlDecode($payload), true);

        if ($decodedPayload['exp'] < time()) {
            return null;
        }

        return $decodedPayload;
    }

    private function base64UrlEncode($data)
    {
        return rtrim(strtr(base64_encode($data), '+/', '-_'), '=');
    }

    private function base64UrlDecode($data)
    {
        return base64_decode(str_pad(strtr($data, '-_', '+/'), strlen($data) % 4, '=', STR_PAD_RIGHT));
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
