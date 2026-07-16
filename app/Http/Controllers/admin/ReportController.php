<?php

namespace App\Http\Controllers\Admin;

use App\Http\Controllers\Controller;
use App\Models\Book;
use App\Models\Borrowing;
use App\Models\User;
use Illuminate\View\View;

class ReportController extends Controller
{
    /**
     * Display summary totals, most borrowed books,
     * and currently overdue borrowing records.
     */
    public function index(): View
    {
        // Calculate the main library report totals.
        $summary = [
            'members' => User::where('role', 'member')->count(),
            'books' => Book::count(),
            'issues' => Borrowing::count(),

            'active' => Borrowing::where(
                'status',
                'borrowed'
            )->count(),

            'returned' => Borrowing::where(
                'status',
                'returned'
            )->count(),

            'overdue' => Borrowing::where('status', 'borrowed')
                ->whereDate('due_date', '<', today())
                ->count(),
        ];

        // Retrieve the five books with the highest borrowing counts.
        $topBooks = Book::withCount('borrowings')
            ->orderByDesc('borrowings_count')
            ->limit(5)
            ->get();

        // Retrieve up to ten currently overdue borrowing records.
        $overdueBorrowings = Borrowing::with(['user', 'book'])
            ->where('status', 'borrowed')
            ->whereDate('due_date', '<', today())
            ->orderBy('due_date')
            ->limit(10)
            ->get();

        return view(
            'admin.reports.index',
            compact('summary', 'topBooks', 'overdueBorrowings')
        );
    }
}