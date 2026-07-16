<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <meta name="csrf-token" content="{{ csrf_token() }}">

    <title>Manage Members - ReadSphere</title>

    {{-- Load the shared dashboard stylesheet. --}}
    <link rel="stylesheet" href="{{ asset('css/dashboard.css') }}">
</head>

<body>
    <div class="app-shell">
        {{-- Shared admin dashboard sidebar. --}}
        @include('partials.dashboard-sidebar')

        <main class="main-content" id="main-content">
            @include('partials.dashboard-topbar', [
                'pageTitle' => 'Manage Members',
                'pageSubtitle' => 'Create and maintain library member accounts.',
            ])

            <section class="content-area" aria-label="Manage Members">
                @include('partials.flash')

                {{-- Member search and add-member controls. --}}
                <div class="toolbar">
                    <form
                        class="filter-form"
                        method="GET"
                        action="{{ route('admin.members.index') }}"
                        aria-label="Search members"
                    >
                        <label class="sr-only" for="member-search">
                            Search members
                        </label>

                        <input
                            id="member-search"
                            name="search"
                            type="search"
                            value="{{ request('search') }}"
                            placeholder="Name, email or phone"
                        >

                        <button class="button" type="submit">
                            Search
                        </button>

                        <a
                            class="button ghost"
                            href="{{ route('admin.members.index') }}"
                        >
                            Reset
                        </a>
                    </form>

                    <a
                        class="button"
                        href="{{ route('admin.members.create') }}"
                    >
                        Add Member
                    </a>
                </div>

                {{-- Display the searchable and paginated member list. --}}
                <section class="panel" aria-labelledby="member-list-heading">
                    <h2 id="member-list-heading" class="sr-only">
                        Member List
                    </h2>

                    <div class="table-wrap">
                        <table>
                            <caption class="sr-only">
                                Library members
                            </caption>

                            <thead>
                                <tr>
                                    <th scope="col">Name</th>
                                    <th scope="col">Email</th>
                                    <th scope="col">Phone</th>
                                    <th scope="col">Active</th>
                                    <th scope="col">Total History</th>
                                    <th scope="col">Actions</th>
                                </tr>
                            </thead>

                            <tbody>
                                @forelse ($members as $member)
                                    <tr>
                                        <td>{{ $member->name }}</td>
                                        <td>{{ $member->email }}</td>
                                        <td>{{ $member->phone ?: '—' }}</td>
                                        <td>{{ $member->active_borrowings_count }}</td>
                                        <td>{{ $member->borrowings_count }}</td>

                                        {{-- View, edit, and delete member actions. --}}
                                        <td class="actions">
                                            <a
                                                href="{{ route('admin.members.show', $member) }}"
                                            >
                                                View
                                            </a>

                                            <a
                                                href="{{ route('admin.members.edit', $member) }}"
                                            >
                                                Edit
                                            </a>

                                            <form
                                                method="POST"
                                                action="{{ route('admin.members.destroy', $member) }}"
                                                data-confirm="Delete this member?"
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
                                            No members found.
                                        </td>
                                    </tr>
                                @endforelse
                            </tbody>
                        </table>
                    </div>

                    {{-- Display pagination links with the search value. --}}
                    <div class="pagination-wrap">
                        {{ $members->links() }}
                    </div>
                </section>
            </section>
        </main>
    </div>

    {{-- Load shared dashboard JavaScript and delete confirmation. --}}
    <script src="{{ asset('js/dashboard.js') }}"></script>
</body>
</html>