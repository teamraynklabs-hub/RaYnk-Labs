-- ============================================================================
-- RaYnk Labs Database Schema
-- ============================================================================
-- This SQL file creates all necessary tables for the RaYnkLabs(PHP) project
-- Compatible with MySQL 5.7+ and MariaDB 10.0+
-- ============================================================================

-- Drop existing database if needed (optional - comment out if updating existing DB)
-- DROP DATABASE IF EXISTS `ranky_labs_db`;

-- Create database with proper encoding
CREATE DATABASE IF NOT EXISTS `ranky_labs_db`
  CHARACTER SET utf8mb4
  COLLATE utf8mb4_unicode_ci;

-- Select the database
USE `ranky_labs_db`;

-- ============================================================================
-- ADMINS TABLE
-- ============================================================================
-- Stores administrator login credentials with bcrypt password hashing
CREATE TABLE IF NOT EXISTS `admins` (
  `id` INT UNSIGNED NOT NULL AUTO_INCREMENT,
  `email` VARCHAR(255) NOT NULL UNIQUE,
  `password_hash` VARCHAR(255) NOT NULL,
  `created_at` TIMESTAMP NOT NULL DEFAULT CURRENT_TIMESTAMP,
  `updated_at` TIMESTAMP NOT NULL DEFAULT CURRENT_TIMESTAMP ON UPDATE CURRENT_TIMESTAMP,
  PRIMARY KEY (`id`),
  UNIQUE KEY `unique_email` (`email`),
  INDEX `idx_created_at` (`created_at`)
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_unicode_ci COMMENT='Administrator login credentials';

-- ============================================================================
-- SUBMISSIONS TABLE
-- ============================================================================
-- Stores all form submissions from website users
CREATE TABLE IF NOT EXISTS `submissions` (
  `id` INT UNSIGNED NOT NULL AUTO_INCREMENT,
  `type` VARCHAR(50) NOT NULL COMMENT 'service, course, ai_tool, community, meetup, contact, turning_point',
  `origin_title` VARCHAR(255) NOT NULL COMMENT 'Title/name of the originating form/service',
  `name` VARCHAR(150) NOT NULL COMMENT 'Submitter full name',
  `email` VARCHAR(255) NOT NULL COMMENT 'Submitter email address',
  `phone` VARCHAR(25) NOT NULL COMMENT 'Submitter phone number',
  `message` TEXT NOT NULL COMMENT 'Detailed message from submitter',
  `stream` VARCHAR(255) NULL COMMENT 'Stream/Field (for community submissions)',
  `skills` TEXT NULL COMMENT 'Skills list (for community submissions)',
  `created_at` TIMESTAMP NOT NULL DEFAULT CURRENT_TIMESTAMP,
  PRIMARY KEY (`id`),
  INDEX `idx_type` (`type`),
  INDEX `idx_email` (`email`),
  INDEX `idx_created_at` (`created_at`),
  FULLTEXT `idx_search` (`name`, `email`, `message`)
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_unicode_ci COMMENT='User form submissions';

-- ============================================================================
-- INSERT DEFAULT ADMIN CREDENTIALS
-- (bcrypt hash with cost 10)
DELETE FROM `admins` WHERE `email` = 'team.raynklabs@gmail.com';

INSERT INTO `admins` (`email`, `password_hash`) VALUES (
    'team.raynklabs@gmail.com',
    '$2y$10$D4bod9hbldoD4socp/6kR.XYzXb52YcGBBHlJYrUtEQuunQU4Kx6O'
);

-- Optional: Confirm it worked
SELECT email, password_hash FROM admins WHERE email = 'team.raynklabs@gmail.com';

