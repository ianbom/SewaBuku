<?php

namespace Database\Factories;

use Illuminate\Database\Eloquent\Factories\Factory;
use Illuminate\Support\Facades\Storage;

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
        $audioFiles = Storage::disk('public')->files('voice/teaser');
        $randomAudio = $audioFiles ? $audioFiles[array_rand($audioFiles)] : null;

        return [
            'judul_buku' => $this->faker->sentence(3),
            'penulis' => $this->faker->name(),
            'sub_judul' => $this->faker->sentence(4),
            'tentang_penulis' => $this->faker->sentence(),
            'penerbit' => $this->faker->company(),
            'isbn' => $this->faker->isbn13(),
            'tahun_terbit' => $this->faker->year(),
            'rating_amazon' => $this->faker->numberBetween(1,5),
            'link_pembelian' => $this->faker->sentence(),
            'teaser_audio' => $randomAudio ?? 'https://example.com/audio.mp3',
            'sinopsis' => $this->faker->paragraph(10),
            'ringkasan_audio' => $randomAudio ?? 'https://example.com/audio.mp3',
        ];
    }
}
