<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <meta name="csrf-token" content="{{ csrf_token() }}">

    <title>Book Details - ReadSphere</title>

    {{-- Load the shared dashboard stylesheet. --}}
    <link rel="stylesheet" href="{{ asset('css/dashboard.css') }}">
</head>

<body>
    <div class="app-shell">
        {{-- Shared admin dashboard sidebar. --}}
        @include('partials.dashboard-sidebar')

        <main class="main-content" id="main-content">
            @include('partials.dashboard-topbar', [
                'pageTitle' => 'Book Details',
                'pageSubtitle' => 'Catalogue and borrowing information for this title.',
            ])

            <section class="content-area" aria-label="Book Details">
                @include('partials.flash')

                {{-- Display the main information about the selected book. --}}
                <section class="details-grid" aria-label="Book details">
                    <article class="detail-card">
                        <span>Title</span>
                        <strong>{{ $book->title }}</strong>
                    </article>

                    <article class="detail-card">
                        <span>Author</span>
                        <strong>{{ $book->author }}</strong>
                    </article>

                    <article class="detail-card">
                        <span>ISBN</span>
                        <strong>{{ $book->isbn }}</strong>
                    </article>

                    <article class="detail-card">
                        <span>Category</span>
                        <strong>{{ $book->category->category_name }}</strong>
                    </article>

                    <article class="detail-card">
                        <span>Total Copies</span>
                        <strong>{{ $book->total_copies }}</strong>
                    </article>

                    <article class="detail-card">
                        <span>Available Copies</span>
                        <strong>{{ $book->available_copies }}</strong>
                    </article>
                </section>

                {{-- Book edit and back-navigation buttons. --}}
                <nav class="form-actions" aria-label="Book actions">
                    <a
                        class="button"
                        href="{{ route('admin.books.edit', $book) }}"
                    >
                        Edit Book
                    </a>

                    <a
                        class="button ghost"
                        href="{{ route('admin.books.index') }}"
                    >
                        Back
                    </a>
                </nav>

                {{-- Display all borrowing records associated with this book. --}}
                <section class="panel" aria-labelledby="book-borrowing-heading">
                    <div class="panel-heading">
                        <h2 id="book-borrowing-heading">
                            Borrowing Records
                        </h2>
                    </div>

                    <div class="table-wrap">
                        <table>
                            <caption class="sr-only">
                                Borrowing records for {{ $book->title }}
                            </caption>

                            <thead>
                                <tr>
                                    <th scope="col">Member</th>
                                    <th scope="col">Issue</th>
                                    <th scope="col">Due</th>
                                    <th scope="col">Returned</th>
                                    <th scope="col">Status</th>
                                </tr>
                            </thead>

                            <tbody>
                                @forelse (
                                    $book->borrowings->sortByDesc('issue_date')
                                    as $borrowing
                                )
                                    <tr>
                                        <td>{{ $borrowing->user->name }}</td>

                                        <td>
                                            {{ $borrowing->issue_date->format('d M Y') }}
                                        </td>

                                        <td>
                                            {{ $borrowing->due_date->format('d M Y') }}
                                        </td>

                                        <td>
                                            {{ $borrowing->returned_at?->format('d M Y') ?? '—' }}
                                        </td>

                                        <td>
                                            <x-status-badge
                                                :status="$borrowing->status"
                                            />
                                        </td>
                                    </tr>
                                @empty
                                    <tr>
                                        <td colspan="5" class="empty">
                                            This book has not been borrowed.
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