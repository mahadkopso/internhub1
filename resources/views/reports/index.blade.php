@extends('layouts.app')
@section('title', 'My Reports')

@section('content')
<div class="d-flex justify-content-between align-items-center mb-4">
    <h3 class="section-title mb-0">My Internship Reports</h3>
    @if($activeApplications->count())
        <a href="{{ route('reports.create') }}" class="btn btn-accent"><i class="bi bi-upload me-1"></i>Submit Report</a>
    @endif
</div>

@if($activeApplications->isEmpty())
    <div class="alert alert-info">You need an approved internship placement before you can submit reports.</div>
@endif

<div class="card p-3">
    <table class="table align-middle">
        <thead><tr><th>Title</th><th>Type</th><th>Submitted</th><th>Status</th><th>Coordinator Feedback</th><th></th></tr></thead>
        <tbody>
        @forelse($reports as $r)
            <tr>
                <td>{{ $r->title }}</td>
                <td class="text-capitalize">{{ $r->report_type }}</td>
                <td>{{ $r->submission_date->format('M d, Y') }}</td>
                <td><x-status-badge :status="$r->status" /></td>
                <td class="small text-muted">{{ \Illuminate\Support\Str::limit($r->coordinator_feedback, 60) ?: '—' }}</td>
                <td><a href="{{ route('reports.show', $r) }}" class="btn btn-sm btn-outline-primary">View</a></td>
            </tr>
        @empty
            <tr><td colspan="6" class="text-muted text-center py-4">No reports submitted yet.</td></tr>
        @endforelse
        </tbody>
    </table>
</div>
<div class="mt-3">{{ $reports->links() }}</div>
@endsection
