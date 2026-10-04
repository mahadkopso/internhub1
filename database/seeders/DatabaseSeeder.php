<?php

namespace Database\Seeders;

use App\Models\Employer;
use App\Models\Internship;
use App\Models\Student;
use App\Models\User;
use Illuminate\Database\Seeder;
use Illuminate\Support\Facades\Hash;

class DatabaseSeeder extends Seeder
{
    /**
     * Seed demo accounts for every role so the system can be
     * evaluated immediately after installation.
     */
    public function run(): void
    {
        // Administrator
        $admin = User::create([
            'name' => 'System Administrator',
            'email' => 'admin@internhub.test',
            'password' => Hash::make('password'),
            'role' => 'admin',
        ]);

        // Internship Coordinator
        $coordinator = User::create([
            'name' => 'Dr. Amina Yusuf',
            'email' => 'coordinator@internhub.test',
            'password' => Hash::make('password'),
            'role' => 'coordinator',
        ]);

        // Employer
        $employerUser = User::create([
            'name' => 'Jordan Lee',
            'email' => 'employer@internhub.test',
            'password' => Hash::make('password'),
            'role' => 'employer',
        ]);

        $employer = Employer::create([
            'user_id' => $employerUser->id,
            'company_name' => 'BrightPath Technologies',
            'industry' => 'Information Technology',
            'company_description' => 'A software company building tools for education and workforce development.',
            'website' => 'https://brightpath.example.com',
            'company_address' => '123 Innovation Way, Tech City',
            'is_verified' => true,
        ]);

        // Student
        $studentUser = User::create([
            'name' => 'Sara Ahmed',
            'email' => 'student@internhub.test',
            'password' => Hash::make('password'),
            'role' => 'student',
        ]);

        Student::create([
            'user_id' => $studentUser->id,
            'student_id_number' => 'STU-000001',
            'university' => 'Sample University',
            'faculty' => 'Faculty of Computing',
            'department' => 'Computer Science',
            'program' => 'BSc Computer Science',
            'year_of_study' => 3,
            'gpa' => 3.6,
            'bio' => 'Aspiring software engineer passionate about web development.',
            'skills' => 'PHP, Laravel, JavaScript, MySQL',
            'assigned_coordinator_id' => $coordinator->id,
        ]);

        // Sample internship posting
        Internship::create([
            'employer_id' => $employer->id,
            'title' => 'Software Engineering Intern',
            'description' => 'Work with our engineering team to build and maintain internal web applications using Laravel and Bootstrap.',
            'requirements' => 'Currently enrolled in a Computer Science or related program. Basic knowledge of PHP and databases.',
            'location' => 'Tech City',
            'work_mode' => 'hybrid',
            'duration' => '3 months',
            'start_date' => now()->addMonth(),
            'application_deadline' => now()->addWeeks(3),
            'slots_available' => 2,
            'is_paid' => true,
            'stipend' => 300,
            'status' => 'open',
            'approval_status' => 'approved',
            'reviewed_by' => $coordinator->id,
        ]);
    }
}
