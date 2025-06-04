<?php
require __DIR__ . '/../vendor/autoload.php';

use Dotenv\Dotenv;

$dotenv = Dotenv::createImmutable(__DIR__ . '/../');
$dotenv->load();

$local_server = [
    'host' => 'localhost',
    'user' => 'root',
    'password' => '',
    'dbname' => $_ENV['DB_NAME'],
];

return [
    'google_client_id' => $_ENV['GOGGLE_CLIENT_ID'],
    'google_app_username'=> $_ENV['GOOGLE_APP_USERNAME'],
    'google_app_password'=> $_ENV['GOOG_APP_PASSWORD'],
    'local_server' => $local_server
];
