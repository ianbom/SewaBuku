<?php

namespace Database\Seeders;

use Illuminate\Database\Console\Seeds\WithoutModelEvents;
use Illuminate\Database\Seeder;
use Illuminate\Support\Facades\DB;

class TagsSeeder extends Seeder
{
    /**
     * Run the database seeds.
     */
    public function run(): void
    {
        $tags = [
            'Novel', 'Komik', 'Drama', 'Fiksi', 'Non-Fiksi',
            'Misteri', 'Petualangan', 'Biografi', 'Horor', 'Romantis',
            'Sejarah', 'Psikologi', 'Kesehatan', 'Pengembangan Diri', 'Pendidikan',
            'Teknologi', 'Politik', 'Agama', 'Sains', 'Bisnis'
        ];

        // Insert each tag into the database
        foreach ($tags as $tag) {
            DB::table('tags')->insert([
                'nama_tags' => $tag,
                'created_at' => now(),
                'updated_at' => now(),
            ]);
        }
    }
}
