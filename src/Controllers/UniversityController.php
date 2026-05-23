<?php

namespace App\Controllers;

use App\Models\University;
use App\Core\Database;

class UniversityController {
    private $universityModel;

    public function __construct() {
        $this->universityModel = new University();
    }

    public function index() {
        $universities = $this->universityModel->getAll();
        $page = 'universities';
        require __DIR__ . '/../../views/layouts/admin.php';
    }

    public function create() {
        if ($_SERVER['REQUEST_METHOD'] !== 'POST') {
            http_response_code(405);
            echo json_encode(['error' => 'Method Not Allowed']);
            return;
        }

        $name = $_POST['name'] ?? '';
        $websiteUrl = $_POST['website_url'] ?? '';
        
        if (empty($name) || !isset($_FILES['logo'])) {
            http_response_code(400);
            echo json_encode(['error' => 'Name and Logo are required']);
            return;
        }

        $uploadDir = __DIR__ . '/../../public/assets/img/universities/';
        if (!is_dir($uploadDir)) {
            mkdir($uploadDir, 0755, true);
        }

        $fileExt = strtolower(pathinfo($_FILES['logo']['name'], PATHINFO_EXTENSION));
        $fileName = uniqid('uni_') . '.' . $fileExt;
        $uploadFile = $uploadDir . $fileName;

        if(!in_array($fileExt, ['jpg', 'jpeg', 'png', 'gif', 'svg'])) {
             echo json_encode(['error' => 'Invalid file format']);
             return;
        }

        if (move_uploaded_file($_FILES['logo']['tmp_name'], $uploadFile)) {
            $logoPath = '/assets/img/universities/' . $fileName;
            if ($this->universityModel->create($name, $logoPath, $websiteUrl)) {
                echo json_encode(['success' => true]);
            } else {
                echo json_encode(['error' => 'Database error']);
            }
        } else {
            echo json_encode(['error' => 'File upload failed']);
        }
    }

    public function delete() {
        if ($_SERVER['REQUEST_METHOD'] !== 'POST') {
            http_response_code(405);
            return;
        }

        $data = json_decode(file_get_contents("php://input"), true);
        $id = $data['id'] ?? null;

        if ($id && $this->universityModel->delete($id)) {
            echo json_encode(['success' => true]);
        } else {
            echo json_encode(['error' => 'Failed to delete']);
        }
    }
}
