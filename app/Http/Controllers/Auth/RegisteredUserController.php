<?php

namespace App\Http\Controllers\Auth;

use App\Http\Controllers\Controller;
use App\Models\Employer;
use App\Models\Student;
use App\Models\User;
use Illuminate\Auth\Events\Registered;
use Illuminate\Http\RedirectResponse;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\Hash;
use Illuminate\Support\Facades\Validator;
use Illuminate\View\View;

class RegisteredUserController extends Controller
{
    public function create(): View
    {
        return view('auth.register');
    }

    /**
     * Handle registration for both Student and Employer self-service accounts.
     * Coordinator and Admin accounts are created only by an Administrator.
     */
    public function store(Request $request): RedirectResponse
    {
        $request->validate([
            'account_type' => ['required', 'in:student,employer'],
            'name' => ['required', 'string', 'max:255'],
            'email' => ['required', 'string', 'email', 'max:255', 'unique:users,email'],
            'password' => ['required', 'confirmed', 'min:8'],
            'phone' => ['nullable', 'string', 'max:30'],
        ]);

        if ($request->account_type === 'student') {
            $request->validate([
                'student_id_number' => ['required', 'string', 'max:50', 'unique:students,student_id_number'],
                'university' => ['required', 'string', 'max:255'],
                'department' => ['nullable', 'string', 'max:255'],
                'program' => ['nullable', 'string', 'max:255'],
                'year_of_study' => ['nullable', 'integer', 'min:1', 'max:8'],
            ]);
        } else {
            $request->validate([
                'company_name' => ['required', 'string', 'max:255'],
                'industry' => ['nullable', 'string', 'max:255'],
            ]);
        }

        $user = User::create([
            'name' => $request->name,
            'email' => $request->email,
            'password' => Hash::make($request->password),
            'role' => $request->account_type,
            'phone' => $request->phone,
        ]);

        if ($request->account_type === 'student') {
            Student::create([
                'user_id' => $user->id,
                'student_id_number' => $request->student_id_number,
                'university' => $request->university,
                'department' => $request->department,
                'program' => $request->program,
                'year_of_study' => $request->year_of_study,
            ]);
        } else {
            Employer::create([
                'user_id' => $user->id,
                'company_name' => $request->company_name,
                'industry' => $request->industry,
            ]);
        }

        event(new Registered($user));

        Auth::login($user);

        return redirect()->route('dashboard');
    }
}
