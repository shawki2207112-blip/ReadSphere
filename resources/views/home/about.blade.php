<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">

    <title>About - ReadSphere</title>

    <link rel="stylesheet" href="{{ asset('css/about.css') }}">
</head>

<body>
    {{-- Display the reusable public navigation bar. --}}
    @include('partials.public-navbar')

    <main>
        {{-- Introduction to the system. --}}
        <section class="about-hero" aria-labelledby="about-heading">
            <div class="about-text">
                <span class="tag">About Our System</span>

                <h1 id="about-heading">
                    Smart library management for admins and members
                </h1>

                <p>
                    Our Library Management System is designed to make library work easier,
                    faster, and more organized. It helps administrators manage books,
                    members, borrowing records, inventory status, and reports from one place.
                </p>

                {{-- Registration and contact links. --}}
                <div class="about-actions">
                    <a href="{{ route('register') }}" class="btn btn-primary">
                        Get Started
                    </a>

                    <a href="{{ route('contact') }}" class="btn btn-secondary">
                        Contact Us
                    </a>
                </div>
            </div>
        </section>

        {{-- Mission and vision of the system. --}}
        <section class="mission-section" aria-label="Mission and vision">
            <article class="mission-card">
                <h2>Our Mission</h2>

                <p>
                    To provide a simple digital platform where libraries can manage daily
                    operations efficiently and members can easily search, borrow, and track books.
                </p>
            </article>

            <article class="mission-card">
                <h2>Our Vision</h2>

                <p>
                    To reduce manual library work and create a smooth, organized, and user-friendly
                    library experience for students, readers, librarians, and administrators.
                </p>
            </article>
        </section>

        {{-- Main features provided by the system. --}}
        <section class="system-section" aria-labelledby="system-provides-heading">
            <h2 id="system-provides-heading">
                What This System Provides
            </h2>

            <div class="system-grid">
                <article class="system-box">
                    <h3>Book Control</h3>
                    <p>
                        Add, view, edit, and delete book records with organized
                        catalogue management.
                    </p>
                </article>

                <article class="system-box">
                    <h3>Member Records</h3>
                    <p>
                        Maintain member profiles and manage library users
                        from the admin dashboard.
                    </p>
                </article>

                <article class="system-box">
                    <h3>Issue &amp; Return</h3>
                    <p>
                        Track issued books, returned books, and borrowing
                        history accurately.
                    </p>
                </article>

                <article class="system-box">
                    <h3>Inventory Status</h3>
                    <p>
                        View available books and understand the current
                        stock of the library.
                    </p>
                </article>

                <article class="system-box">
                    <h3>Reports</h3>
                    <p>
                        Review useful totals for borrowing activity
                        and library performance.
                    </p>
                </article>

                <article class="system-box">
                    <h3>Member Dashboard</h3>
                    <p>
                        Members can search books, view available books,
                        and manage their profile.
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