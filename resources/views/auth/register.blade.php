@extends('layouts.guest')

@section('title', 'Sign Up')

@section('content')
<div class="container py-5">
    <div class="row justify-content-center">
        <div class="col-md-7">
            <div class="card p-4">
                <h3 class="section-title mb-1">Create Your Account</h3>
                <p class="text-muted mb-4">Coordinator and Administrator accounts are provisioned by the university &mdash; sign up here as a Student or Employer.</p>

                <ul class="nav nav-pills mb-3" id="accountTabs">
                    <li class="nav-item"><button class="nav-link active" data-bs-toggle="pill" data-bs-target="#student-tab" type="button">I'm a Student</button></li>
                    <li class="nav-item"><button class="nav-link" data-bs-toggle="pill" data-bs-target="#employer-tab" type="button">I'm an Employer</button></li>
                </ul>

                <form method="POST" action="{{ route('register') }}" id="registerForm">
                    @csrf
                    <div class="tab-content">
                        <div class="tab-pane fade show active" id="student-tab">
                            <input type="hidden" name="account_type" id="accType" value="student">
                        </div>
                    </div>

                    <div class="row g-3 mb-3">
                        <div class="col-md-6">
                            <label class="form-label">Full Name</label>
                            <input type="text" name="name" value="{{ old('name') }}" class="form-control" required>
                        </div>
                        <div class="col-md-6">
                            <label class="form-label">Email address</label>
                            <input type="email" name="email" value="{{ old('email') }}" class="form-control" required>
                        </div>
                        <div class="col-md-6">
                            <label class="form-label">Password</label>
                            <input type="password" name="password" class="form-control" required minlength="8">
                        </div>
                        <div class="col-md-6">
                            <label class="form-label">Confirm Password</label>
                            <input type="password" name="password_confirmation" class="form-control" required>
                        </div>
                        <div class="col-md-6">
                            <label class="form-label">Phone (optional)</label>
                            <input type="text" name="phone" value="{{ old('phone') }}" class="form-control">
                        </div>
                    </div>

                    <div id="studentFields">
                        <h6 class="text-muted mb-2">Student Details</h6>
                        <div class="row g-3 mb-3">
                            <div class="col-md-6">
                                <label class="form-label">Student ID Number</label>
                                <input type="text" name="student_id_number" value="{{ old('student_id_number') }}" class="form-control">
                            </div>
                            <div class="col-md-6">
                                <label class="form-label">University</label>
                                <input type="text" name="university" value="{{ old('university') }}" class="form-control">
                            </div>
                            <div class="col-md-4">
                                <label class="form-label">Department</label>
                                <input type="text" name="department" value="{{ old('department') }}" class="form-control">
                            </div>
                            <div class="col-md-4">
                                <label class="form-label">Program</label>
                                <input type="text" name="program" value="{{ old('program') }}" class="form-control">
                            </div>
                            <div class="col-md-4">
                                <label class="form-label">Year of Study</label>
                                <input type="number" name="year_of_study" min="1" max="8" value="{{ old('year_of_study') }}" class="form-control">
                            </div>
                        </div>
                    </div>

                    <div id="employerFields" class="d-none">
                        <h6 class="text-muted mb-2">Company Details</h6>
                        <div class="row g-3 mb-3">
                            <div class="col-md-6">
                                <label class="form-label">Company Name</label>
                                <input type="text" name="company_name" value="{{ old('company_name') }}" class="form-control">
                            </div>
                            <div class="col-md-6">
                                <label class="form-label">Industry</label>
                                <input type="text" name="industry" value="{{ old('industry') }}" class="form-control">
                            </div>
                        </div>
                    </div>

                    <button type="submit" class="btn btn-accent w-100">Create Account</button>
                </form>
                <p class="text-center mt-3 mb-0">Already have an account? <a href="{{ route('login') }}">Log in</a></p>
            </div>
        </div>
    </div>
</div>

<script>
    document.querySelectorAll('#accountTabs button').forEach(btn => {
        btn.addEventListener('click', function () {
            const isStudent = this.dataset.bsTarget === '#student-tab';
            document.getElementById('accType').value = isStudent ? 'student' : 'employer';
            document.getElementById('studentFields').classList.toggle('d-none', !isStudent);
            document.getElementById('employerFields').classList.toggle('d-none', isStudent);
        });
    });
</script>
@endsection
