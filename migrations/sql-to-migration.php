<?php

/**
 * SQL to Migration Converter
 * 
 * This tool converts SQL files from config/sql/ into migration files
 * 
 * Usage: php migrations/sql-to-migration.php [sql-file]
 *        php migrations/sql-to-migration.php --all
 */

class SqlToMigrationConverter
{
    private $sqlDir;
    private $migrationsDir;
    private $timestamp;

    public function __construct()
    {
        $this->sqlDir = __DIR__ . '/../config/sql';
        $this->migrationsDir = __DIR__;
        $this->timestamp = date('YmdHis');
    }

    /**
     * Convert all SQL files in config/sql directory
     */
    public function convertAll()
    {
        if (!is_dir($this->sqlDir)) {
            echo "Error: SQL directory not found at {$this->sqlDir}\n";
            return;
        }

        $sqlFiles = glob($this->sqlDir . '/*.sql');
        
        if (empty($sqlFiles)) {
            echo "No SQL files found in {$this->sqlDir}\n";
            return;
        }

        echo "Found " . count($sqlFiles) . " SQL file(s)\n\n";

        foreach ($sqlFiles as $sqlFile) {
            $this->convertFile($sqlFile);
            // Increment timestamp to maintain order
            $this->timestamp = date('YmdHis', strtotime('+1 second'));
        }

        echo "\n✅ All SQL files converted to migrations!\n";
    }

    /**
     * Convert a single SQL file to migration
     */
    public function convertFile($sqlFilePath)
    {
        if (!file_exists($sqlFilePath)) {
            echo "Error: File not found: {$sqlFilePath}\n";
            return;
        }

        $sqlContent = file_get_contents($sqlFilePath);
        $filename = basename($sqlFilePath, '.sql');
        
        echo "Converting: {$filename}.sql\n";

        // Parse the SQL content
        $tableName = $this->extractTableName($sqlContent);
        
        if (!$tableName) {
            echo "  ⚠️  Could not extract table name, skipping\n";
            return;
        }

        // Convert MySQL to PostgreSQL
        $pgSql = $this->convertMySQLToPostgreSQL($sqlContent, $tableName);

        // Generate migration file
        $migrationName = "create_{$tableName}_table";
        $className = $this->getClassName($migrationName);
        
        $migrationFile = $this->migrationsDir . '/' . 
                        $this->timestamp . '_' . 
                        $migrationName . '.php';

        // Check if migration already exists
        if (file_exists($migrationFile)) {
            echo "  ⚠️  Migration already exists: " . basename($migrationFile) . "\n";
            return;
        }

        // Generate the migration content
        $migrationContent = $this->generateMigrationFile($className, $tableName, $pgSql, $filename);

        // Write the migration file
        file_put_contents($migrationFile, $migrationContent);

        echo "  ✅ Created: " . basename($migrationFile) . "\n";
    }

    /**
     * Extract table name from SQL
     */
    private function extractTableName($sql)
    {
        // Match CREATE TABLE statements
        if (preg_match('/CREATE\s+TABLE\s+(?:IF\s+NOT\s+EXISTS\s+)?[`"]?(\w+)[`"]?\s*\(/i', $sql, $matches)) {
            return $matches[1];
        }
        return null;
    }

    /**
     * Convert MySQL syntax to PostgreSQL
     */
    private function convertMySQLToPostgreSQL($sql, $tableName)
    {
        // Remove MySQL-specific comments that might interfere
        $sql = preg_replace('/--.*$/m', '', $sql);
        
        // Extract CREATE TABLE statement
        preg_match('/CREATE\s+TABLE.*?\);/is', $sql, $createMatches);
        $createTable = $createMatches[0] ?? '';
        
        // Extract indexes
        preg_match_all('/CREATE\s+INDEX.*?;/is', $sql, $indexMatches);
        $indexes = $indexMatches[0] ?? [];

        // Convert CREATE TABLE
        $pgCreate = $this->convertCreateTable($createTable, $tableName);
        
        // Convert indexes and remove duplicates
        $pgIndexes = array_unique(array_map([$this, 'convertIndex'], $indexes));

        // Combine
        $pgSql = trim($pgCreate);
        
        if (!empty($pgIndexes)) {
            $pgSql .= "\n\n            -- Add indexes for performance\n            ";
            $pgSql .= implode("\n            ", $pgIndexes);
        }

        return $pgSql;
    }

