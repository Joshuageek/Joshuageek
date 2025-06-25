<?php
// luna/config.php

// 1. Environment
define('ENV', 'development');

// 2. Error Reporting
ini_set('display_errors', ENV === 'development' ? 1 : 0);

// 3. Auto-detect paths
$base_path = str_replace($_SERVER['DOCUMENT_ROOT'], '', __DIR__);
define('APP_ROOT', $base_path . '/');
define('ADMIN_ROOT', $base_path . '/admin/');

// 4. Database
define('DB_HOST', 'localhost');
define('DB_USER', ENV === 'development' ? 'dev_user' : 'prod_user');
define('DB_PASS', 'password');
define('DB_NAME', 'luna_db');

// 5. Security
define('CSRF_TOKEN_SALT', 'random-123-abc');