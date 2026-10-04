@extends('layouts.app')
@section('title', 'Create User')

@section('content')
<h3 class="section-title mb-4">Create New User</h3>
<div class="card p-4">
    <form method="POST" action="{{ route('admin.users.store') }}">
        @csrf
        <div class="row g-3">
            <div class="col-md-6">
                <label class="form-label">Full Name</label>
                <input type="text" name="name" class="form-control" required>
            </div>
            <div class="col-md-6">
                <label class="form-label">Email</label>
                <input type="email" name="email" class="form-control" required>
            </div>
            <div class="col-md-6">
                <label class="form-label">Password</label>
                <input type="password" name="password" class="form-control" required minlength="8">
            </div>
            <div class="col-md-6">
                <label class="form-label">Role</label>
                <select name="role" class="form-select" required>
                    <option value="student">Student</option>
                    <option value="employer">Employer</option>
                    <option value="coordinator">Internship Coordinator</option>
                    <option value="admin">Administrator</option>
                </select>
            </div>
            <div class="col-md-6">
                <label class="form-label">Phone (optional)</label>
                <input type="text" name="phone" class="form-control">
            </div>
        </div>
        <button type="submit" class="btn btn-accent mt-4">Create User</button>
    </form>
</div>
@endsection
