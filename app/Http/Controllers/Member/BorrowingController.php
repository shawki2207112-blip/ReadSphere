<?php

namespace App\Http\Controllers\Member;

use App\Http\Controllers\Controller;
use App\Models\Borrowing;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;
use Illuminate\View\View;

class BorrowingController extends Controller
{
    /**
     * Display books currently borrowed by the logged-in member.
     */
    public function current(): View
    {
        $borrowings = Borrowing::with('book.category')
            ->where('user_id', Auth::id())
            ->where('status', 'borrowed')
            ->orderBy('due_date')
            ->get();

        return view(
            'member.borrowings.current',
            compact('borrowings')
        );
    }

    /**
     * Display the member's complete borrowing history.
     */
    public function history(Request $request): View
    {
        $borrowings = Borrowing::with('book.category')
            ->where('user_id', Auth::id())

            // Apply the selected borrowing status filter.
            ->when(
                $request->status,
                fn ($query, $status) =>
                    $query->where('status', $status)
            )
            ->latest('issue_date')
            ->paginate(10)
            ->withQueryString();

        return view(
            'member.borrowings.history',
            compact('borrowings')
        );
    }
}