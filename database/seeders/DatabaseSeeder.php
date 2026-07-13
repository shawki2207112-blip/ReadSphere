<?php

namespace Database\Seeders;

use App\Models\Book;
use App\Models\Borrowing;
use App\Models\Category;
use App\Models\User;
use Illuminate\Database\Seeder;
use Illuminate\Support\Facades\Hash;

class DatabaseSeeder extends Seeder
{
    /**
     * Seed the application's database with demo users,
     * categories, books, and borrowing records.
     */
    public function run(): void
    {
        /*
         Create Demo Users
        */

        $admin = User::create([
            'name' => 'Library Admin',
            'email' => 'admin@library.com',
            'phone' => '01700000000',
            'password' => Hash::make('admin123'),
            'role' => 'admin',
        ]);

        $member = User::create([
            'name' => 'shawki',
            'email' => 'shawki@gmail.com',
            'phone' => '01800000000',
            'password' => Hash::make('shawki123'),
            'role' => 'member',
        ]);

        $secondMember = User::create([
            'name' => 'Mikasa',
            'email' => 'mikasa@gmail.com',
            'phone' => '01900000000',
            'password' => Hash::make('mikasa123'),
            'role' => 'member',
        ]);

        /*
         Create Book Categories
        */

        $programming = Category::create([
            'category_name' => 'Programming',
        ]);

        $business = Category::create([
            'category_name' => 'Business',
        ]);

        $novel = Category::create([
            'category_name' => 'Novel',
        ]);

        $science = Category::create([
            'category_name' => 'Science',
        ]);

        /*
        Create Demo Books
        */

        $books = [
            Book::create([
                'title' => 'Laravel for Beginners',
                'author' => 'A. Rahman',
                'isbn' => '9780000000001',
                'category_id' => $programming->id,
                'total_copies' => 5,
                'available_copies' => 4,
            ]),

            Book::create([
                'title' => 'PHP Essentials',
                'author' => 'Sarah Khan',
                'isbn' => '9780000000002',
                'category_id' => $programming->id,
                'total_copies' => 4,
                'available_copies' => 4,
            ]),

            Book::create([
                'title' => 'Database Fundamentals',
                'author' => 'M. Hasan',
                'isbn' => '9780000000003',
                'category_id' => $programming->id,
                'total_copies' => 3,
                'available_copies' => 3,
            ]),

            Book::create([
                'title' => 'Principles of Management',
                'author' => 'R. Karim',
                'isbn' => '9780000000004',
                'category_id' => $business->id,
                'total_copies' => 4,
                'available_copies' => 4,
            ]),

            Book::create([
                'title' => 'Harry Potter',
                'author' => 'J.K. Rowling',
                'isbn' => '9780000000005',
                'category_id' => $novel->id,
                'total_copies' => 2,
                'available_copies' => 2,
            ]),

            Book::create([
                'title' => 'Everyday Physics',
                'author' => 'N. Ahmed',
                'isbn' => '9780000000006',
                'category_id' => $science->id,
                'total_copies' => 3,
                'available_copies' => 3,
            ]),
        ];

        /*
         Create an Active Borrowing Record

        */

        Borrowing::create([
            'user_id' => $member->id,
            'book_id' => $books[0]->id,
            'issue_date' => today()->subDays(3),
            'due_date' => today()->addDays(11),
            'status' => 'borrowed',
        ]);

        /*
         Create a Returned Borrowing Record
         */
        

        Borrowing::create([
            'user_id' => $secondMember->id,
            'book_id' => $books[3]->id,
            'issue_date' => today()->subDays(30),
            'due_date' => today()->subDays(16),
            'returned_at' => today()->subDays(17),
            'status' => 'returned',
        ]);
    }
}