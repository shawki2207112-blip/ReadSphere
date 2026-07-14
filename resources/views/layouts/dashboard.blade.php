<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">

    {{-- Make the dashboard responsive --}}
    <meta name="viewport" content="width=device-width, initial-scale=1.0">

    {{-- Provide the CSRF token for JavaScript or AJAX requests. --}}
    <meta name="csrf-token" content="{{ csrf_token() }}">

    {{-- Display a page-specific title, with Dashboard as the default. --}}
    <title>@yield('title', 'Dashboard') - ReadSphere</title>

    <link rel="stylesheet" href="{{ asset('css/dashboard.css') }}">
</head>

<body>
    {{-- Main dashboard layout containing the sidebar and page content. --}}
    <div class="app-shell">

        {{-- Display the reusable admin or member sidebar. --}}
        @include('partials.dashboard-sidebar')

        <main class="main-content" id="main-content">

            {{-- Display the reusable dashboard topbar.--}}
            @include('partials.dashboard-topbar', [
                'pageTitle' => trim(
                    $__env->yieldContent('page-title', 'Dashboard')
                ),
                'pageSubtitle' => trim(
                    $__env->yieldContent('page-subtitle')
                ),
            ])

            {{-- Main area for flash messages and page-specific content. --}}
            <section class="content-area">

                {{-- Display success, error, and validation messages. --}}
                @include('partials.flash')

                {{-- Insert the unique content of each dashboard page. --}}
                @yield('content')
            </section>
        </main>
    </div>

    {{-- Load JavaScript used by the dashboard sidebar and other interactions. --}}
    <script src="{{ asset('js/dashboard.js') }}"></script>

    {{-- Allow individual pages to add their own JavaScript. --}}
    @stack('scripts')
</body>
</html>