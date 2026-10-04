@extends('layouts.app')
@section('title', 'Admin Dashboard')

@section('content')
<div class="mb-4">
    <h3 class="section-title mb-0">Administrator Dashboard</h3>
    <p class="text-muted mb-0">System-wide overview and management.</p>
</div>

<div class="row g-3 mb-4">
    <x-stat-card label="Total Users" :value="$stats['total_users']" icon="bi-people-fill" />
    <x-stat-card label="Students" :value="$stats['total_students']" icon="bi-mortarboard" variant="teal" />
    <x-stat-card label="Employers" :value="$stats['total_employers']" icon="bi-building" />
    <x-stat-card label="Coordinators" :value="$stats['total_coordinators']" icon="bi-person-badge" variant="accent" />
</div>
<div class="row g-3 mb-4">
    <x-stat-card label="Total Internships" :value="$stats['total_internships']" icon="bi-briefcase" />
    <x-stat-card label="Open Internships" :value="$stats['open_internships']" icon="bi-unlock" variant="teal" />
    <x-stat-card label="Applications" :value="$stats['total_applications']" icon="bi-send" />
    <x-stat-card label="Reports Submitted" :value="$stats['total_reports']" icon="bi-file-earmark-text" variant="accent" />
</div>

<div class="row g-4">
    <div class="col-lg-8">
        <div class="card p-4">
            <div class="d-flex justify-content-between align-items-center mb-3">
                <h5 class="mb-0">Recently Registered Users</h5>
                <a href="{{ route('admin.users') }}" class="small">Manage all users</a>
            </div>
            <table class="table align-middle">
                <thead><tr><th>Name</th><th>Email</th><th>Role</th><th>Status</th></tr></thead>
                <tbody>
                @foreach($recentUsers as $u)
                    <tr>
                        <td>{{ $u->name }}</td>
                        <td>{{ $u->email }}</td>
                        <td class="text-capitalize">{{ $u->role }}</td>
                        <td>{!! $u->is_active ? '<span class="badge badge-status-approved">Active</span>' : '<span class="badge badge-status-rejected">Inactive</span>' !!}</td>
                    </tr>
                @endforeach
                </tbody>
            </table>
        </div>
    </div>
    <div class="col-lg-4">
        <div class="card p-4">
            <h6 class="mb-3">Quick Links</h6>
            <div class="d-grid gap-2">
                <a href="{{ route('admin.users.create') }}" class="btn btn-outline-primary btn-sm"><i class="bi bi-person-plus me-1"></i>Create User</a>
                <a href="{{ route('admin.internships') }}" class="btn btn-outline-primary btn-sm"><i class="bi bi-briefcase me-1"></i>Internship Records</a>
                <a href="{{ route('admin.reports') }}" class="btn btn-outline-primary btn-sm"><i class="bi bi-bar-chart me-1"></i>System Reports</a>
                <a href="{{ route('admin.settings') }}" class="btn btn-outline-primary btn-sm"><i class="bi bi-gear me-1"></i>System Settings</a>
            </div>
        </div>
    </div>
</div>
@endsection
