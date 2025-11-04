<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>@yield('title', 'HOME DEN Billing - Client')</title>
    <link rel="icon" href="{{ asset('images/favicon.ico') }}" type="image/x-icon">
    
    <!-- Bootstrap CSS -->
    <link href="https://cdn.jsdelivr.net/npm/bootstrap@5.3.2/dist/css/bootstrap.min.css" rel="stylesheet">
    <!-- Bootstrap Icons -->
    <link href="https://cdn.jsdelivr.net/npm/bootstrap-icons@1.11.1/font/bootstrap-icons.css" rel="stylesheet">
    <!-- Google Fonts -->
    <link href="https://fonts.googleapis.com/css2?family=Poppins:wght@400;500;600;700&display=swap" rel="stylesheet">

    <style>
        body {
            font-family: 'Poppins', sans-serif;
            background: #f4f6f9;
            transition: background 0.3s ease, color 0.3s ease;
        }

        /* Navbar */
        .navbar {
            background: linear-gradient(90deg, #212529, #343a40);
            box-shadow: 0 4px 15px rgba(0,0,0,0.1);
        }
        .navbar-brand img {
            height: 40px;
            width: 40px;
            object-fit: contain;
        }
        .navbar-brand span {
            color: #ffffff;
            font-weight: 600;
            font-size: 1rem;
            letter-spacing: 0.5px;
        }
        .nav-link {
            color: #ddd !important;
            font-weight: 500;
        }
        .nav-link.active {
            font-weight: 600;
            color: #00d084 !important;
        }
        .nav-link:hover {
            color: #00d084 !important;
        }

        /* Logout Button */
        .btn-logout {
            border-radius: 50px;
            padding: 0.35rem 1rem;
            font-weight: 500;
            transition: all 0.3s ease;
        }
        .btn-logout:hover {
            background-color: #d05e00;
            color: #fff !important;
            transform: translateY(-2px);
        }

        /* Tables */
        .custom-table {
            border: 1px solid #dee2e6;
            border-radius: 0.75rem;
            overflow: hidden;
            box-shadow: 0 4px 12px rgba(0,0,0,0.1);
            border-collapse: separate;
            border-spacing: 0;
        }
        .custom-table th,
        .custom-table td {
            border-right: 1px solid #dee2e6;
            padding: 0.75rem 1rem;
            vertical-align: middle;
        }
        .custom-table th:last-child,
        .custom-table td:last-child {
            border-right: none;
        }
        .custom-table thead th {
            border-bottom: 2px solid #dee2e6;
            font-weight: 600;
            text-transform: uppercase;
        }
        .custom-table tbody tr {
            text-align: center;
            transition: transform 0.2s, box-shadow 0.2s;
        }
        .custom-table tbody tr:hover {
            box-shadow: 0 6px 15px rgba(0,0,0,0.08);
            background-color: #f0fdf9;
        }

        /* Badge */
        .badge {
            font-size: 0.9rem;
            padding: 0.4em 0.75em;
            text-transform: uppercase;
        }

        /* Dark Mode */
        body.dark-mode {
            background: #1e1e1e;
            color: #e4e4e4;
        }
        body.dark-mode .navbar {
            background: linear-gradient(90deg, #000, #212529);
        }
        body.dark-mode .nav-link {
            color: #ccc !important;
        }
        body.dark-mode .nav-link.active,
        body.dark-mode .nav-link:hover {
            color: #00d084 !important;
        }
        body.dark-mode .custom-table {
            background: #2b2b2b;
            color: #e4e4e4;
        }
        body.dark-mode .custom-table thead {
            background: #343a40;
            color: #fff;
        }

        @media (max-width: 576px) {
            .custom-table {
                font-size: 0.9rem;
            }
            .navbar-brand span {
                font-size: 0.9rem;
            }
        }
    </style>
</head>
<body>
    <nav class="navbar navbar-expand-lg navbar-dark py-2">
        <div class="container">
            <!-- Logo + Brand -->
            <a class="navbar-brand d-flex align-items-center" href="{{ url('/') }}">
                <img src="{{ asset('images/logo.PNG') }}" alt="HOME DEN Invoice Logo" class="me-2">
                <span>HOME DEN INVOICE</span>
            </a>

            <!-- Toggler -->
            <button class="navbar-toggler" type="button" data-bs-toggle="collapse" data-bs-target="#navbarNav">
                <span class="navbar-toggler-icon"></span>
            </button>

            <div class="collapse navbar-collapse" id="navbarNav">
                <ul class="navbar-nav me-auto mb-2 mb-lg-0">
                    @auth
                        <li class="nav-item">
                            <a class="nav-link {{ request()->is('client/dashboard') ? 'active' : '' }}" href="{{ route('client.dashboard') }}">
                                <i class="bi bi-speedometer2 me-2"></i> Dashboard
                            </a>
                        </li>
                    @endauth
                </ul>

                <ul class="navbar-nav ms-auto align-items-center">
                    @auth
                        <li class="nav-item me-2">
                            <button id="darkModeToggle" class="btn btn-outline-light btn-sm rounded-circle" title="Toggle Dark Mode">
                                <i class="bi bi-moon-fill"></i>
                            </button>
                        </li>
                        <li class="nav-item">
                            <form id="client-logout-form" action="{{ route('client.logout') }}" method="POST" style="display:none;">
                                @csrf
                            </form>
                            <a href="{{ route('home') }}" class="btn btn-outline-success text-white btn-logout">
                                Logout ({{ Auth::user()->name }})
                            </a>
                        </li>
                    @else
                        <li class="nav-item">
                            <a class="nav-link" href="{{ route('login') }}">Login</a>
                        </li>
                    @endauth
                </ul>
            </div>
        </div>
    </nav>

    <div class="container mt-4">
        @yield('content')
    </div>

    <!-- Bootstrap JS -->
    <script src="https://cdn.jsdelivr.net/npm/bootstrap@5.3.2/dist/js/bootstrap.bundle.min.js"></script>

    <!-- Dark Mode Script -->
    <script>
        const toggleBtn = document.getElementById('darkModeToggle');
        const body = document.body;

        // Restore dark mode from localStorage
        if (localStorage.getItem('dark-mode') === 'enabled') {
            body.classList.add('dark-mode');
            toggleBtn.innerHTML = '<i class="bi bi-sun-fill"></i>';
        }

        toggleBtn?.addEventListener('click', () => {
            body.classList.toggle('dark-mode');
            if (body.classList.contains('dark-mode')) {
                localStorage.setItem('dark-mode', 'enabled');
                toggleBtn.innerHTML = '<i class="bi bi-sun-fill"></i>';
            } else {
                localStorage.setItem('dark-mode', 'disabled');
                toggleBtn.innerHTML = '<i class="bi bi-moon-fill"></i>';
            }
        });
    </script>
</body>
</html>
