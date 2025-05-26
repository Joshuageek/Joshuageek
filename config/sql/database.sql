CREATE DATABASE IF NOT EXISTS swiftdoc;
USE swiftdoc;

-- Table: booking_submissions
CREATE TABLE IF NOT EXISTS booking_submissions (
  id INT(11) NOT NULL AUTO_INCREMENT,
  full_name VARCHAR(255) NOT NULL,
  phone VARCHAR(20) NOT NULL,
  booking_date DATE NOT NULL,
  email VARCHAR(255) NOT NULL,
  number_of_people VARCHAR(20) NOT NULL,
  booking_time VARCHAR(50) NOT NULL,
  created_at TIMESTAMP NOT NULL DEFAULT current_timestamp(),
  PRIMARY KEY (id)
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_general_ci;

-- Table: questionnaire_responses
CREATE TABLE IF NOT EXISTS questionnaire_responses (
  id INT(11) NOT NULL AUTO_INCREMENT,
  user_id INT(11) DEFAULT NULL,
  therapyReasons TEXT DEFAULT NULL,
  therapyGoals TEXT DEFAULT NULL,
  therapyHistory VARCHAR(20) DEFAULT NULL,
  receivedTherapy TEXT DEFAULT NULL,
  therapyInterest TEXT DEFAULT NULL,
  communicationMethod TEXT DEFAULT NULL,
  sessionFrequency VARCHAR(50) DEFAULT NULL,
  sessionTime VARCHAR(50) DEFAULT NULL,
  therapistQualities TEXT DEFAULT NULL,
  therapistGender TEXT DEFAULT NULL,
  healthCondition TEXT DEFAULT NULL,
  triggers TEXT DEFAULT NULL,
  coping TEXT DEFAULT NULL,
  source TEXT DEFAULT NULL,
  additionalInfo TEXT DEFAULT NULL,
  submitted_at DATETIME DEFAULT current_timestamp(),
  PRIMARY KEY (id)
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_general_ci;

-- Table: therapists
CREATE TABLE IF NOT EXISTS therapists (
  id INT(11) NOT NULL AUTO_INCREMENT,
  user_id INT(11) NOT NULL,
  id_upload VARCHAR(255) NOT NULL,
  specialization VARCHAR(100) NOT NULL,
  other_specialization VARCHAR(255) DEFAULT NULL,
  license_upload VARCHAR(255) NOT NULL,
  licensing_body VARCHAR(255) DEFAULT NULL,
  cv_upload VARCHAR(255) NOT NULL,
  languages LONGTEXT CHARACTER SET utf8mb4 COLLATE utf8mb4_bin NOT NULL CHECK (json_valid(languages)),
  other_language VARCHAR(255) DEFAULT NULL,
  internet_connection ENUM('yes','no') NOT NULL,
  video_conferencing ENUM('yes','no') NOT NULL,
  teletherapy_experience ENUM('yes','no') NOT NULL,
  consent_verification TINYINT(1) NOT NULL DEFAULT 0,
  consent_data TINYINT(1) NOT NULL DEFAULT 0,
  created_at TIMESTAMP NOT NULL DEFAULT current_timestamp(),
  PRIMARY KEY (id)
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_general_ci;

-- Table: users
CREATE TABLE IF NOT EXISTS users (
  id INT(11) NOT NULL AUTO_INCREMENT,
  full_name VARCHAR(225) DEFAULT NULL,
  email VARCHAR(100) DEFAULT NULL,
  phone VARCHAR(100) DEFAULT NULL,
  age VARCHAR(20) DEFAULT NULL,
  gender VARCHAR(10) DEFAULT NULL,
  location VARCHAR(200) DEFAULT NULL,
  role VARCHAR(20) DEFAULT NULL,
  password VARCHAR(225) DEFAULT NULL,
  created_on DATETIME NOT NULL DEFAULT current_timestamp(),
  google_id VARCHAR(255) DEFAULT NULL,
  PRIMARY KEY (id)
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_general_ci;
