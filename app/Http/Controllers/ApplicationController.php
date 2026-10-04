<?php

namespace App\Http\Controllers;

use App\Models\Internship;
use App\Models\InternshipApplication;
use App\Models\Notification;
use App\Models\User;
use Illuminate\Http\RedirectResponse;
use Illuminate\Http\Request;
use Illuminate\View\View;

class ApplicationController extends Controller
{
    /** Student: view own applications */
    public function index(Request $request): View
    {
        $applications = $request->user()->student
            ->applications()
            ->with('internship.employer')
            ->latest()
            ->paginate(10);

        return view('applications.index', compact('applications'));
    }

    /** Student: submit application to an internship */
    public function store(Request $request, Internship $internship): RedirectResponse
    {
        $student = $request->user()->student;

        if (! $student) {
            return back()->withErrors('Please complete your student profile before applying.');
        }

        if ($internship->status !== 'open' || $internship->approval_status !== 'approved') {
            return back()->withErrors('This internship is not currently accepting applications.');
        }

        if ($internship->isDeadlinePassed()) {
            return back()->withErrors('The application deadline for this internship has passed.');
        }

        $exists = InternshipApplication::where('internship_id', $internship->id)
            ->where('student_id', $student->id)
            ->exists();

        if ($exists) {
            return back()->withErrors('You have already applied to this internship.');
        }

        $validated = $request->validate([
            'cover_letter' => ['nullable', 'string', 'max:5000'],
            'resume' => ['nullable', 'file', 'mimes:pdf,doc,docx', 'max:5120'],
        ]);

        $resumePath = $request->hasFile('resume')
            ? $request->file('resume')->store('resumes', 'public')
            : $student->cv_path;

        $application = InternshipApplication::create([
            'internship_id' => $internship->id,
            'student_id' => $student->id,
            'cover_letter' => $validated['cover_letter'] ?? null,
            'resume_path' => $resumePath,
            'employer_status' => 'pending',
            'coordinator_status' => 'pending',
            'status' => 'pending',
            'applied_at' => now(),
        ]);

        Notification::notify(
            $internship->employer->user_id,
            'New Applicant',
            "{$request->user()->name} applied for \"{$internship->title}\".",
            'application'
        );

        return redirect()->route('applications.index')->with('status', 'Application submitted successfully.');
    }

    public function withdraw(InternshipApplication $application): RedirectResponse
    {
        if ($application->student_id !== auth()->user()->student?->id) {
            abort(403);
        }

        if (in_array($application->status, ['approved', 'completed'])) {
            return back()->withErrors('You cannot withdraw an already approved/completed internship.');
        }

        $application->update(['status' => 'withdrawn']);

        return back()->with('status', 'Application withdrawn.');
    }

    /** Employer: view applicants for a specific internship */
    public function forInternship(Internship $internship): View
    {
        if ($internship->employer_id !== auth()->user()->employer?->id) {
            abort(403);
        }

        $applications = $internship->applications()->with('student.user')->latest()->paginate(10);

        return view('applications.employer-review', compact('internship', 'applications'));
    }

    /** Employer: accept / reject / shortlist an applicant */
    public function decide(Request $request, InternshipApplication $application): RedirectResponse
    {
        if ($application->internship->employer_id !== auth()->user()->employer?->id) {
            abort(403);
        }

        $validated = $request->validate([
            'employer_status' => ['required', 'in:shortlisted,accepted,rejected'],
            'employer_feedback' => ['nullable', 'string', 'max:2000'],
        ]);

        $application->update($validated);
        $application->recomputeStatus();

        Notification::notify(
            $application->student->user_id,
            'Application Update',
            "Your application for \"{$application->internship->title}\" was marked as {$validated['employer_status']} by the employer.",
            'application'
        );

        // If employer accepted, notify coordinators that final university approval is needed
        if ($validated['employer_status'] === 'accepted') {
            User::where('role', 'coordinator')->pluck('id')->each(function ($id) use ($application) {
                Notification::notify(
                    $id,
                    'Application Awaiting Coordinator Approval',
                    "{$application->student->user->name} was accepted by an employer for \"{$application->internship->title}\" and needs final approval.",
                    'application',
                    route('coordinator.applications.pending')
                );
            });
        }

        return back()->with('status', 'Applicant status updated.');
    }
}
