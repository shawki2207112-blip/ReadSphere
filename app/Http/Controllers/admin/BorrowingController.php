<?php

namespace App\Http\Controllers\Admin;

use App\Http\Controllers\Controller;
use App\Models\Book;
use App\Models\Borrowing;
use App\Models\User;
use Illuminate\Http\RedirectResponse;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\DB;
use Illuminate\Validation\ValidationException;
use Illuminate\View\View;

class BorrowingController extends Controller
{
    /**
     * Display the issue-book form with members and available books.
     */
    public function create(): View
    {
        $members = User::where('role', 'member')
            ->orderBy('name')
            ->get();

        $books = Book::where('available_copies', '>', 0)
            ->orderBy('title')
            ->get();

        return view(
            'admin.borrowings.issue',
            compact('members', 'books')
        );
    }

    /**
     * Validate and issue a selected book to a member.
     */
    public function store(Request $request): RedirectResponse
    {
        $validated = $request->validate([
            'user_id' => ['required', 'exists:users,id'],
            'book_id' => ['required', 'exists:books,id'],
            'issue_date' => ['required', 'date'],
            'due_date' => [
                'required',
                'date',
                'after_or_equal:issue_date',
            ],
        ]);

        // Ensure the selected user is actually a member.
        $member = User::findOrFail($validated['user_id']);

        if ($member->role !== 'member') {
            throw ValidationException::withMessages([
                'user_id' => 'Please select a valid member.',
            ]);
        }

        /*
         * Use a transaction so the borrowing record and available-copy
         * count are updated together.
         */
        DB::transaction(function () use ($validated) {
            $book = Book::lockForUpdate()
                ->findOrFail($validated['book_id']);

            if ($book->available_copies < 1) {
                throw ValidationException::withMessages([
                    'book_id' => 'This book is currently unavailable.',
                ]);
            }

            // Prevent the same member from borrowing the same book twice.
            $alreadyBorrowed = Borrowing::where(
                'user_id',
                $validated['user_id']
            )
                ->where('book_id', $book->id)
                ->where('status', 'borrowed')
                ->exists();

            if ($alreadyBorrowed) {
                throw ValidationException::withMessages([
                    'book_id' =>
                        'This member already has an active copy of this book.',
                ]);
            }

            Borrowing::create([
                ...$validated,
                'status' => 'borrowed',
            ]);

            // Reduce the number of available copies.
            $book->decrement('available_copies');
        });

        return redirect()
            ->route('admin.borrowings.active')
            ->with('success', 'Book issued successfully.');
    }

    /**
     * Display searchable active borrowings for returning books.
     */
    public function active(Request $request): View
    {
        $borrowings = Borrowing::with(['user', 'book'])
            ->where('status', 'borrowed')
            ->when($request->search, function ($query, $search) {
                $query->where(function ($inner) use ($search) {
                    $inner->whereHas(
                        'user',
                        fn ($q) => $q->where(
                            'name',
                            'like',
                            "%{$search}%"
                        )
                    )
                        ->orWhereHas(
                            'book',
                            fn ($q) => $q->where(
                                'title',
                                'like',
                                "%{$search}%"
                            )
                        );
                });
            })
            ->when(
                $request->overdue === 'yes',
                fn ($query) => $query->whereDate(
                    'due_date',
                    '<',
                    today()
                )
            )
            ->orderBy('due_date')
            ->paginate(10)
            ->withQueryString();

        return view(
            'admin.borrowings.active',
            compact('borrowings')
        );
    }

    /**
     * Mark an active borrowing as returned.
     */
    public function returnBook(
        Borrowing $borrowing
    ): RedirectResponse {
        /*
         * Update the borrowing status and available-copy count
         * within one database transaction.
         */
        DB::transaction(function () use ($borrowing) {
            $borrowing = Borrowing::lockForUpdate()
                ->findOrFail($borrowing->id);

            if ($borrowing->status !== 'borrowed') {
                throw ValidationException::withMessages([
                    'return' =>
                        'This borrowing has already been returned.',
                ]);
            }

            // Include soft-deleted books when finding the borrowed book.
            $book = Book::withTrashed()
                ->lockForUpdate()
                ->findOrFail($borrowing->book_id);

            $borrowing->update([
                'status' => 'returned',
                'returned_at' => today(),
            ]);

            // Restore the copy count only when the book still exists.
            if (! $book->trashed()) {
                $book->increment('available_copies');
            }
        });

        return back()->with(
            'success',
            'Book returned successfully.'
        );
    }

    /**
     * Display searchable borrowing history filtered by status.
     */
    public function history(Request $request): View
    {
        $borrowings = Borrowing::with(['user', 'book'])
            ->when($request->search, function ($query, $search) {
                $query->where(function ($inner) use ($search) {
                    $inner->whereHas(
                        'user',
                        fn ($q) => $q->withTrashed()
                            ->where(
                                'name',
                                'like',
                                "%{$search}%"
                            )
                    )
                        ->orWhereHas(
                            'book',
                            fn ($q) => $q->withTrashed()
                                ->where(
                                    'title',
                                    'like',
                                    "%{$search}%"
                                )
                        );
                });
            })
            ->when(
                $request->status,
                fn ($query, $status) =>
                    $query->where('status', $status)
            )
            ->latest('issue_date')
            ->paginate(12)
            ->withQueryString();

        return view(
            'admin.borrowings.history',
            compact('borrowings')
        );
    }
}