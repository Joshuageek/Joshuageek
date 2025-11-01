<?php

/**
 * Migration: CreateBookingSubmissionsTable
 * Created: 2025-11-01
 * Generated from: config/sql/booking_submissions.sql
 */

require_once __DIR__ . '/Migration.php';

class CreateBookingSubmissionsTable extends Migration
{
    /**
     * Run the migration
     */
    public function up()
    {
        $sql = "
            CREATE TABLE IF NOT EXISTS booking_submissions (
  id SERIAL PRIMARY KEY,
  full_name VARCHAR(255) NOT NULL,
  phone VARCHAR(20) NOT NULL,
  booking_date DATE NOT NULL,
  email VARCHAR(255) NOT NULL,
  number_of_people VARCHAR(20) NOT NULL,
  booking_time VARCHAR(50) NOT NULL,
  status TEXT NOT NULL DEFAULT 'pending',
  created_at TIMESTAMP NOT NULL DEFAULT CURRENT_TIMESTAMP
);

            -- Add indexes for performance
            CREATE INDEX IF NOT EXISTS idx_booking_email ON booking_submissions(email);
            CREATE INDEX IF NOT EXISTS idx_booking_date ON booking_submissions(booking_date);
            CREATE INDEX IF NOT EXISTS idx_booking_status ON booking_submissions(status);
        ";
        
        $this->execute($sql);
    }

    /**
     * Reverse the migration
     */
    public function down()
    {
        $sql = "
            DROP TABLE IF EXISTS booking_submissions CASCADE;
        ";
        
        $this->execute($sql);
    }
}
