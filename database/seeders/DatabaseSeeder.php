<?php

namespace Database\Seeders;

use App\Models\DetailBuku;
use App\Models\Rating;
use App\Models\User;
// use Illuminate\Database\Console\Seeds\WithoutModelEvents;
use Illuminate\Database\Seeder;

class DatabaseSeeder extends Seeder
{
    /**
     * Seed the application's database.
     */
    public function run(): void
    {

        $this->call([
            UserSeeder::class,
            // BukuSeeder::class,
            // DetailBukuSeeder::class,
            // CoverBukuSeeder::class,
            // RatingSeeder::class,
            // TagsSeeder::class,
            // PaketSeeder::class,
            // QuizSeeder::class,
            // SoalSeeder::class,
            // OpsiSeeder::class,
            // TagsChildSeeder::class,
        ]);
    }
}
