<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <meta name="csrf-token" content="{{ csrf_token() }}">

    <title>Member Dashboard - ReadSphere</title>

    <link rel="stylesheet" href="{{ asset('css/dashboard.css') }}">
</head>

<body>
    <div class="app-shell">
        {{-- Shared dashboard sidebar. --}}
        @include('partials.dashboard-sidebar')

        <main class="main-content" id="main-content">
            @include('partials.dashboard-topbar', [
                'pageTitle' => 'Member Dashboard',
                'pageSubtitle' => 'Search books and review your personal borrowing information.',
            ])

            <section class="content-area" aria-label="Member Dashboard">
                @include('partials.flash')

                {{-- Personal borrowing statistics. --}}
                <section
                    class="stats-grid compact"
                    aria-label="Member borrowing summary"
                >
                    <article class="stat-card">
                        <span>Available Titles</span>
                        <strong>{{ $stats['available_books'] }}</strong>
                    </article>

                    <article class="stat-card">
                        <span>Currently Borrowed</span>
                        <strong>{{ $stats['current_borrowings'] }}</strong>
                    </article>

                    <article class="stat-card">
                        <span>Total History</span>
                        <strong>{{ $stats['history'] }}</strong>
                    </article>

                    <article class="stat-card danger">
                        <span>Overdue</span>
                        <strong>{{ $stats['overdue'] }}</strong>
                    </article>
                </section>

                {{--
                    These links will be restored after their routes
                    and controller methods are created.

                <nav class="quick-actions" aria-label="Member quick actions">
                    <a
                        class="button"
                        href="{{ route('member.books.index') }}"
                    >
                        Search Catalogue
                    </a>

                    <a
                        class="button secondary"
                        href="{{ route('member.borrowings.current') }}"
                    >
                        My Borrowed Books
                    </a>
                </nav>
                --}}

                {{-- Member's currently borrowed books. --}}
                <section class="panel" aria-labelledby="current-borrowings-heading">
                    <div class="panel-heading">
                        <h2 id="current-borrowings-heading">
                            Current Borrowings
                        </h2>
                    </div>

                    <div class="table-wrap">
                        <table>
                            <caption class="sr-only">
                                Your current borrowing records
                            </caption>

                            <thead>
                                <tr>
                                    <th scope="col">Book</th>
                                    <th scope="col">Category</th>
                                    <th scope="col">Issue Date</th>
                                    <th scope="col">Due Date</th>
                                    <th scope="col">Condition</th>
                                </tr>
                            </thead>

                            <tbody>
                                @forelse ($currentBorrowings as $borrowing)
                                    <tr>
                                        <td>{{ $borrowing->book->title }}</td>

                                        <td>
                                            {{ $borrowing->book->category->category_name }}
                                        </td>

                                        <td>
                                            {{ $borrowing->issue_date->format('d M Y') }}
                                        </td>

                                        <td>
                                            {{ $borrowing->due_date->format('d M Y') }}
                                        </td>

                                        <td>
                                            <span
                                                class="badge {{ $borrowing->is_overdue
                                                    ? 'badge-danger'
                                                    : 'badge-warning' }}"
                                            >
                                                {{ $borrowing->is_overdue
                                                    ? 'Overdue'
                                                    : 'On loan' }}
                                            </span>
                                        </td>
                                    </tr>
                                @empty
                                    <tr>
                                        <td colspan="5" class="empty">
                                            You have no borrowed books.
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

    <script src="{{ asset('js/dashboard.js') }}"></script>
</body>
</html>