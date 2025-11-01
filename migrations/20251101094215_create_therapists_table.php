<?php

/**
 * Migration: CreateTherapistsTable
 * Created: 2025-11-01
 * Generated from: config/sql/therapist.sql
 */

require_once __DIR__ . '/Migration.php';

class CreateTherapistsTable extends Migration
{
    /**
     * Run the migration
     */
    public function up()
    {
        $sql = "
            CREATE TABLE IF NOT EXISTS therapists (
                id SERIAL PRIMARY KEY,
                user_id INTEGER NOT NULL,
                id_upload VARCHAR(255) NOT NULL,
                specialization VARCHAR(100) NOT NULL,
                other_specialization VARCHAR(255) DEFAULT NULL,
                license_upload VARCHAR(255) NOT NULL,
                licensing_body VARCHAR(255) DEFAULT NULL,
                cv_upload VARCHAR(255) NOT NULL,
                languages JSONB NOT NULL,
                other_language VARCHAR(255) DEFAULT NULL,
                internet_connection VARCHAR(10) CHECK (internet_connection IN ('yes', 'no')) NOT NULL,
                video_conferencing VARCHAR(10) CHECK (video_conferencing IN ('yes', 'no')) NOT NULL,
                teletherapy_experience VARCHAR(10) CHECK (teletherapy_experience IN ('yes', 'no')) NOT NULL,
                consent_verification BOOLEAN NOT NULL DEFAULT FALSE,
                consent_data BOOLEAN NOT NULL DEFAULT FALSE,
                created_at TIMESTAMP NOT NULL DEFAULT CURRENT_TIMESTAMP,
                FOREIGN KEY (user_id) REFERENCES users(id) ON DELETE CASCADE
            );

            -- Add indexes for performance
            CREATE INDEX IF NOT EXISTS idx_therapist_user_id ON therapists(user_id);
            CREATE INDEX IF NOT EXISTS idx_therapist_created_at ON therapists(created_at);
            CREATE INDEX IF NOT EXISTS idx_therapist_specialization ON therapists(specialization);
        ";
        
        $this->execute($sql);
    }

    /**
     * Reverse the migration
     */
    public function down()
    {
        $sql = "
            DROP TABLE IF EXISTS therapists CASCADE;
        ";
        
        $this->execute($sql);
    }
}
