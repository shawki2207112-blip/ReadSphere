<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <meta name="csrf-token" content="{{ csrf_token() }}">

    <title>Member Details - ReadSphere</title>

    {{-- Load the shared dashboard stylesheet. --}}
    <link rel="stylesheet" href="{{ asset('css/dashboard.css') }}">
</head>

<body>
    <div class="app-shell">
        {{-- Shared admin dashboard sidebar. --}}
        @include('partials.dashboard-sidebar')

        <main class="main-content" id="main-content">
            @include('partials.dashboard-topbar', [
                'pageTitle' => 'Member Details',
                'pageSubtitle' => 'Profile and borrowing records for this member.',
            ])

            <section class="content-area" aria-label="Member Details">
                @include('partials.flash')

                {{-- Display the selected member's account information. --}}
                <section class="details-grid" aria-label="Member details">
                    <article class="detail-card">
                        <span>Name</span>
                        <strong>{{ $member->name }}</strong>
                    </article>

                    <article class="detail-card">
                        <span>Email</span>
                        <strong>{{ $member->email }}</strong>
                    </article>

                    <article class="detail-card">
                        <span>Phone</span>
                        <strong>{{ $member->phone ?: 'Not provided' }}</strong>
                    </article>

                    <article class="detail-card">
                        <span>Joined</span>
                        <strong>
                            {{ $member->created_at->format('d M Y') }}
                        </strong>
                    </article>
                </section>

                {{-- Member edit and back-navigation buttons. --}}
                <nav class="form-actions" aria-label="Member actions">
                    <a
                        class="button"
                        href="{{ route('admin.members.edit', $member) }}"
                    >
                        Edit Member
                    </a>

                    <a
                        class="button ghost"
                        href="{{ route('admin.members.index') }}"
                    >
                        Back
                    </a>
                </nav>

                {{-- Display all borrowing records belonging to this member. --}}
                <section class="panel" aria-labelledby="member-history-heading">
                    <div class="panel-heading">
                        <h2 id="member-history-heading">
                            Borrowing History
                        </h2>
                    </div>

                    <div class="table-wrap">
                        <table>
                            <caption class="sr-only">
                                Borrowing history for {{ $member->name }}
                            </caption>

                            <thead>
                                <tr>
                                    <th scope="col">Book</th>
                                    <th scope="col">Issue Date</th>
                                    <th scope="col">Due Date</th>
                                    <th scope="col">Returned</th>
                                    <th scope="col">Status</th>
                                </tr>
                            </thead>

                            <tbody>
                                @forelse (
                                    $member->borrowings->sortByDesc('issue_date')
                                    as $borrowing
                                )
                                    <tr>
                                        <td>{{ $borrowing->book->title }}</td>

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
                                            No borrowing history.
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