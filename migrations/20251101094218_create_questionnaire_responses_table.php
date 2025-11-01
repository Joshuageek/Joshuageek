<?php

/**
 * Migration: CreateQuestionnaireResponsesTable
 * Created: 2025-11-01
 * Generated from: config/sql/questionnaire_responses.sql
 */

require_once __DIR__ . '/Migration.php';

class CreateQuestionnaireResponsesTable extends Migration
{
    /**
     * Run the migration
     */
    public function up()
    {
        $sql = "
            CREATE TABLE IF NOT EXISTS questionnaire_responses (
  id SERIAL PRIMARY KEY,
  user_id INTEGER,
  therapyReasons TEXT,
  therapyGoals TEXT,
  therapyHistory VARCHAR(20),
  receivedTherapy TEXT,
  therapyInterest TEXT,
  communicationMethod TEXT,
  sessionFrequency VARCHAR(50),
  sessionTime VARCHAR(50),
  therapistQualities TEXT,
  therapistGender TEXT,
  healthCondition TEXT,
  triggers TEXT,
  coping TEXT,
  source TEXT,
  additionalInfo TEXT,
  submitted_at TIMESTAMP DEFAULT CURRENT_TIMESTAMP,
  FOREIGN KEY (user_id) REFERENCES users(id) ON DELETE CASCADE
);

            -- Add indexes for performance
            CREATE INDEX IF NOT EXISTS idx_questionnaire_user_id ON questionnaire_responses(user_id);
            CREATE INDEX IF NOT EXISTS idx_questionnaire_submitted_at ON questionnaire_responses(submitted_at);
        ";
        
        $this->execute($sql);
    }

    /**
     * Reverse the migration
     */
    public function down()
    {
        $sql = "
            DROP TABLE IF EXISTS questionnaire_responses CASCADE;
        ";
        
        $this->execute($sql);
    }
}
