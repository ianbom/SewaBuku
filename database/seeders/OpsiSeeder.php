<?php

namespace Database\Seeders;

use App\Models\Opsi;
use Illuminate\Database\Console\Seeds\WithoutModelEvents;
use Illuminate\Database\Seeder;

class OpsiSeeder extends Seeder
{
    /**
     * Run the database seeds.
     */
    public function run(): void
    {
        Opsi::factory()->count(500)->create();
    }
}
