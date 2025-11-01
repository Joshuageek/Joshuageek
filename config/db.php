<?php
ob_start();

// Load environment variables
require_once __DIR__ . '/../vendor/autoload.php';
$dotenv = Dotenv\Dotenv::createImmutable(__DIR__ . '/..');
$dotenv->load();

try {
    // Parse the DATABASE_URL
    $databaseUrl = $_ENV['DATABASE_URL'];
    
    // Parse PostgreSQL URL
    $dbParts = parse_url($databaseUrl);
    
    // Extract components
    $host = $dbParts['host'] ?? 'localhost';
    $port = $dbParts['port'] ?? 5432;
    $dbname = ltrim($dbParts['path'] ?? '', '/');
    $user = $dbParts['user'] ?? '';
    $password = $dbParts['pass'] ?? '';
    
    // Parse query string for additional options
    $options = [];
    if (isset($dbParts['query'])) {
        parse_str($dbParts['query'], $options);
    }
    
    // Build DSN
    $dsn = "pgsql:host={$host};port={$port};dbname={$dbname}";
    
    // Add sslmode if present
    if (isset($options['sslmode'])) {
        $dsn .= ";sslmode={$options['sslmode']}";
    }
    
    // Create PDO connection
    $conn = new PDO($dsn, $user, $password, [
        PDO::ATTR_ERRMODE => PDO::ERRMODE_EXCEPTION,
        PDO::ATTR_EMULATE_PREPARES => false,
        PDO::ATTR_DEFAULT_FETCH_MODE => PDO::FETCH_ASSOC
    ]);
    
} catch(PDOException $e) {
    error_log("Connection failed: " . $e->getMessage());
    throw new Exception("Database connection error: " . $e->getMessage());
}
ob_end_clean();
?>