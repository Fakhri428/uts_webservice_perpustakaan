<?php

namespace Database\Factories;

use App\Models\Book;
use Illuminate\Database\Eloquent\Factories\Factory;

/**
 * @extends \Illuminate\Database\Eloquent\Factories\Factory<\App\Models\Book>
 */
class BookFactory extends Factory
{
    protected $model = Book::class;

    /**
     * Define the model's default state.
     *
     * @return array<string, mixed>
     */
    public function definition(): array
    {
        $categories = ['Fiction', 'Non-Fiction', 'Science', 'History', 'Biography', 'Technology', 'Romance', 'Mystery', 'Fantasy', 'Adventure'];
        
        return [
            'title' => fake()->sentence(3),
            'author' => fake()->name(),
            'description' => fake()->paragraphs(3, true),
            'category' => fake()->randomElement($categories),
            'published_year' => fake()->year(),
            'isbn' => fake()->isbn13(),
            'stock' => fake()->numberBetween(1, 50),
            'image' => null,
        ];
    }
}
