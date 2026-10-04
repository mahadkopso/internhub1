@extends('layouts.guest')

@section('title', 'Welcome')

@section('content')
<div class="ih-hero text-center">
    <div class="container">
        <span class="badge bg-white text-dark px-3 py-2 mb-3">Built for Universities</span>
        <h1 class="display-5 mb-3">Manage Student Internships, End to End</h1>
        <p class="lead col-lg-8 mx-auto mb-4">
            InternHub connects students, employers, and university internship coordinators on one platform &mdash;
            from application to final report, with full university oversight at every step.
        </p>
        <a href="{{ route('register') }}" class="btn btn-accent btn-lg px-4 me-2">Get Started</a>
        <a href="{{ route('login') }}" class="btn btn-outline-light btn-lg px-4">Log In</a>
    </div>
</div>

<div class="container py-5" id="features">
    <h2 class="text-center section-title mb-2">What Makes InternHub Different</h2>
    <p class="text-center text-muted mb-5">Purpose-built for academic internship programs &mdash; not just a job board.</p>
    <div class="row g-4">
        <div class="col-md-4">
            <div class="card h-100 p-4">
                <i class="bi bi-clipboard-check fs-1 text-primary mb-3"></i>
                <h5>Coordinator Approval Workflow</h5>
                <p class="text-muted mb-0">Every posting and placement is reviewed by a university internship coordinator before it's finalized &mdash; ensuring academic quality and credit eligibility.</p>
            </div>
        </div>
        <div class="col-md-4">
            <div class="card h-100 p-4">
                <i class="bi bi-file-earmark-text fs-1 text-success mb-3"></i>
                <h5>Internship Report Submission</h5>
                <p class="text-muted mb-0">Students submit weekly, monthly, and final reports directly through the platform, with structured coordinator feedback for every submission.</p>
            </div>
        </div>
        <div class="col-md-4">
            <div class="card h-100 p-4">
                <i class="bi bi-graph-up-arrow fs-1 text-warning mb-3"></i>
                <h5>Student Progress Monitoring</h5>
                <p class="text-muted mb-0">Coordinators track every active placement in real time &mdash; applications, reports, and milestones &mdash; from a single progress dashboard.</p>
            </div>
        </div>
        <div class="col-md-4">
            <div class="card h-100 p-4">
                <i class="bi bi-briefcase fs-1 text-primary mb-3"></i>
                <h5>Employer Portal</h5>
                <p class="text-muted mb-0">Employers post opportunities, review applicants, and communicate decisions &mdash; all within the university's vetted network.</p>
            </div>
        </div>
        <div class="col-md-4">
            <div class="card h-100 p-4">
                <i class="bi bi-mortarboard fs-1 text-success mb-3"></i>
                <h5>University-Based Management</h5>
                <p class="text-muted mb-0">Designed around academic terms, departments, and faculty oversight rather than generic recruiting.</p>
            </div>
        </div>
        <div class="col-md-4">
            <div class="card h-100 p-4">
                <i class="bi bi-bell fs-1 text-warning mb-3"></i>
                <h5>Real-Time Notifications</h5>
                <p class="text-muted mb-0">Students, employers, and coordinators stay informed at every step &mdash; application updates, approvals, and report feedback.</p>
            </div>
        </div>
    </div>
</div>
@endsection
