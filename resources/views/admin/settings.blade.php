@extends('layouts.app')
@section('title', 'System Settings')

@section('content')
<h3 class="section-title mb-4">System Settings</h3>

<div class="card p-4">
    <form method="POST" action="{{ route('admin.settings.update') }}">
        @csrf @method('PUT')
        <div class="row g-3">
            <div class="col-md-6">
                <label class="form-label">Application Name</label>
                <input type="text" name="app_name" value="{{ $settings['app_name'] ?? 'InternHub' }}" class="form-control" required>
            </div>
            <div class="col-md-6">
                <label class="form-label">University Name</label>
                <input type="text" name="university_name" value="{{ $settings['university_name'] ?? '' }}" class="form-control" required>
            </div>
            <div class="col-md-6">
                <label class="form-label">Deadline Reminder (days before)</label>
                <input type="number" name="application_deadline_reminder_days" value="{{ $settings['application_deadline_reminder_days'] ?? 3 }}" min="1" class="form-control" required>
            </div>
            <div class="col-md-6">
                <label class="form-label">Max Report File Size (MB)</label>
                <input type="number" name="max_report_file_size_mb" value="{{ $settings['max_report_file_size_mb'] ?? 10 }}" min="1" max="50" class="form-control" required>
            </div>
            <div class="col-md-6">
                <div class="form-check mt-2">
                    <input type="checkbox" name="require_coordinator_internship_approval" value="1" class="form-check-input" id="reqInternApproval" @checked(($settings['require_coordinator_internship_approval'] ?? '1') == '1')>
                    <label class="form-check-label" for="reqInternApproval">Require coordinator approval for internship postings</label>
                </div>
            </div>
            <div class="col-md-6">
                <div class="form-check mt-2">
                    <input type="checkbox" name="require_coordinator_application_approval" value="1" class="form-check-input" id="reqAppApproval" @checked(($settings['require_coordinator_application_approval'] ?? '1') == '1')>
                    <label class="form-check-label" for="reqAppApproval">Require coordinator approval for student placements</label>
                </div>
            </div>
        </div>
        <button type="submit" class="btn btn-accent mt-4">Save Settings</button>
    </form>
</div>
@endsection
