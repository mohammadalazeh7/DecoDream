
<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Auth | E_Store</title>
    <link href="https://cdn.jsdelivr.net/npm/bootstrap@5.1.3/dist/css/bootstrap.min.css" rel="stylesheet">
    <link rel="stylesheet" href="https://cdnjs.cloudflare.com/ajax/libs/font-awesome/6.0.0/css/all.min.css">
    <style>
        body {
            background: linear-gradient(180deg, #2F5D50 0%, #1B3C34 100%);
            min-height: 100vh;
            display: flex;
            align-items: center;
            justify-content: center;
            font-family: 'Arial', sans-serif;
        }
        .login-container {
            background: white;
            border-radius: 20px;
            padding: 40px;
            box-shadow: 0 15px 35px rgba(0, 0, 0, 0.1);
            width: 100%;
            max-width: 400px;
        }
        .login-title {
            text-align: center;
            margin-bottom: 30px;
            font-size: 2rem;
            font-weight: bold;
            color: #333;
        }
        .form-control {
            border-radius: 25px;
            padding: 12px 20px;
            margin-bottom: 20px;
            border: 2px solid #e9ecef;
            transition: all 0.3s ease;
        }
        .form-control:focus {
            border-color: #2F5D50;
            box-shadow: 0 2px 4px rgba(0, 0, 0, 0.1);
        }
        .btn-login, .btn-primary, .btn-success {
            background: linear-gradient(180deg, #2F5D50 0%, #1B3C34 100%);
            border: none;
            border-radius: 25px;
            padding: 12px 30px;
            width: 100%;
            color: white;
            font-weight: bold;
            transition: all 0.3s ease;
        }
        .btn-login:hover, .btn-primary:hover, .btn-success:hover {
            transform: translateY(-2px);
            box-shadow: 0 5px 15px rgba(0, 0, 0, 0.2);
        }
        .signup-link {
            text-align: center;
            margin-top: 20px;
            color: #666;
        }
        .signup-link a {
            color: #667eea;
            text-decoration: none;
        }
        .alert {
            border-radius: 15px;
            margin-bottom: 20px;
        }
        #togglePassword {
            color: #666;
            transition: all 0.3s ease;
            cursor: pointer;
        }
        #togglePassword:hover {
            color: #2F5D50;
        }
    </style>
</head>
<body>
    <div class="login-container">
        @yield('content')
    </div>
    <script src="https://cdn.jsdelivr.net/npm/bootstrap@5.1.3/dist/js/bootstrap.bundle.min.js"></script>
    @yield('scripts')
</body>
</html>
