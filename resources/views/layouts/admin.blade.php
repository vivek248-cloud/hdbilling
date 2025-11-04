<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>@yield('title', 'HOME DEN Billing')</title>
    <link rel="icon" href="{{ asset('images/favicon.ico') }}" type="image/x-icon">
    <!-- Bootstrap CSS -->
    <link href="https://cdn.jsdelivr.net/npm/bootstrap@5.3.2/dist/css/bootstrap.min.css" rel="stylesheet">

    <!-- Bootstrap Icons -->
    <link href="https://cdn.jsdelivr.net/npm/bootstrap-icons@1.11.1/font/bootstrap-icons.css" rel="stylesheet">

    <!-- Custom CSS -->
<style>
    html, body {
        height: 100%;
        margin: 0;
        font-family: 'Poppins', sans-serif;
        background: #f8f9fa;
        display: flex;
        flex-direction: column;
        transition: background 0.3s ease, color 0.3s ease;
        color: #212529;
    }

    /* ✅ Dark Mode */
    .dark-mode {
        background: #121212;              /* deep dark */
        color: #e4e4e4;                   /* soft white text */
    }

    /* Optional: cool gradient for dark mode */
    .dark-mode .home-left {
        background: linear-gradient(135deg, #0f2027, #203a43, #2c5364);
    }

    /* 🌓 Toggle Button Styling */
    .dark-toggle-btn {
        position: fixed;
        top: 20px;
        right: 20px;
        background: #ffffff;
        border: none;
        padding: 10px 14px;
        border-radius: 50%;
        cursor: pointer;
        box-shadow: 0 0 10px rgba(0,0,0,0.15);
        transition: background 0.3s ease;
        z-index: 1000;
    }

    .dark-toggle-btn i {
        font-size: 20px;
        color: #000;
    }

    .dark-mode .dark-toggle-btn {
        background: #2c2c2c;
    }

    .dark-mode .dark-toggle-btn i {
        color: #fff;
    }


    /* Navbar Styling */
    .navbar {
        background: linear-gradient(90deg, #212529, #343a40);
        box-shadow: 0 2px 6px rgba(0,0,0,0.3);
        
    }

    .navbar-brand img {
        height: 40px;
        width: auto;
        border-radius: 8px;
        transition: transform 0.3s ease;
    }

    .navbar-brand span {
        font-weight: 600;
        letter-spacing: 1px;
        color: #f8f9fa;
    }

    .navbar-brand:hover img {
        transform: scale(1.1);
    }

    .nav-link {
        color: #f8f9fa !important;
        font-weight: 500;
        transition: color 0.2s ease, background 0.2s ease;
    }

    .nav-link:hover {
        color: #00d084 !important;
        border-radius: 8px;
        border-bottom: 2px solid #00d084;  /* optional underline for highlight */
    }

    .nav-link.active {
        color: #00d084 !important;
        font-weight: 500 !important;
        border-radius: 8px;
        border-bottom: 2px solid #00d084;  /* optional underline for highlight */
    }


    .btn-danger.btn-sm {
        background-color: #dc3545;
        border: none;
        transition: all 0.3s;
    }

    .btn-danger.btn-sm:hover {
        background-color: #c82333;
    }

    /* Page layout fix */
    main {
        flex: 1;
        padding-top: 80px; /* navbar height spacing */
    }

    .container {
        background: #fff;
        border-radius: 10px;
        padding: 20px;
    }

    h2, h3, h4 {
        font-weight: 600;
        color: #343a40;
    }

    .table {
        border-radius: 10px;
        overflow: hidden;
    }

    .table th {
        background-color: #00d084;
        color: #fff;
    }

    footer {
        text-align: center;
        padding: 15px;
        color: #ffffffff;
        background: linear-gradient(90deg, #212529, #343a40);
        border-top: 8px double #ffffffff;
    }
</style>

</head>
<body>

    <!-- Sticky Navbar -->
    <nav class="navbar navbar-expand-lg navbar-dark fixed-top">
        <div class="container-fluid">
            <!-- Logo + Brand -->
            <a class="navbar-brand d-flex align-items-center" href="{{ url('/') }}">
                <img src="{{ asset('images/logo.PNG') }}" alt="HOME DEN Invoice Logo" class="me-2">
                <span>HOME DEN INVOICE</span>
            </a>

            <!-- Toggler -->
            <button class="navbar-toggler" type="button" data-bs-toggle="collapse" data-bs-target="#navbarNav">
                <span class="navbar-toggler-icon"></span>
            </button>

            <!-- Menu -->
            <div class="collapse navbar-collapse" id="navbarNav">
                <ul class="navbar-nav me-auto mb-2 mb-lg-0">
                    @auth
                        @if(Auth::user()->role === 'admin')
                            <li class="nav-item">
                                <a class="nav-link {{ request()->is('admin/dashboard') ? 'active' : '' }}" href="{{ route('admin.dashboard') }}">
                                    <i class="bi bi-speedometer2 me-2"></i> Dashboard
                                </a>
                            </li>
                            <li class="nav-item">
                                <a class="nav-link {{ Route::is('users.*') ? 'active' : '' }}" href="{{ route('users.index') }}">
                                    <i class="bi bi-people me-2"></i> Users
                                </a>
                            </li>
                            <li class="nav-item">
                                <a class="nav-link {{ request()->is('admin/projects') ? 'active' : '' }}" href="{{ route('projects.index') }}">
                                    <i class="bi bi-kanban me-2"></i> Projects
                                </a>
                            </li>
                            <li class="nav-item">
                                <a class="nav-link {{ request()->is('admin/expenses*') ? 'active' : '' }}" href="{{ route('expenses.index') }}">
                                    <i class="bi bi-receipt me-2"></i> Cost
                                </a>
                            </li>
                            <li class="nav-item">
                                <a class="nav-link {{ request()->is('admin/payments*') ? 'active' : '' }}" href="{{ route('payments.index') }}">
                                    <i class="bi bi-cash-stack me-2"></i> Payments
                                </a>
                            </li>
                        @else
                            <li class="nav-item">
                                <a class="nav-link {{ request()->is('client/dashboard') ? 'active' : '' }}" href="{{ route('client.dashboard') }}">
                                    <i class="bi bi-house-door me-2"></i> Dashboard
                                </a>
                            </li>
                        @endif
                    @endauth
                </ul>

                <!-- Right Section -->
                <ul class="navbar-nav ms-auto align-items-center">
                    @guest
                        <li class="nav-item">
                            <a class="nav-link" href="{{ route('login') }}">
                                <i class="bi bi-box-arrow-in-right"></i> Login
                            </a>
                        </li>
                    @else
                        <!-- 🟥 Logout -->
                        <li class="nav-item me-2">
                            <form method="POST" action="{{ route('logout') }}">
                                @csrf
                                <button type="submit" class="btn btn-danger btn-sm">
                                    <i class="bi bi-box-arrow-right"></i> Logout ({{ Auth::user()->name }})
                                </button>
                            </form>
                        </li>

                        <!-- 🌗 Dark Mode Toggle -->
                         &nbsp;
                        <li class="nav-item">
                            <button id="darkModeToggle" class="btn btn-outline-light btn-sm rounded-circle" title="Toggle Dark Mode">
                                <i class="bi bi-moon-fill"></i>
                            </button>
                        </li>
                    @endguest
                </ul>

            </div>
        </div>
    </nav>

<main>
    <div class="container">
        @yield('content')
    </div>
</main>

    <footer>
        © {{ date('Y') }} Home Den Billing. All rights reserved.
    </footer>

    <!-- Bootstrap JS -->
    <script src="https://cdn.jsdelivr.net/npm/bootstrap@5.3.2/dist/js/bootstrap.bundle.min.js"></script>


    <script>
    const toggleBtn = document.getElementById('darkModeToggle');
    const body = document.body;

    // Check if dark mode was previously enabled
    if (localStorage.getItem('dark-mode') === 'enabled') {
        body.classList.add('dark-mode');
        toggleBtn.innerHTML = '<i class="bi bi-sun-fill"></i>';
    }

    toggleBtn.addEventListener('click', () => {
        body.classList.toggle('dark-mode');

        // Switch icon
        if (body.classList.contains('dark-mode')) {
            toggleBtn.innerHTML = '<i class="bi bi-sun-fill"></i>';
            localStorage.setItem('dark-mode', 'enabled');
        } else {
            toggleBtn.innerHTML = '<i class="bi bi-moon-fill"></i>';
            localStorage.setItem('dark-mode', 'disabled');
        }
    });
</script>

</body>
</html>
