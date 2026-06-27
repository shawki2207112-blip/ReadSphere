<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>About - Library Management System</title>

    <link rel="stylesheet" href="{{ asset('css/about.css') }}">
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

    <section class="about-hero">
        <div class="about-text">
            <span class="tag">About Our System</span>
            <h1>Smart library management for admins and members</h1>
            <p>
                Our Library Management System is designed to make library work easier,
                faster, and more organized. It helps administrators manage books,
                members, borrowing records, inventory status, and reports from one place.
            </p>

            <div class="about-actions">
                <a href="{{ url('/register') }}" class="btn btn-primary">Get Started</a>
                <a href="{{ url('/contact') }}" class="btn btn-secondary">Contact Us</a>
            </div>
        </div>
    </section>

    <section class="mission-section">
        <div class="mission-card">
            <h2>Our Mission</h2>
            <p>
                To provide a simple digital platform where libraries can manage daily
                operations efficiently and members can easily search, borrow, and track books.
            </p>
        </div>

        <div class="mission-card">
            <h2>Our Vision</h2>
            <p>
                To reduce manual library work and create a smooth, organized, and user-friendly
                library experience for students, readers, librarians, and administrators.
            </p>
        </div>
    </section>

    <section class="system-section">
        <h2>What This System Provides</h2>

        <div class="system-grid">
            <div class="system-box">
                <h3>Book Control</h3>
                <p>Add, view, edit, and delete book records with organized catalog management.</p>
            </div>

            <div class="system-box">
                <h3>Member Records</h3>
                <p>Maintain member profiles and manage library users from the admin dashboard.</p>
            </div>

            <div class="system-box">
                <h3>Issue & Return</h3>
                <p>Track issued books, returned books, and borrowing history accurately.</p>
            </div>

            <div class="system-box">
                <h3>Inventory Status</h3>
                <p>View available books and understand the current stock of the library.</p>
            </div>

            <div class="system-box">
                <h3>Reports</h3>
                <p>Generate useful reports for borrowing activity and library performance.</p>
            </div>

            <div class="system-box">
                <h3>Member Dashboard</h3>
                <p>Members can search books, view available books, and manage their profile.</p>
            </div>
        </div>
    </section>

    <footer class="footer">
        <p>&copy; {{ date('Y') }} Library Management System. All rights reserved.</p>
    </footer>

</body>
</html>