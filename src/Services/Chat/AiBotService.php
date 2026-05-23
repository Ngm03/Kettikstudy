<?php

namespace App\Services\Chat;

use PDO;
use App\Services\AiService;

/**
 * AiBotService — логика AI-бота "Абай" в чате.
 *
 * Определяет, нужно ли отвечать боту, формирует контекст из истории,
 * получает ответ от AiService и сохраняет его как сообщение в чате.
 */
class AiBotService
{
    private PDO $db;

    /**
     * Триггерные слова/команды, активирующие бота.
     */
    private const TRIGGERS = ['@bot', '@kettik', '/ask'];

    public function __construct(PDO $db)
    {
        $this->db = $db;
    }

    /**
     * Проверяет, должен ли бот ответить на сообщение.
     */
    public function shouldTrigger(string $message): bool
    {
        $lower = mb_strtolower($message);
        foreach (self::TRIGGERS as $trigger) {
            if (str_contains($lower, $trigger)) {
                return true;
            }
        }
        return false;
    }

    /**
     * Получает ответ от AI и сохраняет его в комнату.
     *
     * Вызывается ПОСЛЕ завершения HTTP-ответа (fastcgi_finish_request),
     * чтобы не блокировать клиента.
     */
    public function respond(int $roomId): void
    {
        try {
            $history = $this->buildHistory($roomId);
            $botId   = $this->getOrCreateBotUser();

            $aiService = new AiService();
            $context   = ['name' => 'Студенты Kettik Study'];
            $result    = $aiService->getResponse($history, $context);

            if (empty($result['reply'])) {
                return;
            }

            $reply = $this->formatReply($result['reply']);

            $stmt = $this->db->prepare('
                INSERT INTO study_chat_messages (room_id, user_id, message)
                VALUES (?, ?, ?)
            ');
            $stmt->execute([$roomId, $botId, $reply]);
        } catch (\Exception $e) {
            error_log('AiBotService error: ' . $e->getMessage());
        }
    }

    // -------------------------------------------------------------------------
    // Private helpers
    // -------------------------------------------------------------------------

    /**
     * Формирует историю сообщений для AI (последние 10 сообщений).
     */
    private function buildHistory(int $roomId): array
    {
        $stmt = $this->db->prepare('
            SELECT m.message, u.full_name as author_name, m.user_id
            FROM study_chat_messages m
            JOIN study_users u ON m.user_id = u.id
            WHERE m.room_id = ?
            ORDER BY m.id DESC
            LIMIT 10
        ');
        $stmt->execute([$roomId]);
        $recent = array_reverse($stmt->fetchAll(PDO::FETCH_ASSOC));

        $botId   = $this->getBotId();
        $history = [];

        foreach ($recent as $msg) {
            if ((int) $msg['user_id'] === $botId) {
                $history[] = ['role' => 'assistant', 'content' => $msg['message']];
            } else {
                $history[] = ['role' => 'user', 'content' => $msg['author_name'] . ': ' . $msg['message']];
            }
        }

        return $history;
    }

    /**
     * Добавляет переносы строк в ответ бота для читаемости.
     */
    private function formatReply(string $text): string
    {
        if (substr_count($text, "\n") < 2) {
            $text = preg_replace('/([.!?])\s+([А-ЯA-Z🎯📋📍💼💰✨🎓])/u', "$1\n\n$2", $text);
        }
        return $text;
    }

    /**
     * Возвращает ID бота, или null если бот не создан.
     */
    private function getBotId(): int
    {
        $stmt = $this->db->prepare("SELECT id FROM study_users WHERE email = 'bot@kettik.study'");
        $stmt->execute();
        $bot = $stmt->fetch();

        return $bot ? (int) $bot['id'] : 0;
    }

    /**
     * Находит или создаёт пользователя-бота.
     *
     * @return int ID пользователя-бота
     */
    public function getOrCreateBotUser(): int
    {
        $stmt = $this->db->prepare("SELECT id FROM study_users WHERE email = 'bot@kettik.study'");
        $stmt->execute();
        $bot = $stmt->fetch();

        if ($bot) {
            return (int) $bot['id'];
        }

        try {
            // Пробуем создать с id=0 (системный пользователь)
            $this->db->exec("
                INSERT INTO study_users (id, full_name, email, role, password, phone)
                VALUES (0, 'Абай (Бот)', 'bot@kettik.study', 'admin', 'NO_LOGIN', '+0000000000')
            ");
            return 0;
        } catch (\Exception $e) {
            // Если id=0 не поддерживается, создаём с авто-id
            $this->db->prepare("
                INSERT INTO study_users (full_name, email, role, password, phone)
                VALUES ('Абай (Бот)', 'bot@kettik.study', 'admin', 'NO_LOGIN', '+0000000000')
            ")->execute();
            return (int) $this->db->lastInsertId();
        }
    }
}
