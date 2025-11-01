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
)

CREATE INDEX IF NOT EXISTS idx_therapist_user_id ON therapists(user_id);
CREATE INDEX IF NOT EXISTS idx_therapist_created_at ON therapists(created_at);

