<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <meta name="csrf-token" content="{{ csrf_token() }}">

    <title>Profile - ReadSphere</title>

    {{-- Load the shared dashboard stylesheet. --}}
    <link rel="stylesheet" href="{{ asset('css/dashboard.css') }}">
</head>
<body>
    <div class="app-shell">
        @include('partials.dashboard-sidebar')

        <main class="main-content" id="main-content">
            @include('partials.dashboard-topbar', [
                'pageTitle' => 'My Profile',
                'pageSubtitle' => 'Update your contact details or change your password.',
            ])

            <section class="content-area" aria-label="My Profile">
                @include('partials.flash')

                {{-- Member profile update form. --}}
                <section
                    class="form-card"
                    aria-labelledby="profile-form-heading"
                >
                    <h2 id="profile-form-heading" class="card-title">
                        Profile Information
                    </h2>

                    <form
                        method="POST"
                        action="{{ route('member.profile.update') }}"
                    >
                        @csrf
                        @method('PUT')

                        {{-- Basic account information. --}}
                        <div class="form-grid">
                            <div class="form-field">
                                <label for="name">Full Name</label>
                                <input
                                    id="name"
                                    name="name"
                                    type="text"
                                    value="{{ old('name', $user->name) }}"
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
                                    value="{{ old('email', $user->email) }}"
                                    required
                                >
                            </div>

                            <div class="form-field">
                                <label for="phone">Phone</label>
                                <input
                                    id="phone"
                                    name="phone"
                                    type="tel"
                                    value="{{ old('phone', $user->phone) }}"
                                >
                            </div>
                        </div>

                        <hr>

                        {{-- Optional password change section. --}}
                        <h3>
                            Change Password
                            <span class="optional-text">(optional)</span>
                        </h3>

                        <div class="form-grid">
                            <div class="form-field">
                                <label for="current_password">
                                    Current Password
                                </label>
                                <input
                                    id="current_password"
                                    name="current_password"
                                    type="password"
                                    autocomplete="current-password"
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

                        <p class="help-text">
                            Leave all password fields empty to keep your current password.
                        </p>

                        <div class="form-actions">
                            <button class="button" type="submit">
                                Update Profile
                            </button>
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