<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <meta name="csrf-token" content="{{ csrf_token() }}">

    <title>Manage Categories - ReadSphere</title>

    {{-- Load the shared dashboard stylesheet. --}}
    <link rel="stylesheet" href="{{ asset('css/dashboard.css') }}">
</head>

<body>
    <div class="app-shell">
        {{-- Shared admin dashboard sidebar. --}}
        @include('partials.dashboard-sidebar')

        <main class="main-content" id="main-content">
            @include('partials.dashboard-topbar', [
                'pageTitle' => 'Manage Categories',
                'pageSubtitle' => 'Organize books into simple catalogue categories.',
            ])

            <section class="content-area" aria-label="Manage Categories">
                @include('partials.flash')

                {{-- Category search and add-category controls. --}}
                <div class="toolbar">
                    <form
                        class="filter-form"
                        method="GET"
                        action="{{ route('admin.categories.index') }}"
                        aria-label="Search categories"
                    >
                        <label class="sr-only" for="category-search">
                            Search categories
                        </label>

                        <input
                            id="category-search"
                            name="search"
                            type="search"
                            value="{{ request('search') }}"
                            placeholder="Search categories"
                        >

                        <button class="button" type="submit">
                            Search
                        </button>

                        <a
                            class="button ghost"
                            href="{{ route('admin.categories.index') }}"
                        >
                            Reset
                        </a>
                    </form>

                    <a
                        class="button"
                        href="{{ route('admin.categories.create') }}"
                    >
                        Add Category
                    </a>
                </div>

                {{-- Display the searched and paginated category list. --}}
                <section class="panel" aria-labelledby="category-list-heading">
                    <h2 id="category-list-heading" class="sr-only">
                        Category List
                    </h2>

                    <div class="table-wrap">
                        <table>
                            <caption class="sr-only">
                                Library categories
                            </caption>

                            <thead>
                                <tr>
                                    <th scope="col">#</th>
                                    <th scope="col">Category</th>
                                    <th scope="col">Books</th>
                                    <th scope="col">Actions</th>
                                </tr>
                            </thead>

                            <tbody>
                                @forelse ($categories as $category)
                                    <tr>
                                        <td>
                                            {{ $categories->firstItem() + $loop->index }}
                                        </td>

                                        <td>{{ $category->category_name }}</td>
                                        <td>{{ $category->books_count }}</td>

                                        {{-- Category edit and delete actions. --}}
                                        <td class="actions">
                                            <a
                                                href="{{ route('admin.categories.edit', $category) }}"
                                            >
                                                Edit
                                            </a>

                                            <form
                                                method="POST"
                                                action="{{ route('admin.categories.destroy', $category) }}"
                                                data-confirm="Delete this category? Categories containing books cannot be deleted."
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
                                        <td colspan="4" class="empty">
                                            No categories found.
                                        </td>
                                    </tr>
                                @endforelse
                            </tbody>
                        </table>
                    </div>

                    {{-- Display pagination links. --}}
                    <div class="pagination-wrap">
                        {{ $categories->links() }}
                    </div>
                </section>
            </section>
        </main>
    </div>

    {{-- Load shared dashboard JavaScript and delete confirmation. --}}
    <script src="{{ asset('js/dashboard.js') }}"></script>
</body>
</html>