<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <meta name="csrf-token" content="{{ csrf_token() }}">

    <title>Manage Books - ReadSphere</title>

    {{-- Load the shared dashboard stylesheet. --}}
    <link rel="stylesheet" href="{{ asset('css/dashboard.css') }}">
</head>

<body>
    <div class="app-shell">
        {{-- Shared admin dashboard sidebar. --}}
        @include('partials.dashboard-sidebar')

        <main class="main-content" id="main-content">
            @include('partials.dashboard-topbar', [
                'pageTitle' => 'Manage Books',
                'pageSubtitle' => 'Add, view, edit, delete, search, and filter library books.',
            ])

            <section class="content-area" aria-label="Manage Books">
                @include('partials.flash')

                {{-- Search, filter, reset, and add-book controls. --}}
                <div class="toolbar stack-mobile">
                    <form
                        class="filter-form"
                        method="GET"
                        action="{{ route('admin.books.index') }}"
                        aria-label="Filter books"
                    >
                        <label class="sr-only" for="book-search">
                            Search books
                        </label>

                        <input
                            id="book-search"
                            name="search"
                            type="search"
                            value="{{ request('search') }}"
                            placeholder="Title, author or ISBN"
                        >

                        <label class="sr-only" for="category-filter">
                            Filter by category
                        </label>

                        <select id="category-filter" name="category_id">
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

                        <label class="sr-only" for="availability-filter">
                            Filter by availability
                        </label>

                        <select id="availability-filter" name="availability">
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
                            href="{{ route('admin.books.index') }}"
                        >
                            Reset
                        </a>
                    </form>

                    <a
                        class="button"
                        href="{{ route('admin.books.create') }}"
                    >
                        Add Book
                    </a>
                </div>

                {{-- Display the filtered and paginated book catalogue. --}}
                <section class="panel" aria-labelledby="book-list-heading">
                    <h2 id="book-list-heading" class="sr-only">
                        Book List
                    </h2>

                    <div class="table-wrap">
                        <table>
                            <caption class="sr-only">
                                Library book catalogue
                            </caption>

                            <thead>
                                <tr>
                                    <th scope="col">Title</th>
                                    <th scope="col">Author</th>
                                    <th scope="col">Category</th>
                                    <th scope="col">ISBN</th>
                                    <th scope="col">Copies</th>
                                    <th scope="col">Actions</th>
                                </tr>
                            </thead>

                            <tbody>
                                @forelse ($books as $book)
                                    <tr>
                                        <td>
                                            <strong>{{ $book->title }}</strong>
                                        </td>

                                        <td>{{ $book->author }}</td>

                                        <td>
                                            {{ $book->category->category_name }}
                                        </td>

                                        <td>{{ $book->isbn }}</td>

                                        <td>
                                            {{ $book->available_copies }}
                                            /
                                            {{ $book->total_copies }}
                                        </td>

                                        {{-- Book view, edit, and delete actions. --}}
                                        <td class="actions">
                                            <a href="{{ route('admin.books.show', $book) }}">
                                                View
                                            </a>

                                            <a href="{{ route('admin.books.edit', $book) }}">
                                                Edit
                                            </a>

                                            <form
                                                method="POST"
                                                action="{{ route('admin.books.destroy', $book) }}"
                                                data-confirm="Delete this book?"
                                            >
                                                @csrf
                                                @method('DELETE')

                                                <button
                                                    class="link-danger"
                                                    type="submit"
                                                >
                                                    Delete
                                                </button>
                                            </form>
                                        </td>
                                    </tr>
                                @empty
                                    <tr>
                                        <td colspan="6" class="empty">
                                            No books match the selected filters.
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

    {{-- Load shared dashboard interactions and delete confirmation. --}}
    <script src="{{ asset('js/dashboard.js') }}"></script>
</body>
</html>