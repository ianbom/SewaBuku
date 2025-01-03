<?php

namespace Database\Factories;

use Illuminate\Database\Eloquent\Factories\Factory;
use Illuminate\Support\Facades\Storage;

/**
 * @extends \Illuminate\Database\Eloquent\Factories\Factory<\App\Models\DetailBuku>
 */
class DetailBukuFactory extends Factory
{

    public function definition(): array
    {

        $audioFiles = Storage::disk('public')->files('voice/teaser');
        $randomAudio = $audioFiles ? $audioFiles[array_rand($audioFiles)] : null;

        return [
            'id_buku' => $this->faker->numberBetween(1, 5),
            'bab' => $this->faker->sentence(3),
            'isi' => $this->faker->sentence(50),
            'audio' => $randomAudio
        ];
    }
}
