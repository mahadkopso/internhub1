@extends('layouts.app')
@section('title', 'Pending Internship Postings')

@section('content')
<h3 class="section-title mb-4">Internship Postings Awaiting Approval</h3>

@forelse($internships as $i)
    <div class="card p-4 mb-3">
        <div class="d-flex justify-content-between">
            <div>
                <h5>{{ $i->title }}</h5>
                <p class="text-muted mb-1">{{ $i->employer->company_name }} &middot; {{ $i->location }}</p>
                <p class="small mb-2">{{ \Illuminate\Support\Str::limit($i->description, 200) }}</p>
                <p class="small text-muted mb-0">Slots: {{ $i->slots_available }} &middot; {{ $i->is_paid ? 'Paid ($'.$i->stipend.')' : 'Unpaid' }} &middot; Deadline: {{ $i->application_deadline?->format('M d, Y') ?? 'N/A' }}</p>
            </div>
            <div style="min-width:280px;">
                <form method="POST" action="{{ route('coordinator.internships.decide', $i) }}">
                    @csrf @method('PATCH')
                    <textarea name="coordinator_remarks" class="form-control form-control-sm mb-2" rows="2" placeholder="Remarks (optional)"></textarea>
                    <div class="d-flex gap-2">
                        <button type="submit" name="approval_status" value="approved" class="btn btn-sm btn-success flex-fill">Approve</button>
                        <button type="submit" name="approval_status" value="rejected" class="btn btn-sm btn-outline-danger flex-fill">Reject</button>
                    </div>
                </form>
            </div>
        </div>
    </div>
@empty
    <p class="text-muted">No internship postings awaiting review.</p>
@endforelse

<div class="mt-3">{{ $internships->links() }}</div>
@endsection
