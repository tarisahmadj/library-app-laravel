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
        return new class extends Factory {
            protected $model = Book::class;
            public function definition(): array {
                return [
                    'title' => $this->faker->sentence(4),
                    'author_id' => Author::factory(),
                    'category_id' => Category::factory(),
                    'published_year' => $this->faker->numberBetween(1970, (int)date('Y')),
                    'price' => $this->faker->randomFloat(2, 5, 200),
                ];
            }
        };
    }
}
