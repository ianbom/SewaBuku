<?php

namespace Database\Factories;

use Illuminate\Database\Eloquent\Factories\Factory;

/**
 * @extends \Illuminate\Database\Eloquent\Factories\Factory<\App\Models\Opsi>
 */
class OpsiFactory extends Factory
{
    /**
     * Define the model's default state.
     *
     * @return array<string, mixed>
     */
    public function definition(): array
    {
        return [
            'id_soal' => $this->faker->numberBetween(1, 100),
            'opsi' => $this->faker->sentence(5),
            'is_correct' => $this->faker->numberBetween(0,1),
        ];
    }
}
