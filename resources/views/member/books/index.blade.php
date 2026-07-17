<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <meta name="csrf-token" content="{{ csrf_token() }}">

    <title>
        {{ $onlyAvailable ? 'Available Books' : 'Search Books' }}
        - ReadSphere
    </title>

    {{-- Shared dashboard styles. --}}
    <link rel="stylesheet" href="{{ asset('css/dashboard.css') }}">
</head>

<body>
    <div class="app-shell">
        @include('partials.dashboard-sidebar')

        <main class="main-content" id="main-content">
            @include('partials.dashboard-topbar', [
                'pageTitle' => $onlyAvailable
                    ? 'Available Books'
                    : 'Search Books',
            ])

            <section
                class="content-area"
                aria-label="{{ $onlyAvailable ? 'Available Books' : 'Search Books' }}"
            >
                @include('partials.flash')

                {{-- Book search and filtering controls. --}}
                <section
                    class="filter-card"
                    aria-labelledby="book-filter-heading"
                >
                    <h2 id="book-filter-heading" class="sr-only">
                        Book Search Filters
                    </h2>

                    <div class="filter-form api-filters">
                        <label class="sr-only" for="search">
                            Search books
                        </label>

                        <input
                            id="search"
                            type="search"
                            placeholder="Search title, author or ISBN"
                        >

                        <label class="sr-only" for="category">
                            Filter by category
                        </label>

                        <select id="category">
                            <option value="">All categories</option>

                            @foreach ($categories as $category)
                                <option value="{{ $category->id }}">
                                    {{ $category->category_name }}
                                </option>
                            @endforeach
                        </select>

                        <label class="sr-only" for="availability">
                            Filter by availability
                        </label>

                        <select id="availability">
                            <option value="">Any availability</option>

                            <option
                                value="available"
                                {{ $onlyAvailable ? 'selected' : '' }}
                            >
                                Available only
                            </option>

                            <option value="unavailable">
                                Unavailable
                            </option>
                        </select>

                        <button
                            class="button"
                            type="button"
                            id="searchButton"
                        >
                            Search
                        </button>

                        <button
                            class="button ghost"
                            type="button"
                            id="resetButton"
                        >
                            Reset
                        </button>
                    </div>
                </section>

                {{-- Updated by JavaScript after an API request. --}}
                <p
                    id="resultSummary"
                    class="result-summary"
                    aria-live="polite"
                ></p>

                {{-- Initial books are rendered by Laravel. --}}
                <section
                    id="bookGrid"
                    class="book-grid"
                    aria-label="Book search results"
                    aria-live="polite"
                >
                    @forelse ($initialBooks as $book)
                        <article class="book-card">
                            <span class="book-category">
                                {{ $book->category?->category_name ?? 'Uncategorized' }}
                            </span>

                            <h3>{{ $book->title }}</h3>

                            <p>By {{ $book->author }}</p>

                            <p class="isbn">
                                ISBN: {{ $book->isbn }}
                            </p>

                            <div
                                class="availability {{ $book->available_copies > 0 ? 'in-stock' : 'out-stock' }}"
                            >
                                {{ $book->available_copies > 0
                                    ? $book->available_copies . ' copies available'
                                    : 'Currently unavailable' }}
                            </div>
                        </article>
                    @empty
                        <div class="empty-card">
                            No books are currently available.
                        </div>
                    @endforelse
                </section>
            </section>
        </main>
    </div>

    <script src="{{ asset('js/dashboard.js') }}"></script>

</body>
</html>