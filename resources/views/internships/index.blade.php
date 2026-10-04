@extends('layouts.app')
@section('title', 'Browse Internships')

@section('content')
<h3 class="section-title mb-4">Browse Internships</h3>

<form method="GET" class="card p-3 mb-4">
    <div class="row g-2">
        <div class="col-md-4">
            <input type="text" name="keyword" value="{{ request('keyword') }}" class="form-control" placeholder="Search by title or keyword">
        </div>
        <div class="col-md-3">
            <input type="text" name="location" value="{{ request('location') }}" class="form-control" placeholder="Location">
        </div>
        <div class="col-md-2">
            <select name="work_mode" class="form-select">
                <option value="">Any mode</option>
                <option value="onsite" @selected(request('work_mode')=='onsite')>Onsite</option>
                <option value="remote" @selected(request('work_mode')=='remote')>Remote</option>
                <option value="hybrid" @selected(request('work_mode')=='hybrid')>Hybrid</option>
            </select>
        </div>
        <div class="col-md-2">
            <select name="paid" class="form-select">
                <option value="">Paid or unpaid</option>
                <option value="1" @selected(request('paid')=='1')>Paid only</option>
                <option value="0" @selected(request('paid')=='0')>Unpaid only</option>
            </select>
        </div>
        <div class="col-md-1 d-grid">
            <button class="btn btn-primary"><i class="bi bi-search"></i></button>
        </div>
    </div>
</form>

<div class="row g-4">
    @forelse($internships as $internship)
        <div class="col-md-6 col-lg-4">
            <div class="card internship-card h-100 p-3">
                <div class="d-flex justify-content-between mb-2">
                    <span class="badge text-bg-light text-dark text-capitalize">{{ $internship->work_mode }}</span>
                    @if($internship->is_paid)
                        <span class="badge bg-success">Paid</span>
                    @else
                        <span class="badge bg-secondary">Unpaid</span>
                    @endif
                </div>
                <h5>{{ $internship->title }}</h5>
                <p class="text-muted small mb-1"><i class="bi bi-building me-1"></i>{{ $internship->employer->company_name }}</p>
                <p class="text-muted small mb-2"><i class="bi bi-geo-alt me-1"></i>{{ $internship->location ?? 'Not specified' }}</p>
                <p class="small mb-3">{{ \Illuminate\Support\Str::limit($internship->description, 100) }}</p>
                @if($internship->application_deadline)
                    <p class="small text-muted mb-3"><i class="bi bi-calendar-event me-1"></i>Apply by {{ $internship->application_deadline->format('M d, Y') }}</p>
                @endif
                <a href="{{ route('internships.show', $internship) }}" class="btn btn-outline-primary btn-sm mt-auto">View Details</a>
            </div>
        </div>
    @empty
        <p class="text-muted">No internships match your search criteria right now.</p>
    @endforelse
</div>

<div class="mt-4">{{ $internships->links() }}</div>
@endsection
