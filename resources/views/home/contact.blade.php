<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Contact - Library Management System</title>

    <link rel="stylesheet" href="{{ asset('css/contact.css') }}">
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

    <section class="contact-hero">
        <span class="tag">Contact Us</span>
        <h1>We are here to help your library run smoothly</h1>
        <p>
            Contact the library team for membership support, book availability,
            borrowing information, returns, account access, and general library help.
        </p>
    </section>

    <section class="contact-section">
        <div class="contact-card main-card">
            <h2>Library Support Desk</h2>
            <p>
                Our support desk helps students, readers, librarians, and administrators
                with library services and system-related questions.
            </p>

            <div class="support-hours">
                <h3>Available Hours</h3>
                <p>Saturday - Thursday</p>
                <strong>9:00 AM - 5:00 PM</strong>
            </div>
        </div>

        <div class="contact-card">
            <div class="icon-box">📍</div>
            <h3>Address</h3>
            <p>Library Management Office, Main Campus,KUET</p>
        </div>

        <div class="contact-card">
            <div class="icon-box">✉</div>
            <h3>Email</h3>
            <p>library@gmail.com</p>
        </div>

        <div class="contact-card">
            <div class="icon-box">☎</div>
            <h3>Phone</h3>
            <p>+880 1234 567890</p>
        </div>
    </section>

    <section class="help-section">
        <h2>What can we help with?</h2>

        <div class="help-grid">
            <div class="help-box">
                <h3>Membership</h3>
                <p>Get help with registration, profile updates, and member account access.</p>
            </div>

            <div class="help-box">
                <h3>Book Availability</h3>
                <p>Ask about available books, searched titles, inventory, and catalog records.</p>
            </div>

            <div class="help-box">
                <h3>Borrowing & Returns</h3>
                <p>Receive support for issued books, return dates, borrowing history, and overdue records.</p>
            </div>
        </div>
    </section>

    <section class="notice-section">
        <div class="notice-box">
            <h2>Need faster support?</h2>
            <p>
                For urgent book issue or return problems, please visit the library office
                during working hours with your member ID.
            </p>
            <a href="{{ url('/login') }}" class="btn">Login to Your Account</a>
        </div>
    </section>

    <footer class="footer">
        <p>&copy; {{ date('Y') }} Library Management System. All rights reserved.</p>
    </footer>

</body>
</html>