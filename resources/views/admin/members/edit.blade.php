<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <meta name="csrf-token" content="{{ csrf_token() }}">

    <title>Edit Member - ReadSphere</title>

    {{-- Load the shared dashboard stylesheet. --}}
    <link rel="stylesheet" href="{{ asset('css/dashboard.css') }}">
</head>

<body>
    <div class="app-shell">
        {{-- Shared admin dashboard sidebar. --}}
        @include('partials.dashboard-sidebar')

        <main class="main-content" id="main-content">
            @include('partials.dashboard-topbar', [
                'pageTitle' => 'Edit Member',
                'pageSubtitle' => 'Update member contact or login information.',
            ])

            <section class="content-area" aria-label="Edit Member">
                @include('partials.flash')

                {{-- Form for updating the selected member. --}}
                <section class="form-card" aria-labelledby="member-form-heading">
                    <h2 id="member-form-heading" class="card-title">
                        Member Information
                    </h2>

                    <form
                        method="POST"
                        action="{{ route('admin.members.update', $member) }}"
                    >
                        @csrf
                        @method('PUT')

                        <div class="form-grid">
                            <div class="form-field">
                                <label for="name">Full Name</label>

                                <input
                                    id="name"
                                    name="name"
                                    type="text"
                                    value="{{ old('name', $member->name) }}"
                                    required
                                    autofocus
                                >
                            </div>

                            <div class="form-field">
                                <label for="email">Email</label>

                                <input
                                    id="email"
                                    name="email"
                                    type="email"
                                    value="{{ old('email', $member->email) }}"
                                    required
                                >
                            </div>

                            <div class="form-field">
                                <label for="phone">Phone</label>

                                <input
                                    id="phone"
                                    name="phone"
                                    type="tel"
                                    value="{{ old('phone', $member->phone) }}"
                                >
                            </div>

                            <div class="form-field">
                                <label for="password">New Password</label>

                                <input
                                    id="password"
                                    name="password"
                                    type="password"
                                    autocomplete="new-password"
                                >

                                <small>
                                    Leave blank to keep the current password.
                                </small>
                            </div>

                            <div class="form-field">
                                <label for="password_confirmation">
                                    Confirm New Password
                                </label>

                                <input
                                    id="password_confirmation"
                                    name="password_confirmation"
                                    type="password"
                                    autocomplete="new-password"
                                >
                            </div>
                        </div>

                        {{-- Update the member or return without saving. --}}
                        <div class="form-actions">
                            <button class="button" type="submit">
                                Update Member
                            </button>

                            <a
                                class="button ghost"
                                href="{{ route('admin.members.index') }}"
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