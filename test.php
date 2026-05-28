<?php
session_start();
define('BASE_URL', 'http://localhost/study');
function __($k) { return $k; }

try {
    ob_start();
    require 'views/admin/documents.php';
    $out = ob_get_clean();
    echo "DOCUMENTS SUCCESS! Length: " . strlen($out) . "\n";
} catch (\Throwable $e) {
    echo "DOCUMENTS ERROR: " . $e->getMessage() . "\n";
}

try {
    ob_start();
    require 'views/admin/settings.php';
    $out = ob_get_clean();
    echo "SETTINGS SUCCESS! Length: " . strlen($out) . "\n";
} catch (\Throwable $e) {
    echo "SETTINGS ERROR: " . $e->getMessage() . "\n";
}
