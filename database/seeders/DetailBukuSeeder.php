<?php

namespace Database\Seeders;

use App\Models\DetailBuku;
use Illuminate\Database\Console\Seeds\WithoutModelEvents;
use Illuminate\Database\Seeder;

class DetailBukuSeeder extends Seeder
{

    public function run(): void
    {
        DetailBuku::factory()->count(50)->create();
    }
}
