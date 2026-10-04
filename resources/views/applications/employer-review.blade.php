@extends('layouts.app')
@section('title', 'Review Applicants')

@section('content')
<h3 class="section-title mb-1">Applicants for "{{ $internship->title }}"</h3>
<p class="text-muted mb-4">Review applications and update each candidate's status.</p>

@forelse($applications as $app)
    <div class="card p-4 mb-3">
        <div class="row align-items-center">
            <div class="col-md-4">
                <div class="d-flex align-items-center">
                    <div class="avatar-circle me-3">{{ substr($app->student->user->name, 0, 1) }}</div>
                    <div>
                        <div class="fw-semibold">{{ $app->student->user->name }}</div>
                        <div class="text-muted small">{{ $app->student->program }} &middot; Year {{ $app->student->year_of_study }}</div>
                    </div>
                </div>
            </div>
            <div class="col-md-2">
                <x-status-badge :status="$app->employer_status" />
                <div class="small text-muted mt-1">Coordinator: <x-status-badge :status="$app->coordinator_status" /></div>
            </div>
            <div class="col-md-3">
                @if($app->resume_path)
                    <a href="{{ asset('storage/'.$app->resume_path) }}" target="_blank" class="small"><i class="bi bi-file-earmark-pdf me-1"></i>View Resume</a>
                @else
                    <span class="text-muted small">No resume attached</span>
                @endif
            </div>
            <div class="col-md-3 text-end">
                <form method="POST" action="{{ route('applications.decide', $app) }}" class="d-flex gap-1 justify-content-end">
                    @csrf @method('PATCH')
                    <select name="employer_status" class="form-select form-select-sm w-auto">
                        <option value="shortlisted" @selected($app->employer_status=='shortlisted')>Shortlist</option>
                        <option value="accepted" @selected($app->employer_status=='accepted')>Accept</option>
                        <option value="rejected" @selected($app->employer_status=='rejected')>Reject</option>
                    </select>
                    <button class="btn btn-sm btn-primary">Update</button>
                </form>
            </div>
        </div>
        @if($app->cover_letter)
            <div class="mt-3 pt-3 border-top">
                <p class="small text-muted mb-1">Cover Letter</p>
                <p class="small mb-0">{{ $app->cover_letter }}</p>
            </div>
        @endif
    </div>
@empty
    <p class="text-muted">No applicants yet for this internship.</p>
@endforelse

<div class="mt-3">{{ $applications->links() }}</div>
@endsection