    /**
     * Convert CREATE TABLE from MySQL to PostgreSQL
     */
    private function convertCreateTable($sql, $tableName)
    {
        // Remove backticks
        $sql = str_replace(['`', '"'], '', $sql);

        // Convert AUTO_INCREMENT to SERIAL
        $sql = preg_replace('/INT\(\d+\)\s+NOT\s+NULL\s+AUTO_INCREMENT/i', 'SERIAL', $sql);
        $sql = preg_replace('/INTEGER\s+NOT\s+NULL\s+AUTO_INCREMENT/i', 'SERIAL', $sql);
        
        // Convert INT(n) to INTEGER
        $sql = preg_replace('/INT\(\d+\)/i', 'INTEGER', $sql);
        
        // Convert TINYINT(1) to BOOLEAN
        $sql = preg_replace('/TINYINT\(1\)/i', 'BOOLEAN', $sql);
        $sql = preg_replace('/TINYINTEGER/i', 'BOOLEAN', $sql); // Fix double conversion
        
        // Convert DEFAULT 0 to DEFAULT FALSE for booleans
        $sql = preg_replace('/(BOOLEAN.*?)DEFAULT\s+0/i', '$1DEFAULT FALSE', $sql);
        $sql = preg_replace('/(BOOLEAN.*?)DEFAULT\s+1/i', '$1DEFAULT TRUE', $sql);
        
        // Convert ENUM to VARCHAR with CHECK constraint
        $sql = preg_replace_callback(
            '/(\w+)\s+ENUM\((.*?)\)/i',
            function($matches) {
                $column = $matches[1];
                $values = $matches[2];
                // Clean up the values
                $values = str_replace("'", "", $values);
                $valuesArray = array_map('trim', explode(',', $values));
                $checkValues = implode("', '", $valuesArray);
                return "{$column} VARCHAR(10) CHECK ({$column} IN ('{$checkValues}'))";
            },
            $sql
        );
        
        // Convert LONGTEXT with JSON validation to JSONB
        $sql = preg_replace('/LONGTEXT\s+CHARACTER\s+SET\s+\w+\s+COLLATE\s+\w+\s+NOT\s+NULL\s+CHECK\s*\(json_valid\(\w+\)\)/i', 'JSONB NOT NULL', $sql);
        
        // Convert TEXT to TEXT (already compatible)
        // Convert TIMESTAMP
        $sql = preg_replace('/TIMESTAMP\s+NOT\s+NULL\s+DEFAULT\s+current_timestamp\(\)/i', 'TIMESTAMP NOT NULL DEFAULT CURRENT_TIMESTAMP', $sql);
        $sql = preg_replace('/TIMESTAMP\s+DEFAULT\s+current_timestamp\(\)/i', 'TIMESTAMP DEFAULT CURRENT_TIMESTAMP', $sql);
        
        // Remove PRIMARY KEY constraint from column definition if using SERIAL
        $sql = preg_replace('/SERIAL\s+PRIMARY\s+KEY/i', 'SERIAL PRIMARY KEY', $sql);
        
        // Convert separate PRIMARY KEY line and make id PRIMARY KEY
        $sql = preg_replace('/,\s*PRIMARY\s+KEY\s*\(\s*id\s*\)\s*$/im', '', $sql);
        
        // Change id SERIAL to id SERIAL PRIMARY KEY
        if (preg_match('/id\s+SERIAL/i', $sql) && !preg_match('/id\s+SERIAL\s+PRIMARY\s+KEY/i', $sql)) {
            $sql = preg_replace('/id\s+SERIAL\s*,/i', 'id SERIAL PRIMARY KEY,', $sql);
            $sql = preg_replace('/id\s+SERIAL\s*\n/i', "id SERIAL PRIMARY KEY,\n", $sql);
        }
        
        // If id is INTEGER, convert to SERIAL PRIMARY KEY
        if (!preg_match('/id\s+SERIAL/i', $sql)) {
            $sql = preg_replace('/id\s+INTEGER\s*,/i', 'id SERIAL PRIMARY KEY,', $sql);
        }

        // Add IF NOT EXISTS
        if (!preg_match('/IF\s+NOT\s+EXISTS/i', $sql)) {
            $sql = preg_replace('/CREATE\s+TABLE\s+/i', 'CREATE TABLE IF NOT EXISTS ', $sql);
        }

        return $sql;
    }

