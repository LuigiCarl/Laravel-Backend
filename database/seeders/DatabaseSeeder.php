<?php

namespace Database\Seeders;

use Illuminate\Database\Seeder;
use App\Models\User;
use App\Models\Book;
use App\Models\Borrow;

class DatabaseSeeder extends Seeder
{
    /**
     * Seed the application's database.
     */
    public function run(): void
    {
        // Create one fixed test user
        $user = User::factory()->create([
            'name' => 'Test User',
            'email' => 'test@example.com',
        ]);

        // Create additional random users
        $users = User::factory(5)->create();

        // Create books
        $books = Book::factory(10)->create();

        // Create borrows for test user
        foreach ($books->take(5) as $book) {
            Borrow::factory()->create([
                'book_id' => $book->id,
                'borrower_id' => $user->id,
            ]);
        }

        // Create random borrows for other users
        foreach ($books->slice(5) as $book) {
            Borrow::factory()->create([
                'book_id' => $book->id,
                'borrower_id' => $users->random()->id,
            ]);
        }
    }
}
