<?php
require __DIR__ . '/../vendor/autoload.php';

use Dotenv\Dotenv;

// Load .env from the root directory
$dotenv = Dotenv::createImmutable(__DIR__ . '/../');
$dotenv->load();

$local_server = [
    'host' => 'localhost',
    'user' => 'root',
    'password' => '',
    'dbname' => $_ENV['DB_NAME'],
];

return [
    'google_client_id' => $_ENV['GOGGLE_CLEINT_ID'],
    'local_server' => $local_server
];
