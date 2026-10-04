<?php

namespace App\Http\Controllers;

use App\Models\Internship;
use App\Models\InternshipApplication;
use App\Models\Report;
use App\Models\User;
use Illuminate\Http\Request;
use Illuminate\View\View;

class DashboardController extends Controller
{
    public function index(Request $request): View
    {
        $user = $request->user();

        return match ($user->role) {
            'student' => $this->studentDashboard($user),
            'employer' => $this->employerDashboard($user),
            'coordinator' => $this->coordinatorDashboard($user),
            'admin' => $this->adminDashboard($user),
            default => abort(403),
        };
    }

    private function studentDashboard(User $user): View
    {
        $student = $user->student;

        $applications = $student
            ? $student->applications()->with('internship.employer')->latest()->get()
            : collect();

        $reports = $student
            ? $student->reports()->with('application.internship')->latest()->get()
            : collect();

        $activeApplication = $applications->firstWhere('status', 'approved');

        $stats = [
            'total_applications' => $applications->count(),
            'pending_applications' => $applications->where('status', 'pending')->count(),
            'approved_applications' => $applications->where('status', 'approved')->count(),
            'reports_submitted' => $reports->count(),
            'reports_pending' => $reports->where('status', 'pending')->count(),
        ];

        return view('dashboards.student', compact('student', 'applications', 'reports', 'activeApplication', 'stats'));
    }

    private function employerDashboard(User $user): View
    {
        $employer = $user->employer;

        $internships = $employer
            ? $employer->internships()->withCount('applications')->latest()->get()
            : collect();

        $recentApplications = $employer
            ? InternshipApplication::whereIn('internship_id', $internships->pluck('id'))
                ->with(['student.user', 'internship'])
                ->latest()
                ->take(10)
                ->get()
            : collect();

        $stats = [
            'total_postings' => $internships->count(),
            'open_postings' => $internships->where('status', 'open')->count(),
            'pending_approval' => $internships->where('approval_status', 'pending')->count(),
            'total_applicants' => $internships->sum('applications_count'),
        ];

        return view('dashboards.employer', compact('employer', 'internships', 'recentApplications', 'stats'));
    }

    private function coordinatorDashboard(User $user): View
    {
        $pendingApplications = InternshipApplication::where('coordinator_status', 'pending')
            ->with(['student.user', 'internship.employer'])
            ->latest()
            ->take(10)
            ->get();

        $pendingInternships = Internship::where('approval_status', 'pending')
            ->with('employer')
            ->latest()
            ->take(10)
            ->get();

        $pendingReports = Report::where('status', 'pending')
            ->with(['student.user', 'application.internship'])
            ->latest()
            ->take(10)
            ->get();

        $stats = [
            'pending_applications' => InternshipApplication::where('coordinator_status', 'pending')->count(),
            'pending_internships' => Internship::where('approval_status', 'pending')->count(),
            'pending_reports' => Report::where('status', 'pending')->count(),
            'active_students' => InternshipApplication::where('status', 'approved')->distinct('student_id')->count('student_id'),
        ];

        return view('dashboards.coordinator', compact('pendingApplications', 'pendingInternships', 'pendingReports', 'stats'));
    }

    private function adminDashboard(User $user): View
    {
        $stats = [
            'total_users' => User::count(),
            'total_students' => User::where('role', 'student')->count(),
            'total_employers' => User::where('role', 'employer')->count(),
            'total_coordinators' => User::where('role', 'coordinator')->count(),
            'total_internships' => Internship::count(),
            'open_internships' => Internship::where('status', 'open')->count(),
            'total_applications' => InternshipApplication::count(),
            'approved_applications' => InternshipApplication::where('status', 'approved')->count(),
            'total_reports' => Report::count(),
        ];

        $recentUsers = User::latest()->take(8)->get();

        return view('dashboards.admin', compact('stats', 'recentUsers'));
    }
}
