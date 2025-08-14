<?php

namespace Database\Factories;

use Illuminate\Database\Eloquent\Factories\Factory;

/**
 * @extends \Illuminate\Database\Eloquent\Factories\Factory<\App\Models\Rating>
 */
class RatingFactory extends Factory
{
    /**
     * Define the model's default state.
     *
     * @return array<string, mixed>
     */
    public function definition(): array
    {
        return new class extends Factory {
            protected $model = Rating::class;
            public function definition(): array {
                return [
                    'book_id' => Book::factory(),
                    'score' => $this->faker->numberBetween(1,5),
                    'comment' => $this->faker->boolean(30) ? $this->faker->sentence(12) : null,
                ];
            }
        };
    }
}
