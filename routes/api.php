<?php

use App\Http\Controllers\Api\BookApiController;
use App\Http\Controllers\Api\CategoryApiController;
use Illuminate\Support\Facades\Route;

// Return all books with optional search and filtering.
Route::get('/books', [BookApiController::class, 'index']);

// Return the details of one selected book.
Route::get('/books/{book}', [BookApiController::class, 'show']);

// Return all book categories with their book counts.
Route::get('/categories', [CategoryApiController::class, 'index']);