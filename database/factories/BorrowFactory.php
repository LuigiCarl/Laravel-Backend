<?php

namespace Database\Factories;

use App\Models\Book;
use App\Models\User;
use Illuminate\Database\Eloquent\Factories\Factory;

/**
 * @extends \Illuminate\Database\Eloquent\Factories\Factory<\App\Models\Borrow>
 */
class BorrowFactory extends Factory
{
    public function definition(): array
    {
        $borrowDate = $this->faker->dateTimeBetween('-1 month', 'now');
        $dueDate = (clone $borrowDate)->modify('+14 days');

        // Determine borrow status
        $status = $this->faker->randomElement(['active', 'returned']);

        // Set return date only if status is "returned"
        $returnDate = $status === 'returned'
            ? $this->faker->dateTimeBetween($borrowDate, 'now')
            : null;

        return [
            'book_id' => Book::factory(),
            'borrower_id' => User::factory(),
            'borrow_date' => $borrowDate,
            'due_date' => $dueDate,
            'return_date' => $returnDate,
            'status' => $status,
        ];
    }
}
