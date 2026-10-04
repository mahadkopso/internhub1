<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>@yield('title', 'Welcome') - InternHub</title>
    <link href="https://cdn.jsdelivr.net/npm/bootstrap@5.3.3/dist/css/bootstrap.min.css" rel="stylesheet">
    <link rel="stylesheet" href="https://cdn.jsdelivr.net/npm/bootstrap-icons@1.11.3/font/bootstrap-icons.css">
    <link href="{{ asset('css/app.css') }}" rel="stylesheet">
</head>
<body class="ih-guest-body">
    <nav class="navbar navbar-expand-lg navbar-dark ih-navbar">
        <div class="container">
            <a class="navbar-brand fw-bold" href="{{ route('home') }}"><i class="bi bi-mortarboard-fill me-1"></i> InternHub</a>
            <button class="navbar-toggler" type="button" data-bs-toggle="collapse" data-bs-target="#guestNav">
                <span class="navbar-toggler-icon"></span>
            </button>
            <div class="collapse navbar-collapse" id="guestNav">
                <ul class="navbar-nav ms-auto align-items-lg-center gap-lg-2">
                    <li class="nav-item"><a class="nav-link" href="{{ route('home') }}#features">Features</a></li>
                    <li class="nav-item"><a class="nav-link" href="{{ route('login') }}">Log in</a></li>
                    <li class="nav-item"><a class="btn btn-light btn-sm px-3" href="{{ route('register') }}">Sign up</a></li>
                </ul>
            </div>
        </div>
    </nav>

    @if(session('status'))
        <div class="container mt-3">
            <div class="alert alert-success">{{ session('status') }}</div>
        </div>
    @endif

    @yield('content')

    <footer class="text-center text-muted py-4 small border-top mt-5">
        &copy; {{ date('Y') }} InternHub &mdash; University Internship Management System
    </footer>
    <script src="https://cdn.jsdelivr.net/npm/bootstrap@5.3.3/dist/js/bootstrap.bundle.min.js"></script>
</body>
</html>
