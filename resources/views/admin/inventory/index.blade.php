<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <meta name="csrf-token" content="{{ csrf_token() }}">

    <title>Inventory Status - ReadSphere</title>

    {{-- Load the shared dashboard stylesheet. --}}
    <link rel="stylesheet" href="{{ asset('css/dashboard.css') }}">
</head>

<body>
    <div class="app-shell">
        {{-- Shared admin dashboard sidebar. --}}
        @include('partials.dashboard-sidebar')

        <main class="main-content" id="main-content">
            @include('partials.dashboard-topbar', [
                'pageTitle' => 'Inventory Status',
                'pageSubtitle' => 'See total, available, and borrowed copies for each title.',
            ])

            <section class="content-area" aria-label="Inventory Status">
                @include('partials.flash')

                {{-- Display the overall inventory summary. --}}
                <section class="stats-grid compact" aria-label="Inventory summary">
                    <article class="stat-card">
                        <span>Titles</span>
                        <strong>{{ $summary['titles'] }}</strong>
                    </article>

                    <article class="stat-card">
                        <span>Total Copies</span>
                        <strong>{{ $summary['total'] }}</strong>
                    </article>

                    <article class="stat-card">
                        <span>Available</span>
                        <strong>{{ $summary['available'] }}</strong>
                    </article>

                    <article class="stat-card">
                        <span>Borrowed</span>
                        <strong>{{ $summary['borrowed'] }}</strong>
                    </article>
                </section>

                {{-- Search and filter inventory records. --}}
                <div class="toolbar">
                    <form
                        class="filter-form"
                        method="GET"
                        action="{{ route('admin.inventory') }}"
                        aria-label="Filter inventory"
                    >
                        <label class="sr-only" for="inventory-search">
                            Search inventory
                        </label>

                        <input
                            id="inventory-search"
                            name="search"
                            type="search"
                            value="{{ request('search') }}"
                            placeholder="Title, author or ISBN"
                        >

                        <label class="sr-only" for="inventory-category">
                            Filter by category
                        </label>

                        <select id="inventory-category" name="category_id">
                            <option value="">All categories</option>

                            @foreach ($categories as $category)
                                <option
                                    value="{{ $category->id }}"
                                    @selected(request('category_id') == $category->id)
                                >
                                    {{ $category->category_name }}
                                </option>
                            @endforeach
                        </select>

                        <label class="sr-only" for="inventory-availability">
                            Filter by availability
                        </label>

                        <select
                            id="inventory-availability"
                            name="availability"
                        >
                            <option value="">Any availability</option>

                            <option
                                value="available"
                                @selected(request('availability') === 'available')
                            >
                                Available
                            </option>

                            <option
                                value="unavailable"
                                @selected(request('availability') === 'unavailable')
                            >
                                Unavailable
                            </option>
                        </select>

                        <button class="button" type="submit">
                            Filter
                        </button>

                        <a
                            class="button ghost"
                            href="{{ route('admin.inventory') }}"
                        >
                            Reset
                        </a>
                    </form>
                </div>

                {{-- Display the filtered and paginated inventory list. --}}
                <section class="panel" aria-labelledby="inventory-list-heading">
                    <h2 id="inventory-list-heading" class="sr-only">
                        Inventory List
                    </h2>

                    <div class="table-wrap">
                        <table>
                            <caption class="sr-only">
                                Book inventory status
                            </caption>

                            <thead>
                                <tr>
                                    <th scope="col">Book</th>
                                    <th scope="col">Category</th>
                                    <th scope="col">Total</th>
                                    <th scope="col">Available</th>
                                    <th scope="col">Borrowed</th>
                                    <th scope="col">Status</th>
                                </tr>
                            </thead>

                            <tbody>
                                @forelse ($books as $book)
                                    <tr>
                                        <td>{{ $book->title }}</td>
                                        <td>{{ $book->category->category_name }}</td>
                                        <td>{{ $book->total_copies }}</td>
                                        <td>{{ $book->available_copies }}</td>

                                        <td>
                                            {{ $book->total_copies - $book->available_copies }}
                                        </td>

                                        <td>
                                            {{-- Show the current availability status. --}}
                                            <span
                                                class="badge {{ $book->available_copies > 0
                                                    ? 'badge-success'
                                                    : 'badge-danger' }}"
                                            >
                                                {{ $book->available_copies > 0
                                                    ? 'Available'
                                                    : 'Out of stock' }}
                                            </span>
                                        </td>
                                    </tr>
                                @empty
                                    <tr>
                                        <td colspan="6" class="empty">
                                            No books found.
                                        </td>
                                    </tr>
                                @endforelse
                            </tbody>
                        </table>
                    </div>

                    {{-- Display pagination links while keeping active filters. --}}
                    <div class="pagination-wrap">
                        {{ $books->links() }}
                    </div>
                </section>
            </section>
        </main>
    </div>

    {{-- Load shared dashboard JavaScript. --}}
    <script src="{{ asset('js/dashboard.js') }}"></script>
</body>
</html>