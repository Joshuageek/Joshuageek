<?php

/**
 * Base Migration Class
 * All migration files should extend this class
 */
abstract class Migration
{
    protected $conn;

    public function __construct($conn)
    {
        $this->conn = $conn;
    }

    /**
     * Run the migration (apply changes)
     */
    abstract public function up();

    /**
     * Reverse the migration (rollback changes)
     */
    abstract public function down();

    /**
     * Execute a SQL query
     */
    protected function execute($sql)
    {
        try {
            $this->conn->exec($sql);
            return true;
        } catch (PDOException $e) {
            throw new Exception("Migration error: " . $e->getMessage());
        }
    }

    /**
     * Check if a table exists
     */
    protected function tableExists($tableName)
    {
        $stmt = $this->conn->prepare("
            SELECT EXISTS (
                SELECT FROM information_schema.tables 
                WHERE table_schema = 'public' 
                AND table_name = :table_name
            )
        ");
        $stmt->execute(['table_name' => $tableName]);
        return $stmt->fetchColumn();
    }

    /**
     * Check if a column exists in a table
     */
    protected function columnExists($tableName, $columnName)
    {
        $stmt = $this->conn->prepare("
            SELECT EXISTS (
                SELECT FROM information_schema.columns 
                WHERE table_schema = 'public' 
                AND table_name = :table_name 
                AND column_name = :column_name
            )
        ");
        $stmt->execute([
            'table_name' => $tableName,
            'column_name' => $columnName
        ]);
        return $stmt->fetchColumn();
    }

    /**
     * Check if an index exists
     */
    protected function indexExists($indexName)
    {
        $stmt = $this->conn->prepare("
            SELECT EXISTS (
                SELECT FROM pg_indexes 
                WHERE schemaname = 'public' 
                AND indexname = :index_name
            )
        ");
        $stmt->execute(['index_name' => $indexName]);
        return $stmt->fetchColumn();
    }
}
