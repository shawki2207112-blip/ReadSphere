<?php

namespace App\Http\Controllers;

use App\Models\User;
use Illuminate\Http\RedirectResponse;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\Hash;
use Illuminate\View\View;

class AuthController extends Controller
{
    /**
     * Display the login page.
     */
    public function showLogin(): View
    {
        return view('home.login');
    }

    /**
     * Validate the login form and authenticate the user.
     */
    public function login(Request $request): RedirectResponse
    {
        /*
         * Validate the submitted email and password.
         */
        $credentials = $request->validate([
            'email' => ['required', 'email'],
            'password' => ['required', 'string'],
        ]);

        /*
         * Attempt to authenticate the user.
         *
         * This enables "remember me" feature
         * when the remember checkbox is selected.
         */
        if (!Auth::attempt(
            $credentials,
            $request->boolean('remember')
        )) {
            return back()
                ->withErrors([
                    'email' => 'The provided email or password is incorrect.',
                ])
                ->onlyInput('email');
        }

        /*
         * Regenerate the session ID after login to prevent
         * session fixation attacks.
         */
        $request->session()->regenerate();

        /*
         * Redirect the authenticated user according to their role.
         */
        return redirect()->intended(
            Auth::user()->isAdmin()
                ? route('admin.dashboard')
                : route('member.dashboard')
        )->with(
            'success',
            'Welcome back, '.Auth::user()->name.'!'
        );
    }

    /**
     * Display the member registration page.
     */
    public function showRegister(): View
    {
        return view('home.register');
    }

    /**
     * Validate the registration form and create a new member account.
     */
    public function register(Request $request): RedirectResponse
    {
        /*
         * Validate the submitted registration data.
         *
         * The confirmed rule requires a matching
         * password_confirmation field.
         */
        $validated = $request->validate([
            'name' => [
                'required',
                'string',
                'max:100',
            ],
            'email' => [
                'required',
                'email',
                'max:150',
                'unique:users,email',
            ],
            'phone' => [
                'nullable',
                'string',
                'max:30',
            ],
            'password' => [
                'required',
                'string',
                'min:6',
                'confirmed',
            ],
        ]);

        /*
         * Create the new member account.
         *
         * The role is assigned manually as "member" so that users
         * cannot register themselves as administrators.
         */
        $user = User::create([
            'name' => $validated['name'],
            'email' => $validated['email'],
            'phone' => $validated['phone'] ?? null,
            'password' => Hash::make($validated['password']),
            'role' => 'member',
        ]);

        /*
         * Automatically log in the newly registered member.
         */
        Auth::login($user);

        /*
         * Regenerate the session ID after authentication.
         */
        $request->session()->regenerate();

        return redirect()
            ->route('member.dashboard')
            ->with(
                'success',
                'Registration completed successfully.'
            );
    }

    /**
     * Log out the authenticated user safely.
     */
    public function logout(Request $request): RedirectResponse
    {
        Auth::logout();

        $request->session()->invalidate();

        $request->session()->regenerateToken();

        return redirect()
            ->route('home')
            ->with(
                'success',
                'You have been logged out.'
            );
    }
}