<?php

namespace Database\Seeders;

use Illuminate\Database\Console\Seeds\WithoutModelEvents;
use Illuminate\Database\Seeder;
use Illuminate\Support\Facades\DB;

class PaketSeeder extends Seeder
{
    /**
     * Run the database seeds.
     */
    public function run(): void
    {
        DB::table('paket_langganan')->insert([
            'nama_paket' => 'Paket 1 Bulan',
            'harga' => 50000,
            'masa_waktu' => 30,
            'deskripsi' => 'Ini paket 1 bulan anda bisa berlangganan 30 hari',
            'is_active' => true,
            'created_at' => now(),
            'updated_at' => now(),
        ]);

        DB::table('paket_langganan')->insert([
            'nama_paket' => 'Paket 2 Bulan',
            'harga' => 100000,
            'masa_waktu' => 60,
            'deskripsi' => 'Ini paket 2 bulan anda bisa berlangganan 60 hari',
            'is_active' => true,
            'created_at' => now(),
            'updated_at' => now(),
        ]);

        DB::table('paket_langganan')->insert([
            'nama_paket' => 'Paket 3 Bulan',
            'harga' => 150000,
            'masa_waktu' => 90,
            'deskripsi' => 'Ini paket 3 bulan anda bisa berlangganan 90 hari',
            'is_active' => true,
            'created_at' => now(),
            'updated_at' => now(),
        ]);
    }
}
