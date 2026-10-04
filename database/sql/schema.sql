-- InternHub Database Schema (MySQL 8)
-- This mirrors the Laravel migrations and is provided for reference / manual setup.

CREATE DATABASE IF NOT EXISTS internhub CHARACTER SET utf8mb4 COLLATE utf8mb4_unicode_ci;
USE internhub;

CREATE TABLE users (
    id BIGINT UNSIGNED AUTO_INCREMENT PRIMARY KEY,
    name VARCHAR(255) NOT NULL,
    email VARCHAR(255) NOT NULL UNIQUE,
    email_verified_at TIMESTAMP NULL,
    password VARCHAR(255) NOT NULL,
    role ENUM('student','employer','coordinator','admin') NOT NULL DEFAULT 'student',
    phone VARCHAR(30) NULL,
    is_active TINYINT(1) NOT NULL DEFAULT 1,
    remember_token VARCHAR(100) NULL,
    created_at TIMESTAMP NULL,
    updated_at TIMESTAMP NULL
) ENGINE=InnoDB;

CREATE TABLE students (
    id BIGINT UNSIGNED AUTO_INCREMENT PRIMARY KEY,
    user_id BIGINT UNSIGNED NOT NULL,
    student_id_number VARCHAR(50) NOT NULL UNIQUE,
    university VARCHAR(255) NOT NULL DEFAULT 'University',
    faculty VARCHAR(255) NULL,
    department VARCHAR(255) NULL,
    program VARCHAR(255) NULL,
    year_of_study TINYINT UNSIGNED NULL,
    gpa DECIMAL(3,2) NULL,
    bio TEXT NULL,
    skills VARCHAR(1000) NULL,
    cv_path VARCHAR(255) NULL,
    profile_photo_path VARCHAR(255) NULL,
    linkedin_url VARCHAR(255) NULL,
    assigned_coordinator_id BIGINT UNSIGNED NULL,
    created_at TIMESTAMP NULL,
    updated_at TIMESTAMP NULL,
    FOREIGN KEY (user_id) REFERENCES users(id) ON DELETE CASCADE,
    FOREIGN KEY (assigned_coordinator_id) REFERENCES users(id) ON DELETE SET NULL
) ENGINE=InnoDB;

CREATE TABLE employers (
    id BIGINT UNSIGNED AUTO_INCREMENT PRIMARY KEY,
    user_id BIGINT UNSIGNED NOT NULL,
    company_name VARCHAR(255) NOT NULL,
    industry VARCHAR(255) NULL,
    company_description TEXT NULL,
    website VARCHAR(255) NULL,
    company_address VARCHAR(500) NULL,
    logo_path VARCHAR(255) NULL,
    contact_person VARCHAR(255) NULL,
    is_verified TINYINT(1) NOT NULL DEFAULT 0,
    created_at TIMESTAMP NULL,
    updated_at TIMESTAMP NULL,
    FOREIGN KEY (user_id) REFERENCES users(id) ON DELETE CASCADE
) ENGINE=InnoDB;

CREATE TABLE internships (
    id BIGINT UNSIGNED AUTO_INCREMENT PRIMARY KEY,
    employer_id BIGINT UNSIGNED NOT NULL,
    title VARCHAR(255) NOT NULL,
    description TEXT NOT NULL,
    requirements TEXT NULL,
    location VARCHAR(255) NULL,
    work_mode ENUM('onsite','remote','hybrid') NOT NULL DEFAULT 'onsite',
    duration VARCHAR(100) NULL,
    start_date DATE NULL,
    application_deadline DATE NULL,
    slots_available INT UNSIGNED NOT NULL DEFAULT 1,
    is_paid TINYINT(1) NOT NULL DEFAULT 0,
    stipend DECIMAL(10,2) NULL,
    status ENUM('open','closed') NOT NULL DEFAULT 'open',
    approval_status ENUM('pending','approved','rejected') NOT NULL DEFAULT 'pending',
    reviewed_by BIGINT UNSIGNED NULL,
    coordinator_remarks TEXT NULL,
    created_at TIMESTAMP NULL,
    updated_at TIMESTAMP NULL,
    FOREIGN KEY (employer_id) REFERENCES employers(id) ON DELETE CASCADE,
    FOREIGN KEY (reviewed_by) REFERENCES users(id) ON DELETE SET NULL
) ENGINE=InnoDB;

