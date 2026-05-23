<?php

namespace App\Core;

class Csrf
{
    private static ?string $fallbackToken = null;

    public static function init(): void
    {
        if (session_status() === PHP_SESSION_NONE && !headers_sent()) {
            @session_start();
        }

        if (!empty($_SESSION)) {
            if (empty($_SESSION['csrf_token'])) {
                $_SESSION['csrf_token'] = bin2hex(random_bytes(32));
            }
        }
    }

    public static function token(): string
    {
        self::init();
        if (!empty($_SESSION['csrf_token'])) {
            return $_SESSION['csrf_token'];
        }
        if (self::$fallbackToken === null) {
            self::$fallbackToken = bin2hex(random_bytes(32));
        }
        return self::$fallbackToken;
    }

    public static function field(): string
    {
        return '<input type="hidden" name="_csrf_token" value="' . self::token() . '">';
    }

    public static function validate(): bool
    {
        self::init();

        $token = $_POST['_csrf_token']
            ?? $_SERVER['HTTP_X_CSRF_TOKEN']
            ?? null;

        if (!$token) {
            return false;
        }

        $expected = !empty($_SESSION['csrf_token']) ? $_SESSION['csrf_token'] : self::$fallbackToken;
        if (!$expected) {
            return false;
        }

        return hash_equals($expected, $token);
    }

    public static function check(): void
    {
        if (!self::validate()) {
            http_response_code(403);
            header('Content-Type: application/json');
            echo json_encode(['error' => 'Invalid CSRF token']);
            exit;
        }
    }
}
