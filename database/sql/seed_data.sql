-- InternHub Demo Data (matches schema.sql)
-- Run this AFTER schema.sql has been imported successfully.
-- All demo accounts use the password: password

USE internhub;

-- 1) Users (password hash below = bcrypt hash of "password")
INSERT INTO users (id, name, email, password, role, phone, is_active, created_at, updated_at) VALUES
(1, 'System Administrator', 'admin@internhub.test', '$2y$10$92IXUNpkjO0rOQ5byMi.Ye4oKoEa3Ro9llC/.og/at2.uheWG/igi', 'admin', NULL, 1, NOW(), NOW()),
(2, 'Dr. Amina Yusuf', 'coordinator@internhub.test', '$2y$10$92IXUNpkjO0rOQ5byMi.Ye4oKoEa3Ro9llC/.og/at2.uheWG/igi', 'coordinator', NULL, 1, NOW(), NOW()),
(3, 'Jordan Lee', 'employer@internhub.test', '$2y$10$92IXUNpkjO0rOQ5byMi.Ye4oKoEa3Ro9llC/.og/at2.uheWG/igi', 'employer', NULL, 1, NOW(), NOW()),
(4, 'Sara Ahmed', 'student@internhub.test', '$2y$10$92IXUNpkjO0rOQ5byMi.Ye4oKoEa3Ro9llC/.og/at2.uheWG/igi', 'student', NULL, 1, NOW(), NOW());

-- 2) Employer profile (linked to user id 3)
INSERT INTO employers (id, user_id, company_name, industry, company_description, website, company_address, is_verified, created_at, updated_at) VALUES
(1, 3, 'BrightPath Technologies', 'Information Technology', 'A software company building tools for education and workforce development.', 'https://brightpath.example.com', '123 Innovation Way, Tech City', 1, NOW(), NOW());

-- 3) Student profile (linked to user id 4, assigned to coordinator id 2)
INSERT INTO students (id, user_id, student_id_number, university, faculty, department, program, year_of_study, gpa, bio, skills, assigned_coordinator_id, created_at, updated_at) VALUES
(1, 4, 'STU-000001', 'Sample University', 'Faculty of Computing', 'Computer Science', 'BSc Computer Science', 3, 3.6, 'Aspiring software engineer passionate about web development.', 'PHP, Laravel, JavaScript, MySQL', 2, NOW(), NOW());

-- 4) Sample internship posting (employer id 1, approved by coordinator id 2)
INSERT INTO internships (id, employer_id, title, description, requirements, location, work_mode, duration, start_date, application_deadline, slots_available, is_paid, stipend, status, approval_status, reviewed_by, created_at, updated_at) VALUES
(1, 1, 'Software Engineering Intern', 'Work with our engineering team to build and maintain internal web applications using Laravel and Bootstrap.', 'Currently enrolled in a Computer Science or related program. Basic knowledge of PHP and databases.', 'Tech City', 'hybrid', '3 months', DATE_ADD(CURDATE(), INTERVAL 30 DAY), DATE_ADD(CURDATE(), INTERVAL 21 DAY), 2, 1, 300.00, 'open', 'approved', 2, NOW(), NOW());
