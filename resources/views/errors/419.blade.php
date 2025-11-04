<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Session Expired - 419</title>
    <link href="https://cdn.jsdelivr.net/npm/bootstrap@5.3.2/dist/css/bootstrap.min.css" rel="stylesheet">
    <style>
        body {
            background-color: #f8f9fa;
            display: flex;
            justify-content: center;
            align-items: center;
            height: 100vh;
            font-family: 'Poppins', sans-serif;
        }
        .error-box {
            max-width: 500px;
            background: white;
            border-radius: 12px;
            box-shadow: 0 4px 12px rgba(0, 0, 0, 0.1);
            padding: 40px;
            text-align: center;
        }
        .error-code {
            font-size: 72px;
            font-weight: 700;
            color: #dc3545;
        }
        .error-message {
            font-size: 18px;
            margin-top: 10px;
        }
        .btn-custom {
            background-color: #198754;
            color: white;
            padding: 10px 20px;
            border-radius: 8px;
            text-decoration: none;
            display: inline-block;
            margin-top: 20px;
            transition: background 0.3s;
        }
        .btn-custom:hover {
            background-color: #157347;
        }
    </style>
</head>
<body>
    <div class="error-box">
        <div class="error-code">419</div>
        <div class="error-message">
            Your session has expired.<br>
            Redirecting to Home in 5 seconds...
        </div>
        <a href="{{ route('home') }}" class="btn-custom">Go Now</a>
    </div>

    {{-- ✅ Auto redirect script --}}
    <script>
        setTimeout(() => {
            window.location.href = "{{ route('home') }}";
        }, 5000);
    </script>
</body>
</html>
