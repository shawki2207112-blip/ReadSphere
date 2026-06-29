<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Login - Library Management System</title>

    <link rel="stylesheet" href="{{ asset('css/login.css') }}">
</head>
<body>

    <nav class="navbar">
        <div class="logo">Library Management</div>

        <div>
            <a href="{{ url('/') }}">Home</a>
            <a href="{{ url('/about') }}">About</a>
            <a href="{{ url('/contact') }}">Contact</a>
            <a href="{{ url('/login') }}">Login</a>
            <a href="{{ url('/register') }}">Register</a>
        </div>
    </nav>

    <section class="login-section">
        <div class="login-content">
    <span class="tag">Welcome Back</span>
    <h1>Login to your library account</h1>
    <p>
        Access your dashboard to manage library activity, check books,
        view borrowing records, and continue your library work smoothly.
    </p>

    <div class="login-image-box">
        <img src="{{ asset('images/library-hero.png') }}" alt="Library Management" class="login-image">
    </div>
</div>
        </div>

        <div class="login-card">
            <h2>Login</h2>

            <form action="#" method="POST">
                @csrf

                <div class="form-group">
                    <label for="email">Email Address</label>
                    <input type="email" id="email" name="email" placeholder="Enter your email" required>
                </div>

                <div class="form-group">
                    <label for="password">Password</label>
                    <input type="password" id="password" name="password" placeholder="Enter your password" required>
                </div>

                <button type="submit" class="login-btn">Login</button>

                <p class="register-text">
                    Do not have an account?
                    <a href="{{ url('/register') }}">Register here</a>
                </p>
            </form>
        </div>
    </section>

    <footer class="footer">
        <p>&copy; {{ date('Y') }} Library Management System. All rights reserved.</p>
    </footer>

</body>
</html>