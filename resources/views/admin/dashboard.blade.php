<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">

    {{-- CSRF token for secure JavaScript or AJAX requests. --}}
    <meta name="csrf-token" content="{{ csrf_token() }}">

    <title>Admin Dashboard - ReadSphere</title>

    {{-- Load the shared dashboard stylesheet. --}}
    <link rel="stylesheet" href="{{ asset('css/dashboard.css') }}">
</head>

<body>
    <div class="app-shell">

        {{-- Reusable dashboard sidebar. --}}
        @include('partials.dashboard-sidebar')

        <main class="main-content" id="main-content">

            {{-- Dashboard title and subtitle. --}}
            @include('partials.dashboard-topbar', [
                'pageTitle' => 'Admin Dashboard',
                'pageSubtitle' => 'Overview of books, members, inventory, and borrowing activity.',
            ])

            <section class="content-area" aria-label="Admin Dashboard">

                {{-- Display success, error, and validation messages. --}}
                @include('partials.flash')

                {{-- Summary cards for the main library statistics. --}}
                <section class="stats-grid" aria-label="Library summary">
                    <article class="stat-card">
                        <span>Book Titles</span>
                        <strong>{{ $stats['book_titles'] }}</strong>
                    </article>

                    <article class="stat-card">
                        <span>Total Copies</span>
                        <strong>{{ $stats['total_copies'] }}</strong>
                    </article>

                    <article class="stat-card">
                        <span>Available Copies</span>
                        <strong>{{ $stats['available_copies'] }}</strong>
                    </article>

                    <article class="stat-card">
                        <span>Members</span>
                        <strong>{{ $stats['members'] }}</strong>
                    </article>

                    <article class="stat-card">
                        <span>Active Borrowings</span>
                        <strong>{{ $stats['active_borrowings'] }}</strong>
                    </article>

                    <article class="stat-card danger">
                        <span>Overdue</span>
                        <strong>{{ $stats['overdue'] }}</strong>
                    </article>
                </section>

                {{-- Shortcuts to common admin actions. --}}
                <nav class="quick-actions" aria-label="Quick actions">
                    <a class="button" href="{{ route('admin.books.create') }}">
                        Add Book
                    </a>

                    <a class="button secondary" href="{{ route('admin.members.create') }}">
                        Add Member
                    </a>

                    <a class="button secondary" href="{{ route('admin.borrowings.create') }}">
                        Issue Book
                    </a>
                </nav>

                {{-- Show the latest borrowing records. --}}
                <section class="panel" aria-labelledby="recent-borrowings-heading">
                    <div class="panel-heading">
                        <h2 id="recent-borrowings-heading">
                            Recent Borrowing Activity
                        </h2>

                        <a href="{{ route('admin.borrowings.history') }}">
                            View all
                        </a>
                    </div>

                    <div class="table-wrap">
                        <table>
                            <caption class="sr-only">
                                Recent borrowing activity
                            </caption>

                            <thead>
                                <tr>
                                    <th scope="col">Member</th>
                                    <th scope="col">Book</th>
                                    <th scope="col">Issue Date</th>
                                    <th scope="col">Due Date</th>
                                    <th scope="col">Status</th>
                                </tr>
                            </thead>

                            <tbody>
                                @forelse ($recentBorrowings as $borrowing)
                                    <tr>
                                        <td>{{ $borrowing->user->name }}</td>
                                        <td>{{ $borrowing->book->title }}</td>
                                        <td>{{ $borrowing->issue_date->format('d M Y') }}</td>
                                        <td>{{ $borrowing->due_date->format('d M Y') }}</td>
                                        <td>
                                            <x-status-badge :status="$borrowing->status" />
                                        </td>
                                    </tr>
                                @empty
                                    <tr>
                                        <td colspan="5" class="empty">
                                            No borrowing records yet.
                                        </td>
                                    </tr>
                                @endforelse
                            </tbody>
                        </table>
                    </div>
                </section>
            </section>
        </main>
    </div>

    {{-- Load shared dashboard JavaScript. --}}
    <script src="{{ asset('js/dashboard.js') }}"></script>
</body>
</html>