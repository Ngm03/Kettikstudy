<?php

namespace App\Core;

class Migrator
{
    public static function run(): void
    {
        try {
            $db = Database::getInstance()->getConnection();
        } catch (\Exception $e) {
            error_log('Migrator: Database connection failed: ' . $e->getMessage());
            return;
        }

        try {
            $db->exec("CREATE TABLE IF NOT EXISTS study_migrations (
                id INT AUTO_INCREMENT PRIMARY KEY,
                name VARCHAR(255) NOT NULL UNIQUE,
                executed_at TIMESTAMP DEFAULT CURRENT_TIMESTAMP
            ) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4");
        } catch (\PDOException $e) {
            error_log('Migrator: failed to create migrations table: ' . $e->getMessage());
            return;
        }

        $migrationsDir = __DIR__ . '/../../migrations';
        if (!is_dir($migrationsDir)) {
            return;
        }

        $files = glob($migrationsDir . '/*.php');
        sort($files);

        foreach ($files as $file) {
            $name = basename($file);

            $stmt = $db->prepare("SELECT id FROM study_migrations WHERE name = ?");
            $stmt->execute([$name]);
            if ($stmt->fetch()) {
                continue;
            }

            try {
                require_once $file;
                $db->prepare("INSERT INTO study_migrations (name) VALUES (?)")->execute([$name]);
            } catch (\Exception $e) {
                error_log('Migrator: error in ' . $name . ': ' . $e->getMessage());
            }
        }
    }
}
