<?php

/**
 * Database Migration Runner
 * Usage:
 *   php migrations/migrate.php up              # Run all pending migrations
 *   php migrations/migrate.php down            # Rollback last migration
 *   php migrations/migrate.php status          # Show migration status
 *   php migrations/migrate.php create <name>   # Create new migration file
 */

require_once __DIR__ . '/../vendor/autoload.php';
require_once __DIR__ . '/../config/db.php';
require_once __DIR__ . '/Migration.php';

class MigrationRunner
{
    private $conn;
    private $migrationsPath;

    public function __construct($conn)
    {
        $this->conn = $conn;
        $this->migrationsPath = __DIR__;
        $this->ensureMigrationsTableExists();
    }

    /**
     * Create migrations tracking table if it doesn't exist
     */
    private function ensureMigrationsTableExists()
    {
        $sql = "
            CREATE TABLE IF NOT EXISTS migrations (
                id SERIAL PRIMARY KEY,
                migration VARCHAR(255) NOT NULL UNIQUE,
                batch INTEGER NOT NULL,
                executed_at TIMESTAMP DEFAULT CURRENT_TIMESTAMP
            );
            
            CREATE INDEX IF NOT EXISTS idx_migrations_batch ON migrations(batch);
        ";
        
        try {
            $this->conn->exec($sql);
        } catch (PDOException $e) {
            die("Error creating migrations table: " . $e->getMessage() . "\n");
        }
    }

    /**
     * Get all migration files
     */
    private function getMigrationFiles()
    {
        $files = glob($this->migrationsPath . '/*.php');
        $migrations = [];

        foreach ($files as $file) {
            $filename = basename($file);
            // Skip Migration.php, migrate.php, and sql-to-migration.php
            if (in_array($filename, ['Migration.php', 'migrate.php', 'sql-to-migration.php', 'seed.php'])) {
                continue;
            }
            if (preg_match('/^\d{14}_.*\.php$/', $filename)) {
                $migrations[] = $filename;
            }
        }

        sort($migrations);
        return $migrations;
    }

    /**
     * Get executed migrations
     */
    private function getExecutedMigrations()
    {
        $stmt = $this->conn->query("SELECT migration FROM migrations ORDER BY migration");
        return $stmt->fetchAll(PDO::FETCH_COLUMN);
    }

    /**
     * Get pending migrations
     */
    private function getPendingMigrations()
    {
        $allMigrations = $this->getMigrationFiles();
        $executedMigrations = $this->getExecutedMigrations();
        return array_diff($allMigrations, $executedMigrations);
    }

    /**
     * Get current batch number
     */
    private function getCurrentBatch()
    {
        $stmt = $this->conn->query("SELECT COALESCE(MAX(batch), 0) FROM migrations");
        return (int)$stmt->fetchColumn();
    }

