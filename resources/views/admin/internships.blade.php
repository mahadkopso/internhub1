@extends('layouts.app')
@section('title', 'Internship Records')

@section('content')
<h3 class="section-title mb-4">Internship Records</h3>

<form method="GET" class="card p-3 mb-3">
    <div class="row g-2">
        <div class="col-md-3">
            <select name="status" class="form-select">
                <option value="">All Status</option>
                <option value="open" @selected(request('status')=='open')>Open</option>
                <option value="closed" @selected(request('status')=='closed')>Closed</option>
            </select>
        </div>
        <div class="col-md-3">
            <select name="approval_status" class="form-select">
                <option value="">All Approval</option>
                <option value="pending" @selected(request('approval_status')=='pending')>Pending</option>
                <option value="approved" @selected(request('approval_status')=='approved')>Approved</option>
                <option value="rejected" @selected(request('approval_status')=='rejected')>Rejected</option>
            </select>
        </div>
        <div class="col-md-2 d-grid"><button class="btn btn-primary">Filter</button></div>
    </div>
</form>

<div class="card p-3">
    <table class="table align-middle">
        <thead><tr><th>Title</th><th>Employer</th><th>Status</th><th>Approval</th><th>Applicants</th><th>Posted</th><th></th></tr></thead>
        <tbody>
        @forelse($internships as $i)
            <tr>
                <td>{{ $i->title }}</td>
                <td>{{ $i->employer->company_name }}</td>
                <td class="text-capitalize">{{ $i->status }}</td>
                <td><x-status-badge :status="$i->approval_status" /></td>
                <td>{{ $i->applications()->count() }}</td>
                <td>{{ $i->created_at->format('M d, Y') }}</td>
                <td>
                    <form method="POST" action="{{ route('admin.internships.delete', $i) }}" onsubmit="return confirm('Delete this internship record?')">
                        @csrf @method('DELETE')
                        <button class="btn btn-sm btn-outline-danger">Delete</button>
                    </form>
                </td>
            </tr>
        @empty
            <tr><td colspan="7" class="text-muted text-center py-4">No internship records found.</td></tr>
        @endforelse
        </tbody>
    </table>
</div>
<div class="mt-3">{{ $internships->links() }}</div>
@endsection
