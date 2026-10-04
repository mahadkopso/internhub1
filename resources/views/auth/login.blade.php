@extends('layouts.guest')

@section('title', 'Log In')

@section('content')
<div class="container py-5">
    <div class="row justify-content-center">
        <div class="col-md-5">
            <div class="card p-4">
                <h3 class="section-title mb-1">Welcome Back</h3>
                <p class="text-muted mb-4">Log in to your InternHub account</p>

                <form method="POST" action="{{ route('login') }}">
                    @csrf
                    <div class="mb-3">
                        <label class="form-label">Email address</label>
                        <input type="email" name="email" value="{{ old('email') }}" class="form-control @error('email') is-invalid @enderror" required autofocus>
                        @error('email') <div class="invalid-feedback">{{ $message }}</div> @enderror
                    </div>
                    <div class="mb-3">
                        <label class="form-label">Password</label>
                        <input type="password" name="password" class="form-control" required>
                    </div>
                    <div class="mb-3 form-check">
                        <input type="checkbox" name="remember" class="form-check-input" id="remember">
                        <label class="form-check-label" for="remember">Remember me</label>
                    </div>
                    <button type="submit" class="btn btn-accent w-100">Log In</button>
                </form>

                <hr>
                <p class="text-center text-muted small mb-1">Demo accounts (password: <code>password</code>)</p>
                <ul class="small text-muted mb-3">
                    <li>Student: student@internhub.test</li>
                    <li>Employer: employer@internhub.test</li>
                    <li>Coordinator: coordinator@internhub.test</li>
                    <li>Admin: admin@internhub.test</li>
                </ul>
                <p class="text-center mb-0">No account? <a href="{{ route('register') }}">Sign up</a></p>
            </div>
        </div>
    </div>
</div>
@endsection
