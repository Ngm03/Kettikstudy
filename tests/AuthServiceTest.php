<?php

namespace Tests;

use PHPUnit\Framework\TestCase;
use App\Services\AuthService;

class AuthServiceTest extends TestCase
{
    private AuthService $authService;

    protected function setUp(): void
    {
        parent::setUp();
        $this->authService = new AuthService();
    }

    public function testGenerateTokenReturnsValidString(): void
    {
        $token = $this->authService->generateToken(1, 'admin');
        $this->assertIsString($token);
        $this->assertCount(3, explode('.', $token));
    }

    public function testValidateTokenReturnsPayloadForValidToken(): void
    {
        $token = $this->authService->generateToken(42, 'student');
        $payload = $this->authService->validateToken($token);

        $this->assertIsArray($payload);
        $this->assertEquals(42, $payload['sub']);
        $this->assertEquals('student', $payload['role']);
    }

    public function testValidateTokenReturnsNullForInvalidToken(): void
    {
        $validToken = $this->authService->generateToken(1, 'admin');
        $invalidToken = $validToken . 'invalid';

        $payload = $this->authService->validateToken($invalidToken);
        $this->assertNull($payload);
    }
}
