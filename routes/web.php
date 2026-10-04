<?php

use App\Http\Controllers\Auth\AuthenticatedSessionController;
use App\Http\Controllers\Auth\RegisteredUserController;
use App\Http\Controllers\AdminController;
use App\Http\Controllers\ApplicationController;
use App\Http\Controllers\CoordinatorController;
use App\Http\Controllers\DashboardController;
use App\Http\Controllers\EmployerProfileController;
use App\Http\Controllers\InternshipController;
use App\Http\Controllers\NotificationController;
use App\Http\Controllers\ReportController;
use App\Http\Controllers\StudentProfileController;
use Illuminate\Support\Facades\Artisan;
use Illuminate\Support\Facades\Route;

/*
|--------------------------------------------------------------------------
| Public routes
|--------------------------------------------------------------------------
*/
Route::get('/', function () {
    return view('welcome');
})->name('home');

Route::get('/run-migrations', function () {
    try {
        Artisan::call('migrate', ['--force' => true]);
        $output = Artisan::output();
        return response("<pre style='padding:20px;background:#1e1e1e;color:#00ff88;font-family:monospace;border-radius:8px;'>Migrations ran successfully!\n\n" . htmlspecialchars($output) . "</pre>");
    } catch (\Throwable $e) {
        return response("<pre style='padding:20px;background:#1e1e1e;color:#ff5555;font-family:monospace;border-radius:8px;'>Migration Error:\n\n" . htmlspecialchars($e->getMessage()) . "</pre>", 500);
    }
});

Route::get('/run-seeders', function () {
    try {
        Artisan::call('db:seed', ['--force' => true]);
        $output = Artisan::output();
        return response("<pre style='padding:20px;background:#1e1e1e;color:#00ff88;font-family:monospace;border-radius:8px;'>Seeders ran successfully!\n\n" . htmlspecialchars($output) . "</pre>");
    } catch (\Throwable $e) {
        return response("<pre style='padding:20px;background:#1e1e1e;color:#ff5555;font-family:monospace;border-radius:8px;'>Seeder Error:\n\n" . htmlspecialchars($e->getMessage()) . "</pre>", 500);
    }
});

Route::middleware('guest')->group(function () {
    Route::get('register', [RegisteredUserController::class, 'create'])->name('register');
    Route::post('register', [RegisteredUserController::class, 'store']);
    Route::get('login', [AuthenticatedSessionController::class, 'create'])->name('login');
    Route::post('login', [AuthenticatedSessionController::class, 'store']);
});

