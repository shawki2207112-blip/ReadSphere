<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <meta name="csrf-token" content="{{ csrf_token() }}">

    <title>Edit Book - ReadSphere</title>

    {{-- Load the shared dashboard stylesheet. --}}
    <link rel="stylesheet" href="{{ asset('css/dashboard.css') }}">
</head>

<body>
    <div class="app-shell">
        {{-- Shared admin dashboard sidebar. --}}
        @include('partials.dashboard-sidebar')

        <main class="main-content" id="main-content">
            @include('partials.dashboard-topbar', [
                'pageTitle' => 'Edit Book',
                'pageSubtitle' => 'Update catalogue information and total copy count safely.',
            ])

            <section class="content-area" aria-label="Edit Book">
                @include('partials.flash')

                {{-- Form for updating an existing book record. --}}
                <section class="form-card" aria-labelledby="book-form-heading">
                    <h2 id="book-form-heading" class="card-title">
                        Book Information
                    </h2>

                    <form
                        method="POST"
                        action="{{ route('admin.books.update', $book) }}"
                    >
                        @csrf
                        @method('PUT')

                        <div class="form-grid">
                            <div class="form-field">
                                <label for="title">Title</label>

                                <input
                                    id="title"
                                    name="title"
                                    type="text"
                                    value="{{ old('title', $book->title) }}"
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
                                    value="{{ old('author', $book->author) }}"
                                    required
                                >
                            </div>

                            <div class="form-field">
                                <label for="isbn">ISBN</label>

                                <input
                                    id="isbn"
                                    name="isbn"
                                    type="text"
                                    value="{{ old('isbn', $book->isbn) }}"
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
                                            @selected(
                                                old('category_id', $book->category_id)
                                                == $category->id
                                            )
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
                                    value="{{ old('total_copies', $book->total_copies) }}"
                                    required
                                >
                            </div>
                        </div>

                        {{-- Prevents reducing copies below the currently borrowed amount. --}}
                        <p class="help-text">
                            Currently borrowed copies cannot be removed from the total count.
                        </p>

                        <div class="form-actions">
                            <button class="button" type="submit">
                                Update Book
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