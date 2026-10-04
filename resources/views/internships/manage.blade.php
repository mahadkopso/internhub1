@extends('layouts.app')
@section('title', 'My Postings')

@section('content')
<div class="d-flex justify-content-between align-items-center mb-4">
    <h3 class="section-title mb-0">My Internship Postings</h3>
    <a href="{{ route('internships.create') }}" class="btn btn-accent"><i class="bi bi-plus-lg me-1"></i>Post Internship</a>
</div>

<div class="card p-3">
    <table class="table align-middle">
        <thead>
            <tr><th>Title</th><th>Applicants</th><th>Status</th><th>Approval</th><th>Deadline</th><th></th></tr>
        </thead>
        <tbody>
        @forelse($internships as $i)
            <tr>
                <td>{{ $i->title }}</td>
                <td>{{ $i->applications_count }}</td>
                <td><span class="badge {{ $i->status=='open' ? 'badge-status-approved' : 'badge-status-withdrawn' }} text-capitalize">{{ $i->status }}</span></td>
                <td><x-status-badge :status="$i->approval_status" /></td>
                <td>{{ $i->application_deadline?->format('M d, Y') ?? '—' }}</td>
                <td class="text-end">
                    <a href="{{ route('applications.for-internship', $i) }}" class="btn btn-sm btn-outline-primary">Applicants</a>
                    <a href="{{ route('internships.edit', $i) }}" class="btn btn-sm btn-outline-secondary">Edit</a>
                    <form method="POST" action="{{ route('internships.destroy', $i) }}" class="d-inline" onsubmit="return confirm('Delete this posting?')">
                        @csrf @method('DELETE')
                        <button class="btn btn-sm btn-outline-danger">Delete</button>
                    </form>
                </td>
            </tr>
        @empty
            <tr><td colspan="6" class="text-muted text-center py-4">You haven't posted any internships yet.</td></tr>
        @endforelse
        </tbody>
    </table>
</div>
<div class="mt-3">{{ $internships->links() }}</div>
@endsection
