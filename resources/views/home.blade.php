<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>HOME DEN • Smart Billing Solutions</title>


    <!-- SEO Meta Tags -->
    <meta name="title" content="Home Den Interiors | Smart Billing & Project Management">
    <meta name="description" content="Home Den Interiors presents Home Den Invoice — a smart billing and project management platform for interior design and construction companies. Track projects, manage invoices, and control finances effortlessly.">
    <meta name="keywords" content="Home Den Interiors, Home Den Invoice, billing software, interior billing, construction billing, invoice system, project management, Trichy interiors, Tamil Nadu">
    <meta name="author" content="Home Den Interiors">

    <!-- Open Graph (For Google + Social Media) -->
    <meta property="og:title" content="Home Den Interiors | Smart Billing Solutions">
    <meta property="og:description" content="Smart billing and project tracking system for Home Den Interiors.">
    <meta property="og:image" content="{{ asset('images/logo.PNG') }}">
    <meta property="og:url" content="https://homedeninvoice.com">
    <meta property="og:type" content="website">
    <meta property="og:site_name" content="Home Den Invoice">

    <!-- Canonical URL -->
    <link rel="canonical" href="https://homedeninvoice.com">

    <script type="application/ld+json">
    {
    "@context": "https://schema.org",
    "@type": "Organization",
    "name": "Home Den Interiors",
    "url": "https://homedeninvoice.com",
    "logo": "https://homedeninvoice.com/images/logo.PNG",
    "sameAs": [
        "https://www.facebook.com/homedeninteriors",
        "https://www.instagram.com/homedeninteriors"
    ],
    "description": "Smart billing and project management platform by Home Den Interiors, designed for seamless invoice tracking and financial control."
    }
    </script>


    <!-- Bootstrap 5 + Icons -->
    <link href="https://cdn.jsdelivr.net/npm/bootstrap@5.3.3/dist/css/bootstrap.min.css" rel="stylesheet">
    <link rel="stylesheet" href="https://cdn.jsdelivr.net/npm/bootstrap-icons@1.11.3/font/bootstrap-icons.css">
    
    <!-- Google Fonts: Elegant & Modern -->
    <link href="https://fonts.googleapis.com/css2?family=Inter:wght@400;500;600;700;800&family=Playfair+Display:wght@700;800&display=swap" rel="stylesheet">

    <style>
        :root {
            --primary: #4f46e5;
            --primary-dark: #4338ca;
            --accent: #ec4899;
            --glass: rgba(255, 255, 255, 0.12);
            --glass-border: rgba(255, 255, 255, 0.2);
            --text: #ffffff;
            --text-light: rgba(255, 255, 255, 0.8);
        }

        body {
            font-family: 'Inter', sans-serif;
            background: linear-gradient(-45deg, #0f0f0f, #1a1a2e, #04070fff, #020b16ff);
            background-size: 400% 400%;
            animation: gradientShift 15s ease infinite;
            min-height: 100vh;
            color: white;
            margin: 0;
            padding: 2rem 1rem;
            display: flex;
            flex-direction: column;
            justify-content: center;
            align-items: center;
            position: relative;
            overflow-x: hidden;
        }

        @keyframes gradientShift {
            0% { background-position: 0% 50%; }
            50% { background-position: 100% 50%; }
            100% { background-position: 0% 50%; }
        }

        /* Floating Glass Card */
        .glass-card {
            background: var(--glass);
            backdrop-filter: blur(20px);
            -webkit-backdrop-filter: blur(20px);
            border-radius: 24px;
            border: 1px solid var(--glass-border);
            box-shadow: 
                0 25px 50px rgba(0, 0, 0, 0.4),
                0 0 60px rgba(79, 70, 229, 0.15),
                inset 0 1px 0 rgba(255, 255, 255, 0.1);
            overflow: hidden;
            width: 100%;
            max-width: 1100px;
            display: grid;
            grid-template-columns: 1.1fr 1fr;
            animation: float 8s ease-in-out infinite;
        }

        @keyframes float {
            0%, 100% { transform: translateY(0px); }
            50% { transform: translateY(-15px); }
        }

        /* Left Side - Hero */
        .hero-section {
            background: linear-gradient(135deg, rgba(0, 0, 0, 0.53), rgba(0, 0, 0, 0.36)),
                        url("{{ asset('images/about-hall.jpg') }}") center/cover no-repeat;
            padding: 4rem 3rem;
            display: flex;
            flex-direction: column;
            justify-content: center;
            position: relative;
        }

        .hero-section::before {
            content: '';
            position: absolute;
            inset: 0;
            background: linear-gradient(135deg, rgba(0,0,0,0.4), transparent 50%);
            border-radius: 24px 0 0 24px;
        }

    /* REPLACE your current .logo CSS with this */
    .logo {
        width: 110px;
        height: 110px;
        border-radius: 24px;
        object-fit: contain;
        
        /* Remove white background + add premium glassmorphic card effect */
        background: rgba(255, 255, 255, 0);
        padding: 16px;

        margin-bottom: 2rem;
        align-self: center;
        
        /* Subtle hover lift */
        transition: all 0.4s ease;
    }

        .hero-title {
            font-family: 'Playfair Display', serif;
            font-size: 3.8rem;
            font-weight: 800;
            background: linear-gradient(90deg, #fff, #e9e9e9ff);
            -webkit-background-clip: text;
            background-clip: text;
            -webkit-text-fill-color: transparent;
            text-align: center;
            margin: 0 0 1rem 0;
            line-height: 1.1;
        }

        .hero-subtitle {
            font-size: 1.35rem;
            font-weight: 600;
            opacity: 0.95;
            margin: 0 0 1.2rem 0;
            color: #ffffffff;
            text-align: center;
        }

        .hero-desc {
            font-size: 1.1rem;
            line-height: 1.7;
            opacity: 0.9;
            max-width: 420px;
            color: #ffffffff;
        }

        /* Right Side - Login */
        .login-section {
            background: linear-gradient(-45deg, #0f0f0f, #1a1a2e, #04070fff, #020b16ff);
            backdrop-filter: blur(12px);
            padding: 4rem 3rem;
            display: flex;
            flex-direction: column;
            justify-content: center;
            align-items: center;
            gap: 2.5rem;
        }

        .login-title {
            font-size: 2.4rem;
            font-weight: 700;
            background: linear-gradient(90deg, #ffffffff, #c9c9c9ff);
            -webkit-background-clip: text;
            background-clip: text;
            -webkit-text-fill-color: transparent;
        }

        .login-buttons {
            display: flex;
            flex-direction: column;
            gap: 1.5rem;
            width: 100%;
            max-width: 320px;
        }

.btn-glass {
    position: relative;
    display: flex;
    align-items: center;
    justify-content: center;
    gap: 14px;
    padding: 1.1rem 2.4rem;
    font-size: 1.1rem;
    font-weight: 700;
    color: #ffffff;
    text-decoration: none;
    border-radius: 18px;
    overflow: hidden;
    backdrop-filter: blur(16px);
    -webkit-backdrop-filter: blur(16px);
    border: 1.5px solid rgba(255, 255, 255, 0.25);
    background: rgba(255, 255, 255, 0.08);
    box-shadow: 
        0 8px 32px rgba(0, 0, 0, 0.37),
        inset 0 2px 8px rgba(255, 255, 255, 0.15);
    transition: all 0.4s cubic-bezier(0.34, 1.56, 0.64, 1);
    cursor: pointer;
    z-index: 1;
}





/* Hover: Liquid Fill + Shine */
.btn-glass:hover {
    transform: translateY(-10px) scale(1.06);
    background: linear-gradient(135deg, #5b52f8 0%, #ec4899 100%);
    border-color: transparent;
    box-shadow: 
        0 20px 50px rgba(91, 82, 248, 0.4),
        0 10px 20px rgba(236, 72, 153, 0.3),
        inset 0 2px 12px rgba(255, 255, 255, 0.3);
}



.btn-glass:hover::after {
    transform: translateY(0%);
}

/* Icon Animation */
.btn-glass i {
    font-size: 1.55rem;
    transition: all 0.5s cubic-bezier(0.34, 1.56, 0.64, 1);
    filter: drop-shadow(0 2px 4px rgba(0,0,0,0.3));
}

.btn-glass:hover i {
    transform: translateY(-3px) rotate(360deg) scale(1.25);
}

/* Press Effect */
.btn-glass:active {
    transform: translateY(-4px) scale(1.02);
    transition: all 0.1s ease;
}

/* Optional: Add a subtle pulse for extra premium feel */
@keyframes pulse-glow {
    0%, 100% { box-shadow: 0 20px 50px rgba(91, 82, 248, 0.4), 0 10px 20px rgba(236, 72, 153, 0.3); }
    50% { box-shadow: 0 25px 60px rgba(91, 82, 248, 0.5), 0 15px 30px rgba(236, 72, 153, 0.4); }
}

.btn-glass:hover {
    animation: pulse-glow 2s infinite;
}

        /* Footer */
        footer {
            margin-top: 4rem;
            font-size: 0.95rem;
            color: rgba(255,255,255,0.6);
            text-align: center;
        }

        /* Mobile Responsive */
        @media (max-width: 992px) {
            .glass-card {
                grid-template-columns: 1fr;
                max-width: 500px;
            }
            .hero-section {
                padding: 3rem 2rem;
                border-radius: 24px 24px 0 0;
            }
            .hero-title {
                font-size: 3rem;
            }
            .login-section {
                border-radius: 0 0 24px 24px;
                padding: 3rem 2rem;
            }
        }

        @media (max-width: 480px) {
            .hero-title { font-size: 2.6rem; }
            .hero-subtitle { font-size: 1.2rem; }
            .login-title { font-size: 2rem; }
            .btn-glass { padding: 1rem 1.5rem; font-size: 1rem; }
        }
    </style>
</head>
<body>

    <div class="glass-card">
        <!-- Left: Hero Section -->
        <div class="hero-section">
            <img src="{{ asset('images/logo.PNG') }}" alt="HOME DEN Logo" class="logo">
            <h1 class="hero-title">HOME DEN</h1>
            <p class="hero-subtitle">Smart Billing Solutions</p>
            <p class="hero-desc">“Track Projects. Manage Invoices. Control Your Finances Effortlessly.”</p>
        </div>

        <!-- Right: Login Section -->
        <div class="login-section">
            <h2 class="login-title">Welcome Back</h2>
            <div class="login-buttons">
                <a href="{{ route('login') }}" class="btn-glass">
                    <i class="bi bi-gear-wide-connected"></i>
                    <span>Admin Login</span>
                </a>
                <a href="{{ route('client.login') }}" class="btn-glass">
                    <i class="bi bi-person-circle"></i>
                    <span>Client Login</span>
                </a>
            </div>
        </div>
    </div>

    <footer>
        © {{ date('Y') }} HOME DEN Billing • All Rights Reserved
    </footer>

    <!-- Bootstrap JS -->
    <script src="https://cdn.jsdelivr.net/npm/bootstrap@5.3.3/dist/js/bootstrap.bundle.min.js"></script>
</body>
</html>