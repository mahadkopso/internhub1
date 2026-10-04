@extends('layouts.app')
@section('title', 'Employer Dashboard')

@section('content')
<div class="d-flex justify-content-between align-items-center mb-4">
    <div>
        <h3 class="section-title mb-0">{{ $employer->company_name ?? auth()->user()->name }}</h3>
        <p class="text-muted mb-0">Manage your internship postings and applicants.</p>
    </div>
    <a href="{{ route('internships.create') }}" class="btn btn-accent"><i class="bi bi-plus-lg me-1"></i> Post Internship</a>
</div>

<div class="row g-3 mb-4">
    <x-stat-card label="Total Postings" :value="$stats['total_postings']" icon="bi-briefcase" />
    <x-stat-card label="Open Postings" :value="$stats['open_postings']" icon="bi-unlock" variant="teal" />
    <x-stat-card label="Pending Approval" :value="$stats['pending_approval']" icon="bi-hourglass-split" variant="accent" />
    <x-stat-card label="Total Applicants" :value="$stats['total_applicants']" icon="bi-people" />
</div>

<div class="row g-4">
    <div class="col-lg-7">
        <div class="card p-4">
            <div class="d-flex justify-content-between align-items-center mb-3">
                <h5 class="mb-0">My Postings</h5>
                <a href="{{ route('internships.manage') }}" class="small">View all</a>
            </div>
            @forelse($internships->take(6) as $i)
                <div class="d-flex justify-content-between align-items-center border-bottom py-2">
                    <div>
                        <div class="fw-semibold">{{ $i->title }}</div>
                        <div class="text-muted small">{{ $i->applications_count }} applicant(s)</div>
                    </div>
                    <div class="text-end">
                        <x-status-badge :status="$i->approval_status" />
                        <div><a href="{{ route('applications.for-internship', $i) }}" class="small">View applicants</a></div>
                    </div>
                </div>
            @empty
                <p class="text-muted mb-0">You haven't posted any internships yet.</p>
            @endforelse
        </div>
    </div>
    <div class="col-lg-5">
        <div class="card p-4">
            <h5 class="mb-3">Recent Applicants</h5>
            @forelse($recentApplications as $app)
                <div class="d-flex justify-content-between align-items-center border-bottom py-2">
                    <div>
                        <div class="fw-semibold">{{ $app->student->user->name }}</div>
                        <div class="text-muted small">{{ $app->internship->title }}</div>
                    </div>
                    <x-status-badge :status="$app->employer_status" />
                </div>
            @empty
                <p class="text-muted mb-0">No applicants yet.</p>
            @endforelse
        </div>
    </div>
</div>
@endsection
