<?php
require __DIR__ . '/../vendor/autoload.php';

use Dotenv\Dotenv;

// Load .env from the root directory
$dotenv = Dotenv::createImmutable(__DIR__ . '/../');
$dotenv->load();

// Now you can access env variables via getenv() or $_ENV or $_SERVER
return [
    'google_client_id' => $_ENV['GOGGLE_CLEINT_ID'],
];
