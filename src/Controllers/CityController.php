<?php

namespace App\Controllers;

use App\Core\Database;

class CityController
{
    private $db;

    public function __construct()
    {
        $this->db = Database::getInstance()->getConnection();
    }

    public function listCities()
    {
        header('Content-Type: application/json');

        $stmt = $this->db->query("SELECT id, name_ru, name_en, name_pl, description FROM study_cities ORDER BY name_ru ASC");
        $cities = $stmt->fetchAll(\PDO::FETCH_ASSOC);

        echo json_encode(['cities' => $cities]);
    }
}
