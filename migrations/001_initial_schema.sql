CREATE DATABASE IF NOT EXISTS votingsystem
  CHARACTER SET utf8mb4
  COLLATE utf8mb4_unicode_ci;

USE votingsystem;

CREATE TABLE IF NOT EXISTS users (
  id INT NOT NULL AUTO_INCREMENT,
  username VARCHAR(100) NOT NULL UNIQUE,
  email VARCHAR(255) NOT NULL UNIQUE,
  password VARCHAR(255) NOT NULL,
  first_name VARCHAR(100) NOT NULL,
  last_name VARCHAR(100) NOT NULL,
  student_id VARCHAR(20) DEFAULT NULL,
  program VARCHAR(100) DEFAULT NULL,
  is_admin TINYINT(1) NOT NULL DEFAULT 0,
  email_authenticated TINYINT(1) NOT NULL DEFAULT 0,
  activation_code VARCHAR(32) DEFAULT NULL,
  activation_expiry DATETIME DEFAULT NULL,
  PRIMARY KEY (id)
);

CREATE TABLE IF NOT EXISTS candidates (
  id INT NOT NULL AUTO_INCREMENT,
  last_name VARCHAR(100) NOT NULL,
  first_name VARCHAR(100) NOT NULL,
  position VARCHAR(100) NOT NULL,
  section VARCHAR(100) DEFAULT NULL,
  description TEXT DEFAULT NULL,
  image_path VARCHAR(255) DEFAULT NULL,
  PRIMARY KEY (id)
);

CREATE TABLE IF NOT EXISTS election_settings (
  id INT NOT NULL AUTO_INCREMENT,
  datetime_start DATETIME NOT NULL,
  datetime_end DATETIME NOT NULL,
  PRIMARY KEY (id)
);

CREATE TABLE IF NOT EXISTS votes (
  id INT NOT NULL AUTO_INCREMENT,
  ballot_id VARCHAR(32) NOT NULL,
  user_id INT NOT NULL,
  candidate_id INT NOT NULL,
  position VARCHAR(100) NOT NULL,
  datetime DATETIME NOT NULL DEFAULT CURRENT_TIMESTAMP,
  PRIMARY KEY (id),
  KEY idx_votes_ballot_id (ballot_id),
  KEY idx_votes_user_datetime (user_id, datetime),
  KEY idx_votes_candidate_id (candidate_id),
  CONSTRAINT fk_votes_user
    FOREIGN KEY (user_id) REFERENCES users(id)
    ON DELETE CASCADE
    ON UPDATE CASCADE,
  CONSTRAINT fk_votes_candidate
    FOREIGN KEY (candidate_id) REFERENCES candidates(id)
    ON DELETE CASCADE
    ON UPDATE CASCADE
);
