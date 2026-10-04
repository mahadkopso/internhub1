# InternHub — Student Internship Management System

A full-stack university internship management platform inspired by Handshake's UX,
built specifically for **university internship programs**, using:

- **Frontend:** HTML5, CSS3, Bootstrap 5.3
- **Backend:** PHP 8.2, Laravel 12 (MVC)
- **Database:** MySQL 8

This package contains the application-specific source code (Models, Controllers,
Migrations, Routes, Blade views, custom CSS). It is meant to be dropped into a
fresh Laravel 12 skeleton, because the Laravel framework itself (vendor/ files)
must be installed via Composer with internet access.

---

## 1. What differentiates InternHub from Handshake

| Feature | Handshake | InternHub |
|---|---|---|
| Internship report submission | ❌ Not supported | ✅ Weekly/monthly/midterm/final reports with file upload |
| Coordinator approval workflow | ❌ No academic gatekeeping | ✅ Postings **and** placements require university coordinator approval |
| Student progress monitoring | ❌ Not designed for this | ✅ Dedicated coordinator dashboard tracking active placements & reports |
| University-based management | Generic multi-university job board | Purpose-built around one university's internship program, departments, and academic oversight |

---

## 2. Project Structure (what's included here)

```
app/
  Models/                 User, Student, Employer, Internship, InternshipApplication, Report, Notification, Setting
  Http/Controllers/       Auth/, Dashboard, Student/Employer profile, Internship, Application, Report,
                          Coordinator, Admin, Notification controllers
  Http/Middleware/        EnsureUserHasRole.php (role-based access control)
  Providers/AppServiceProvider.php
bootstrap/app.php         Registers the `role` middleware alias + routing
database/
  migrations/             users, students, employers, internships, internship_applications, reports, notifications, settings
  seeders/DatabaseSeeder.php   Demo accounts for all 4 roles + sample internship
  sql/schema.sql          Plain SQL schema (for reference / manual DB setup)
resources/views/          Blade templates for every role & workflow (see below)
routes/web.php            All application routes, grouped & protected by role
public/css/app.css        Custom Bootstrap theme (navy/orange academic branding)
composer.json / .env.example
```

### Views included
- `layouts/app.blade.php`, `layouts/guest.blade.php` — shared navigation & shell
- `welcome.blade.php` — marketing/landing page
- `auth/login.blade.php`, `auth/register.blade.php` (student/employer self sign-up toggle)
- `dashboards/{student,employer,coordinator,admin}.blade.php`
- `internships/{index,show,create,edit,manage,_form}.blade.php`
- `applications/{index,employer-review}.blade.php`
- `reports/{index,create,show}.blade.php`
- `students/profile.blade.php`, `employers/profile.blade.php`
- `coordinator/{pending-internships,pending-applications,progress,student-progress,reports}.blade.php`
- `admin/{users,user-create,internships,reports,settings}.blade.php`
- `notifications/index.blade.php`
- `components/stat-card.blade.php`, `components/status-badge.blade.php`

---

## 3. Setup Instructions

### Step 1 — Create a fresh Laravel project
```bash
composer create-project laravel/laravel internhub
cd internhub
```

### Step 2 — Copy this package's files into it
Copy (overwrite) the following folders/files from this delivery into your new
`internhub/` project, preserving paths:
```
app/Models/*
app/Http/Controllers/*
app/Http/Middleware/*
app/Providers/AppServiceProvider.php
bootstrap/app.php
database/migrations/*
database/seeders/DatabaseSeeder.php
resources/views/*
routes/web.php
routes/console.php
public/css/app.css
.env.example  (merge DB_* values into your own .env)
```

### Step 3 — Configure your database
Create a MySQL 8 database and update `.env`:
```
DB_CONNECTION=mysql
DB_HOST=127.0.0.1
DB_PORT=3306
DB_DATABASE=internhub
DB_USERNAME=root
DB_PASSWORD=your_password
```

### Step 4 — Install dependencies & generate app key
```bash
composer install
php artisan key:generate
```

### Step 5 — Run migrations & seed demo data
```bash
php artisan migrate
php artisan db:seed
```

### Step 6 — Link storage (for CVs, resumes, reports, logos)
```bash
php artisan storage:link
```

### Step 7 — Serve the application
```bash
php artisan serve
```
Visit `http://localhost:8000`.

### Demo accounts (password: `password` for all)
| Role | Email |
|---|---|
| Student | student@internhub.test |
| Employer | employer@internhub.test |
| Coordinator | coordinator@internhub.test |
| Administrator | admin@internhub.test |

---

## 4. Roles & Permissions

Access control is enforced by the `role` middleware
(`app/Http/Middleware/EnsureUserHasRole.php`), aliased in `bootstrap/app.php`
and applied per route group in `routes/web.php`:

```php
Route::middleware('role:coordinator')->group(function () { ... });
```

- **Student** — self-registers, manages profile, browses/apply for internships,
  views application status, uploads reports, receives notifications.
- **Employer** — self-registers, manages company profile, posts internships
  (pending coordinator approval), reviews & decides on applicants.
- **Internship Coordinator** — created by Admin only. Approves/rejects internship
  postings and student placements, monitors active students' progress, reviews
  submitted reports.
- **Administrator** — created via seeder or by another Admin. Manages all users
  (create/activate/deactivate/delete), views all internship records, generates
  system-wide analytics, configures system settings (approval requirements,
  file size limits, etc.).

## 5. Core Workflow (differentiator)

1. Employer posts an internship → **status: pending** until a Coordinator approves it.
2. Student applies to an approved internship.
3. Employer reviews and marks the applicant as shortlisted/accepted/rejected.
4. Once an employer **accepts** a student, the application still needs
   **Coordinator approval** before the placement is considered official —
   this is what authorizes academic credit and unlocks report submission.
5. Once approved, the student is automatically assigned to that Coordinator
   for progress monitoring, and can submit weekly/monthly/final reports.
6. The Coordinator reviews each report (approve / needs revision / reject)
   with written feedback, and tracks all active students from the
   **Progress Monitoring** dashboard.
7. Notifications are dispatched at every step (new applicant, decision made,
   report submitted, report reviewed, posting reviewed).

## 6. Security

- Passwords hashed via Laravel's `Hash::make()` (bcrypt).
- CSRF protection on all forms (`@csrf`).
- Server-side validation on every controller action (`$request->validate()`).
- Role-based route protection via middleware; ownership checks in controllers
  (e.g., an employer cannot view another employer's applicants).
- File uploads restricted by mime type and size (`mimes:pdf,doc,docx`, `max:`).
- Inactive user accounts are blocked at login and forcibly logged out.
