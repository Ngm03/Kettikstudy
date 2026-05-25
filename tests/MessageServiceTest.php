<?php

namespace Tests;

use PHPUnit\Framework\TestCase;
use App\Services\Chat\MessageService;

class MessageServiceTest extends TestCase
{
    public function testGetMessagesReturnsArray(): void
    {
        $pdoMock = $this->createMock(\PDO::class);
        $stmtMock = $this->createMock(\PDOStatement::class);
        
        $pdoMock->method('prepare')->willReturn($stmtMock);
        $pdoMock->method('query')->willReturn($stmtMock);
        $stmtMock->method('execute')->willReturn(true);
        $stmtMock->method('fetchAll')->willReturn([
            ['id' => 1, 'message' => 'Hello', 'author_name' => 'John', 'role' => 'student']
        ]);

        $service = new MessageService($pdoMock);
        $messages = $service->getMessages(1, 0, 1);

        $this->assertIsArray($messages);
        $this->assertCount(1, $messages);
        $this->assertEquals('Hello', $messages[0]['message']);
    }
}
