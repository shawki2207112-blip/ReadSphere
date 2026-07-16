<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">

    <title>Login - ReadSphere</title>

    <link rel="stylesheet" href="{{ asset('css/login.css') }}">
</head>
<body>
    @include('partials.public-navbar')

    <main>
        <section class="login-section" aria-labelledby="login-page-heading">
            <div class="login-content">
                <span class="tag">Welcome Back</span>
                <h1 id="login-page-heading">Login to your library account</h1>
                <p>
                    Access your dashboard to manage library activity, search books,
                    and review borrowing records.
                </p>

                <figure class="login-image-box">
                    <img
                        src="{{ asset('images/library-hero.png') }}"
                        alt="Books inside a library"
                        class="login-image"
                    >
                </figure>
            </div>

            <section class="login-card" aria-labelledby="login-form-heading">
                <h2 id="login-form-heading">Login</h2>

                @include('partials.flash')

                <form action="{{ route('login.submit') }}" method="POST">
                    @csrf

                    <div class="form-group">
                        <label for="email">Email Address</label>
                        <input
                            type="email"
                            id="email"
                            name="email"
                            value="{{ old('email') }}"
                            placeholder="Enter your email"
                            autocomplete="email"
                            required
                            autofocus
                        >
                    </div>

                    <div class="form-group">
                        <label for="password">Password</label>
                        <input
                            type="password"
                            id="password"
                            name="password"
                            placeholder="Enter your password"
                            autocomplete="current-password"
                            required
                        >
                    </div>

                    <label class="remember-row" for="remember">
                        <input type="checkbox" id="remember" name="remember" value="1">
                        <span>Remember me</span>
                    </label>

                    <button type="submit" class="login-btn">Login</button>

                    <p class="register-text">
                        Do not have an account?
                        <a href="{{ route('register') }}">Register here</a>
                    </p>
                </form>

            </section>
        </section>
    </main>

    <footer class="footer">
        <p>&copy; {{ date('Y') }} ReadSphere Library Management System.</p>
    </footer>
</body>
</html>
