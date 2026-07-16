<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <meta name="csrf-token" content="{{ csrf_token() }}">

    <title>Borrowing History - ReadSphere</title>

    {{-- Load the shared dashboard stylesheet. --}}
    <link rel="stylesheet" href="{{ asset('css/dashboard.css') }}">
</head>

<body>
    <div class="app-shell">
        {{-- Shared admin dashboard sidebar. --}}
        @include('partials.dashboard-sidebar')

        <main class="main-content" id="main-content">
            @include('partials.dashboard-topbar', [
                'pageTitle' => 'Borrowing History',
                'pageSubtitle' => 'Review all current and completed borrowing records.',
            ])

            <section class="content-area" aria-label="Borrowing History">
                @include('partials.flash')

                {{-- Search borrowing records and filter them by status. --}}
                <div class="toolbar">
                    <form
                        class="filter-form"
                        method="GET"
                        action="{{ route('admin.borrowings.history') }}"
                        aria-label="Filter borrowing history"
                    >
                        <label class="sr-only" for="history-search">
                            Search by member or book
                        </label>

                        <input
                            id="history-search"
                            name="search"
                            type="search"
                            value="{{ request('search') }}"
                            placeholder="Member or book"
                        >

                        <label class="sr-only" for="status-filter">
                            Filter by status
                        </label>

                        <select id="status-filter" name="status">
                            <option value="">All statuses</option>

                            <option
                                value="borrowed"
                                @selected(request('status') === 'borrowed')
                            >
                                Borrowed
                            </option>

                            <option
                                value="returned"
                                @selected(request('status') === 'returned')
                            >
                                Returned
                            </option>
                        </select>

                        <button class="button" type="submit">
                            Filter
                        </button>

                        <a
                            class="button ghost"
                            href="{{ route('admin.borrowings.history') }}"
                        >
                            Reset
                        </a>
                    </form>
                </div>

                {{-- Display all active and returned borrowing records. --}}
                <section class="panel" aria-labelledby="borrowing-history-heading">
                    <h2 id="borrowing-history-heading" class="sr-only">
                        Borrowing History
                    </h2>

                    <div class="table-wrap">
                        <table>
                            <caption class="sr-only">
                                All borrowing records
                            </caption>

                            <thead>
                                <tr>
                                    <th scope="col">Member</th>
                                    <th scope="col">Book</th>
                                    <th scope="col">Issue</th>
                                    <th scope="col">Due</th>
                                    <th scope="col">Returned</th>
                                    <th scope="col">Status</th>
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
                                            {{ $borrowing->returned_at?->format('d M Y') ?? '—' }}
                                        </td>

                                        <td>
                                            <x-status-badge :status="$borrowing->status" />
                                        </td>
                                    </tr>
                                @empty
                                    <tr>
                                        <td colspan="6" class="empty">
                                            No borrowing records found.
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

    {{-- Load shared dashboard JavaScript. --}}
    <script src="{{ asset('js/dashboard.js') }}"></script>
</body>
</html>