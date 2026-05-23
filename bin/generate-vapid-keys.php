<?php
// Generate VAPID keys for Web Push
require_once __DIR__ . '/../vendor/autoload.php';

use Minishlink\WebPush\VAPID;

$keys = VAPID::createVapidKeys();

echo "VAPID Keys Generated!\n\n";
echo "Add these to your .env file:\n\n";
echo "VAPID_PUBLIC_KEY=" . $keys['publicKey'] . "\n";
echo "VAPID_PRIVATE_KEY=" . $keys['privateKey'] . "\n";
echo "\n";
echo "Also add your admin email:\n";
echo "VAPID_SUBJECT=mailto:admin@kettik.study\n";
