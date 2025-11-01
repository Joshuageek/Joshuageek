<?php

/**
 * Database Connection Test
 * Run this to verify your database credentials are correct
 */

echo "╔════════════════════════════════════════╗\n";
echo "║   Database Connection Test             ║\n";
echo "╚════════════════════════════════════════╝\n\n";

// Load environment variables
require_once __DIR__ . '/vendor/autoload.php';

try {
    $dotenv = Dotenv\Dotenv::createImmutable(__DIR__);
    $dotenv->load();
    echo "✅ Environment file loaded\n";
} catch (Exception $e) {
    die("❌ Error loading .env file: " . $e->getMessage() . "\n");
}

// Check if DATABASE_URL exists
if (!isset($_ENV['DATABASE_URL'])) {
    die("❌ DATABASE_URL not found in .env file\n");
}

echo "✅ DATABASE_URL found\n";

// Parse the URL
$databaseUrl = $_ENV['DATABASE_URL'];
$dbParts = parse_url($databaseUrl);

echo "\n📊 Connection Details:\n";
echo "   Host: " . ($dbParts['host'] ?? 'not set') . "\n";
echo "   Port: " . ($dbParts['port'] ?? '5432') . "\n";
echo "   Database: " . ltrim($dbParts['path'] ?? '', '/') . "\n";
echo "   User: " . ($dbParts['user'] ?? 'not set') . "\n";
echo "   Password: " . (isset($dbParts['pass']) ? str_repeat('*', strlen($dbParts['pass'])) : 'not set') . "\n";

// Try to connect
echo "\n🔄 Attempting connection...\n";

try {
    $host = $dbParts['host'] ?? 'localhost';
    $port = $dbParts['port'] ?? 5432;
    $dbname = ltrim($dbParts['path'] ?? '', '/');
    $user = $dbParts['user'] ?? '';
    $password = $dbParts['pass'] ?? '';
    
    $options = [];
    if (isset($dbParts['query'])) {
        parse_str($dbParts['query'], $options);
    }
    
    $dsn = "pgsql:host={$host};port={$port};dbname={$dbname}";
    
    if (isset($options['sslmode'])) {
        $dsn .= ";sslmode={$options['sslmode']}";
    }
    
    $conn = new PDO($dsn, $user, $password, [
        PDO::ATTR_ERRMODE => PDO::ERRMODE_EXCEPTION,
        PDO::ATTR_DEFAULT_FETCH_MODE => PDO::FETCH_ASSOC
    ]);
    
    echo "✅ Connection successful!\n\n";
    
    // Get PostgreSQL version
    $stmt = $conn->query('SELECT version()');
    $version = $stmt->fetchColumn();
    echo "📌 PostgreSQL Version:\n   " . $version . "\n\n";
    
    // Check if migrations table exists
    $stmt = $conn->query("
        SELECT EXISTS (
            SELECT FROM information_schema.tables 
            WHERE table_schema = 'public' 
            AND table_name = 'migrations'
        )
    ");
    $hasMigrations = $stmt->fetchColumn();
    
    if ($hasMigrations) {
        echo "✅ Migrations table exists\n";
        
        $stmt = $conn->query("SELECT COUNT(*) FROM migrations");
        $count = $stmt->fetchColumn();
        echo "   Executed migrations: {$count}\n";
    } else {
        echo "⚠️  Migrations table does not exist yet (will be created on first migration)\n";
    }
    
    // List all tables
    $stmt = $conn->query("
        SELECT tablename 
        FROM pg_tables 
        WHERE schemaname = 'public' 
        ORDER BY tablename
    ");
    $tables = $stmt->fetchAll(PDO::FETCH_COLUMN);
    
    echo "\n📋 Existing Tables:\n";
    if (empty($tables)) {
        echo "   (no tables yet - run migrations to create them)\n";
    } else {
        foreach ($tables as $table) {
            echo "   - {$table}\n";
        }
    }
    
    echo "\n✅ Database is ready! You can now run migrations:\n";
    echo "   php migrations/migrate.php up\n\n";
    
} catch (PDOException $e) {
    echo "❌ Connection failed!\n\n";
    echo "Error: " . $e->getMessage() . "\n\n";
    echo "Common solutions:\n";
    echo "1. Check your DATABASE_URL in .env file\n";
    echo "2. Get fresh credentials from Neon console: https://console.neon.tech\n";
    echo "3. Make sure there are no extra spaces or quotes\n";
    echo "4. Try resetting your database password in Neon\n\n";
    exit(1);
}
