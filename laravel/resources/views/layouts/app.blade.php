<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Haier DOP Portal</title>
    <link rel="stylesheet" href="https://cdn.jsdelivr.net/npm/bootstrap@5.3.3/dist/css/bootstrap.min.css">
    <link rel="stylesheet" href="https://cdn.jsdelivr.net/npm/bootstrap-icons@1.11.3/font/bootstrap-icons.css">
    <link rel="stylesheet" href="https://cdn.datatables.net/1.13.6/css/jquery.dataTables.min.css">
    <link rel="stylesheet" href="https://cdn.datatables.net/1.13.6/css/dataTables.bootstrap5.min.css">
    <link rel="stylesheet" href="https://cdn.datatables.net/responsive/2.5.0/css/responsive.bootstrap5.min.css">
    <style>
        /* Small visual tweaks for cleaner UI */
        body { padding-top: 0; font-size: 0.95rem; }
        .navbar-brand { font-size: 1.25rem; }
        .card-header { background: #f8f9fa; }
        .table thead th { background: #f1f5f9; }
        .badge { font-size: 0.85em; }
        .input-group .toggle-password { border-left: 1px solid rgba(0,0,0,0.08); }
        .container { max-width: 1100px; }
    </style>
</head>
<body class="bg-light">
    <nav class="navbar navbar-expand-lg navbar-dark bg-primary mb-4">
        <div class="container">
            <a class="navbar-brand fw-bold" href="{{ auth('admin')->check() ? route('admin.dashboard') : url('/') }}">
                Haier DOP Portal
            </a>
            <div class="d-flex gap-2">
                @php
                    // Prefer the framework request check, but fall back to raw URI when needed
                    $path = request()->getPathInfo() ?? ($_SERVER['REQUEST_URI'] ?? '/');
                    $currentRoute = Route::currentRouteName() ?? null;
                    $isAdminArea = str_starts_with($path, '/admin') || request()->is('admin/*') || str_starts_with($currentRoute ?? '', 'admin.');
                    // detect auth-related pages so we don't show login/signup links when already on them
                    $isUserAuthPage = in_array($currentRoute, ['login', 'signup', 'password.reset']);
                    $isAdminAuthPage = $currentRoute === 'admin.login' || request()->is('admin/login');
                @endphp

                @if($isAdminArea)
                    @auth('admin')
                        <a href="{{ route('admin.form') }}" class="btn btn-outline-light btn-sm me-2">Submit Request</a>
                        <a href="{{ route('admin.requests.mine') }}" class="btn btn-outline-light btn-sm me-2">My Requests</a>
                        <a href="{{ route('admin.dashboard') }}" class="btn btn-outline-light btn-sm me-2">Admin Dashboard</a>
                        <form method="POST" action="{{ route('admin.logout') }}" class="d-inline">
                            @csrf
                            <button class="btn btn-outline-light btn-sm">Logout (Admin)</button>
                        </form>
                    @else
                        {{-- don't show Admin Login link if already on admin login page --}}
                        @unless($isAdminAuthPage)
                            <a href="{{ route('admin.login') }}" class="btn btn-outline-light btn-sm me-2">Admin Login</a>
                        @endunless
                    @endauth
                @else
                    @auth('web')
                        <a href="{{ route('user.requests') }}" class="btn btn-outline-light btn-sm me-2">My Requests</a>
                        <form method="POST" action="{{ route('logout') }}" class="d-inline">
                            @csrf
                            <button class="btn btn-outline-light btn-sm">Logout</button>
                        </form>
                    @else
                        {{-- hide login/signup links when already on those pages to avoid confusion --}}
                        @unless($isUserAuthPage)
                            <a href="{{ route('login') }}" class="btn btn-outline-light btn-sm me-2">Login</a>
                            <a href="{{ route('signup') }}" class="btn btn-outline-light btn-sm">Sign Up</a>
                        @endunless
                    @endauth
                @endif
            </div>
        </div>
    </nav>

    <main class="container mb-5">
        @if(session('success'))
            <div class="alert alert-success">{{ session('success') }}</div>
        @endif
        @if($errors->any())
            <div class="alert alert-danger">
                <ul class="mb-0">
                    @foreach($errors->all() as $error)
                        <li>{{ $error }}</li>
                    @endforeach
                </ul>
            </div>
        @endif
        @yield('content')
    </main>
    <script src="https://code.jquery.com/jquery-3.7.1.min.js"></script>
    <script src="https://cdn.jsdelivr.net/npm/bootstrap@5.3.3/dist/js/bootstrap.bundle.min.js"></script>
    <script src="https://cdn.datatables.net/1.13.6/js/jquery.dataTables.min.js"></script>
    <script src="https://cdn.datatables.net/1.13.6/js/dataTables.bootstrap5.min.js"></script>
    <script src="https://cdn.datatables.net/responsive/2.5.0/js/dataTables.responsive.min.js"></script>
    <script src="https://cdn.datatables.net/responsive/2.5.0/js/responsive.bootstrap5.min.js"></script>
    <script>
        // Toggle password visibility for inputs with a matching data-target button (uses bootstrap icons)
        document.addEventListener('click', function (e) {
            const btn = e.target.closest('.toggle-password');
            if (!btn) return;
            const target = document.querySelector(btn.getAttribute('data-target'));
            if (!target) return;
            const icon = btn.querySelector('i');
            if (target.type === 'password') {
                target.type = 'text';
                if (icon) { icon.classList.remove('bi-eye'); icon.classList.add('bi-eye-slash'); }
            } else {
                target.type = 'password';
                if (icon) { icon.classList.remove('bi-eye-slash'); icon.classList.add('bi-eye'); }
            }
        });
    </script>
</body>
</html>