Route::middleware('auth')->group(function () {
    Route::post('logout', [AuthenticatedSessionController::class, 'destroy'])->name('logout');

    Route::get('dashboard', [DashboardController::class, 'index'])->name('dashboard');

    // Notifications - all roles
    Route::get('notifications', [NotificationController::class, 'index'])->name('notifications.index');
    Route::patch('notifications/{notification}/read', [NotificationController::class, 'markRead'])->name('notifications.read');
    Route::patch('notifications/read-all', [NotificationController::class, 'markAllRead'])->name('notifications.read-all');

    // Browsing internships is open to any authenticated user (mainly students)
    Route::get('internships', [InternshipController::class, 'index'])->name('internships.index');
    Route::get('internships/{internship}', [InternshipController::class, 'show'])->name('internships.show');

    /*
    |----------------------------------------------------------------
    | Student
    |----------------------------------------------------------------
    */
    Route::middleware('role:student')->group(function () {
        Route::get('profile', [StudentProfileController::class, 'edit'])->name('student.profile.edit');
        Route::put('profile', [StudentProfileController::class, 'update'])->name('student.profile.update');

        Route::post('internships/{internship}/apply', [ApplicationController::class, 'store'])->name('applications.store');
        Route::get('my-applications', [ApplicationController::class, 'index'])->name('applications.index');
        Route::patch('applications/{application}/withdraw', [ApplicationController::class, 'withdraw'])->name('applications.withdraw');

        Route::get('my-reports', [ReportController::class, 'index'])->name('reports.index');
        Route::get('my-reports/create', [ReportController::class, 'create'])->name('reports.create');
        Route::post('my-reports', [ReportController::class, 'store'])->name('reports.store');
    });

    // Report viewing shared between student/coordinator/admin (authorization inside controller)
    Route::get('reports/{report}', [ReportController::class, 'show'])->name('reports.show')->middleware('role:student,coordinator,admin');

    /*
    |----------------------------------------------------------------
    | Employer
    |----------------------------------------------------------------
    */
    Route::middleware('role:employer')->prefix('employer')->name('employer.')->group(function () {
        Route::get('profile', [EmployerProfileController::class, 'edit'])->name('profile.edit');
        Route::put('profile', [EmployerProfileController::class, 'update'])->name('profile.update');
    });

    Route::middleware('role:employer')->group(function () {
        Route::get('my-internships', [InternshipController::class, 'manage'])->name('internships.manage');
        Route::get('my-internships/create', [InternshipController::class, 'create'])->name('internships.create');
        Route::post('my-internships', [InternshipController::class, 'store'])->name('internships.store');
        Route::get('my-internships/{internship}/edit', [InternshipController::class, 'edit'])->name('internships.edit');
        Route::put('my-internships/{internship}', [InternshipController::class, 'update'])->name('internships.update');
        Route::delete('my-internships/{internship}', [InternshipController::class, 'destroy'])->name('internships.destroy');

        Route::get('my-internships/{internship}/applicants', [ApplicationController::class, 'forInternship'])->name('applications.for-internship');
        Route::patch('applications/{application}/decide', [ApplicationController::class, 'decide'])->name('applications.decide');
    });

    /*
    |----------------------------------------------------------------
    | Internship Coordinator
    |----------------------------------------------------------------
    */
    Route::middleware('role:coordinator')->prefix('coordinator')->name('coordinator.')->group(function () {
        Route::get('internships/pending', [CoordinatorController::class, 'pendingInternships'])->name('internships.pending');
        Route::patch('internships/{internship}/decide', [CoordinatorController::class, 'decideInternship'])->name('internships.decide');

        Route::get('applications/pending', [CoordinatorController::class, 'pendingApplications'])->name('applications.pending');
        Route::patch('applications/{application}/decide', [CoordinatorController::class, 'decideApplication'])->name('applications.decide');

        Route::get('progress', [CoordinatorController::class, 'progress'])->name('progress');
        Route::get('progress/{student}', [CoordinatorController::class, 'studentProgress'])->name('progress.show');

        Route::get('reports', [CoordinatorController::class, 'reports'])->name('reports.index');
        Route::patch('reports/{report}/review', [CoordinatorController::class, 'reviewReport'])->name('reports.review');
    });

    /*
    |----------------------------------------------------------------
    | Administrator
    |----------------------------------------------------------------
    */
    Route::middleware('role:admin')->prefix('admin')->name('admin.')->group(function () {
        Route::get('users', [AdminController::class, 'users'])->name('users');
        Route::get('users/create', [AdminController::class, 'createUser'])->name('users.create');
        Route::post('users', [AdminController::class, 'storeUser'])->name('users.store');
        Route::patch('users/{user}/toggle', [AdminController::class, 'toggleUserStatus'])->name('users.toggle');
        Route::delete('users/{user}', [AdminController::class, 'deleteUser'])->name('users.delete');

        Route::get('internships', [AdminController::class, 'internships'])->name('internships');
        Route::delete('internships/{internship}', [AdminController::class, 'deleteInternship'])->name('internships.delete');

        Route::get('reports', [AdminController::class, 'reports'])->name('reports');

        Route::get('settings', [AdminController::class, 'settings'])->name('settings');
        Route::put('settings', [AdminController::class, 'updateSettings'])->name('settings.update');
    });
});
