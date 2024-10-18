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
            'penerbit' => $this->faker->company(),
            'jumlah_halaman' => $this->faker->numberBetween(100, 500),
            'isbn' => $this->faker->isbn13(),
            'tahun_terbit' => $this->faker->year(),
            'harga' => $this->faker->randomFloat(2, 10000, 100000), // harga dengan 2 desimal
            'teaser_audio' => $this->faker->fileExtension(), // Bisa diubah sesuai logika
            'sinopsis' => $this->faker->paragraph(5),
            'ringkasan_audio' => $this->faker->paragraph(5)
        ];
    }
}