    /**
     * Run pending migrations
     */
    public function up()
    {
        $pendingMigrations = $this->getPendingMigrations();

        if (empty($pendingMigrations)) {
            echo "No pending migrations.\n";
            return;
        }

        $batch = $this->getCurrentBatch() + 1;

        echo "Running " . count($pendingMigrations) . " migration(s)...\n\n";

        foreach ($pendingMigrations as $migration) {
            echo "Migrating: {$migration}\n";

            try {
                $this->conn->beginTransaction();

                // Load and execute migration
                require_once $this->migrationsPath . '/' . $migration;
                $className = $this->getClassNameFromFile($migration);
                $instance = new $className($this->conn);
                $instance->up();

                // Record migration
                $stmt = $this->conn->prepare("
                    INSERT INTO migrations (migration, batch) 
                    VALUES (:migration, :batch)
                ");
                $stmt->execute([
                    'migration' => $migration,
                    'batch' => $batch
                ]);

                $this->conn->commit();
                echo "✅ Migrated:  {$migration}\n";

            } catch (Exception $e) {
                $this->conn->rollBack();
                die("\n❌ Migration failed: {$migration}\nError: " . $e->getMessage() . "\n");
            }
        }

        echo "\n✅ All migrations completed successfully!\n";
    }

    /**
     * Rollback last batch of migrations
     */
    public function down()
    {
        $batch = $this->getCurrentBatch();

        if ($batch === 0) {
            echo "Nothing to rollback.\n";
            return;
        }

        $stmt = $this->conn->prepare("
            SELECT migration FROM migrations 
            WHERE batch = :batch 
            ORDER BY migration DESC
        ");
        $stmt->execute(['batch' => $batch]);
        $migrations = $stmt->fetchAll(PDO::FETCH_COLUMN);

        foreach ($migrations as $migration) {
            echo "Rolling back: {$migration}\n";

            try {
                $this->conn->beginTransaction();

                // Load and execute rollback
                require_once $this->migrationsPath . '/' . $migration;
                $className = $this->getClassNameFromFile($migration);
                $instance = new $className($this->conn);
                $instance->down();

                // Remove migration record
                $stmt = $this->conn->prepare("DELETE FROM migrations WHERE migration = :migration");
                $stmt->execute(['migration' => $migration]);

                $this->conn->commit();
                echo "✅ Rolled back: {$migration}\n";

            } catch (Exception $e) {
                $this->conn->rollBack();
                die("\n❌ Rollback failed: {$migration}\nError: " . $e->getMessage() . "\n");
            }
        }

        echo "\n✅ Rollback completed successfully!\n";
    }

    /**
     * Show migration status
     */
    public function status()
    {
        $allMigrations = $this->getMigrationFiles();
        $executedMigrations = $this->getExecutedMigrations();

        echo "\n" . str_repeat("=", 80) . "\n";
        echo "MIGRATION STATUS\n";
        echo str_repeat("=", 80) . "\n\n";

        if (empty($allMigrations)) {
            echo "No migrations found.\n";
            return;
        }

        foreach ($allMigrations as $migration) {
            $status = in_array($migration, $executedMigrations) ? "✅ [EXECUTED]" : "⏳ [PENDING]";
            echo sprintf("%-15s %s\n", $status, $migration);
        }

        echo "\n";
        echo "Total migrations: " . count($allMigrations) . "\n";
        echo "Executed: " . count($executedMigrations) . "\n";
        echo "Pending: " . (count($allMigrations) - count($executedMigrations)) . "\n\n";
    }

    /**
     * Create a new migration file
     */
    public function create($name)
    {
        if (empty($name)) {
            die("Please provide a migration name.\nUsage: php migrations/migrate.php create <name>\n");
        }

        // Convert name to snake_case
        $name = strtolower(preg_replace('/[^a-zA-Z0-9]+/', '_', $name));
        $timestamp = date('YmdHis');
        $filename = "{$timestamp}_{$name}.php";
        $className = $this->getClassNameFromFile($filename);

        $template = "<?php

/**
 * Migration: {$name}
 * Created: " . date('Y-m-d H:i:s') . "
 */

require_once __DIR__ . '/Migration.php';

class {$className} extends Migration
{
    /**
     * Run the migration
     */
    public function up()
    {
        // TODO: Add your migration code here
        \$sql = \"
            -- Add your SQL here
        \";
        
        \$this->execute(\$sql);
    }

    /**
     * Reverse the migration
     */
    public function down()
    {
        // TODO: Add your rollback code here
        \$sql = \"
            -- Add your rollback SQL here
        \";
        
        \$this->execute(\$sql);
    }
}
";

        $filepath = $this->migrationsPath . '/' . $filename;
        file_put_contents($filepath, $template);

        echo "✅ Created migration: {$filename}\n";
    }

    /**
     * Get class name from migration filename
     */
    private function getClassNameFromFile($filename)
    {
        $name = preg_replace('/^\d{14}_/', '', $filename);
        $name = str_replace('.php', '', $name);
        $parts = explode('_', $name);
        $className = '';
        foreach ($parts as $part) {
            $className .= ucfirst($part);
        }
        return $className;
    }
}

// CLI Handler
if (php_sapi_name() !== 'cli') {
    die("This script must be run from the command line.\n");
}

$command = $argv[1] ?? 'status';
$arg = $argv[2] ?? null;

$runner = new MigrationRunner($conn);

switch ($command) {
    case 'up':
        $runner->up();
        break;
    
    case 'down':
        $runner->down();
        break;
    
    case 'status':
        $runner->status();
        break;
    
    case 'create':
        $runner->create($arg);
        break;
    
    default:
        echo "Unknown command: {$command}\n\n";
        echo "Available commands:\n";
        echo "  up              Run all pending migrations\n";
        echo "  down            Rollback last batch of migrations\n";
        echo "  status          Show migration status\n";
        echo "  create <name>   Create new migration file\n";
        break;
}
