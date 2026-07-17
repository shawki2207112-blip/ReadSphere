<?php

namespace App\Http\Controllers\Member;

use App\Http\Controllers\Controller;
use Illuminate\Http\RedirectResponse;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Hash;
use Illuminate\Validation\ValidationException;
use Illuminate\View\View;

class ProfileController extends Controller
{
    /**
     * Display the logged-in member's profile form.
     */
    public function edit(Request $request): View
    {
        return view('member.profile.edit', [
            'user' => $request->user(),
        ]);
    }

    /**
     * Validate and update the member's profile information.
     */
    public function update(Request $request): RedirectResponse
    {
        $user = $request->user();

        $validated = $request->validate([
            'name' => ['required', 'string', 'max:100'],
            'email' => [
                'required',
                'email',
                'max:150',
                'unique:users,email,'.$user->id,
            ],
            'phone' => ['nullable', 'string', 'max:30'],
            'current_password' => ['nullable', 'string'],
            'password' => [
                'nullable',
                'string',
                'min:6',
                'confirmed',
            ],
        ]);

        // Change the password only when a new password is provided.
        if (! empty($validated['password'])) {
            // Verify the member's current password first.
            if (
                empty($validated['current_password']) ||
                ! Hash::check(
                    $validated['current_password'],
                    $user->password
                )
            ) {
                throw ValidationException::withMessages([
                    'current_password' =>
                        'The current password is incorrect.',
                ]);
            }

            $validated['password'] = Hash::make(
                $validated['password']
            );
        } else {
            unset($validated['password']);
        }

        // The current password is only used for verification.
        unset($validated['current_password']);

        $user->update($validated);

        return back()->with(
            'success',
            'Profile updated successfully.'
        );
    }
}