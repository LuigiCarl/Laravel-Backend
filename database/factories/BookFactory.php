<?php

namespace Database\Factories;

use Illuminate\Database\Eloquent\Factories\Factory;

/**
 * @extends \Illuminate\Database\Eloquent\Factories\Factory<\App\Models\Book>
 */
class BookFactory extends Factory
{
    public function definition(): array
    {
        $copies = $this->faker->numberBetween(1, 20);
        return [
            'title' => $this->faker->sentence(3),
            'author' => $this->faker->name,
            'isbn' => $this->faker->unique()->isbn13,
            'category' => $this->faker->word,
            'published_year' => $this->faker->numberBetween(1980, date('Y')),
            'copies' => $copies,
            'available_copies' => $this->faker->numberBetween(0, $copies),
            'description' => $this->faker->paragraph,
            'cover_image' => $this->faker->imageUrl(200, 300, 'books', true),
        ];
    }
}
