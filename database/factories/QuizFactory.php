<?php

namespace Database\Factories;

use Illuminate\Database\Eloquent\Factories\Factory;

/**
 * @extends \Illuminate\Database\Eloquent\Factories\Factory<\App\Models\Quiz>
 */
class QuizFactory extends Factory
{
    /**
     * Define the model's default state.
     *
     * @return array<string, mixed>
     */
    public function definition(): array
    {
        return [
            'id_detail_buku' => $this->faker->unique()->numberBetween(1, 100),
            'nama_quiz' => $this->faker->sentence(5),
            'deskripsi' => $this->faker->sentence(20),
        ];
    }
}
