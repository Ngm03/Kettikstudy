<?php

namespace App\Models;

use App\Core\Database;
use PDO;

class University {
    private $pdo;

    public function __construct() {
        $this->pdo = Database::getInstance()->getConnection();
    }

    public function getAll() {
        $stmt = $this->pdo->query("SELECT * FROM study_universities ORDER BY id DESC");
        return $stmt->fetchAll(PDO::FETCH_ASSOC);
    }

    public function create($name, $logoPath, $websiteUrl = null) {
        $stmt = $this->pdo->prepare("INSERT INTO study_universities (name, logo_path, website_url) VALUES (?, ?, ?)");
        return $stmt->execute([$name, $logoPath, $websiteUrl]);
    }

    public function delete($id) {
        $stmt = $this->pdo->prepare("DELETE FROM study_universities WHERE id = ?");
        return $stmt->execute([$id]);
    }
}
