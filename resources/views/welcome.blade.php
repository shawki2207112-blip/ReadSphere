<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">

    <title>ReadSphere</title>

    <link rel="stylesheet" href="{{ asset('css/home.css') }}">
</head>
<body>
    @include('partials.public-navbar')

    <main class="simple-page">
        <section class="simple-card">
            <h1>ReadSphere Library Management System</h1>
            <p>The application is ready. Use the public website or sign in to continue.</p>
            <a class="btn btn-primary" href="{{ route('home') }}">Open Home Page</a>
        </section>
    </main>

    <footer class="footer">
        <p>&copy; {{ date('Y') }} ReadSphere Library Management System.</p>
    </footer>
</body>
</html>
