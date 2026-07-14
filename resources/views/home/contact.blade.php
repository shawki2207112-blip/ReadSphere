<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">

    <title>Contact - ReadSphere</title>

    {{-- Load the contact page stylesheet. --}}
    <link rel="stylesheet" href="{{ asset('css/contact.css') }}">
</head>

<body>
    {{-- Display the reusable public navigation bar. --}}
    @include('partials.public-navbar')

    <main>
        {{-- Contact page introduction section. --}}
        <section class="contact-hero" aria-labelledby="contact-heading">
            <span class="tag">Contact Us</span>

            <h1 id="contact-heading">
                We are here to help your library run smoothly
            </h1>

            <p>
                Contact the library team for membership support, book availability,
                borrowing information, returns, account access, and general library help.
            </p>
        </section>

        {{-- Main library contact information. --}}
        <section class="contact-section" aria-label="Contact information">
            <article class="contact-card main-card">
                <h2>Library Support Desk</h2>

                <p>
                    Our support desk helps students, readers, librarians, and administrators
                    with library services and system-related questions.
                </p>

                {{-- Library support hours. --}}
                <div class="support-hours">
                    <h3>Available Hours</h3>
                    <p>Saturday - Thursday</p>
                    <strong>9:00 AM - 5:00 PM</strong>
                </div>
            </article>

            {{-- Library address. --}}
            <article class="contact-card">
                <div class="icon-box" aria-hidden="true">📍</div>
                <h3>Address</h3>
                <p>Library Management Office, Main Campus, KUET</p>
            </article>

            {{-- Library email address. --}}
            <article class="contact-card">
                <div class="icon-box" aria-hidden="true">✉</div>
                <h3>Email</h3>
                <p>
                    <a href="mailto:library@gmail.com">
                        library@gmail.com
                    </a>
                </p>
            </article>

            {{-- Library phone number. --}}
            <article class="contact-card">
                <div class="icon-box" aria-hidden="true">☎</div>
                <h3>Phone</h3>
                <p>
                    <a href="tel:+8801234567890">
                        +880 1234 567890
                    </a>
                </p>
            </article>
        </section>

        {{-- Types of support provided by the library. --}}
        <section class="help-section" aria-labelledby="help-heading">
            <h2 id="help-heading">What can we help with?</h2>

            <div class="help-grid">
                <article class="help-box">
                    <h3>Membership</h3>
                    <p>
                        Get help with registration, profile updates,
                        and member account access.
                    </p>
                </article>

                <article class="help-box">
                    <h3>Book Availability</h3>
                    <p>
                        Ask about available books, searched titles,
                        inventory, and catalogue records.
                    </p>
                </article>

                <article class="help-box">
                    <h3>Borrowing &amp; Returns</h3>
                    <p>
                        Receive support for issued books, return dates,
                        borrowing history, and overdue records.
                    </p>
                </article>
            </div>
        </section>

        {{-- Urgent support notice and account login link. --}}
        <section class="notice-section" aria-labelledby="urgent-support-heading">
            <div class="notice-box">
                <h2 id="urgent-support-heading">Need faster support?</h2>

                <p>
                    For urgent book issue or return problems, please visit the library office
                    during working hours with your member ID.
                </p>

                <a href="{{ route('login') }}" class="btn">
                    Login to Your Account
                </a>
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