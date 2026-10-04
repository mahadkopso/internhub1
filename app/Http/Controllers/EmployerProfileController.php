<?php

namespace App\Http\Controllers;

use Illuminate\Http\RedirectResponse;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Storage;
use Illuminate\View\View;

class EmployerProfileController extends Controller
{
    public function edit(Request $request): View
    {
        $employer = $request->user()->employer;
        return view('employers.profile', compact('employer'));
    }

    public function update(Request $request): RedirectResponse
    {
        $employer = $request->user()->employer;

        $validated = $request->validate([
            'company_name' => ['required', 'string', 'max:255'],
            'industry' => ['nullable', 'string', 'max:255'],
            'company_description' => ['nullable', 'string', 'max:3000'],
            'website' => ['nullable', 'url', 'max:255'],
            'company_address' => ['nullable', 'string', 'max:500'],
            'contact_person' => ['nullable', 'string', 'max:255'],
            'logo' => ['nullable', 'image', 'max:2048'],
        ]);

        if ($request->hasFile('logo')) {
            if ($employer->logo_path) {
                Storage::disk('public')->delete($employer->logo_path);
            }
            $validated['logo_path'] = $request->file('logo')->store('logos', 'public');
        }

        $employer->update($validated);

        return back()->with('status', 'Company profile updated successfully.');
    }
}
