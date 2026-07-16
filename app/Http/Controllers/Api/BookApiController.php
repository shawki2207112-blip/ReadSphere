<?php

namespace App\Http\Controllers\Api;

use App\Http\Controllers\Controller;
use App\Models\Book;
use Illuminate\Http\JsonResponse;
use Illuminate\Http\Request;

class BookApiController extends Controller
{
    /**
     * Return searchable and filterable book records in JSON format.
     */
    public function index(Request $request): JsonResponse
    {
        $books = Book::with('category')

            // Search by book title, author, or ISBN.
            ->when($request->filled('search'), function ($query) use ($request) {
                $search = trim((string) $request->input('search'));

                $query->where(function ($inner) use ($search) {
                    $inner->where('title', 'like', "%{$search}%")
                        ->orWhere('author', 'like', "%{$search}%")
                        ->orWhere('isbn', 'like', "%{$search}%");
                });
            })

            // Filter books by category.
            ->when(
                $request->filled('category_id'),
                fn ($query) => $query->where(
                    'category_id',
                    $request->integer('category_id')
                )
            )

            // Show only books with available copies.
            ->when(
                $request->input('availability') === 'available',
                fn ($query) => $query->where('available_copies', '>', 0)
            )

            // Show only books with no available copies.
            ->when(
                $request->input('availability') === 'unavailable',
                fn ($query) => $query->where('available_copies', 0)
            )
            ->orderBy('title')
            ->limit(100)
            ->get();

        // Return the matching books and total result count.
        return response()->json([
            'success' => true,
            'count' => $books->count(),
            'books' => $books,
        ]);
    }

    /**
     * Return one book with its category information.
     */
    public function show(Book $book): JsonResponse
    {
        $book->load('category');

        return response()->json([
            'success' => true,
            'book' => $book,
        ]);
    }
}