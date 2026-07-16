<?php

namespace App\Http\Controllers\Admin;

use App\Http\Controllers\Controller;
use App\Models\User;
use Illuminate\Http\RedirectResponse;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Hash;
use Illuminate\View\View;

class MemberController extends Controller
{
    /**
     * Display a searchable and paginated list of members.
     */
    public function index(Request $request): View
    {
        $members = User::where('role', 'member')
            ->withCount([
                'borrowings',

                // Count only the member's currently borrowed books.
                'borrowings as active_borrowings_count' =>
                    fn ($query) => $query->where('status', 'borrowed'),
            ])
            ->when($request->search, function ($query, $search) {
                $query->where(function ($inner) use ($search) {
                    $inner->where('name', 'like', "%{$search}%")
                        ->orWhere('email', 'like', "%{$search}%")
                        ->orWhere('phone', 'like', "%{$search}%");
                });
            })
            ->orderBy('name')
            ->paginate(10)
            ->withQueryString();

        return view('admin.members.index', compact('members'));
    }

    /**
     * Display the form for creating a member.
     */
    public function create(): View
    {
        return view('admin.members.create');
    }

    /**
     * Validate and save a new member account.
     */
    public function store(Request $request): RedirectResponse
    {
        $validated = $request->validate([
            'name' => ['required', 'string', 'max:100'],
            'email' => [
                'required',
                'email',
                'max:150',
                'unique:users,email',
            ],
            'phone' => ['nullable', 'string', 'max:30'],
            'password' => [
                'required',
                'string',
                'min:6',
                'confirmed',
            ],
        ]);

        // Secure the password and assign the member role.
        $validated['password'] = Hash::make($validated['password']);
        $validated['role'] = 'member';

        User::create($validated);

        return redirect()
            ->route('admin.members.index')
            ->with('success', 'Member added successfully.');
    }

    /**
     * Display one member with borrowing history.
     */
    public function show(User $member): View
    {
        // Prevent admin accounts from being accessed as members.
        abort_unless($member->role === 'member', 404);

        $member->load(['borrowings.book']);

        return view('admin.members.show', compact('member'));
    }

    /**
     * Display the form for editing a member.
     */
    public function edit(User $member): View
    {
        abort_unless($member->role === 'member', 404);

        return view('admin.members.edit', compact('member'));
    }

    /**
     * Validate and update the selected member.
     */
    public function update(
        Request $request,
        User $member
    ): RedirectResponse {
        abort_unless($member->role === 'member', 404);

        $validated = $request->validate([
            'name' => ['required', 'string', 'max:100'],
            'email' => [
                'required',
                'email',
                'max:150',
                'unique:users,email,'.$member->id,
            ],
            'phone' => ['nullable', 'string', 'max:30'],
            'password' => [
                'nullable',
                'string',
                'min:6',
                'confirmed',
            ],
        ]);

        // Keep the existing password when no new password is entered.
        if (empty($validated['password'])) {
            unset($validated['password']);
        } else {
            $validated['password'] = Hash::make(
                $validated['password']
            );
        }

        $member->update($validated);

        return redirect()
            ->route('admin.members.index')
            ->with('success', 'Member updated successfully.');
    }

    /**
     * Delete a member only when there are no active borrowings.
     */
    public function destroy(User $member): RedirectResponse
    {
        abort_unless($member->role === 'member', 404);

        if (
            $member->borrowings()
                ->where('status', 'borrowed')
                ->exists()
        ) {
            return back()->with(
                'error',
                'This member has active borrowed books and cannot be deleted yet.'
            );
        }

        // Soft deletion preserves the member's borrowing history.
        $member->delete();

        return back()->with(
            'success',
            'Member deleted successfully. Borrowing history was preserved.'
        );
    }
}