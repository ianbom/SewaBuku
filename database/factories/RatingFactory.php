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
        return [
            'id' => $this->faker->numberBetween(1, 20),
            'id_buku' => $this->faker->numberBetween(1, 20),
            'rating' => $this->faker->numberBetween(1, 5),
            'komentar' => $this->faker->sentence(),
        ];
    }
}
