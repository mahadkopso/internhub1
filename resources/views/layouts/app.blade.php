<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>@yield('title', 'Dashboard') - InternHub</title>
    <meta name="csrf-token" content="{{ csrf_token() }}">
    <link href="https://cdn.jsdelivr.net/npm/bootstrap@5.3.3/dist/css/bootstrap.min.css" rel="stylesheet">
    <link rel="stylesheet" href="https://cdn.jsdelivr.net/npm/bootstrap-icons@1.11.3/font/bootstrap-icons.css">
    <link href="{{ asset('css/app.css') }}" rel="stylesheet">
</head>
<body>
    <nav class="navbar navbar-expand-lg navbar-dark ih-navbar sticky-top">
        <div class="container-fluid px-4">
            <a class="navbar-brand fw-bold" href="{{ route('dashboard') }}">
                <i class="bi bi-mortarboard-fill me-1"></i> InternHub
            </a>
            <button class="navbar-toggler" type="button" data-bs-toggle="collapse" data-bs-target="#mainNav">
                <span class="navbar-toggler-icon"></span>
            </button>
            <div class="collapse navbar-collapse" id="mainNav">
                <ul class="navbar-nav me-auto mb-2 mb-lg-0">
                    <li class="nav-item"><a class="nav-link" href="{{ route('dashboard') }}">Dashboard</a></li>

                    @auth
                        @if(auth()->user()->isStudent())
                            <li class="nav-item"><a class="nav-link" href="{{ route('internships.index') }}">Browse Internships</a></li>
                            <li class="nav-item"><a class="nav-link" href="{{ route('applications.index') }}">My Applications</a></li>
                            <li class="nav-item"><a class="nav-link" href="{{ route('reports.index') }}">My Reports</a></li>
                            <li class="nav-item"><a class="nav-link" href="{{ route('student.profile.edit') }}">Profile</a></li>
                        @endif

                        @if(auth()->user()->isEmployer())
                            <li class="nav-item"><a class="nav-link" href="{{ route('internships.manage') }}">My Postings</a></li>
                            <li class="nav-item"><a class="nav-link" href="{{ route('internships.create') }}">Post Internship</a></li>
                            <li class="nav-item"><a class="nav-link" href="{{ route('employer.profile.edit') }}">Company Profile</a></li>
                        @endif

                        @if(auth()->user()->isCoordinator())
                            <li class="nav-item"><a class="nav-link" href="{{ route('coordinator.applications.pending') }}">Applications</a></li>
                            <li class="nav-item"><a class="nav-link" href="{{ route('coordinator.internships.pending') }}">Postings</a></li>
                            <li class="nav-item"><a class="nav-link" href="{{ route('coordinator.progress') }}">Progress</a></li>
                            <li class="nav-item"><a class="nav-link" href="{{ route('coordinator.reports.index') }}">Reports</a></li>
                        @endif

                        @if(auth()->user()->isAdmin())
                            <li class="nav-item"><a class="nav-link" href="{{ route('admin.users') }}">Users</a></li>
                            <li class="nav-item"><a class="nav-link" href="{{ route('admin.internships') }}">Internships</a></li>
                            <li class="nav-item"><a class="nav-link" href="{{ route('admin.reports') }}">Reports</a></li>
                            <li class="nav-item"><a class="nav-link" href="{{ route('admin.settings') }}">Settings</a></li>
                        @endif
                    @endauth
                </ul>
                <ul class="navbar-nav align-items-lg-center">
                    @auth
                        <li class="nav-item dropdown">
                            <a class="nav-link position-relative" href="{{ route('notifications.index') }}">
                                <i class="bi bi-bell-fill"></i>
                                @php $unread = auth()->user()->unreadNotifications()->count(); @endphp
                                @if($unread > 0)
                                    <span class="position-absolute top-0 start-100 translate-middle badge rounded-pill bg-danger">{{ $unread }}</span>
                                @endif
                            </a>
                        </li>
                        <li class="nav-item dropdown">
                            <a class="nav-link dropdown-toggle" href="#" role="button" data-bs-toggle="dropdown">
                                <i class="bi bi-person-circle me-1"></i>{{ auth()->user()->name }}
                                <span class="badge text-bg-light text-dark ms-1 text-capitalize">{{ auth()->user()->role }}</span>
                            </a>
                            <ul class="dropdown-menu dropdown-menu-end">
                                <li>
                                    <form method="POST" action="{{ route('logout') }}">
                                        @csrf
                                        <button type="submit" class="dropdown-item">Logout</button>
                                    </form>
                                </li>
                            </ul>
                        </li>
                    @endauth
                </ul>
            </div>
        </div>
    </nav>

    <main class="py-4">
        <div class="container-fluid px-4">
            @if(session('status'))
                <div class="alert alert-success alert-dismissible fade show" role="alert">
                    {{ session('status') }}
                    <button type="button" class="btn-close" data-bs-dismiss="alert"></button>
                </div>
            @endif
            @if($errors->any())
                <div class="alert alert-danger alert-dismissible fade show" role="alert">
                    <ul class="mb-0">
                        @foreach($errors->all() as $error)
                            <li>{{ $error }}</li>
                        @endforeach
                    </ul>
                    <button type="button" class="btn-close" data-bs-dismiss="alert"></button>
                </div>
            @endif

            @yield('content')
        </div>
    </main>

    <footer class="text-center text-muted py-4 small">
        &copy; {{ date('Y') }} InternHub &mdash; University Internship Management System
    </footer>

    <script src="https://cdn.jsdelivr.net/npm/bootstrap@5.3.3/dist/js/bootstrap.bundle.min.js"></script>
</body>
</html>
