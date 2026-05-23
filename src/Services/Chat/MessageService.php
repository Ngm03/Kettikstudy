<?php

namespace App\Services\Chat;

use PDO;

/**
 * MessageService — вся логика работы с сообщениями.
 *
 * Получение, отправка, редактирование, удаление, реакции, поиск.
 * Не знает об HTTP. Не взаимодействует с файловой системой (для этого FileAttachmentService).
 */
class MessageService
{
    private PDO $db;

    // Максимальное время редактирования/удаления своего сообщения (секунды)
    private const EDIT_WINDOW_SECONDS = 900; // 15 минут

    public function __construct(PDO $db)
    {
        $this->db = $db;
    }

    /**
     * Возвращает сообщения комнаты начиная с after_id.
     *
     * @param int $roomId   ID комнаты
     * @param int $afterId  Вернуть только сообщения с id > afterId (для polling)
     * @param int $userId   ID текущего пользователя (для метки is_mine и реакций)
     */
    public function getMessages(int $roomId, int $afterId, int $userId): array
    {
        $stmt = $this->db->prepare('
            SELECT m.id, m.message, m.attachment_url, m.is_edited, m.reply_to_id, m.reply_to_text, m.created_at,
                   u.full_name as author_name, m.user_id, u.role,
                   ru.full_name as reply_to_author
            FROM study_chat_messages m
            JOIN study_users u ON m.user_id = u.id
            LEFT JOIN study_chat_messages rm ON m.reply_to_id = rm.id
            LEFT JOIN study_users ru ON rm.user_id = ru.id
            WHERE m.room_id = ? AND m.id > ?
            ORDER BY m.id ASC
            LIMIT 100
        ');
        $stmt->execute([$roomId, $afterId]);
        $messages = $stmt->fetchAll(PDO::FETCH_ASSOC);

        // Подгружаем реакции одним запросом
        $reactionsMap = $this->loadReactions($messages, $userId);

        foreach ($messages as &$msg) {
            $msg['is_mine']   = ((int) $msg['user_id'] === $userId);
            $msg['time']      = date('H:i', strtotime($msg['created_at']));
            $msg['reactions'] = $reactionsMap[(int) $msg['id']] ?? [];
            unset($msg['user_id']); // не отдаём наружу
        }

        return $messages;
    }

    /**
     * Сохраняет сообщение в БД.
     *
     * @return int ID нового сообщения
     * @throws \RuntimeException при ошибке вставки
     */
    public function saveMessage(
        int $roomId,
        int $userId,
        string $message,
        ?string $attachmentUrl = null,
        ?int $replyToId = null,
        ?string $replyToText = null
    ): int {
        $censored = $this->applyCensorship($message);

        $stmt = $this->db->prepare('
            INSERT INTO study_chat_messages
                (room_id, user_id, message, attachment_url, reply_to_id, reply_to_text)
            VALUES (?, ?, ?, ?, ?, ?)
        ');

        $success = $stmt->execute([
            $roomId,
            $userId,
            htmlspecialchars($censored, ENT_QUOTES, 'UTF-8'),
            $attachmentUrl,
            $replyToId ?: null,
            $replyToText ? mb_substr($replyToText, 0, 200) : null,
        ]);

        if (!$success) {
            throw new \RuntimeException('Failed to insert message');
        }

        return (int) $this->db->lastInsertId();
    }

    /**
     * Редактирует сообщение. Только автор, только в течение EDIT_WINDOW_SECONDS.
     *
     * @throws \RuntimeException при нарушении прав или тайм-аута
     */
    public function editMessage(int $messageId, int $userId, string $newText): void
    {
        $msg = $this->findMessage($messageId);

        if (!$msg) {
            throw new \RuntimeException('Message not found', 404);
        }

        if ((int) $msg['user_id'] !== $userId) {
            throw new \RuntimeException('Not the author', 403);
        }

        if ((time() - strtotime($msg['created_at'])) > self::EDIT_WINDOW_SECONDS) {
            throw new \RuntimeException('Edit window expired', 403);
        }

        $censored = $this->applyCensorship($newText);

        $stmt = $this->db->prepare('UPDATE study_chat_messages SET message = ?, is_edited = 1 WHERE id = ?');
        $stmt->execute([htmlspecialchars($censored, ENT_QUOTES, 'UTF-8'), $messageId]);
    }

    /**
     * Удаляет сообщение.
     * Автор может удалить в течение EDIT_WINDOW_SECONDS; admin/manager — в любое время.
     *
     * @return string|null URL вложения (если было) для последующего удаления файла
     * @throws \RuntimeException при нарушении прав
     */
    public function deleteMessage(int $messageId, int $userId, string $userRole): ?string
    {
        $msg = $this->findMessage($messageId);

        if (!$msg) {
            throw new \RuntimeException('Message not found', 404);
        }

        $isStaff   = in_array($userRole, ['admin', 'manager'], true);
        $isAuthor  = ((int) $msg['user_id'] === $userId);
        $inWindow  = (time() - strtotime($msg['created_at'])) <= self::EDIT_WINDOW_SECONDS;

        if (!$isStaff && (!$isAuthor || !$inWindow)) {
            throw new \RuntimeException('Cannot delete this message', 403);
        }

        $stmt = $this->db->prepare('DELETE FROM study_chat_messages WHERE id = ?');
        $stmt->execute([$messageId]);

        return $msg['attachment_url'] ?: null;
    }

    /**
     * Переключает реакцию пользователя на сообщение (toggle).
     *
     * @return string 'added' или 'removed'
     */
    public function toggleReaction(int $messageId, int $userId, string $emoji): string
    {
        $stmt = $this->db->prepare('
            SELECT id FROM study_chat_reactions
            WHERE user_id = ? AND message_id = ? AND emoji = ?
        ');
        $stmt->execute([$userId, $messageId, $emoji]);
        $existing = $stmt->fetch();

        if ($existing) {
            $this->db->prepare('DELETE FROM study_chat_reactions WHERE id = ?')
                ->execute([$existing['id']]);
            return 'removed';
        }

        $this->db->prepare('INSERT INTO study_chat_reactions (message_id, user_id, emoji) VALUES (?,?,?)')
            ->execute([$messageId, $userId, $emoji]);

        return 'added';
    }

    /**
     * Поиск сообщений по тексту в комнате.
     */
    public function searchMessages(int $roomId, string $query): array
    {
        $stmt = $this->db->prepare('
            SELECT m.id, m.message, m.created_at, u.full_name as author_name
            FROM study_chat_messages m
            JOIN study_users u ON m.user_id = u.id
            WHERE m.room_id = ? AND m.message LIKE ?
            ORDER BY m.created_at DESC
            LIMIT 30
        ');
        $stmt->execute([$roomId, '%' . $query . '%']);
        $results = $stmt->fetchAll(PDO::FETCH_ASSOC);

        foreach ($results as &$r) {
            $r['time'] = date('H:i', strtotime($r['created_at']));
        }

        return $results;
    }

    /**
     * Получает счётчики непрочитанных сообщений по комнатам.
     */
    public function getUnreadCounts(int $userId): array
    {
        $stmt = $this->db->prepare('
            SELECT m.room_id, COUNT(*) as unread
            FROM study_chat_messages m
            LEFT JOIN study_chat_read_status rs ON rs.room_id = m.room_id AND rs.user_id = ?
            WHERE m.user_id != ?
              AND (rs.last_read_at IS NULL OR m.created_at > rs.last_read_at)
            GROUP BY m.room_id
        ');
        $stmt->execute([$userId, $userId]);

        $counts = [];
        foreach ($stmt->fetchAll(PDO::FETCH_ASSOC) as $row) {
            $counts[(int) $row['room_id']] = (int) $row['unread'];
        }

        return $counts;
    }

    /**
     * Отмечает комнату как прочитанную.
     */
    public function markRoomAsRead(int $userId, int $roomId): void
    {
        $stmt = $this->db->prepare('
            INSERT INTO study_chat_read_status (user_id, room_id, last_read_at)
            VALUES (?, ?, NOW())
            ON DUPLICATE KEY UPDATE last_read_at = NOW()
        ');
        $stmt->execute([$userId, $roomId]);
    }

    /**
     * Обновляет метку last_active_at пользователя.
     */
    public function ping(int $userId): void
    {
        $this->db->prepare('UPDATE study_users SET last_active_at = NOW() WHERE id = ?')
            ->execute([$userId]);
    }

    // -------------------------------------------------------------------------
    // Private helpers
    // -------------------------------------------------------------------------

    private function findMessage(int $messageId): ?array
    {
        $stmt = $this->db->prepare('SELECT id, user_id, created_at, attachment_url FROM study_chat_messages WHERE id = ?');
        $stmt->execute([$messageId]);
        $msg = $stmt->fetch(PDO::FETCH_ASSOC);

        return $msg ?: null;
    }

    private function loadReactions(array $messages, int $userId): array
    {
        if (empty($messages)) {
            return [];
        }

        $messageIds = array_map('intval', array_column($messages, 'id'));
        $in = implode(',', $messageIds);

        try {
            $stmt = $this->db->query("
                SELECT message_id, emoji, COUNT(*) as cnt,
                       GROUP_CONCAT(user_id) as user_ids
                FROM study_chat_reactions
                WHERE message_id IN ($in)
                GROUP BY message_id, emoji
            ");

            $map = [];
            foreach ($stmt->fetchAll(PDO::FETCH_ASSOC) as $r) {
                $map[(int) $r['message_id']][] = [
                    'emoji' => $r['emoji'],
                    'count' => (int) $r['cnt'],
                    'mine'  => in_array((string) $userId, explode(',', $r['user_ids'])),
                ];
            }
            return $map;
        } catch (\Exception $e) {
            return [];
        }
    }

    /**
     * Применяет цензуру к тексту на основе настроек из БД.
     */
    public function applyCensorship(string $message): string
    {
        try {
            $settingModel  = new \App\Models\Setting();
            $censoredWords = $settingModel->get('chat_censored_words', '');

            if (empty($censoredWords)) {
                return $message;
            }

            $badWords = array_map('trim', explode(',', mb_strtolower($censoredWords)));
            $words    = explode(' ', $message);

            foreach ($words as &$word) {
                $clean = mb_strtolower(preg_replace('/[^\p{L}\p{N}]+/u', '', $word));
                if (in_array($clean, $badWords, true)) {
                    $word = str_repeat('*', mb_strlen($word));
                }
            }

            return implode(' ', $words);
        } catch (\Exception $e) {
            return $message; // цензура не должна ломать отправку
        }
    }
}
