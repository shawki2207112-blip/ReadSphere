<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <meta name="csrf-token" content="{{ csrf_token() }}">

    <title>Issue Book - ReadSphere</title>

    {{-- Load the shared dashboard stylesheet. --}}
    <link rel="stylesheet" href="{{ asset('css/dashboard.css') }}">
</head>

<body>
    <div class="app-shell">
        {{-- Shared admin dashboard sidebar. --}}
        @include('partials.dashboard-sidebar')

        <main class="main-content" id="main-content">
            @include('partials.dashboard-topbar', [
                'pageTitle' => 'Issue Book',
                'pageSubtitle' => 'Assign an available book to a member and set its due date.',
            ])

            <section class="content-area" aria-label="Issue Book">
                @include('partials.flash')

                {{-- Form for issuing an available book to a member. --}}
                <section class="form-card" aria-labelledby="issue-form-heading">
                    <h2 id="issue-form-heading" class="card-title">
                        Issue Information
                    </h2>

                    <form
                        method="POST"
                        action="{{ route('admin.borrowings.store') }}"
                    >
                        @csrf

                        <div class="form-grid">
                            <div class="form-field">
                                <label for="user_id">Member</label>

                                <select
                                    id="user_id"
                                    name="user_id"
                                    required
                                    autofocus
                                >
                                    <option value="">Select member</option>

                                    @foreach ($members as $member)
                                        <option
                                            value="{{ $member->id }}"
                                            @selected(old('user_id') == $member->id)
                                        >
                                            {{ $member->name }} — {{ $member->email }}
                                        </option>
                                    @endforeach
                                </select>
                            </div>

                            <div class="form-field">
                                <label for="book_id">Available Book</label>

                                <select id="book_id" name="book_id" required>
                                    <option value="">Select book</option>

                                    @foreach ($books as $book)
                                        <option
                                            value="{{ $book->id }}"
                                            @selected(old('book_id') == $book->id)
                                        >
                                            {{ $book->title }}
                                            ({{ $book->available_copies }} available)
                                        </option>
                                    @endforeach
                                </select>
                            </div>

                            <div class="form-field">
                                <label for="issue_date">Issue Date</label>

                                <input
                                    id="issue_date"
                                    name="issue_date"
                                    type="date"
                                    value="{{ old('issue_date', today()->format('Y-m-d')) }}"
                                    required
                                >
                            </div>

                            <div class="form-field">
                                <label for="due_date">Due Date</label>

                                <input
                                    id="due_date"
                                    name="due_date"
                                    type="date"
                                    value="{{ old('due_date', today()->addDays(14)->format('Y-m-d')) }}"
                                    required
                                >
                            </div>
                        </div>

                        {{-- Submit the issue request or view active borrowings. --}}
                        <div class="form-actions">
                            <button class="button" type="submit">
                                Issue Book
                            </button>

                            <a
                                class="button ghost"
                                href="{{ route('admin.borrowings.active') }}"
                            >
                                Active Borrowings
                            </a>
                        </div>
                    </form>
                </section>
            </section>
        </main>
    </div>

    {{-- Load shared dashboard JavaScript. --}}
    <script src="{{ asset('js/dashboard.js') }}"></script>
</body>
</html>