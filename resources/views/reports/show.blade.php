@extends('layouts.app')
@section('title', $report->title)

@section('content')
<h3 class="section-title mb-4">{{ $report->title }}</h3>
<div class="card p-4">
    <div class="row mb-3">
        <div class="col-md-4"><strong>Type:</strong> <span class="text-capitalize">{{ $report->report_type }}</span></div>
        <div class="col-md-4"><strong>Submitted:</strong> {{ $report->submission_date->format('M d, Y') }}</div>
        <div class="col-md-4"><strong>Status:</strong> <x-status-badge :status="$report->status" /></div>
    </div>
    @if($report->description)
        <h6>Summary</h6>
        <p>{{ $report->description }}</p>
    @endif
    <a href="{{ asset('storage/'.$report->file_path) }}" target="_blank" class="btn btn-outline-primary btn-sm mb-3"><i class="bi bi-download me-1"></i>Download Report File</a>

    @if($report->coordinator_feedback)
        <div class="alert alert-secondary mt-3">
            <strong>Coordinator Feedback:</strong>
            <p class="mb-0">{{ $report->coordinator_feedback }}</p>
        </div>
    @endif
</div>
@endsection
