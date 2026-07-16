<?php

use App\Http\Controllers\Admin\BorrowingController as AdminBorrowingController;
use App\Http\Controllers\Admin\CategoryController as AdminCategoryController;
use App\Http\Controllers\Admin\BookController as AdminBookController;;
use App\Http\Controllers\AuthController;
use App\Http\Controllers\DashboardController;
use Illuminate\Support\Facades\Route;

/*
 Public Routes
 */


Route::view('/', 'home.index')->name('home');

Route::view('/about', 'home.about')->name('about');

Route::view('/contact', 'home.contact')->name('contact');


/*
Guest Authentication Routes
Only users who are not logged in can access these routes.
*/

Route::middleware('guest')->group(function () {
    Route::get('/login', [AuthController::class, 'showLogin'])
        ->name('login');

    Route::post('/login', [AuthController::class, 'login'])
        ->name('login.submit');

    Route::get('/register', [AuthController::class, 'showRegister'])
        ->name('register');

    Route::post('/register', [AuthController::class, 'register'])
        ->name('register.submit');
});


/*
 Authenticated Routes
*/

Route::middleware('auth')->group(function () {
    /*
     * Redirect the user to the correct dashboard based on their role.
     */
    Route::get('/dashboard', function () {
        return auth()->user()->isAdmin()
            ? redirect()->route('admin.dashboard')
            : redirect()->route('member.dashboard');
    })->name('dashboard');

    /*
     * Admin dashboard route.
     */
    Route::middleware('role:admin')
        ->prefix('admin')
        ->name('admin.')
        ->group(function () {
            Route::get('/dashboard', [DashboardController::class, 'admin'])
                ->name('dashboard');
                // Admin book-management routes.
            Route::resource('books', AdminBookController::class);
            // Add category-management route
            Route::resource('categories', AdminCategoryController::class)->except('show');
            
            // Display the form for issuing a book to a member.
            Route::get('/borrowings/issue', [AdminBorrowingController::class, 'create'])->name('borrowings.create');
            // Validate and save a new borrowing record.
            Route::post('/borrowings/issue', [AdminBorrowingController::class, 'store'])->name('borrowings.store');
            // Display active borrowing records and return options.
            Route::get('/borrowings/active', [AdminBorrowingController::class, 'active'])->name('borrowings.active');
            // Mark a selected borrowing record as returned.
            Route::patch('/borrowings/{borrowing}/return', [AdminBorrowingController::class, 'returnBook'])->name('borrowings.return');
            // Display all active and completed borrowing records.
            Route::get('/borrowings/history', [AdminBorrowingController::class, 'history'])->name('borrowings.history');
        });

    /*
     * Member dashboard route.
     */
    Route::middleware('role:member')
        ->prefix('member')
        ->name('member.')
        ->group(function () {
            Route::get('/dashboard', [DashboardController::class, 'member'])
                ->name('dashboard');
        });

    /*
     * Logout route.
     */
    Route::post('/logout', [AuthController::class, 'logout'])
        ->name('logout');
});