<?php

namespace App\Http\Controllers;

use Illuminate\Http\RedirectResponse;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Storage;
use Illuminate\View\View;

class StudentProfileController extends Controller
{
    public function edit(Request $request): View
    {
        $student = $request->user()->student;
        return view('students.profile', compact('student'));
    }

    public function update(Request $request): RedirectResponse
    {
        $student = $request->user()->student;

        $validated = $request->validate([
            'university' => ['required', 'string', 'max:255'],
            'faculty' => ['nullable', 'string', 'max:255'],
            'department' => ['nullable', 'string', 'max:255'],
            'program' => ['nullable', 'string', 'max:255'],
            'year_of_study' => ['nullable', 'integer', 'min:1', 'max:8'],
            'gpa' => ['nullable', 'numeric', 'min:0', 'max:4'],
            'bio' => ['nullable', 'string', 'max:2000'],
            'skills' => ['nullable', 'string', 'max:1000'],
            'linkedin_url' => ['nullable', 'url', 'max:255'],
            'cv' => ['nullable', 'file', 'mimes:pdf,doc,docx', 'max:5120'],
            'photo' => ['nullable', 'image', 'max:2048'],
        ]);

        if ($request->hasFile('cv')) {
            if ($student->cv_path) {
                Storage::disk('public')->delete($student->cv_path);
            }
            $validated['cv_path'] = $request->file('cv')->store('cvs', 'public');
        }

        if ($request->hasFile('photo')) {
            if ($student->profile_photo_path) {
                Storage::disk('public')->delete($student->profile_photo_path);
            }
            $validated['profile_photo_path'] = $request->file('photo')->store('profile-photos', 'public');
        }

        $student->update($validated);

        return back()->with('status', 'Profile updated successfully.');
    }
}
