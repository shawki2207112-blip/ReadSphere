<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <meta name="csrf-token" content="{{ csrf_token() }}">

    <title>Reports - ReadSphere</title>

    {{-- Load the shared dashboard stylesheet. --}}
    <link rel="stylesheet" href="{{ asset('css/dashboard.css') }}">
</head>

<body>
    <div class="app-shell">
        {{-- Shared admin dashboard sidebar. --}}
        @include('partials.dashboard-sidebar')

        <main class="main-content" id="main-content">
            @include('partials.dashboard-topbar', [
                'pageTitle' => 'Simple Reports',
                'pageSubtitle' => 'Basic library totals, popular books, and overdue records without complex charts.',
            ])

            <section class="content-area" aria-label="Simple Reports">
                @include('partials.flash')

                {{-- Display the main library report totals. --}}
                <section class="stats-grid" aria-label="Report summary">
                    <article class="stat-card">
                        <span>Members</span>
                        <strong>{{ $summary['members'] }}</strong>
                    </article>

                    <article class="stat-card">
                        <span>Book Titles</span>
                        <strong>{{ $summary['books'] }}</strong>
                    </article>

                    <article class="stat-card">
                        <span>Total Issues</span>
                        <strong>{{ $summary['issues'] }}</strong>
                    </article>

                    <article class="stat-card">
                        <span>Active</span>
                        <strong>{{ $summary['active'] }}</strong>
                    </article>

                    <article class="stat-card">
                        <span>Returned</span>
                        <strong>{{ $summary['returned'] }}</strong>
                    </article>

                    <article class="stat-card danger">
                        <span>Overdue</span>
                        <strong>{{ $summary['overdue'] }}</strong>
                    </article>
                </section>

                {{-- Display popular books and overdue records side by side. --}}
                <div class="two-column">

                    {{-- Most frequently borrowed books. --}}
                    <section class="panel" aria-labelledby="top-books-heading">
                        <div class="panel-heading">
                            <h2 id="top-books-heading">
                                Most Borrowed Books
                            </h2>
                        </div>

                        <div class="table-wrap">
                            <table>
                                <caption class="sr-only">
                                    Most borrowed books
                                </caption>

                                <thead>
                                    <tr>
                                        <th scope="col">Book</th>
                                        <th scope="col">Borrowings</th>
                                    </tr>
                                </thead>

                                <tbody>
                                    @forelse ($topBooks as $book)
                                        <tr>
                                            <td>{{ $book->title }}</td>
                                            <td>{{ $book->borrowings_count }}</td>
                                        </tr>
                                    @empty
                                        <tr>
                                            <td colspan="2" class="empty">
                                                No data yet.
                                            </td>
                                        </tr>
                                    @endforelse
                                </tbody>
                            </table>
                        </div>
                    </section>

                    {{-- Currently overdue borrowing records. --}}
                    <section class="panel" aria-labelledby="overdue-records-heading">
                        <div class="panel-heading">
                            <h2 id="overdue-records-heading">
                                Overdue Records
                            </h2>
                        </div>

                        <div class="table-wrap">
                            <table>
                                <caption class="sr-only">
                                    Overdue borrowing records
                                </caption>

                                <thead>
                                    <tr>
                                        <th scope="col">Member</th>
                                        <th scope="col">Book</th>
                                        <th scope="col">Due</th>
                                    </tr>
                                </thead>

                                <tbody>
                                    @forelse ($overdueBorrowings as $borrowing)
                                        <tr>
                                            <td>{{ $borrowing->user->name }}</td>
                                            <td>{{ $borrowing->book->title }}</td>
                                            <td>
                                                {{ $borrowing->due_date->format('d M Y') }}
                                            </td>
                                        </tr>
                                    @empty
                                        <tr>
                                            <td colspan="3" class="empty">
                                                No overdue records.
                                            </td>
                                        </tr>
                                    @endforelse
                                </tbody>
                            </table>
                        </div>
                    </section>
                </div>
            </section>
        </main>
    </div>

    {{-- Load shared dashboard JavaScript. --}}
    <script src="{{ asset('js/dashboard.js') }}"></script>
</body>
</html>