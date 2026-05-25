<?php
require 'vendor/autoload.php';
$pdo = \App\Core\Database::getInstance()->getConnection();
$stmt = $pdo->query('SHOW CREATE TABLE study_leads');
print_r($stmt->fetch());
