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

    <script>
        // Store the page's default availability setting.
        const initialAvailableOnly = @json($onlyAvailable);

        const searchInput = document.getElementById('search');
        const categoryInput = document.getElementById('category');
        const availabilityInput =
            document.getElementById('availability');
        const bookGrid = document.getElementById('bookGrid');
        const resultSummary =
            document.getElementById('resultSummary');

        let debounceTimer;

        // Prevent API data from being inserted as unsafe HTML.
        function escapeHtml(value) {
            const element = document.createElement('div');
            element.textContent = value ?? '';

            return element.innerHTML;
        }

        // Request filtered book records from the Book API.
        async function loadBooks() {
            const params = new URLSearchParams();

            if (searchInput.value.trim()) {
                params.set('search', searchInput.value.trim());
            }

            if (categoryInput.value) {
                params.set('category_id', categoryInput.value);
            }

            if (availabilityInput.value) {
                params.set(
                    'availability',
                    availabilityInput.value
                );
            }

            bookGrid.innerHTML =
                '<div class="loading-card">Loading books…</div>';

            resultSummary.textContent = '';

            try {
                const response = await fetch(
                    `/api/books?${params.toString()}`,
                    {
                        headers: {
                            Accept: 'application/json',
                        },
                    }
                );

                if (!response.ok) {
                    throw new Error('Unable to retrieve books.');
                }

                const data = await response.json();

                resultSummary.textContent =
                    `${data.count} book${data.count === 1 ? '' : 's'} found`;

                if (!data.books.length) {
                    bookGrid.innerHTML =
                        '<div class="empty-card">No books match your search.</div>';

                    return;
                }

                // Convert API book records into book cards.
                bookGrid.innerHTML = data.books
                    .map((book) => {
                        const available =
                            Number(book.available_copies) > 0;

                        const availabilityText = available
                            ? `${book.available_copies} copies available`
                            : 'Currently unavailable';

                        return `
                            <article class="book-card">
                                <span class="book-category">
                                    ${escapeHtml(
                                        book.category?.category_name ||
                                        'Uncategorized'
                                    )}
                                </span>

                                <h3>${escapeHtml(book.title)}</h3>

                                <p>
                                    By ${escapeHtml(book.author)}
                                </p>

                                <p class="isbn">
                                    ISBN: ${escapeHtml(book.isbn)}
                                </p>

                                <div class="availability ${
                                    available
                                        ? 'in-stock'
                                        : 'out-stock'
                                }">
                                    ${availabilityText}
                                </div>
                            </article>
                        `;
                    })
                    .join('');
            } catch (error) {
                bookGrid.innerHTML =
                    '<div class="empty-card">Could not load books. Please try again.</div>';
            }
        }

        // Search when the Search button is clicked.
        document
            .getElementById('searchButton')
            .addEventListener('click', loadBooks);

        // Restore the default filters and reload the books.
        document
            .getElementById('resetButton')
            .addEventListener('click', () => {
                searchInput.value = '';
                categoryInput.value = '';

                availabilityInput.value =
                    initialAvailableOnly ? 'available' : '';

                loadBooks();
            });

        // Delay live search to avoid unnecessary API requests.
        searchInput.addEventListener('input', () => {
            clearTimeout(debounceTimer);
            debounceTimer = setTimeout(loadBooks, 350);
        });

        categoryInput.addEventListener('change', loadBooks);
        availabilityInput.addEventListener('change', loadBooks);
    </script>
</body>
</html>