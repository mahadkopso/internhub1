@extends('layouts.app')
@section('title', 'My Applications')

@section('content')
<h3 class="section-title mb-4">My Applications</h3>

<div class="card p-3">
    <table class="table align-middle">
        <thead>
            <tr><th>Internship</th><th>Employer</th><th>Employer Status</th><th>Coordinator Status</th><th>Overall Status</th><th>Applied</th><th></th></tr>
        </thead>
        <tbody>
        @forelse($applications as $app)
            <tr>
                <td>{{ $app->internship->title }}</td>
                <td>{{ $app->internship->employer->company_name }}</td>
                <td><x-status-badge :status="$app->employer_status" /></td>
                <td><x-status-badge :status="$app->coordinator_status" /></td>
                <td><x-status-badge :status="$app->status" /></td>
                <td>{{ $app->applied_at->format('M d, Y') }}</td>
                <td>
                    @if(in_array($app->status, ['pending','under_review']))
                        <form method="POST" action="{{ route('applications.withdraw', $app) }}" onsubmit="return confirm('Withdraw this application?')">
                            @csrf @method('PATCH')
                            <button class="btn btn-sm btn-outline-danger">Withdraw</button>
                        </form>
                    @endif
                </td>
            </tr>
        @empty
            <tr><td colspan="7" class="text-muted text-center py-4">You haven't applied to any internships yet. <a href="{{ route('internships.index') }}">Browse opportunities</a>.</td></tr>
        @endforelse
        </tbody>
    </table>
</div>
<div class="mt-3">{{ $applications->links() }}</div>
@endsection
