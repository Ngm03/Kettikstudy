<?php

namespace App\Services\Chat;

use PDO;

/**
 * ChatRoomService — управление чат-комнатами.
 *
 * Отвечает за создание, получение и инициализацию комнат.
 * Не знает ничего об HTTP — только о данных.
 */
class ChatRoomService
{
    private PDO $db;

    public function __construct(PDO $db)
    {
        $this->db = $db;
    }

    /**
     * Возвращает список доступных комнат для пользователя.
     */
    public function getRoomsForUser(int $userId): array
    {
        $rooms = [];

        // 1. Общий чат
        $rooms[] = $this->getOrCreateGeneralRoom();

        // 2. Канал рассылки
        $rooms[] = $this->getOrCreateBroadcastRoom();

        // 3. Городские и приватные чаты в зависимости от роли
        $stmt = $this->db->prepare('SELECT role, city_id FROM study_users WHERE id = ?');
        $stmt->execute([$userId]);
        $user = $stmt->fetch(PDO::FETCH_ASSOC);

        if (!$user) {
            return $rooms;
        }

        if (in_array($user['role'], ['admin', 'manager'], true)) {
            // Админ/менеджер видит все городские чаты
            $stmt = $this->db->prepare('
                SELECT cr.id, cr.type, cr.name, cr.avatar
                FROM study_chat_rooms cr
                WHERE cr.type = "city"
            ');
            $stmt->execute();
            foreach ($stmt->fetchAll(PDO::FETCH_ASSOC) as $room) {
                $rooms[] = $room;
            }

            // Приватные чаты менеджера
            $stmt = $this->db->prepare('
                SELECT cr.id, cr.type, cr.name, cr.avatar, u.full_name as student_name
                FROM study_chat_rooms cr
                JOIN study_users u ON cr.student_id = u.id
                WHERE cr.type = "private" AND cr.manager_id = ?
            ');
            $stmt->execute([$userId]);
            foreach ($stmt->fetchAll(PDO::FETCH_ASSOC) as $pr) {
                $rooms[] = [
                    'id'     => $pr['id'],
                    'type'   => 'private',
                    'name'   => $pr['student_name'] . ' (ЛС)',
                    'avatar' => $pr['avatar'],
                ];
            }
        } else {
            // Студент видит только свой городской чат
            if ($user['city_id']) {
                $rooms[] = $this->getOrCreateCityRoom($user['city_id']);
            }

            // Приватный чат с менеджером
            $stmt = $this->db->prepare('
                SELECT cr.id, cr.type, cr.name, cr.avatar, m.full_name as manager_name
                FROM study_chat_rooms cr
                JOIN study_users m ON cr.manager_id = m.id
                WHERE cr.type = "private" AND cr.student_id = ?
            ');
            $stmt->execute([$userId]);
            $privateRoom = $stmt->fetch(PDO::FETCH_ASSOC);
            if ($privateRoom) {
                $rooms[] = [
                    'id'     => $privateRoom['id'],
                    'type'   => 'private',
                    'name'   => 'Ваш Менеджер: ' . $privateRoom['manager_name'],
                    'avatar' => $privateRoom['avatar'],
                ];
            }
        }

        return array_filter($rooms); // убираем null-элементы
    }

    /**
     * Находит или создаёт общий чат.
     */
    public function getOrCreateGeneralRoom(): array
    {
        $stmt = $this->db->prepare("SELECT id, type, name, avatar FROM study_chat_rooms WHERE type = 'general' LIMIT 1");
        $stmt->execute();
        $room = $stmt->fetch(PDO::FETCH_ASSOC);

        if (!$room) {
            $this->db->exec("INSERT INTO study_chat_rooms (type, name) VALUES ('general', 'Kettik Study')");
            $id   = $this->db->lastInsertId();
            $room = ['id' => $id, 'type' => 'general', 'name' => 'Kettik Study', 'avatar' => null];
        }

        return $room;
    }

    /**
     * Находит или создаёт канал рассылки.
     */
    public function getOrCreateBroadcastRoom(): array
    {
        $stmt = $this->db->prepare("SELECT id, type, name, avatar FROM study_chat_rooms WHERE type = 'broadcast' LIMIT 1");
        $stmt->execute();
        $room = $stmt->fetch(PDO::FETCH_ASSOC);

        if (!$room) {
            $this->db->exec("INSERT INTO study_chat_rooms (type, name) VALUES ('broadcast', '📢 Рассылка')");
            $id   = $this->db->lastInsertId();
            $room = ['id' => $id, 'type' => 'broadcast', 'name' => '📢 Рассылка', 'avatar' => null];
        }

        return $room;
    }

    /**
     * Находит или создаёт городской чат для указанного city_id.
     */
    public function getOrCreateCityRoom(int $cityId): ?array
    {
        $stmt = $this->db->prepare('
            SELECT cr.id, cr.type, cr.name, cr.avatar, c.name_ru as city_name
            FROM study_chat_rooms cr
            JOIN study_cities c ON cr.city_id = c.id
            WHERE cr.type = "city" AND cr.city_id = ?
        ');
        $stmt->execute([$cityId]);
        $room = $stmt->fetch(PDO::FETCH_ASSOC);

        if ($room) {
            return ['id' => $room['id'], 'type' => 'city', 'name' => 'Чат ' . $room['city_name'], 'avatar' => $room['avatar']];
        }

        // Создаём комнату
        $stmt = $this->db->prepare('SELECT name_ru FROM study_cities WHERE id = ?');
        $stmt->execute([$cityId]);
        $cityName = $stmt->fetchColumn();

        if (!$cityName) {
            return null;
        }

        $name = 'Чат ' . $cityName;
        $insert = $this->db->prepare("INSERT INTO study_chat_rooms (type, city_id, name) VALUES ('city', ?, ?)");
        $insert->execute([$cityId, $name]);
        $newId = $this->db->lastInsertId();

        return ['id' => $newId, 'type' => 'city', 'name' => $name, 'avatar' => null];
    }

    /**
     * Находит или создаёт приватную комнату между менеджером и студентом.
     *
     * @return int ID комнаты
     */
    public function getOrCreatePrivateRoom(int $managerId, int $studentId): int
    {
        $stmt = $this->db->prepare("
            SELECT id FROM study_chat_rooms
            WHERE type = 'private' AND student_id = ? AND manager_id = ?
            LIMIT 1
        ");
        $stmt->execute([$studentId, $managerId]);
        $existing = $stmt->fetchColumn();

        if ($existing) {
            return (int) $existing;
        }

        $insert = $this->db->prepare("
            INSERT INTO study_chat_rooms (type, name, student_id, manager_id)
            VALUES ('private', 'Private Chat', ?, ?)
        ");
        $insert->execute([$studentId, $managerId]);

        return (int) $this->db->lastInsertId();
    }

    /**
     * Проверяет, имеет ли пользователь доступ к указанной комнате.
     */
    public function userCanAccessRoom(int $userId, string $userRole, array $room): bool
    {
        if (in_array($userRole, ['admin', 'manager'], true)) {
            return true;
        }

        switch ($room['type']) {
            case 'general':
            case 'broadcast':
                return true;

            case 'city':
                $stmt = $this->db->prepare('SELECT city_id FROM study_users WHERE id = ?');
                $stmt->execute([$userId]);
                $cityId = $stmt->fetchColumn();
                return $cityId == $room['city_id'];

            case 'private':
                return $room['student_id'] == $userId || $room['manager_id'] == $userId;
        }

        return false;
    }

    /**
     * Получает комнату по ID.
     */
    public function findRoom(int $roomId): ?array
    {
        $stmt = $this->db->prepare('SELECT * FROM study_chat_rooms WHERE id = ?');
        $stmt->execute([$roomId]);
        $room = $stmt->fetch(PDO::FETCH_ASSOC);

        return $room ?: null;
    }
}
