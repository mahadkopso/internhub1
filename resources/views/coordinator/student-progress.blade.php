@extends('layouts.app')
@section('title', 'Student Progress')

@section('content')
<h3 class="section-title mb-1">{{ $student->user->name }}</h3>
<p class="text-muted mb-4">{{ $student->university }} &middot; {{ $student->program }} &middot; Year {{ $student->year_of_study }}</p>

<div class="row g-4">
    <div class="col-lg-6">
        <div class="card p-4">
            <h6 class="mb-3">Internship Placements</h6>
            @forelse($student->applications as $app)
                <div class="border-bottom py-2">
                    <div class="fw-semibold">{{ $app->internship->title }}</div>
                    <div class="text-muted small">{{ $app->internship->employer->company_name }}</div>
                    <x-status-badge :status="$app->status" />
                </div>
            @empty
                <p class="text-muted mb-0">No applications on record.</p>
            @endforelse
        </div>
    </div>
    <div class="col-lg-6">
        <div class="card p-4">
            <h6 class="mb-3">Submitted Reports</h6>
            @forelse($student->reports as $report)
                <div class="border-bottom py-2 d-flex justify-content-between align-items-center">
                    <div>
                        <div class="fw-semibold">{{ $report->title }}</div>
                        <div class="text-muted small text-capitalize">{{ $report->report_type }} &middot; {{ $report->submission_date->format('M d, Y') }}</div>
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
