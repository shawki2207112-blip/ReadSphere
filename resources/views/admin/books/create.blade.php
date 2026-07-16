<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <meta name="csrf-token" content="{{ csrf_token() }}">

    <title>Add Book - ReadSphere</title>

    {{-- Load the shared dashboard stylesheet. --}}
    <link rel="stylesheet" href="{{ asset('css/dashboard.css') }}">
</head>

<body>
    <div class="app-shell">
        {{-- Shared admin dashboard sidebar. --}}
        @include('partials.dashboard-sidebar')

        <main class="main-content" id="main-content">
            @include('partials.dashboard-topbar', [
                'pageTitle' => 'Add Book',
                'pageSubtitle' => 'Create a new catalogue record and its opening copy count.',
            ])

            <section class="content-area" aria-label="Add Book">
                @include('partials.flash')

                {{-- Form for creating a new book record. --}}
                <section class="form-card" aria-labelledby="book-form-heading">
                    <h2 id="book-form-heading" class="card-title">
                        Book Information
                    </h2>

                    <form method="POST" action="{{ route('admin.books.store') }}">
                        @csrf

                        <div class="form-grid">
                            <div class="form-field">
                                <label for="title">Title</label>

                                <input
                                    id="title"
                                    name="title"
                                    type="text"
                                    value="{{ old('title') }}"
                                    required
                                    autofocus
                                >
                            </div>

                            <div class="form-field">
                                <label for="author">Author</label>

                                <input
                                    id="author"
                                    name="author"
                                    type="text"
                                    value="{{ old('author') }}"
                                    required
                                >
                            </div>

                            <div class="form-field">
                                <label for="isbn">ISBN</label>

                                <input
                                    id="isbn"
                                    name="isbn"
                                    type="text"
                                    value="{{ old('isbn') }}"
                                    required
                                >
                            </div>

                            <div class="form-field">
                                <label for="category_id">Category</label>

                                <select id="category_id" name="category_id" required>
                                    <option value="">Select category</option>

                                    @foreach ($categories as $category)
                                        <option
                                            value="{{ $category->id }}"
                                            @selected(old('category_id') == $category->id)
                                        >
                                            {{ $category->category_name }}
                                        </option>
                                    @endforeach
                                </select>
                            </div>

                            <div class="form-field">
                                <label for="total_copies">Total Copies</label>

                                <input
                                    id="total_copies"
                                    name="total_copies"
                                    type="number"
                                    min="1"
                                    value="{{ old('total_copies', 1) }}"
                                    required
                                >
                            </div>
                        </div>

                        {{-- Save the book or return to the book list. --}}
                        <div class="form-actions">
                            <button class="button" type="submit">
                                Save Book
                            </button>

                            <a
                                class="button ghost"
                                href="{{ route('admin.books.index') }}"
                            >
                                Cancel
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