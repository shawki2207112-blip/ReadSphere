<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <meta name="csrf-token" content="{{ csrf_token() }}">

    <title>Borrow History - ReadSphere</title>

    {{-- Load the shared dashboard stylesheet. --}}
    <link rel="stylesheet" href="{{ asset('css/dashboard.css') }}">
</head>
<body>
    <div class="app-shell">
        @include('partials.dashboard-sidebar')

        <main class="main-content" id="main-content">
            @include('partials.dashboard-topbar', [
                'pageTitle' => 'My Borrow History',
                'pageSubtitle' => 'All books previously and currently linked to your account.',
            ])

            <section class="content-area" aria-label="My Borrow History">
                @include('partials.flash')

                {{-- Filter borrowing history by current status. --}}
                <div class="toolbar">
                    <form
                        class="filter-form"
                        method="GET"
                        action="{{ route('member.borrowings.history') }}"
                        aria-label="Filter your borrowing history"
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
                            href="{{ route('member.borrowings.history') }}"
                        >
                            Reset
                        </a>
                    </form>
                </div>

                {{-- Display the member's complete borrowing history. --}}
                <section
                    class="panel"
                    aria-labelledby="member-history-heading"
                >
                    <h2
                        id="member-history-heading"
                        class="sr-only"
                    >
                        My Borrow History
                    </h2>

                    <div class="table-wrap">
                        <table>
                            <caption class="sr-only">
                                Your complete borrowing history
                            </caption>

                            <thead>
                                <tr>
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
                                        <td>
                                            {{ $borrowing->book->title }}
                                        </td>

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

                                               <x-status-badge :status="$borrowing->is_overdue?'overdue': $borrowing->status"
                                                />
                                        </td>
                                    </tr>
                                @empty
                                    <tr>
                                        <td colspan="5" class="empty">
                                            No borrowing history.
                                        </td>
                                    </tr>
                                @endforelse
                            </tbody>
                        </table>
                    </div>

                    {{-- Display pagination links for history records. --}}
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