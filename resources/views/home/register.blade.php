<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">

    <title>Register - ReadSphere</title>

    
    <link rel="stylesheet" href="{{ asset('css/login.css') }}">
</head>

<body>
    {{-- Display the reusable public navigation bar. --}}
    @include('partials.public-navbar')

    <main>
        {{-- Registration page layout with introduction and form. --}}
        <section class="login-section register-section" aria-labelledby="register-page-heading">
            <div class="login-content">
                <span class="tag">New Membership</span>

                <h1 id="register-page-heading">
                    Create your member account
                </h1>

                <p>
                    Registered users receive a member dashboard where they can search
                    the catalogue and track their own borrowing records.
                </p>

                {{-- Library image shown beside the registration form. --}}
                <figure class="login-image-box">
                    <img
                        src="{{ asset('images/library-hero.png') }}"
                        alt="Books inside a library"
                        class="login-image"
                    >
                </figure>
            </div>

            {{-- Member registration form. --}}
            <section class="login-card" aria-labelledby="register-form-heading">
                <h2 id="register-form-heading">Register</h2>

                {{-- Display success, error, and validation messages. --}}
                @include('partials.flash')

                <form action="{{ route('register.submit') }}" method="POST">
                    @csrf

                    {{-- Member full name. --}}
                    <div class="form-group">
                        <label for="name">Full Name</label>

                        <input
                            id="name"
                            name="name"
                            type="text"
                            value="{{ old('name') }}"
                            autocomplete="name"
                            required
                            autofocus
                        >
                    </div>

                    {{-- Member email address. --}}
                    <div class="form-group">
                        <label for="email">Email</label>

                        <input
                            id="email"
                            name="email"
                            type="email"
                            value="{{ old('email') }}"
                            autocomplete="email"
                            required
                        >
                    </div>

                    {{-- Optional member phone number. --}}
                    <div class="form-group">
                        <label for="phone">Phone</label>

                        <input
                            id="phone"
                            name="phone"
                            type="tel"
                            value="{{ old('phone') }}"
                            autocomplete="tel"
                        >
                    </div>

                    {{-- New account password. --}}
                    <div class="form-group">
                        <label for="password">Password</label>

                        <input
                            id="password"
                            name="password"
                            type="password"
                            autocomplete="new-password"
                            required
                        >
                    </div>

                    {{-- Password confirmation required by Laravel's confirmed rule. --}}
                    <div class="form-group">
                        <label for="password_confirmation">
                            Confirm Password
                        </label>

                        <input
                            id="password_confirmation"
                            name="password_confirmation"
                            type="password"
                            autocomplete="new-password"
                            required
                        >
                    </div>

                    {{-- Submit the registration form. --}}
                    <button type="submit" class="login-btn">
                        Create Member Account
                    </button>

                    {{-- Link for users who already have an account. --}}
                    <p class="register-text">
                        Already registered?
                        <a href="{{ route('login') }}">Login here</a>
                    </p>
                </form>
            </section>
        </section>
    </main>

    {{-- Website footer with the current year. --}}
    <footer class="footer">
        <p>
            &copy; {{ date('Y') }} ReadSphere Library Management System.
        </p>
    </footer>
</body>
</html>