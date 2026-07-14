<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">

    <title>ReadSphere - Library Management System</title>

    <link rel="stylesheet" href="{{ asset('css/home.css') }}">
</head>

<body>
    {{-- Display the reusable public navigation bar. --}}
    @include('partials.public-navbar')

    <main>
        {{-- Main homepage introduction section. --}}
        <section class="hero" aria-labelledby="home-heading">
            <div class="hero-text">
                <h1 id="home-heading">
                    Welcome to ReadSphere: Library Management System
                </h1>

                <p>
                    Manage books, members, issue records, returns, borrowing history,
                    inventory status, and reports from one simple Laravel-based system.
                </p>

                {{-- Registration and login buttons. --}}
                <div class="buttons">
                    <a href="{{ route('register') }}" class="btn btn-primary">
                        Register Now
                    </a>

                    <a href="{{ route('login') }}" class="btn btn-secondary">
                        Login
                    </a>
                </div>
            </div>

            {{-- Library image displayed beside the introduction. --}}
            <figure class="hero-image-box">
                <img
                    src="{{ asset('images/library-hero.png') }}"
                    alt="Books arranged inside a modern library"
                    class="hero-image"
                >
            </figure>
        </section>

        {{-- Overview of the main library-management features. --}}
        <section class="section" aria-labelledby="features-heading">
            <h2 id="features-heading">System Features</h2>

            <div class="features">
                <article class="feature-box">
                    <h3>Book Management</h3>
                    <p>
                        Add, view, edit, and delete books from the library database.
                    </p>
                </article>

                <article class="feature-box">
                    <h3>Member Management</h3>
                    <p>
                        Manage library members, update their details, and track activity.
                    </p>
                </article>

                <article class="feature-box">
                    <h3>Borrowing System</h3>
                    <p>
                        Issue books, return books, and maintain borrowing history.
                    </p>
                </article>
            </div>
        </section>
    </main>

    {{-- Website footer with the current year. --}}
    <footer class="footer">
        <p>
            &copy; {{ date('Y') }} ReadSphere Library Management System.
            All rights reserved.
        </p>
    </footer>
</body>
</html>