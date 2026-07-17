<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <meta name="csrf-token" content="{{ csrf_token() }}">

    <title>My Borrowed Books - ReadSphere</title>

    {{-- Load the shared dashboard stylesheet. --}}
    <link rel="stylesheet" href="{{ asset('css/dashboard.css') }}">
</head>
<body>
    <div class="app-shell">
        @include('partials.dashboard-sidebar')

        <main class="main-content" id="main-content">
            @include('partials.dashboard-topbar', [
                'pageTitle' => 'My Borrowed Books',
                'pageSubtitle' => 'Books currently issued to your member account.',
            ])

            <section class="content-area" aria-label="My Borrowed Books">
                @include('partials.flash')

                {{-- Display books currently borrowed by the logged-in member. --}}
                <section
                    class="panel"
                    aria-labelledby="my-borrowed-books-heading"
                >
                    <h2
                        id="my-borrowed-books-heading"
                        class="sr-only"
                    >
                        My Borrowed Books
                    </h2>

                    <div class="table-wrap">
                        <table>
                            <caption class="sr-only">
                                Books currently issued to you
                            </caption>

                            <thead>
                                <tr>
                                    <th scope="col">Book</th>
                                    <th scope="col">Author</th>
                                    <th scope="col">Category</th>
                                    <th scope="col">Issue Date</th>
                                    <th scope="col">Due Date</th>
                                    <th scope="col">Condition</th>
                                </tr>
                            </thead>

                            <tbody>
                                @forelse ($borrowings as $borrowing)
                                    <tr>
                                        <td>
                                            {{ $borrowing->book->title }}
                                        </td>

                                        <td>
                                            {{ $borrowing->book->author }}
                                        </td>

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
                                            {{-- Show whether the loan is overdue. --}}
                                            <span
                                                class="badge {{ $borrowing->is_overdue ? 'badge-danger' : 'badge-warning' }}"
                                            >
                                                {{ $borrowing->is_overdue
                                                    ? 'Overdue'
                                                    : 'On loan' }}
                                            </span>
                                        </td>
                                    </tr>
                                @empty
                                    <tr>
                                        <td colspan="6" class="empty">
                                            You currently have no borrowed books.
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