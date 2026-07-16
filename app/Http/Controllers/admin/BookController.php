<?php

namespace App\Http\Controllers\Admin;

use App\Http\Controllers\Controller;
use App\Models\Book;
use App\Models\Category;
use Illuminate\Http\RedirectResponse;
use Illuminate\Http\Request;
use Illuminate\Validation\ValidationException;
use Illuminate\View\View;

class BookController extends Controller
{
    /**
     * Display a searchable and filterable list of books.
     */
    public function index(Request $request): View
    {
        $books = $this->filteredBooks($request)
            ->paginate(10)
            ->withQueryString();

        $categories = Category::orderBy('category_name')->get();

        return view('admin.books.index', compact('books', 'categories'));
    }

    /**
     * Display the form for adding a new book.
     */
    public function create(): View
    {
        $categories = Category::orderBy('category_name')->get();

        return view('admin.books.create', compact('categories'));
    }

    /**
     * Validate and save a new book.
     */
    public function store(Request $request): RedirectResponse
    {
        $validated = $request->validate([
            'title' => ['required', 'string', 'max:180'],
            'author' => ['required', 'string', 'max:150'],
            'isbn' => ['required', 'string', 'max:50', 'unique:books,isbn'],
            'category_id' => ['required', 'exists:categories,id'],
            'total_copies' => ['required', 'integer', 'min:1', 'max:10000'],
        ]);

        // All copies are available when a new book is added.
        $validated['available_copies'] = $validated['total_copies'];

        Book::create($validated);

        return redirect()
            ->route('admin.books.index')
            ->with('success', 'Book added successfully.');
    }

    /**
     * Display one book with its category and borrowing records.
     */
    public function show(Book $book): View
    {
        $book->load(['category', 'borrowings.user']);

        return view('admin.books.show', compact('book'));
    }

    /**
     * Display the form for editing a book.
     */
    public function edit(Book $book): View
    {
        $categories = Category::orderBy('category_name')->get();

        return view('admin.books.edit', compact('book', 'categories'));
    }

    /**
     * Validate and update an existing book.
     */
    public function update(Request $request, Book $book): RedirectResponse
    {
        $validated = $request->validate([
            'title' => ['required', 'string', 'max:180'],
            'author' => ['required', 'string', 'max:150'],
            'isbn' => [
                'required',
                'string',
                'max:50',
                'unique:books,isbn,'.$book->id,
            ],
            'category_id' => ['required', 'exists:categories,id'],
            'total_copies' => ['required', 'integer', 'min:1', 'max:10000'],
        ]);

        // Calculate how many copies are currently borrowed.
        $borrowedCopies = $book->total_copies - $book->available_copies;

        // Total copies cannot be less than the number already borrowed.
        if ($validated['total_copies'] < $borrowedCopies) {
            throw ValidationException::withMessages([
                'total_copies' =>
                    "Total copies cannot be lower than the {$borrowedCopies} copies currently borrowed.",
            ]);
        }

        // Recalculate available copies after changing the total quantity.
        $validated['available_copies'] =
            $validated['total_copies'] - $borrowedCopies;

        $book->update($validated);

        return redirect()
            ->route('admin.books.index')
            ->with('success', 'Book updated successfully.');
    }

    /**
     * Delete a book when it has no active borrowing records.
     */
    public function destroy(Book $book): RedirectResponse
    {
        if ($book->borrowings()->where('status', 'borrowed')->exists()) {
            return back()->with(
                'error',
                'Return all active copies before deleting this book.'
            );
        }

        // Soft delete preserves the book's borrowing history.
        $book->delete();

        return back()->with(
            'success',
            'Book deleted successfully. Its borrowing history was preserved.'
        );
    }

    /**
     * Display inventory statistics and filtered book records.
     */
    public function inventory(Request $request): View
    {
        $books = $this->filteredBooks($request)
            ->paginate(12)
            ->withQueryString();

        $categories = Category::orderBy('category_name')->get();

        $summary = [
            'titles' => Book::count(),
            'total' => Book::sum('total_copies'),
            'available' => Book::sum('available_copies'),
            'borrowed' =>
                Book::sum('total_copies') - Book::sum('available_copies'),
        ];

        return view(
            'admin.inventory.index',
            compact('books', 'categories', 'summary')
        );
    }

    /**
     * Build the book query using search, category, and availability filters.
     */
    private function filteredBooks(Request $request)
    {
        return Book::with('category')
            ->when($request->search, function ($query, $search) {
                $query->where(function ($inner) use ($search) {
                    $inner->where('title', 'like', "%{$search}%")
                        ->orWhere('author', 'like', "%{$search}%")
                        ->orWhere('isbn', 'like', "%{$search}%");
                });
            })
            ->when(
                $request->category_id,
                fn ($query, $id) => $query->where('category_id', $id)
            )
            ->when(
                $request->availability === 'available',
                fn ($query) => $query->where('available_copies', '>', 0)
            )
            ->when(
                $request->availability === 'unavailable',
                fn ($query) => $query->where('available_copies', 0)
            )
            ->orderBy('title');
    }
}