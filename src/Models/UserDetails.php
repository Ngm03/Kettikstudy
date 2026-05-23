<?php

namespace App\Models;

use PDO;

class UserDetails {
    private $pdo;

    public function __construct(PDO $pdo) {
        $this->pdo = $pdo;
    }

    public function create($data) {
        $sql = "INSERT INTO study_user_details (
            user_id, passport_number, passport_issue_date, passport_expiry_date, 
            passport_authority, iin, birth_date, birth_place, 
            address_registration, address_residential,
            desired_country, desired_university_id, desired_program
        ) VALUES (
            :user_id, :passport_number, :passport_issue_date, :passport_expiry_date, 
            :passport_authority, :iin, :birth_date, :birth_place, 
            :address_registration, :address_residential,
            :desired_country, :desired_university_id, :desired_program
        )";

        $stmt = $this->pdo->prepare($sql);
        $stmt->execute([
            ':user_id' => $data['user_id'],
            ':passport_number' => $data['passport_number'] ?? null,
            ':passport_issue_date' => $data['passport_issue_date'] ?? null,
            ':passport_expiry_date' => $data['passport_expiry_date'] ?? null,
            ':passport_authority' => $data['passport_authority'] ?? null,
            ':iin' => $data['iin'] ?? null,
            ':birth_date' => $data['birth_date'] ?? null,
            ':birth_place' => $data['birth_place'] ?? null,
            ':address_registration' => $data['address_registration'] ?? null,
            ':address_residential' => $data['address_residential'] ?? null,
            ':desired_country' => $data['desired_country'] ?? null,
            ':desired_university_id' => $data['desired_university_id'] ?? null,
            ':desired_program' => $data['desired_program'] ?? null
        ]);

        return $this->pdo->lastInsertId();
    }

    public function findByUserId($userId) {
        $stmt = $this->pdo->prepare("SELECT * FROM study_user_details WHERE user_id = ?");
        $stmt->execute([$userId]);
        return $stmt->fetch(PDO::FETCH_ASSOC);
    }

    public function update($userId, $data) {
        $fields = [];
        $params = [':user_id' => $userId];

        foreach ($data as $key => $value) {
            if (in_array($key, [
                'passport_number', 'passport_issue_date', 'passport_expiry_date', 
                'passport_authority', 'iin', 'birth_date', 'birth_place', 
                'address_registration', 'address_residential',
                'desired_country', 'desired_university_id', 'desired_program'
            ])) {
                $fields[] = "$key = :$key";
                $params[":$key"] = $value;
            }
        }

        if (empty($fields)) {
            return false;
        }

        $sql = "UPDATE study_user_details SET " . implode(', ', $fields) . " WHERE user_id = :user_id";
        $stmt = $this->pdo->prepare($sql);
        return $stmt->execute($params);
    }
}
