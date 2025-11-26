<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Client Login | HOME DEN Billing</title>
    <link rel="icon" href="{{ asset('images/favicon.ico') }}" type="image/x-icon">

    <!-- Bootstrap CSS -->
    <link href="https://cdn.jsdelivr.net/npm/bootstrap@5.3.2/dist/css/bootstrap.min.css" rel="stylesheet">

    <!-- Google Fonts -->
    <link href="https://fonts.googleapis.com/css2?family=Poppins:wght@400;500;600;700&display=swap" rel="stylesheet">
    <link rel="stylesheet" href="https://cdn.jsdelivr.net/npm/bootstrap-icons@1.11.1/font/bootstrap-icons.css">

    <style>
        body {
            font-family: 'Poppins', sans-serif;
            margin: 0;
            min-height: 100vh;
            display: flex;
            align-items: center;
            justify-content: center;
            background: linear-gradient(-45deg, #0f0f0f, #1a1a2e, #04070fff, #020b16ff);
        }

        .login-container {
            display: flex;
            width: 90%;
            max-width: 1000px;
            min-height: 600px;
            border-radius: 1rem;
            overflow: hidden;
            box-shadow: 0 12px 35px rgba(0,0,0,0.2);
        }

        .login-left {
            flex: 1;
            background: url("{{ asset('images/about-hall.jpg') }}") no-repeat center center/cover;
            color: #fff;
            display: flex;
            flex-direction: column;
            justify-content: center;
        }


        .top-layer {
            position: relative;
            z-index: 1;
            display: flex;
            justify-content: center;
            height: 100%;
            align-items: center;
            flex-direction: column;
            backdrop-filter: blur(3px) brightness(0.8);
        }

        .top-layer h1 {
            font-size: 2.5rem;
            font-weight: 800;
            font-family: 'Playfair Display', serif;
            margin-bottom: 1rem;
            color: black;
        }
        .top-layer span {
            font-size: 1.2rem;
            font-weight: 500;
            margin-bottom: 1rem;
            color: #000000d3;
        }

        .top-layer p {
            font-size: 1rem;
            line-height: 1.5;
            text-align: center;
            font-weight: 800;
            opacity: 0.9;
            color: #00000096;
        }

        .login-right {
            flex: 1;
            background: #fff;
            padding: 3rem;
            display: flex;
            flex-direction: column;
            justify-content: center;
        }

        .login-right h2 {
            font-weight: 700;
            margin-bottom: 1rem;
            text-align: center;
            color: #333;
        }

        .form-control {
            border-radius: 8px;
            padding: 0.75rem;
            margin-bottom: 1rem;
            border: 1px solid #ccc;
        }

        .form-control:focus {
            border-color: #00d084;
            box-shadow: 0 0 0 0.2rem rgba(0,208,132,0.2);
        }

        .btn-login {
            background-color: #00d084;
            color: #fff;
            font-weight: 600;
            padding: 0.75rem;
            border-radius: 8px;
            width: 100%;
            border: none;
            margin-bottom: 1rem;
        }

        .btn-login:hover {
            background-color: #00b670;
        }

        .social-login {
            display: flex;
            justify-content: center;
            align-items: center;
            gap: 0.5rem;
            border: 1px solid #ccc;
            border-radius: 8px;
            padding: 0.5rem;
            cursor: pointer;
            transition: background 0.3s ease;
        }

        .social-login:hover {
            background: #f5f5f5;
        }

        .remember-forgot {
            display: flex;
            justify-content: space-between;
            font-size: 0.9rem;
            margin-bottom: 1rem;
        }

        .signup-text {
            text-align: center;
            margin-top: 1rem;
            font-size: 0.9rem;
        }


        
        @media (max-width: 768px) {
            .login-container {
                flex-direction: column;
            }
            .login-left, .login-right {
                flex: unset;
                width: 100%;
                min-height: 300px;
            }
            .login-left {
                order: 2;
            }
        }
    </style>
</head>
<body>
    <div class="login-container">
        <div class="login-left">
            <div class="top-layer">
                <span>SMART BILLING SOLUTIONS</span>
                <h1>HOME DEN</h1>
                <p>“Track Projects. Manage Invoices. Control Your Finances Effortlessly.”</p>
            </div>
        </div>


        <div class="login-right">
            <h2>Welcome Back</h2>

            @if($errors->any())
                <div class="alert alert-danger">
                    {{ $errors->first() }}
                </div>
            @endif

            <form method="POST" action="{{ route('client.login.submit') }}">
                @csrf

                <!-- Username -->
                <div class="mb-3">
                    <input type="text" name="name" class="form-control" placeholder="Enter your name" required>
                </div>

                <!-- Password with toggle -->
                <div class="input-group mb-3">
                    <input type="password" name="password" id="passwordField" class="form-control" placeholder="Enter your password" required>
                    <button type="button" class="btn btn-outline-primary btn-primary" id="togglePassword" style="height:50px;color:white;">
                        <i class="bi bi-eye" id="eyeIcon"></i>
                    </button>
                </div>

                <!-- Remember Me -->
                <div class="remember-forgot mb-3 d-flex align-items-center">
                    <input type="checkbox" name="remember" class="form-check-input me-2" id="remember">
                    <label class="form-check-label" for="remember">Remember Me</label>
                </div>

                <!-- Submit -->
                <button type="submit" class="btn-login btn btn-primary w-100"><i class="bi bi-box-arrow-in-right"></i> Login</button>
            </form>



        </div>
    </div>

    <script>
    const togglePassword = document.getElementById('togglePassword');
    const passwordField = document.getElementById('passwordField');
    const eyeIcon = document.getElementById('eyeIcon');

    togglePassword.addEventListener('click', () => {
        const type = passwordField.getAttribute('type') === 'password' ? 'text' : 'password';
        passwordField.setAttribute('type', type);

        // Toggle icon
        eyeIcon.classList.toggle('bi-eye');
        eyeIcon.classList.toggle('bi-eye-slash');
    });
</script>

</body>
</html>
