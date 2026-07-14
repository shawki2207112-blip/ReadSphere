<?php

namespace App\Http\Controllers;

use App\Models\Book;
use App\Models\Borrowing;
use App\Models\Category;
use App\Models\User;
use Illuminate\Support\Facades\Auth;
use Illuminate\View\View;

class DashboardController extends Controller
{
    /**
     * Display the admin dashboard with library statistics
     * and recent borrowing activity.
     */
    public function admin(): View
    {
        $stats = [
            'categories' => Category::count(),
            'book_titles' => Book::count(),
            'total_copies' => Book::sum('total_copies'),
            'available_copies' => Book::sum('available_copies'),
            'members' => User::where('role', 'member')->count(),
            'active_borrowings' => Borrowing::where('status', 'borrowed')->count(),
            'overdue' => Borrowing::where('status', 'borrowed')
                ->whereDate('due_date', '<', today())
                ->count(),
        ];

        // Retrieve the six most recent borrowing records with member and book details.
        $recentBorrowings = Borrowing::with(['user', 'book'])
            ->latest('issue_date')
            ->limit(6)
            ->get();

        return view('admin.dashboard', compact('stats', 'recentBorrowings'));
    }

    /**
     * Display the member dashboard with personal borrowing statistics
     * and currently borrowed books.
     */
    public function member(): View
    {
        $userId = Auth::id();

        $stats = [
            'available_books' => Book::where('available_copies', '>', 0)->count(),

            'current_borrowings' => Borrowing::where('user_id', $userId)
                ->where('status', 'borrowed')
                ->count(),

            'history' => Borrowing::where('user_id', $userId)->count(),

            'overdue' => Borrowing::where('user_id', $userId)
                ->where('status', 'borrowed')
                ->whereDate('due_date', '<', today())
                ->count(),
        ];

        // Retrieve the member's current borrowings ordered by the nearest due date.
        $currentBorrowings = Borrowing::with('book.category')
            ->where('user_id', $userId)
            ->where('status', 'borrowed')
            ->orderBy('due_date')
            ->limit(5)
            ->get();

        return view('member.dashboard', compact('stats', 'currentBorrowings'));
    }
}