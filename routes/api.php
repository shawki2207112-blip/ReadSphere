<?php

use App\Http\Controllers\Api\BookApiController;
use Illuminate\Support\Facades\Route;

// Return all books with optional search and filtering.
Route::get('/books', [BookApiController::class, 'index']);

// Return the details of one selected book.
Route::get('/books/{book}', [BookApiController::class, 'show']);
