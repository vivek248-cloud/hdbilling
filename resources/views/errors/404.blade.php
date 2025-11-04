<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>404 - Page Not Found</title>
    <link href="https://cdn.jsdelivr.net/npm/bootstrap@5.3.2/dist/css/bootstrap.min.css" rel="stylesheet">
    <link href="https://cdn.jsdelivr.net/npm/bootstrap-icons/font/bootstrap-icons.css" rel="stylesheet">
    <style>
        body {
            color: white;
            display: flex;
            justify-content: center;
            align-items: center;
            height: 100vh;
            font-family: 'Poppins', sans-serif;
            color: black;
        }
        .error-box {
            background: rgba(255, 255, 255, 0.1);
            backdrop-filter: blur(10px);
            border-radius: 15px;
            box-shadow: 0 4px 20px rgba(0, 0, 0, 0.3);
            padding: 40px;
            max-width: 450px;
            text-align: center;
            color: #0c0c0cff;
        }
        .error-code {
            font-size: 100px;
            font-weight: 700;
            color: #ff0707ff;
        }
        .error-message {
            font-size: 18px;
            margin-top: 10px;
            opacity: 0.9;
            color: #000;
        }
        .btn-custom {
            background-color: #ffc107;
            color: #000;
            padding: 12px 25px;
            border-radius: 30px;
            text-decoration: none;
            display: inline-block;
            margin-top: 20px;
            font-weight: 600;
            transition: background 0.3s;
        }
        .btn-custom:hover {
            background-color: #e0a800;
            color: #000;
        }
        .countdown {
            margin-top: 15px;
            font-size: 14px;
            opacity: 0.8;
            color: #000;
        }
    </style>
</head>
<body>
    <div class="error-box">
        <i class="bi bi-exclamation-triangle-fill display-4 text-danger"></i>
        <div class="error-code">404</div>
        <div class="error-message">
            Oops! The page you're looking for doesn't exist or may have been moved.
        </div>
        <a href="{{ route('home') }}" class="btn-custom">Go to Home</a>
        <div class="countdown">
            Redirecting in <span id="timer">5</span> seconds...
        </div>
    </div>

    {{-- Auto redirect script --}}
    <script>
        let timeLeft = 5;
        const timerElement = document.getElementById('timer');

        const countdown = setInterval(() => {
            timeLeft--;
            timerElement.textContent = timeLeft;
            if (timeLeft <= 0) {
                clearInterval(countdown);
                window.location.href = "{{ route('home') }}";
            }
        }, 1000);
    </script>
</body>
</html>
