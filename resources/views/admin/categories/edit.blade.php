<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <meta name="csrf-token" content="{{ csrf_token() }}">

    <title>Edit Category - ReadSphere</title>

    {{-- Load the shared dashboard stylesheet. --}}
    <link rel="stylesheet" href="{{ asset('css/dashboard.css') }}">
</head>

<body>
    <div class="app-shell">
        {{-- Shared admin dashboard sidebar. --}}
        @include('partials.dashboard-sidebar')

        <main class="main-content" id="main-content">
            @include('partials.dashboard-topbar', [
                'pageTitle' => 'Edit Category',
                'pageSubtitle' => 'Update the selected category name.',
            ])

            <section class="content-area" aria-label="Edit Category">
                @include('partials.flash')

                {{-- Form for updating the selected category. --}}
                <section class="form-card" aria-labelledby="category-form-heading">
                    <h2 id="category-form-heading" class="card-title">
                        Category Information
                    </h2>

                    <form
                        method="POST"
                        action="{{ route('admin.categories.update', $category) }}"
                    >
                        @csrf
                        @method('PUT')

                        <div class="form-field">
                            <label for="category_name">Category Name</label>

                            <input
                                id="category_name"
                                name="category_name"
                                type="text"
                                value="{{ old('category_name', $category->category_name) }}"
                                required
                                autofocus
                            >
                        </div>

                        {{-- Update the category or return without saving. --}}
                        <div class="form-actions">
                            <button class="button" type="submit">
                                Update Category
                            </button>

                            <a
                                class="button ghost"
                                href="{{ route('admin.categories.index') }}"
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