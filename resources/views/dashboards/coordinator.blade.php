@extends('layouts.app')
@section('title', 'Coordinator Dashboard')

@section('content')
<div class="mb-4">
    <h3 class="section-title mb-0">Internship Coordinator Dashboard</h3>
    <p class="text-muted mb-0">Review applications, approve postings, and monitor student progress.</p>
</div>

<div class="row g-3 mb-4">
    <x-stat-card label="Pending Applications" :value="$stats['pending_applications']" icon="bi-hourglass-split" variant="accent" />
    <x-stat-card label="Pending Postings" :value="$stats['pending_internships']" icon="bi-briefcase" />
    <x-stat-card label="Pending Reports" :value="$stats['pending_reports']" icon="bi-file-earmark-text" variant="teal" />
    <x-stat-card label="Active Students" :value="$stats['active_students']" icon="bi-people" />
</div>

<div class="row g-4">
    <div class="col-lg-4">
        <div class="card p-4 h-100">
            <div class="d-flex justify-content-between align-items-center mb-3">
                <h6 class="mb-0">Applications Awaiting Approval</h6>
                <a href="{{ route('coordinator.applications.pending') }}" class="small">View all</a>
            </div>
            @forelse($pendingApplications as $app)
                <div class="border-bottom py-2">
                    <div class="fw-semibold">{{ $app->student->user->name }}</div>
                    <div class="text-muted small">{{ $app->internship->title }} &middot; {{ $app->internship->employer->company_name }}</div>
                </div>
            @empty
                <p class="text-muted mb-0">All caught up!</p>
            @endforelse
        </div>
    </div>
    <div class="col-lg-4">
        <div class="card p-4 h-100">
            <div class="d-flex justify-content-between align-items-center mb-3">
                <h6 class="mb-0">Postings Awaiting Approval</h6>
                <a href="{{ route('coordinator.internships.pending') }}" class="small">View all</a>
            </div>
            @forelse($pendingInternships as $i)
                <div class="border-bottom py-2">
                    <div class="fw-semibold">{{ $i->title }}</div>
                    <div class="text-muted small">{{ $i->employer->company_name }}</div>
                </div>
            @empty
                <p class="text-muted mb-0">All caught up!</p>
            @endforelse
        </div>
    </div>
    <div class="col-lg-4">
        <div class="card p-4 h-100">
            <div class="d-flex justify-content-between align-items-center mb-3">
                <h6 class="mb-0">Reports Awaiting Review</h6>
                <a href="{{ route('coordinator.reports.index') }}" class="small">View all</a>
            </div>
            @forelse($pendingReports as $r)
                <div class="border-bottom py-2">
                    <div class="fw-semibold">{{ $r->student->user->name }}</div>
                    <div class="text-muted small">{{ $r->title }} &middot; {{ ucfirst($r->report_type) }}</div>
                </div>
            @empty
                <p class="text-muted mb-0">All caught up!</p>
            @endforelse
        </div>
    </div>
</div>
@endsection
