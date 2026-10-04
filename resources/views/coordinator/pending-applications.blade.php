@extends('layouts.app')
@section('title', 'Pending Applications')

@section('content')
<h3 class="section-title mb-4">Applications Awaiting Final Approval</h3>
<p class="text-muted mb-4">These students have applied to internships. Approve to authorize the placement for academic credit and progress monitoring.</p>

@forelse($applications as $app)
    <div class="card p-4 mb-3">
        <div class="d-flex justify-content-between">
            <div>
                <h5>{{ $app->student->user->name }}</h5>
                <p class="text-muted mb-1">{{ $app->internship->title }} at {{ $app->internship->employer->company_name }}</p>
                <p class="small mb-2">Employer decision: <x-status-badge :status="$app->employer_status" /></p>
                <p class="small text-muted mb-0">Student: {{ $app->student->program }}, Year {{ $app->student->year_of_study }} &middot; GPA {{ $app->student->gpa ?? 'N/A' }}</p>
            </div>
            <div style="min-width:280px;">
                <form method="POST" action="{{ route('coordinator.applications.decide', $app) }}">
                    @csrf @method('PATCH')
                    <textarea name="coordinator_remarks" class="form-control form-control-sm mb-2" rows="2" placeholder="Remarks (optional)"></textarea>
                    <div class="d-flex gap-2">
                        <button type="submit" name="coordinator_status" value="approved" class="btn btn-sm btn-success flex-fill">Approve</button>
                        <button type="submit" name="coordinator_status" value="rejected" class="btn btn-sm btn-outline-danger flex-fill">Reject</button>
                    </div>
                </form>
            </div>
        </div>
    </div>
@empty
    <p class="text-muted">No applications awaiting review.</p>
@endforelse

<div class="mt-3">{{ $applications->links() }}</div>
@endsection
