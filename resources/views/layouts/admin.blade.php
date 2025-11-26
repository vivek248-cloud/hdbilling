<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>@yield('title', 'HOME DEN Billing')</title>
    <link rel="icon" href="{{ asset('images/favicon.ico') }}" type="image/x-icon">

    <!-- Bootstrap 5.3 + Icons -->
    <link href="https://cdn.jsdelivr.net/npm/bootstrap@5.3.2/dist/css/bootstrap.min.css" rel="stylesheet">
    <link href="https://cdn.jsdelivr.net/npm/bootstrap-icons@1.11.1/font/bootstrap-icons.css" rel="stylesheet">

    <!-- Poppins Font -->
    <link href="https://fonts.googleapis.com/css2?family=Poppins:wght@400;500;600;700&display=swap" rel="stylesheet">

    <style>
        :root {
            --primary: #00d084;
            --danger: #dc3545;
            --danger-dark: #c82333;
            --bg-light: #f8f9fa;
            --bg-dark: #121212;
            --surface-light: #ffffff;
            --surface-dark: #1e1e1e;
            --text-light: #212529;
            --text-dark: #e4e4e4;
        }

        html, body {
            height: 100%;
            margin: 0;
            font-family: 'Poppins', sans-serif;
            background: var(--bg-light);
            color: var(--text-light);
            display: flex;
            flex-direction: column;
            transition: background .3s, color .3s;
        }

        /* Dark Mode */
        body.dark-mode {
            background: var(--bg-dark);
            color: var(--text-dark);
        }
        body.dark-mode .container { background: var(--surface-dark); color: var(--text-dark); }
        body.dark-mode .navbar { background: linear-gradient(90deg, #000, #1a1a1a) !important; }
        body.dark-mode .table th { background: var(--primary); }
        body.dark-mode footer { background: linear-gradient(90deg, #000, #1a1a1a); color: var(--text-dark); }

        /* Navbar */
        .navbar {
            background: linear-gradient(90deg, #212529, #343a40);
            box-shadow: 0 2px 6px rgba(0,0,0,.3);
        }
        .navbar-brand img {
            height: 40px;
            width: auto;
            border-radius: 8px;
            transition: transform .3s;
        }
        .navbar-brand:hover img { transform: scale(1.1); }
        .navbar-brand span {
            font-weight: 600;
            letter-spacing: 1px;
            color: #f8f9fa;
        }
        .nav-link {
            color: #f8f9fa !important;
            font-weight: 500;
            transition: color .2s, background .2s;
        }
        .nav-link:hover,
        .nav-link.active {
            color: var(--primary) !important;
            border-bottom: 2px solid var(--primary);
            border-radius: 8px;
        }

        /* Logout Button */
        .btn-logout {
            background: var(--danger);
            color: #fff !important;
            border: none;
            border-radius: 2rem;
            padding: .4rem 1rem;
            font-weight: 500;
            transition: all .2s;
            display: flex;
            align-items: center;
            gap: .4rem;
        }
        .btn-logout:hover {
            background: var(--danger-dark);
            transform: translateY(-1px);
        }

        /* Dark Mode Toggle */
        #darkModeToggle, #darkModeToggleMobile {
            width: 38px; height: 38px;
            border-radius: 50%;
            background: rgba(255,255,255,.15);
            border: none;
            color: #fff;
            font-size: 1.1rem;
            transition: background .2s;
        }
        #darkModeToggle:hover, #darkModeToggleMobile:hover { background: rgba(255,255,255,.25); }

        /* Page layout */
        main { flex: 1; padding-top: 80px; }
        .container .container{
            background: var(--surface-light);
            border-radius: 12px;
            padding: 1.5rem;
            box-shadow: 0 2px 8px rgba(0,0,0,.08);
        }
        .table { border-radius: 10px; overflow: hidden; }
        .table th { background: var(--primary); color: #fff; }

        /* Footer */
        footer {
            text-align: center;
            padding: 1rem;
            background: linear-gradient(90deg, #212529, #343a40);
            color: #fff;
            border-top: 6px double #fff;
            font-size: .9rem;
        }

        /* Off-canvas (RIGHT side on mobile) */
        .offcanvas {
            width: 280px !important;
            background: #212529;
        }
        .offcanvas-header { border-bottom: 1px solid rgba(255,255,255,.1); }
        .offcanvas-title { color: #fff; font-weight: 600; }
        .offcanvas .nav-link {
            color: #ddd !important;
            padding: .75rem 1.5rem;
            font-weight: 500;
        }
        .offcanvas .nav-link:hover,
        .offcanvas .nav-link.active {
            background: rgba(0,208,132,.15);
            color: var(--primary) !important;
            padding-left: 2rem;
        }
        body.dark-mode .offcanvas { background: #000; }


        #productTable th, 
        #productTable td {
            vertical-align: middle;
            text-align: center;
            white-space: nowrap;
            padding: 6px 8px;
            font-size: 14px;
        }

        #productTable input, 
        #productTable select {
            width: 100%;
            font-size: 13px;
            padding: 4px 6px;
        }

        .table-responsive {
            border-radius: 6px;
            border: 1px solid #ddd;
            background: #fff;
            overflow-x: auto;
            overflow-y: hidden;
        }

        .table-secondary th {
            text-align: center;
            background-color: #f8f9fa;
            color: #333;
            font-weight: 600;
        }


        @media (max-width: 576px) {
            .offcanvas { width: 100% !important; }
        }


    </style>
</head>
<body>

<!-- ====================== NAVBAR ====================== -->
<nav class="navbar navbar-expand-lg navbar-dark fixed-top">
    <div class="container-fluid">

        <!-- Brand (centered on mobile) -->
        <a class="navbar-brand mx-auto mx-lg-0" href="{{ url('/') }}">
            <img src="{{ asset('images/logo.png') }}" alt="Logo">
            <span>HOME DEN INVOICE</span>
        </a>

        <!-- Hamburger (mobile) – opens RIGHT off-canvas -->
        <button class="navbar-toggler d-lg-none ms-auto" type="button" data-bs-toggle="offcanvas" data-bs-target="#rightMenu">
            <span class="navbar-toggler-icon"></span>
        </button>

        <!-- Desktop: Left Menu + Right Actions -->
        <div class="collapse navbar-collapse" id="navbarNav">
            <!-- LEFT: Menu Items -->
            <ul class="navbar-nav me-auto mb-2 mb-lg-0 px-5">
                @auth
                    @if(Auth::user()->role === 'admin')
                        <li class="nav-item">
                            <a class="nav-link {{ request()->is('admin/dashboard') ? 'active' : '' }}"
                               href="{{ route('admin.dashboard') }}">
                                <i class="bi bi-speedometer2 me-2"></i> Dashboard
                            </a>
                        </li>
                        <li class="nav-item">
                            <a class="nav-link {{ Route::is('users.*') ? 'active' : '' }}"
                               href="{{ route('users.index') }}">
                                <i class="bi bi-people me-2"></i> Users
                            </a>
                        </li>
                        <li class="nav-item">
                            <a class="nav-link {{ request()->is('admin/projects') ? 'active' : '' }}"
                               href="{{ route('projects.index') }}">
                                <i class="bi bi-kanban me-2"></i> Projects
                            </a>
                        </li>
                        <li class="nav-item">
                            <a class="nav-link {{ request()->is('admin/expenses*') ? 'active' : '' }}"
                               href="{{ route('expenses.index') }}">
                                <i class="bi bi-receipt me-2"></i> Cost
                            </a>
                        </li>
                        <li class="nav-item">
                            <a class="nav-link {{ request()->is('admin/payments*') ? 'active' : '' }}"
                               href="{{ route('payments.index') }}">
                                <i class="bi bi-cash-stack me-2"></i> Payments
                            </a>
                        </li>
                        <li class="nav-item">
                            <a class="nav-link {{ request()->is('customers*') ? 'active' : '' }}"
                            href="{{ route('customers.index') }}">
                            <i class="bi bi-people"></i> Quotations
                            </a>
                        </li>
                    @else
                        <li class="nav-item">
                            <a class="nav-link {{ request()->is('client/dashboard') ? 'active' : '' }}"
                               href="{{ route('client.dashboard') }}">
                                <i class="bi bi-house-door me-2"></i> Dashboard
                            </a>
                        </li>
                    @endif
                @endauth
            </ul>

            <!-- RIGHT: Auth Actions -->
            <ul class="navbar-nav ms-auto align-items-center gap-2">
                @guest
                    <li class="nav-item">
                        <a class="nav-link" href="{{ route('login') }}">
                            <i class="bi bi-box-arrow-in-right"></i> Login
                        </a>
                    </li>
                @else
                    <li class="nav-item">
                        <form method="POST" action="{{ route('logout') }}" class="d-inline">
                            @csrf
                            <button type="submit" class="btn btn-logout">
                                <i class="bi bi-box-arrow-right"></i>
                                Logout ({{ Auth::user()->name }})
                            </button>
                        </form>
                    </li>

                    <li class="nav-item">
                        <button id="darkModeToggle" class="btn" title="Toggle Dark Mode">
                            <i class="bi bi-moon-fill"></i>
                        </button>
                    </li>
                @endguest
            </ul>
        </div>
    </div>
</nav>

<!-- ====================== OFF-CANVAS (RIGHT SIDE - MOBILE) ====================== -->
<div class="offcanvas offcanvas-end" tabindex="-1" id="rightMenu">
    <div class="offcanvas-header">
        <h5 class="offcanvas-title">Menu</h5>
        <button type="button" class="btn-close btn-close-white" data-bs-dismiss="offcanvas"></button>
    </div>
    <div class="offcanvas-body">
        <ul class="nav flex-column">
            @auth
                @if(Auth::user()->role === 'admin')
                    <li class="nav-item">
                        <a class="nav-link {{ request()->is('admin/dashboard') ? 'active' : '' }}"
                           href="{{ route('admin.dashboard') }}">
                            <i class="bi bi-speedometer2"></i> Dashboard
                        </a>
                    </li>
                    <li class="nav-item">
                        <a class="nav-link {{ Route::is('users.*') ? 'active' : '' }}"
                           href="{{ route('users.index') }}">
                            <i class="bi bi-people"></i> Users
                        </a>
                    </li>
                    <li class="nav-item">
                        <a class="nav-link {{ request()->is('admin/projects') ? 'active' : '' }}"
                           href="{{ route('projects.index') }}">
                            <i class="bi bi-kanban"></i> Projects
                        </a>
                    </li>
                    <li class="nav-item">
                        <a class="nav-link {{ request()->is('admin/expenses*') ? 'active' : '' }}"
                           href="{{ route('expenses.index') }}">
                            <i class="bi bi-receipt"></i> Cost
                        </a>
                    </li>
                    <li class="nav-item">
                        <a class="nav-link {{ request()->is('admin/payments*') ? 'active' : '' }}"
                           href="{{ route('payments.index') }}">
                            <i class="bi bi-cash-stack"></i> Payments
                        </a>
                    </li>
                    <li class="nav-item">
                        <a class="nav-link {{ request()->is('customers*') ? 'active' : '' }}"
                            href="{{ route('customers.index') }}">
                        <i class="bi bi-people"></i> Quotations
                        </a>
                    </li>


                    
                @else
                    <li class="nav-item">
                        <a class="nav-link {{ request()->is('client/dashboard') ? 'active' : '' }}"
                           href="{{ route('client.dashboard') }}">
                            <i class="bi bi-house-door"></i> Dashboard
                        </a>
                    </li>
                @endif
            @endauth

            <hr class="my-4 border-secondary">

            <div class="px-3">
                <div class="d-flex align-items-center justify-content-between mb-3">
                    <button id="darkModeToggleMobile" class="btn btn-sm btn-outline-light rounded-pill w-100">
                        <i class="bi bi-moon-fill"></i>
                    </button>
                </div>

                @guest
                    <a href="{{ route('login') }}" class="btn btn-outline-light w-100">
                        <i class="bi bi-box-arrow-in-right"></i> Login
                    </a>
                @else
                    <form method="POST" action="{{ route('logout') }}" class="d-inline w-100" style="text-align: center;">
                        @csrf
                        <button type="submit" class="btn btn-logout w-100 text-center">
                            <i class="bi bi-box-arrow-right"></i>
                            Logout ({{ Auth::user()->name }})
                        </button>
                    </form>
                @endguest
            </div>
        </ul>
    </div>
</div>

<!-- ====================== MAIN CONTENT ====================== -->
<main>
    <div class="container">
        @yield('content')
    </div>
</main>

<!-- ====================== FOOTER ====================== -->
<footer>
    © {{ date('Y') }} Home Den Billing. All rights reserved.
</footer>

<!-- ====================== SCRIPTS ====================== -->
<script src="https://cdn.jsdelivr.net/npm/bootstrap@5.3.2/dist/js/bootstrap.bundle.min.js"></script>

<script>
    const body = document.body;
    const toggleDesktop = document.getElementById('darkModeToggle');
    const toggleMobile = document.getElementById('darkModeToggleMobile');

    const applyDarkMode = (enable) => {
        if (enable) {
            body.classList.add('dark-mode');
            [toggleDesktop, toggleMobile].forEach(btn => {
                if (btn) btn.innerHTML = '<i class="bi bi-sun-fill"></i>';
            });
            localStorage.setItem('dark-mode', 'enabled');
        } else {
            body.classList.remove('dark-mode');
            [toggleDesktop, toggleMobile].forEach(btn => {
                if (btn) btn.innerHTML = '<i class="bi bi-moon-fill"></i>';
            });
            localStorage.setItem('dark-mode', 'disabled');
        }
    };

    // Init
    const saved = localStorage.getItem('dark-mode');
    const prefersDark = window.matchMedia('(prefers-color-scheme: dark)').matches;
    applyDarkMode(saved === 'enabled' || (!saved && prefersDark));

    // Listeners
    [toggleDesktop, toggleMobile].forEach(btn => {
        btn?.addEventListener('click', () => {
            applyDarkMode(!body.classList.contains('dark-mode'));
        });
    });

    // Close offcanvas on outside click
    document.addEventListener('click', e => {
        const canvas = document.getElementById('rightMenu');
        if (window.innerWidth < 992 && canvas.classList.contains('show')) {
            const inside = canvas.contains(e.target) || e.target.closest('.navbar-toggler');
            if (!inside) bootstrap.Offcanvas.getInstance(canvas)?.hide();
        }
    });
</script>
</body>
</html>