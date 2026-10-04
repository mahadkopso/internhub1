<?php

namespace App\Http\Controllers;

use App\Models\Internship;
use App\Models\Notification;
use App\Models\User;
use Illuminate\Http\RedirectResponse;
use Illuminate\Http\Request;
use Illuminate\View\View;

class InternshipController extends Controller
{
    /** Browse internships (Student-facing) */
    public function index(Request $request): View
    {
        $query = Internship::openAndApproved()->with('employer');

        if ($request->filled('keyword')) {
            $keyword = $request->keyword;
            $query->where(function ($q) use ($keyword) {
                $q->where('title', 'like', "%{$keyword}%")
                  ->orWhere('description', 'like', "%{$keyword}%");
            });
        }

        if ($request->filled('location')) {
            $query->where('location', 'like', '%'.$request->location.'%');
        }

        if ($request->filled('work_mode')) {
            $query->where('work_mode', $request->work_mode);
        }

        if ($request->filled('paid')) {
            $query->where('is_paid', $request->paid === '1');
        }

        $internships = $query->latest()->paginate(9)->withQueryString();

        return view('internships.index', compact('internships'));
    }

    public function show(Internship $internship): View
    {
        $internship->load('employer');

        $alreadyApplied = false;
        if (auth()->check() && auth()->user()->isStudent() && auth()->user()->student) {
            $alreadyApplied = $internship->applications()
                ->where('student_id', auth()->user()->student->id)
                ->exists();
        }

        return view('internships.show', compact('internship', 'alreadyApplied'));
    }

    /** Employer: list own postings */
    public function manage(Request $request): View
    {
        $internships = $request->user()->employer
            ->internships()
            ->withCount('applications')
            ->latest()
            ->paginate(10);

        return view('internships.manage', compact('internships'));
    }

    public function create(): View
    {
        return view('internships.create');
    }

    public function store(Request $request): RedirectResponse
    {
        $validated = $request->validate([
            'title' => ['required', 'string', 'max:255'],
            'description' => ['required', 'string'],
            'requirements' => ['nullable', 'string'],
            'location' => ['nullable', 'string', 'max:255'],
            'work_mode' => ['required', 'in:onsite,remote,hybrid'],
            'duration' => ['nullable', 'string', 'max:100'],
            'start_date' => ['nullable', 'date'],
            'application_deadline' => ['nullable', 'date'],
            'slots_available' => ['required', 'integer', 'min:1'],
            'is_paid' => ['nullable', 'boolean'],
            'stipend' => ['nullable', 'numeric', 'min:0'],
        ]);

        $validated['is_paid'] = $request->boolean('is_paid');
        $validated['employer_id'] = $request->user()->employer->id;
        $validated['approval_status'] = 'pending';
        $validated['status'] = 'open';

        $internship = Internship::create($validated);

        // Notify coordinators for the university oversight/approval workflow
        User::where('role', 'coordinator')->pluck('id')->each(function ($id) use ($internship) {
            Notification::notify(
                $id,
                'New Internship Posting Pending Review',
                "\"{$internship->title}\" was submitted and needs your approval.",
                'internship',
                route('coordinator.internships.pending')
            );
        });

        return redirect()->route('internships.manage')
            ->with('status', 'Internship posted successfully and is pending coordinator approval.');
    }

    public function edit(Internship $internship): View
    {
        $this->authorizeOwnership($internship);
        return view('internships.edit', compact('internship'));
    }

    public function update(Request $request, Internship $internship): RedirectResponse
    {
        $this->authorizeOwnership($internship);

        $validated = $request->validate([
            'title' => ['required', 'string', 'max:255'],
            'description' => ['required', 'string'],
            'requirements' => ['nullable', 'string'],
            'location' => ['nullable', 'string', 'max:255'],
            'work_mode' => ['required', 'in:onsite,remote,hybrid'],
            'duration' => ['nullable', 'string', 'max:100'],
            'start_date' => ['nullable', 'date'],
            'application_deadline' => ['nullable', 'date'],
            'slots_available' => ['required', 'integer', 'min:1'],
            'is_paid' => ['nullable', 'boolean'],
            'stipend' => ['nullable', 'numeric', 'min:0'],
            'status' => ['required', 'in:open,closed'],
        ]);

        $validated['is_paid'] = $request->boolean('is_paid');

        // Re-submit for approval if key content changed
        if ($internship->title !== $validated['title'] || $internship->description !== $validated['description']) {
            $validated['approval_status'] = 'pending';
        }

        $internship->update($validated);

        return redirect()->route('internships.manage')->with('status', 'Internship updated successfully.');
    }

    public function destroy(Internship $internship): RedirectResponse
    {
        $this->authorizeOwnership($internship);
        $internship->delete();
        return redirect()->route('internships.manage')->with('status', 'Internship posting removed.');
    }

    private function authorizeOwnership(Internship $internship): void
    {
        if ($internship->employer_id !== auth()->user()->employer?->id) {
            abort(403);
        }
    }
}
