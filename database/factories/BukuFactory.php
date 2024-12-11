<?php

namespace Database\Factories;

use Illuminate\Database\Eloquent\Factories\Factory;

/**
 * @extends \Illuminate\Database\Eloquent\Factories\Factory<\App\Models\Buku>
 */
class BukuFactory extends Factory
{
    /**
     * Define the model's default state.
     *
     * @return array<string, mixed>
     */
    public function definition(): array
    {
        return [
            'judul_buku' => $this->faker->sentence(3),
            'penulis' => $this->faker->name(),
            'tentang_penulis' => $this->faker->sentence(),
            'penerbit' => $this->faker->company(),
            'isbn' => $this->faker->isbn13(),
            'tahun_terbit' => $this->faker->year(),
            'rating_amazon' => $this->faker->numberBetween(1,5),
            'link_pembelian' => $this->faker->sentence(),
            'teaser_audio' => $this->faker->fileExtension(), // Bisa diubah sesuai logika
            'sinopsis' => $this->faker->paragraph(5),
            'ringkasan_audio' => $this->faker->paragraph(5)
        ];
    }
}
