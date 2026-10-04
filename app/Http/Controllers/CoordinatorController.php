<?php

namespace App\Http\Controllers;

use App\Models\Internship;
use App\Models\InternshipApplication;
use App\Models\Notification;
use App\Models\Report;
use App\Models\Student;
use Illuminate\Http\RedirectResponse;
use Illuminate\Http\Request;
use Illuminate\View\View;

class CoordinatorController extends Controller
{
    /** Pending internship postings requiring university approval */
    public function pendingInternships(): View
    {
        $internships = Internship::where('approval_status', 'pending')
            ->with('employer')
            ->latest()
            ->paginate(10);

        return view('coordinator.pending-internships', compact('internships'));
    }

    public function decideInternship(Request $request, Internship $internship): RedirectResponse
    {
        $validated = $request->validate([
            'approval_status' => ['required', 'in:approved,rejected'],
            'coordinator_remarks' => ['nullable', 'string', 'max:2000'],
        ]);

        $internship->update([
            'approval_status' => $validated['approval_status'],
            'coordinator_remarks' => $validated['coordinator_remarks'] ?? null,
            'reviewed_by' => $request->user()->id,
        ]);

        Notification::notify(
            $internship->employer->user_id,
            'Internship Posting Reviewed',
            "Your posting \"{$internship->title}\" was {$validated['approval_status']} by the university coordinator.",
            'internship'
        );

        return back()->with('status', 'Internship posting reviewed.');
    }

    /** Pending student applications requiring final coordinator approval */
    public function pendingApplications(): View
    {
        $applications = InternshipApplication::where('coordinator_status', 'pending')
            ->with(['student.user', 'internship.employer'])
            ->latest()
            ->paginate(10);

        return view('coordinator.pending-applications', compact('applications'));
    }

    public function decideApplication(Request $request, InternshipApplication $application): RedirectResponse
    {
        $validated = $request->validate([
            'coordinator_status' => ['required', 'in:approved,rejected'],
            'coordinator_remarks' => ['nullable', 'string', 'max:2000'],
        ]);

        $application->update([
            'coordinator_status' => $validated['coordinator_status'],
            'coordinator_remarks' => $validated['coordinator_remarks'] ?? null,
            'reviewed_by' => $request->user()->id,
            'reviewed_at' => now(),
        ]);

        $application->recomputeStatus();

        // Auto-assign coordinator to student for progress monitoring
        if ($validated['coordinator_status'] === 'approved') {
            $application->student->update(['assigned_coordinator_id' => $request->user()->id]);
        }

        Notification::notify(
            $application->student->user_id,
            'Application Decision',
            "Your placement for \"{$application->internship->title}\" was {$validated['coordinator_status']} by the coordinator.",
            'application'
        );

        return back()->with('status', 'Application reviewed.');
    }

    /** Monitor progress of all active students under this coordinator's oversight */
    public function progress(Request $request): View
    {
        $students = Student::whereHas('applications', fn ($q) => $q->where('status', 'approved'))
            ->with(['user', 'applications' => fn ($q) => $q->where('status', 'approved')->with('internship.employer'), 'reports'])
            ->paginate(12);

        return view('coordinator.progress', compact('students'));
    }

    public function studentProgress(Student $student): View
    {
        $student->load(['user', 'applications.internship.employer', 'reports' => fn ($q) => $q->latest()]);
        return view('coordinator.student-progress', compact('student'));
    }

    /** Manage submitted reports: list + review */
    public function reports(Request $request): View
    {
        $query = Report::with(['student.user', 'application.internship']);

        if ($request->filled('status')) {
            $query->where('status', $request->status);
        }

        $reports = $query->latest()->paginate(10)->withQueryString();

        return view('coordinator.reports', compact('reports'));
    }

    public function reviewReport(Request $request, Report $report): RedirectResponse
    {
        $validated = $request->validate([
            'status' => ['required', 'in:approved,rejected,needs_revision'],
            'coordinator_feedback' => ['nullable', 'string', 'max:2000'],
        ]);

        $report->update([
            'status' => $validated['status'],
            'coordinator_feedback' => $validated['coordinator_feedback'] ?? null,
            'reviewed_by' => $request->user()->id,
            'reviewed_at' => now(),
        ]);

        Notification::notify(
            $report->student->user_id,
            'Report Reviewed',
            "Your \"{$report->title}\" report was marked as {$validated['status']}.",
            'report'
        );

        return back()->with('status', 'Report reviewed.');
    }
}
