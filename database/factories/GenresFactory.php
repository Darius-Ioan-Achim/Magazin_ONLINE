<?php

namespace Database\Factories;

use Illuminate\Database\Eloquent\Factories\Factory;

/**
 * @extends \Illuminate\Database\Eloquent\Factories\Factory<\App\Models\Model>
 */
class GenresFactory extends Factory
{
    /**
     * Define the model's default state.
     *
     * @return array<string, mixed>
     */
    public function definition(): array
    {
        $genres = [
            'Action', 'Adventure', 'Comedy', 'Drama', 'Horror', 'Thriller',
            'Romance', 'Sci-Fi', 'Fantasy', 'Mystery', 'Crime', 'Documentary',
            'Animation', 'Family', 'Musical', 'Western', 'War', 'Biography',
            'History', 'Sport', 'Music', 'News', 'Reality', 'Talk Show'
        ];
        return [
            'name' => $this->faker->unique()->randomElement($genres),
        ];
    }
    public function withName(string $name): static
    {
        return $this->state(fn (array $attributes) => [
            'name' => $name,
        ]);
    }

    /**
     * Create a random genre name if predefined ones are exhausted.
     */
    public function random(): static
    {
        return $this->state(fn (array $attributes) => [
            'name' => $this->faker->unique()->word(),
        ]);
    }
}
