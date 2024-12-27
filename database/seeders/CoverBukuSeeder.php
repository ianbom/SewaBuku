<?php

namespace Database\Seeders;

use App\Models\CoverBuku;
use Illuminate\Database\Console\Seeds\WithoutModelEvents;
use Illuminate\Database\Seeder;

class CoverBukuSeeder extends Seeder
{
    /**
     * Run the database seeds.
     */
    public function run(): void
    {
        CoverBuku::factory()->count(50)->create();
    }
}
