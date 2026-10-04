@extends('layouts.app')
@section('title', $internship->title)

@section('content')
<div class="row">
    <div class="col-lg-8">
        <div class="card p-4 mb-4">
            <div class="d-flex justify-content-between align-items-start mb-2">
                <div>
                    <h3 class="mb-1">{{ $internship->title }}</h3>
                    <p class="text-muted mb-0"><i class="bi bi-building me-1"></i>{{ $internship->employer->company_name }} &middot; {{ $internship->location ?? 'Location N/A' }}</p>
                </div>
                <span class="badge text-bg-light text-dark text-capitalize">{{ $internship->work_mode }}</span>
            </div>

            <hr>
            <h6>Description</h6>
            <p>{{ $internship->description }}</p>

            @if($internship->requirements)
                <h6>Requirements</h6>
                <p>{{ $internship->requirements }}</p>
            @endif

            <div class="row mt-3">
                <div class="col-md-4"><strong>Duration:</strong> {{ $internship->duration ?? 'N/A' }}</div>
                <div class="col-md-4"><strong>Slots:</strong> {{ $internship->slots_available }}</div>
                <div class="col-md-4"><strong>Compensation:</strong> {{ $internship->is_paid ? '$'.number_format($internship->stipend, 2).'/mo' : 'Unpaid' }}</div>
            </div>
            @if($internship->application_deadline)
                <p class="mt-3 mb-0"><strong>Application Deadline:</strong> {{ $internship->application_deadline->format('F d, Y') }}</p>
            @endif
        </div>

        @auth
        @if(auth()->user()->isStudent())
            <div class="card p-4">
                <h5 class="mb-3">Apply for this Internship</h5>
                @if($alreadyApplied)
                    <div class="alert alert-info mb-0">You have already applied for this internship.</div>
                @elseif($internship->isDeadlinePassed())
                    <div class="alert alert-warning mb-0">The application deadline has passed.</div>
                @else
                    <form method="POST" action="{{ route('applications.store', $internship) }}" enctype="multipart/form-data">
                        @csrf
                        <div class="mb-3">
                            <label class="form-label">Cover Letter</label>
                            <textarea name="cover_letter" class="form-control" rows="4" placeholder="Tell the employer why you're a great fit..."></textarea>
                        </div>
                        <div class="mb-3">
                            <label class="form-label">Resume / CV (optional if already on your profile)</label>
                            <input type="file" name="resume" class="form-control" accept=".pdf,.doc,.docx">
                        </div>
                        <button type="submit" class="btn btn-accent">Submit Application</button>
                    </form>
                @endif
            </div>
        @endif
        @endauth
    </div>

    <div class="col-lg-4">
        <div class="card p-4">
            <h6 class="mb-3">About the Employer</h6>
            <p class="mb-1 fw-semibold">{{ $internship->employer->company_name }}</p>
            <p class="text-muted small mb-2">{{ $internship->employer->industry }}</p>
            <p class="small">{{ $internship->employer->company_description }}</p>
            @if($internship->employer->website)
                <a href="{{ $internship->employer->website }}" target="_blank" class="small">{{ $internship->employer->website }}</a>
            @endif
        </div>
    </div>
</div>
@endsection