CREATE TABLE internship_applications (
    id BIGINT UNSIGNED AUTO_INCREMENT PRIMARY KEY,
    internship_id BIGINT UNSIGNED NOT NULL,
    student_id BIGINT UNSIGNED NOT NULL,
    cover_letter TEXT NULL,
    resume_path VARCHAR(255) NULL,
    employer_status ENUM('pending','shortlisted','accepted','rejected') NOT NULL DEFAULT 'pending',
    employer_feedback TEXT NULL,
    coordinator_status ENUM('pending','approved','rejected') NOT NULL DEFAULT 'pending',
    coordinator_remarks TEXT NULL,
    reviewed_by BIGINT UNSIGNED NULL,
    reviewed_at TIMESTAMP NULL,
    status ENUM('pending','under_review','approved','rejected','withdrawn','completed') NOT NULL DEFAULT 'pending',
    applied_at TIMESTAMP NOT NULL DEFAULT CURRENT_TIMESTAMP,
    created_at TIMESTAMP NULL,
    updated_at TIMESTAMP NULL,
    UNIQUE KEY uniq_internship_student (internship_id, student_id),
    FOREIGN KEY (internship_id) REFERENCES internships(id) ON DELETE CASCADE,
    FOREIGN KEY (student_id) REFERENCES students(id) ON DELETE CASCADE,
    FOREIGN KEY (reviewed_by) REFERENCES users(id) ON DELETE SET NULL
) ENGINE=InnoDB;

CREATE TABLE reports (
    id BIGINT UNSIGNED AUTO_INCREMENT PRIMARY KEY,
    application_id BIGINT UNSIGNED NOT NULL,
    student_id BIGINT UNSIGNED NOT NULL,
    title VARCHAR(255) NOT NULL,
    report_type ENUM('weekly','monthly','midterm','final') NOT NULL DEFAULT 'weekly',
    week_number INT UNSIGNED NULL,
    description TEXT NULL,
    file_path VARCHAR(255) NOT NULL,
    submission_date DATE NOT NULL DEFAULT (CURRENT_DATE),
    status ENUM('pending','approved','rejected','needs_revision') NOT NULL DEFAULT 'pending',
    coordinator_feedback TEXT NULL,
    reviewed_by BIGINT UNSIGNED NULL,
    reviewed_at TIMESTAMP NULL,
    created_at TIMESTAMP NULL,
    updated_at TIMESTAMP NULL,
    FOREIGN KEY (application_id) REFERENCES internship_applications(id) ON DELETE CASCADE,
    FOREIGN KEY (student_id) REFERENCES students(id) ON DELETE CASCADE,
    FOREIGN KEY (reviewed_by) REFERENCES users(id) ON DELETE SET NULL
) ENGINE=InnoDB;

CREATE TABLE notifications (
    id BIGINT UNSIGNED AUTO_INCREMENT PRIMARY KEY,
    user_id BIGINT UNSIGNED NOT NULL,
    title VARCHAR(255) NOT NULL,
    message TEXT NOT NULL,
    type VARCHAR(50) NOT NULL DEFAULT 'general',
    link VARCHAR(255) NULL,
    is_read TINYINT(1) NOT NULL DEFAULT 0,
    created_at TIMESTAMP NULL,
    updated_at TIMESTAMP NULL,
    FOREIGN KEY (user_id) REFERENCES users(id) ON DELETE CASCADE
) ENGINE=InnoDB;

CREATE TABLE settings (
    id BIGINT UNSIGNED AUTO_INCREMENT PRIMARY KEY,
    `key` VARCHAR(255) NOT NULL UNIQUE,
    value TEXT NULL,
    created_at TIMESTAMP NULL,
    updated_at TIMESTAMP NULL
) ENGINE=InnoDB;

-- Default system settings
INSERT INTO settings (`key`, value, created_at, updated_at) VALUES
('app_name', 'InternHub', NOW(), NOW()),
('university_name', 'Sample University', NOW(), NOW()),
('application_deadline_reminder_days', '3', NOW(), NOW()),
('require_coordinator_internship_approval', '1', NOW(), NOW()),
('require_coordinator_application_approval', '1', NOW(), NOW()),
('max_report_file_size_mb', '10', NOW(), NOW());
