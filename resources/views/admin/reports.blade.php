@extends('layouts.app')
@section('title', 'System Reports')

@section('content')
<h3 class="section-title mb-4">System Reports &amp; Analytics</h3>

<div class="row g-4">
    <div class="col-md-4">
        <div class="card p-4">
            <h6 class="mb-3">Applications by Status</h6>
            @forelse($applicationsByStatus as $status => $count)
                <div class="d-flex justify-content-between border-bottom py-2">
                    <x-status-badge :status="$status" />
                    <span class="fw-semibold">{{ $count }}</span>
                </div>
            @empty
                <p class="text-muted mb-0">No data yet.</p>
            @endforelse
        </div>
    </div>
    <div class="col-md-4">
        <div class="card p-4">
            <h6 class="mb-3">Internship Postings by Approval</h6>
            @forelse($internshipsByApproval as $status => $count)
                <div class="d-flex justify-content-between border-bottom py-2">
                    <x-status-badge :status="$status" />
                    <span class="fw-semibold">{{ $count }}</span>
                </div>
            @empty
                <p class="text-muted mb-0">No data yet.</p>
            @endforelse
        </div>
    </div>
    <div class="col-md-4">
        <div class="card p-4">
            <h6 class="mb-3">Reports by Status</h6>
            @forelse($reportsByStatus as $status => $count)
                <div class="d-flex justify-content-between border-bottom py-2">
                    <x-status-badge :status="$status" />
                    <span class="fw-semibold">{{ $count }}</span>
                </div>
            @empty
                <p class="text-muted mb-0">No data yet.</p>
            @endforelse
        </div>
    </div>
</div>

<div class="row g-4 mt-1">
    <div class="col-md-6">
        <div class="card p-4">
            <h6 class="mb-3">Top Employers by Postings</h6>
            @forelse($topEmployers as $row)
                <div class="d-flex justify-content-between border-bottom py-2">
                    <span>{{ $row->employer->company_name ?? 'Unknown' }}</span>
                    <span class="fw-semibold">{{ $row->total }}</span>
                </div>
            @empty
                <p class="text-muted mb-0">No data yet.</p>
            @endforelse
        </div>
    </div>
    <div class="col-md-6">
        <div class="card p-4">
            <h6 class="mb-3">Applications per Month</h6>
            @forelse($monthlyApplications as $row)
                <div class="d-flex justify-content-between border-bottom py-2">
                    <span>{{ $row->month }}</span>
                    <span class="fw-semibold">{{ $row->total }}</span>
                </div>
            @empty
                <p class="text-muted mb-0">No data yet.</p>
            @endforelse
        </div>
    </div>
</div>
@endsection
