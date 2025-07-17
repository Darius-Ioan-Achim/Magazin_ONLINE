<?php

namespace Database\Factories;

use Illuminate\Database\Eloquent\Factories\Factory;

/**
 * @extends \Illuminate\Database\Eloquent\Factories\Factory<\App\Models\Book>
 */
class BookFactory extends Factory
{
    /**
     * Define the model's default state.
     *
     * @return array<string, mixed>
     */
    public function definition(): array
    {
        return [
             'title' => $this->faker->sentence(3),
            'author' => $this->faker->name(),
            'description' => $this->faker->paragraph(4),
            'isbn' => $this->faker->unique()->isbn13(),
            'stock' => $this->faker->numberBetween(0, 100),
            'price' => $this->faker->randomFloat(2, 10, 200),
            'image_path' => $this->faker->optional()->imageUrl(640, 480, 'books', true),
            'is_active' => $this->faker->boolean(90),
            'category_id' => fake()->numberBetween(1, 10), // ID simplu în loc de factory
            'genre_id' => fake()->numberBetween(1, 10),    // ID simplu în loc de factory
        ];
    }
}
