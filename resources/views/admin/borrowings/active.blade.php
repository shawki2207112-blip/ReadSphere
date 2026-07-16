<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <meta name="csrf-token" content="{{ csrf_token() }}">

    <title>Return Book - ReadSphere</title>

    {{-- Load the shared dashboard stylesheet. --}}
    <link rel="stylesheet" href="{{ asset('css/dashboard.css') }}">
</head>

<body>
    <div class="app-shell">
        {{-- Shared admin dashboard sidebar. --}}
        @include('partials.dashboard-sidebar')

        <main class="main-content" id="main-content">
            @include('partials.dashboard-topbar', [
                'pageTitle' => 'Active Borrowings / Return Book',
                'pageSubtitle' => 'Find active issues and mark a book as returned.',
            ])

            <section class="content-area" aria-label="Active Borrowings / Return Book">
                @include('partials.flash')

                {{-- Search and filter active borrowing records. --}}
                <div class="toolbar">
                    <form
                        class="filter-form"
                        method="GET"
                        action="{{ route('admin.borrowings.active') }}"
                        aria-label="Filter active borrowings"
                    >
                        <label class="sr-only" for="active-search">
                            Search by member or book
                        </label>

                        <input
                            id="active-search"
                            name="search"
                            type="search"
                            value="{{ request('search') }}"
                            placeholder="Member or book"
                        >

                        <label class="sr-only" for="overdue-filter">
                            Filter overdue borrowings
                        </label>

                        <select id="overdue-filter" name="overdue">
                            <option value="">All active</option>

                            <option
                                value="yes"
                                @selected(request('overdue') === 'yes')
                            >
                                Overdue only
                            </option>
                        </select>

                        <button class="button" type="submit">
                            Filter
                        </button>

                        <a
                            class="button ghost"
                            href="{{ route('admin.borrowings.active') }}"
                        >
                            Reset
                        </a>
                    </form>

                    <a
                        class="button"
                        href="{{ route('admin.borrowings.create') }}"
                    >
                        Issue New Book
                    </a>
                </div>

                {{-- Display active borrowings and return-book actions. --}}
                <section class="panel" aria-labelledby="active-borrowings-heading">
                    <h2 id="active-borrowings-heading" class="sr-only">
                        Active Borrowings
                    </h2>

                    <div class="table-wrap">
                        <table>
                            <caption class="sr-only">
                                Active borrowing records
                            </caption>

                            <thead>
                                <tr>
                                    <th scope="col">Member</th>
                                    <th scope="col">Book</th>
                                    <th scope="col">Issue Date</th>
                                    <th scope="col">Due Date</th>
                                    <th scope="col">Condition</th>
                                    <th scope="col">Action</th>
                                </tr>
                            </thead>

                            <tbody>
                                @forelse ($borrowings as $borrowing)
                                    <tr>
                                        <td>{{ $borrowing->user->name }}</td>
                                        <td>{{ $borrowing->book->title }}</td>
                                        <td>{{ $borrowing->issue_date->format('d M Y') }}</td>
                                        <td>{{ $borrowing->due_date->format('d M Y') }}</td>

                                        <td>
                                            {{-- Show whether the borrowing is overdue. --}}
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

                                        <td>
                                            {{-- Mark the selected borrowing as returned. --}}
                                            <form
                                                method="POST"
                                                action="{{ route('admin.borrowings.return', $borrowing) }}"
                                                data-confirm="Mark this book as returned?"
                                            >
                                                @csrf
                                                @method('PATCH')

                                                <button
                                                    class="button small"
                                                    type="submit"
                                                >
                                                    Return Book
                                                </button>
                                            </form>
                                        </td>
                                    </tr>
                                @empty
                                    <tr>
                                        <td colspan="6" class="empty">
                                            No active borrowings found.
                                        </td>
                                    </tr>
                                @endforelse
                            </tbody>
                        </table>
                    </div>

                    {{-- Display pagination links with active filters. --}}
                    <div class="pagination-wrap">
                        {{ $borrowings->links() }}
                    </div>
                </section>
            </section>
        </main>
    </div>

    {{-- Load shared dashboard JavaScript and confirmation messages. --}}
    <script src="{{ asset('js/dashboard.js') }}"></script>
</body>
</html>