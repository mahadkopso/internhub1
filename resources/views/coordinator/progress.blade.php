@extends('layouts.app')
@section('title', 'Student Progress Monitoring')

@section('content')
<h3 class="section-title mb-4">Student Progress Monitoring</h3>
<p class="text-muted mb-4">Track all students currently placed in an approved internship.</p>

<div class="row g-4">
@forelse($students as $student)
    @php $activeApp = $student->applications->first(); @endphp
    <div class="col-md-6 col-lg-4">
        <div class="card p-4 h-100">
            <div class="d-flex align-items-center mb-3">
                <div class="avatar-circle me-3">{{ substr($student->user->name,0,1) }}</div>
                <div>
                    <div class="fw-semibold">{{ $student->user->name }}</div>
                    <div class="text-muted small">{{ $student->program }}</div>
                </div>
            </div>
            @if($activeApp)
                <p class="small mb-1"><strong>Placement:</strong> {{ $activeApp->internship->title }}</p>
                <p class="small mb-1"><strong>Employer:</strong> {{ $activeApp->internship->employer->company_name }}</p>
            @endif
            <p class="small mb-3"><strong>Reports Submitted:</strong> {{ $student->reports->count() }}</p>
            <a href="{{ route('coordinator.progress.show', $student) }}" class="btn btn-sm btn-outline-primary mt-auto">View Details</a>
        </div>
    </div>
@empty
    <p class="text-muted">No students are currently placed in an active internship.</p>
@endforelse
</div>
<div class="mt-4">{{ $students->links() }}</div>
@endsection
