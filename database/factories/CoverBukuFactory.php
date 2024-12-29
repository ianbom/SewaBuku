<?php

namespace Database\Factories;

use Illuminate\Database\Eloquent\Factories\Factory;
use Illuminate\Support\Facades\Storage;

/**
 * @extends \Illuminate\Database\Eloquent\Factories\Factory<\App\Models\CoverBuku>
 */
class CoverBukuFactory extends Factory
{
    /**
     * Define the model's default state.
     *
     * @return array<string, mixed>
     */
    public function definition(): array
    {
        $coverPhoto = Storage::disk('public')->files('cover_buku');
        $randomCover = $coverPhoto ? $coverPhoto[array_rand($coverPhoto)] : null;

        return [
            'id_buku' => $this->faker->numberBetween(1, 5),
            'file_image' => $randomCover
        ];
    }
}
