    <!DOCTYPE html>
    <html lang="en">
    <head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>HOME DEN Billing</title>

    <!-- Bootstrap CSS -->
    <link href="https://cdn.jsdelivr.net/npm/bootstrap@5.3.2/dist/css/bootstrap.min.css" rel="stylesheet">
    <link href="https://fonts.googleapis.com/css2?family=Poppins:wght@400;500;600;700&display=swap" rel="stylesheet">
    <link rel="stylesheet" href="https://cdn.jsdelivr.net/npm/bootstrap-icons@1.11.1/font/bootstrap-icons.css">

    <style>
            body {
                font-family: 'Poppins', sans-serif;
                background: black;
                min-height: 100vh;
                display: flex;
                flex-direction: column; /* column layout */
                justify-content: center; /* center card vertically */
                align-items: center;
                padding: 1rem;
            }

        .home-container {
            display: flex;
            width: 90%;
            max-width: 1000px;
            min-height: 500px;
            border-radius: 1rem;
            overflow: hidden;
            box-shadow: 0 12px 35px rgba(0,0,0,0.2);
        }

        .home-left {
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

        .home-right {
            flex: 1;
            background: #fff;
            padding: 3rem;
            display: flex;
            flex-direction: column;
            justify-content: center;
            align-items: center;
            text-align: center;
        }

        .home-right img {
            height: 100px;
            margin-bottom: 1.5rem;
        }

        .home-right h2 {
            font-weight: 700;
            margin-bottom: 2rem;
            color: #333;
        }

        .login-links {
            display: flex;
            justify-content: center;
            gap: 2rem;
            flex-wrap: wrap;
        }

        .login-links a {
            display: flex;
            align-items: center;
            justify-content: center;
            gap: 0.5rem; /* spacing between icon and text */
            text-decoration: none;
            background: linear-gradient(135deg, #2600d0ff, #8d9dfdff);
            color: #fff;
            padding: 1rem 2rem;
            border-radius: 10px;
            font-weight: 600;
            font-size: 1.1rem;
            transition: all 0.4s ease;
            box-shadow: 0 4px 12px rgba(0, 0, 0, 0.1);
        }

        .login-links a:hover {
            background: linear-gradient(135deg, #8d9dfdff,  #2600d0ff);
            transform: translateY(-5px) scale(1.05);
            box-shadow: 0 8px 20px rgba(0, 0, 0, 0.25);
        }


        .login-links a i {
        font-size: 1.2rem;
        transition: transform 0.3s ease;
        }

        .login-links a:hover i {
            transform: rotate(360deg) scale(1.2); /* subtle icon animation */
        }

        @media (max-width: 768px) {
            .home-container {
                flex-direction: column;
            }
            .home-left, .home-right {
                flex: unset;
                width: 100%;
                min-height: 250px;
            }
            .home-left {
                order: 1!important;
            }
            .home-right {
                order: 2!important;
            }
        }

        footer {
            text-align: center;
            color: #fff;
            margin-top: 2rem;
            font-size: 0.9rem;
        }
    </style>
    </head>
    <body>

    <div class="home-container">
        <div class="home-left">
            <div class="top-layer">
            <img src="{{ asset('images/logo.PNG') }}" alt="HOME DEN Logo" style="height: 100px;width: 100px; margin-bottom: 20px; margin:auto; z-index: 2;">
            <br>
            <h1>HOME DEN</h1>
            <span>SMART BILLING SOLUTIONS</span>
            <p>“Track Projects. Manage Invoices. Control Your Finances Effortlessly.”</p>
            </div>
        </div>


        <div class="home-right">
            <!-- <img src="{{ asset('images/logo.PNG') }}" alt="HOME DEN Billing Logo"> -->
            <h2>Welcome</h2>
            <div class="login-links">
                <a href="{{ route('login') }}">
                    <i class="bi bi-gear-wide-connected"></i> Admin Login
                </a>
                <a href="{{ route('client.login') }}">
                    <i class="bi bi-person-circle"></i> Client Login
                </a>
            </div>
        </div>
    </div>

    <footer>
        © {{ date('Y') }} HOME DEN Billing. All rights reserved.
    </footer>

    <!-- Bootstrap JS -->
    <script src="https://cdn.jsdelivr.net/npm/bootstrap@5.3.2/dist/js/bootstrap.bundle.min.js"></script>
    </body>
    </html>
