@extends('layouts.app')
@section('title', 'Manage Reports')

@section('content')
<h3 class="section-title mb-4">Manage Submitted Reports</h3>

<form method="GET" class="mb-3">
    <select name="status" class="form-select w-auto d-inline-block" onchange="this.form.submit()">
        <option value="">All Statuses</option>
        <option value="pending" @selected(request('status')=='pending')>Pending</option>
        <option value="approved" @selected(request('status')=='approved')>Approved</option>
        <option value="needs_revision" @selected(request('status')=='needs_revision')>Needs Revision</option>
        <option value="rejected" @selected(request('status')=='rejected')>Rejected</option>
    </select>
</form>

@forelse($reports as $report)
    <div class="card p-4 mb-3">
        <div class="row align-items-center">
            <div class="col-md-4">
                <div class="fw-semibold">{{ $report->title }}</div>
                <div class="text-muted small">{{ $report->student->user->name }} &middot; {{ ucfirst($report->report_type) }}</div>
            </div>
            <div class="col-md-2">
                <x-status-badge :status="$report->status" />
            </div>
            <div class="col-md-2">
                <a href="{{ asset('storage/'.$report->file_path) }}" target="_blank" class="small">Download</a>
            </div>
            <div class="col-md-4">
                <form method="POST" action="{{ route('coordinator.reports.review', $report) }}">
                    @csrf @method('PATCH')
                    <div class="d-flex gap-1">
                        <select name="status" class="form-select form-select-sm">
                            <option value="approved" @selected($report->status=='approved')>Approve</option>
                            <option value="needs_revision" @selected($report->status=='needs_revision')>Needs Revision</option>
                            <option value="rejected" @selected($report->status=='rejected')>Reject</option>
                        </select>
                        <button class="btn btn-sm btn-primary">Save</button>
                    </div>
                    <input type="text" name="coordinator_feedback" class="form-control form-control-sm mt-1" placeholder="Feedback (optional)" value="{{ $report->coordinator_feedback }}">
                </form>
            </div>
        </div>
    </div>
@empty
    <p class="text-muted">No reports found.</p>
@endforelse

<div class="mt-3">{{ $reports->links() }}</div>
@endsection
