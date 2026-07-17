<?php

namespace App\Http\Controllers\Member;

use App\Http\Controllers\Controller;
use App\Models\Book;
use App\Models\Category;
use Illuminate\Http\Request;
use Illuminate\View\View;

class BookController extends Controller
{
    /**
     * Display the book search page with initial book records.
     */
    public function index(Request $request): View
    {
        // Load categories for the category filter.
        $categories = Category::orderBy('category_name')->get();

        // Load the first twelve books for the initial page display.
        $initialBooks = Book::with('category')
            ->orderBy('title')
            ->limit(12)
            ->get();

        // Allow the page to display both available and unavailable books.
        $onlyAvailable = false;

        return view(
            'member.books.index',
            compact('categories', 'initialBooks', 'onlyAvailable')
        );
    }

    /**
     * Display only books that currently have available copies.
     */
    public function available(): View
    {
        // Load categories for the category filter.
        $categories = Category::orderBy('category_name')->get();

        // Load the first twelve books with at least one available copy.
        $initialBooks = Book::with('category')
            ->where('available_copies', '>', 0)
            ->orderBy('title')
            ->limit(12)
            ->get();

        // Keep the availability filter selected on the page.
        $onlyAvailable = true;

        return view(
            'member.books.index',
            compact('categories', 'initialBooks', 'onlyAvailable')
        );
    }
}