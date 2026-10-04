@extends('layouts.app')
@section('title', 'Manage Users')

@section('content')
<div class="d-flex justify-content-between align-items-center mb-4">
    <h3 class="section-title mb-0">Manage Users</h3>
    <a href="{{ route('admin.users.create') }}" class="btn btn-accent"><i class="bi bi-person-plus me-1"></i>Create User</a>
</div>

<form method="GET" class="card p-3 mb-3">
    <div class="row g-2">
        <div class="col-md-4">
            <input type="text" name="keyword" value="{{ request('keyword') }}" class="form-control" placeholder="Search name or email">
        </div>
        <div class="col-md-3">
            <select name="role" class="form-select">
                <option value="">All Roles</option>
                <option value="student" @selected(request('role')=='student')>Student</option>
                <option value="employer" @selected(request('role')=='employer')>Employer</option>
                <option value="coordinator" @selected(request('role')=='coordinator')>Coordinator</option>
                <option value="admin" @selected(request('role')=='admin')>Admin</option>
            </select>
        </div>
        <div class="col-md-2 d-grid">
            <button class="btn btn-primary">Filter</button>
        </div>
    </div>
</form>

<div class="card p-3">
    <table class="table align-middle">
        <thead><tr><th>Name</th><th>Email</th><th>Role</th><th>Status</th><th>Joined</th><th></th></tr></thead>
        <tbody>
        @forelse($users as $u)
            <tr>
                <td>{{ $u->name }}</td>
                <td>{{ $u->email }}</td>
                <td class="text-capitalize">{{ $u->role }}</td>
                <td>{!! $u->is_active ? '<span class="badge badge-status-approved">Active</span>' : '<span class="badge badge-status-rejected">Inactive</span>' !!}</td>
                <td>{{ $u->created_at->format('M d, Y') }}</td>
                <td class="text-end">
                    <form method="POST" action="{{ route('admin.users.toggle', $u) }}" class="d-inline">
                        @csrf @method('PATCH')
                        <button class="btn btn-sm btn-outline-secondary">{{ $u->is_active ? 'Deactivate' : 'Activate' }}</button>
                    </form>
                    <form method="POST" action="{{ route('admin.users.delete', $u) }}" class="d-inline" onsubmit="return confirm('Delete this user?')">
                        @csrf @method('DELETE')
                        <button class="btn btn-sm btn-outline-danger">Delete</button>
                    </form>
                </td>
            </tr>
        @empty
            <tr><td colspan="6" class="text-muted text-center py-4">No users found.</td></tr>
        @endforelse
        </tbody>
    </table>
</div>
<div class="mt-3">{{ $users->links() }}</div>
@endsection
