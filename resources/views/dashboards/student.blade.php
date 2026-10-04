@extends('layouts.app')
@section('title', 'Student Dashboard')

@section('content')
<div class="d-flex justify-content-between align-items-center mb-4">
    <div>
        <h3 class="section-title mb-0">Welcome back, {{ auth()->user()->name }}</h3>
        <p class="text-muted mb-0">Here's an overview of your internship journey.</p>
    </div>
    <a href="{{ route('internships.index') }}" class="btn btn-accent"><i class="bi bi-search me-1"></i> Browse Internships</a>
</div>

<div class="row g-3 mb-4">
    <x-stat-card label="Applications" :value="$stats['total_applications']" icon="bi-send" />
    <x-stat-card label="Pending" :value="$stats['pending_applications']" icon="bi-hourglass-split" variant="accent" />
    <x-stat-card label="Approved" :value="$stats['approved_applications']" icon="bi-check-circle" variant="teal" />
    <x-stat-card label="Reports Submitted" :value="$stats['reports_submitted']" icon="bi-file-earmark-text" />
</div>

@if($activeApplication)
<div class="card p-4 mb-4">
    <h5 class="mb-3"><i class="bi bi-briefcase-fill text-success me-2"></i>Current Internship</h5>
    <p class="mb-1"><strong>{{ $activeApplication->internship->title }}</strong> at {{ $activeApplication->internship->employer->company_name }}</p>
    <p class="text-muted mb-3">{{ $activeApplication->internship->location }} &middot; {{ $activeApplication->internship->duration }}</p>
    <a href="{{ route('reports.create') }}" class="btn btn-sm btn-outline-primary">Submit a Report</a>
</div>
@endif

<div class="row g-4">
    <div class="col-lg-7">
        <div class="card p-4">
            <div class="d-flex justify-content-between align-items-center mb-3">
                <h5 class="mb-0">Recent Applications</h5>
                <a href="{{ route('applications.index') }}" class="small">View all</a>
            </div>
            @forelse($applications->take(5) as $app)
                <div class="d-flex justify-content-between align-items-center border-bottom py-2">
                    <div>
                        <div class="fw-semibold">{{ $app->internship->title }}</div>
                        <div class="text-muted small">{{ $app->internship->employer->company_name }}</div>
                    </div>
                    <x-status-badge :status="$app->status" />
                </div>
            @empty
                <p class="text-muted mb-0">You haven't applied to any internships yet.</p>
            @endforelse
        </div>
    </div>
    <div class="col-lg-5">
        <div class="card p-4">
            <div class="d-flex justify-content-between align-items-center mb-3">
                <h5 class="mb-0">Recent Reports</h5>
                <a href="{{ route('reports.index') }}" class="small">View all</a>
            </div>
            @forelse($reports->take(5) as $report)
                <div class="d-flex justify-content-between align-items-center border-bottom py-2">
                    <div>
                        <div class="fw-semibold">{{ $report->title }}</div>
                        <div class="text-muted small text-capitalize">{{ $report->report_type }} report</div>
                    </div>
                    <x-status-badge :status="$report->status" />
                </div>
            @empty
                <p class="text-muted mb-0">No reports submitted yet.</p>
            @endforelse
        </div>
    </div>
</div>
@endsection