    /**
     * Convert index statement
     */
    private function convertIndex($sql)
    {
        // Already PostgreSQL compatible, just clean up
        $sql = str_replace(['`', '"'], '', $sql);
        return trim($sql);
    }

    /**
     * Generate complete migration file content
     */
    private function generateMigrationFile($className, $tableName, $pgSql, $originalFile)
    {
        $date = date('Y-m-d');
        
        return "<?php

/**
 * Migration: {$className}
 * Created: {$date}
 * Generated from: config/sql/{$originalFile}.sql
 */

require_once __DIR__ . '/Migration.php';

class {$className} extends Migration
{
    /**
     * Run the migration
     */
    public function up()
    {
        \$sql = \"
            {$pgSql}
        \";
        
        \$this->execute(\$sql);
    }

    /**
     * Reverse the migration
     */
    public function down()
    {
        \$sql = \"
            DROP TABLE IF EXISTS {$tableName} CASCADE;
        \";
        
        \$this->execute(\$sql);
    }
}
";
    }

    /**
     * Get class name from migration name
     */
    private function getClassName($name)
    {
        $parts = explode('_', $name);
        $className = '';
        foreach ($parts as $part) {
            $className .= ucfirst($part);
        }
        return $className;
    }

    /**
     * Preview conversion without creating files
     */
    public function preview($sqlFilePath)
    {
        if (!file_exists($sqlFilePath)) {
            echo "Error: File not found: {$sqlFilePath}\n";
            return;
        }

        $sqlContent = file_get_contents($sqlFilePath);
        $filename = basename($sqlFilePath, '.sql');
        $tableName = $this->extractTableName($sqlContent);
        
        if (!$tableName) {
            echo "Could not extract table name\n";
            return;
        }

        echo "Original SQL ({$filename}.sql):\n";
        echo "=====================================\n";
        echo $sqlContent . "\n\n";

        echo "PostgreSQL Conversion:\n";
        echo "=====================================\n";
        $pgSql = $this->convertMySQLToPostgreSQL($sqlContent, $tableName);
        echo $pgSql . "\n\n";

        $migrationName = "create_{$tableName}_table";
        echo "Migration file would be: {$this->timestamp}_{$migrationName}.php\n";
    }
}

// CLI Handler
if (php_sapi_name() !== 'cli') {
    die("This script must be run from the command line.\n");
}

echo "╔════════════════════════════════════════╗\n";
echo "║   SQL to Migration Converter           ║\n";
echo "╚════════════════════════════════════════╝\n\n";

$converter = new SqlToMigrationConverter();

$command = $argv[1] ?? '--help';

switch ($command) {
    case '--all':
        $converter->convertAll();
        break;
    
    case '--preview':
        if (!isset($argv[2])) {
            echo "Error: Please specify a SQL file to preview\n";
            echo "Usage: php migrations/sql-to-migration.php --preview config/sql/users.sql\n";
            exit(1);
        }
        $converter->preview($argv[2]);
        break;
    
    case '--help':
        echo "Convert SQL files to migration files\n\n";
        echo "Usage:\n";
        echo "  php migrations/sql-to-migration.php --all              Convert all SQL files\n";
        echo "  php migrations/sql-to-migration.php <file>             Convert single SQL file\n";
        echo "  php migrations/sql-to-migration.php --preview <file>   Preview conversion\n";
        echo "\n";
        echo "Examples:\n";
        echo "  php migrations/sql-to-migration.php --all\n";
        echo "  php migrations/sql-to-migration.php config/sql/users.sql\n";
        echo "  php migrations/sql-to-migration.php --preview config/sql/users.sql\n";
        break;
    
    default:
        // Assume it's a file path
        $converter->convertFile($command);
        break;
}
