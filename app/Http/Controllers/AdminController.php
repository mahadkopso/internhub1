<?php

namespace App\Http\Controllers;

use App\Models\Internship;
use App\Models\InternshipApplication;
use App\Models\Report;
use App\Models\Setting;
use App\Models\User;
use Illuminate\Http\RedirectResponse;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Hash;
use Illuminate\View\View;

class AdminController extends Controller
{
    /** Manage all users */
    public function users(Request $request): View
    {
        $query = User::query();

        if ($request->filled('role')) {
            $query->where('role', $request->role);
        }

        if ($request->filled('keyword')) {
            $keyword = $request->keyword;
            $query->where(fn ($q) => $q->where('name', 'like', "%{$keyword}%")->orWhere('email', 'like', "%{$keyword}%"));
        }

        $users = $query->latest()->paginate(15)->withQueryString();

        return view('admin.users', compact('users'));
    }

    public function createUser(): View
    {
        return view('admin.user-create');
    }

    public function storeUser(Request $request): RedirectResponse
    {
        $validated = $request->validate([
            'name' => ['required', 'string', 'max:255'],
            'email' => ['required', 'email', 'unique:users,email'],
            'password' => ['required', 'min:8'],
            'role' => ['required', 'in:student,employer,coordinator,admin'],
            'phone' => ['nullable', 'string', 'max:30'],
        ]);

        $validated['password'] = Hash::make($validated['password']);
        $user = User::create($validated);

        if ($user->role === 'student') {
            $user->student()->create(['student_id_number' => 'STU-'.str_pad($user->id, 6, '0', STR_PAD_LEFT)]);
        } elseif ($user->role === 'employer') {
            $user->employer()->create(['company_name' => $request->name.' Company']);
        }

        return redirect()->route('admin.users')->with('status', 'User created successfully.');
    }

    public function toggleUserStatus(User $user): RedirectResponse
    {
        $user->update(['is_active' => ! $user->is_active]);
        return back()->with('status', 'User status updated.');
    }

    public function deleteUser(User $user): RedirectResponse
    {
        if ($user->role === 'admin' && User::where('role', 'admin')->count() <= 1) {
            return back()->withErrors('Cannot delete the last remaining administrator.');
        }
        $user->delete();
        return back()->with('status', 'User deleted.');
    }

    /** Manage all internship records */
    public function internships(Request $request): View
    {
        $query = Internship::with('employer');

        if ($request->filled('status')) {
            $query->where('status', $request->status);
        }
        if ($request->filled('approval_status')) {
            $query->where('approval_status', $request->approval_status);
        }

        $internships = $query->latest()->paginate(15)->withQueryString();

        return view('admin.internships', compact('internships'));
    }

    public function deleteInternship(Internship $internship): RedirectResponse
    {
        $internship->delete();
        return back()->with('status', 'Internship record removed.');
    }

    /** Generate system reports (analytics dashboard) */
    public function reports(): View
    {
        $applicationsByStatus = InternshipApplication::selectRaw('status, count(*) as total')
            ->groupBy('status')->pluck('total', 'status');

        $internshipsByApproval = Internship::selectRaw('approval_status, count(*) as total')
            ->groupBy('approval_status')->pluck('total', 'approval_status');

        $reportsByStatus = Report::selectRaw('status, count(*) as total')
            ->groupBy('status')->pluck('total', 'status');

        $topEmployers = Internship::selectRaw('employer_id, count(*) as total')
            ->groupBy('employer_id')->orderByDesc('total')->with('employer')->take(5)->get();

        $monthlyApplications = InternshipApplication::selectRaw("DATE_FORMAT(created_at, '%Y-%m') as month, count(*) as total")
            ->groupBy('month')->orderBy('month')->take(12)->get();

        return view('admin.reports', compact(
            'applicationsByStatus', 'internshipsByApproval', 'reportsByStatus', 'topEmployers', 'monthlyApplications'
        ));
    }

    /** Configure system settings */
    public function settings(): View
    {
        $settings = Setting::pluck('value', 'key');
        return view('admin.settings', compact('settings'));
    }

    public function updateSettings(Request $request): RedirectResponse
    {
        $validated = $request->validate([
            'app_name' => ['required', 'string', 'max:255'],
            'university_name' => ['required', 'string', 'max:255'],
            'application_deadline_reminder_days' => ['required', 'integer', 'min:1'],
            'require_coordinator_internship_approval' => ['nullable', 'boolean'],
            'require_coordinator_application_approval' => ['nullable', 'boolean'],
            'max_report_file_size_mb' => ['required', 'integer', 'min:1', 'max:50'],
        ]);

        $validated['require_coordinator_internship_approval'] = $request->boolean('require_coordinator_internship_approval') ? '1' : '0';
        $validated['require_coordinator_application_approval'] = $request->boolean('require_coordinator_application_approval') ? '1' : '0';

        foreach ($validated as $key => $value) {
            Setting::set($key, $value);
        }

        return back()->with('status', 'System settings updated.');
    }
}
