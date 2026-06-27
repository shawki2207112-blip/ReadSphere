<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Library Management System</title>

    <link rel="stylesheet" href="{{ asset('css/home.css') }}">
</head>
<body>

    <nav class="navbar">
        <div class="logo">ReadSphere</div>

        <div>
            <a href="{{ url('/') }}">Home</a>
            <a href="{{ url('/about') }}">About</a>
            <a href="{{ url('/contact') }}">Contact</a>
            <a href="{{ url('/login') }}">Login</a>
            <a href="{{ url('/register') }}">Register</a>
        </div>
    </nav>

    <section class="hero">
        <div class="hero-text">
            <h1>Welcome to ReadSphere: Library Management System</h1>
            <p>
                Manage books, members, issue records, returns, borrowing history,
                inventory status, and reports from one simple Laravel-based system.
            </p>

            <div class="buttons">
                <a href="{{ url('/register') }}" class="btn btn-primary">Register Now</a>
                <a href="{{ url('/login') }}" class="btn btn-secondary">Login</a>
            </div>
        </div>

  <div class="hero-image-box">
    <img src="{{ asset('images/library-hero.png') }}" alt="Library Management" class="hero-image">
</div>
    </section>

    <section class="section">
        <h2>System Features</h2>

        <div class="features">
            <div class="feature-box">
                <h3>Book Management</h3>
                <p>Add, view, edit, and delete books from the library database.</p>
            </div>

            <div class="feature-box">
                <h3>Member Management</h3>
                <p>Manage library members, update their details, and track activity.</p>
            </div>

            <div class="feature-box">
                <h3>Borrowing System</h3>
                <p>Issue books, return books, and maintain borrowing history.</p>
            </div>
        </div>
    </section>

   
    <footer class="footer">
        <p>&copy; {{ date('Y') }} Library Management System. All rights reserved.</p>
    </footer>

</body>
</html>