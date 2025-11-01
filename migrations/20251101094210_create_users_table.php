<?php

/**
 * Migration: CreateUsersTable
 * Created: 2025-11-01
 * Generated from: config/sql/user.sql
 */

require_once __DIR__ . '/Migration.php';

class CreateUsersTable extends Migration
{
    /**
     * Run the migration
     */
    public function up()
    {
        $sql = "
            CREATE TABLE IF NOT EXISTS users (
  id SERIAL PRIMARY KEY,
  full_name VARCHAR(225),
  email VARCHAR(100),
  phone VARCHAR(100),
  age VARCHAR(20),
  gender VARCHAR(10),
  location VARCHAR(200),
  role VARCHAR(20),
  password VARCHAR(225),
  created_on TIMESTAMP NOT NULL DEFAULT CURRENT_TIMESTAMP,
  google_id VARCHAR(255)
);

            -- Add indexes for performance
            CREATE INDEX IF NOT EXISTS idx_users_email ON users(email);
            CREATE INDEX IF NOT EXISTS idx_users_google_id ON users(google_id);
            CREATE INDEX IF NOT EXISTS idx_users_role ON users(role);
        ";
        
        $this->execute($sql);
    }

    /**
     * Reverse the migration
     */
    public function down()
    {
        $sql = "
            DROP TABLE IF EXISTS users CASCADE;
        ";
        
        $this->execute($sql);
    }
}
