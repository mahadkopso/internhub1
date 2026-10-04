<?php

namespace App\Http\Controllers;

use App\Models\InternshipApplication;
use App\Models\Notification;
use App\Models\Report;
use Illuminate\Http\RedirectResponse;
use Illuminate\Http\Request;
use Illuminate\View\View;

class ReportController extends Controller
{
    /** Student: list own reports */
    public function index(Request $request): View
    {
        $reports = $request->user()->student
            ->reports()
            ->with('application.internship')
            ->latest()
            ->paginate(10);

        $activeApplications = $request->user()->student
            ->applications()
            ->where('status', 'approved')
            ->with('internship')
            ->get();

        return view('reports.index', compact('reports', 'activeApplications'));
    }

    public function create(Request $request): View
    {
        $activeApplications = $request->user()->student
            ->applications()
            ->where('status', 'approved')
            ->with('internship')
            ->get();

        return view('reports.create', compact('activeApplications'));
    }

    public function store(Request $request): RedirectResponse
    {
        $student = $request->user()->student;

        $validated = $request->validate([
            'application_id' => ['required', 'exists:internship_applications,id'],
            'title' => ['required', 'string', 'max:255'],
            'report_type' => ['required', 'in:weekly,monthly,midterm,final'],
            'week_number' => ['nullable', 'integer', 'min:1'],
            'description' => ['nullable', 'string', 'max:3000'],
            'file' => ['required', 'file', 'mimes:pdf,doc,docx', 'max:10240'],
        ]);

        $application = InternshipApplication::where('id', $validated['application_id'])
            ->where('student_id', $student->id)
            ->where('status', 'approved')
            ->firstOrFail();

        $filePath = $request->file('file')->store('reports', 'public');

        $report = Report::create([
            'application_id' => $application->id,
            'student_id' => $student->id,
            'title' => $validated['title'],
            'report_type' => $validated['report_type'],
            'week_number' => $validated['week_number'] ?? null,
            'description' => $validated['description'] ?? null,
            'file_path' => $filePath,
            'submission_date' => now(),
            'status' => 'pending',
        ]);

        // Notify the assigned coordinator (or all coordinators if none assigned)
        $coordinatorId = $student->assigned_coordinator_id;
        if ($coordinatorId) {
            Notification::notify($coordinatorId, 'New Report Submitted', "{$request->user()->name} submitted a {$report->report_type} report for review.", 'report');
        } else {
            \App\Models\User::where('role', 'coordinator')->pluck('id')->each(function ($id) use ($request, $report) {
                Notification::notify($id, 'New Report Submitted', "{$request->user()->name} submitted a {$report->report_type} report for review.", 'report');
            });
        }

        return redirect()->route('reports.index')->with('status', 'Report uploaded successfully.');
    }

    public function show(Report $report): View
    {
        if ($report->student_id !== auth()->user()->student?->id && ! in_array(auth()->user()->role, ['coordinator', 'admin'])) {
            abort(403);
        }
        return view('reports.show', compact('report'));
    }
}
