<?php

namespace Database\Seeders;

use App\Models\Tags;
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
        // Disable foreign key checks
        DB::statement('SET FOREIGN_KEY_CHECKS=0;');

        // Truncate the table to remove existing data
        DB::table('tags')->truncate();

        $tags = [
            'Novel',
            'Komik',
            'Drama',
            'Fiksi',
            'Non-Fiksi',
            'Misteri',
            'Petualangan',
            'Biografi',
            'Horor',
            'Romantis',
            'Sejarah',
            'Psikologi',
            'Kesehatan',
            'Pengembangan Diri',
            'Pendidikan',
            'Teknologi',
            'Politik',
            'Agama',
            'Sains',
            'Bisnis'
        ];

        // Insert each tag into the database
        foreach ($tags as $tag) {
            DB::table('tags')->insert([
                'nama_tags' => $tag,
                'created_at' => now(),
                'updated_at' => now(),
            ]);
        }

        // Re-enable foreign key checks
        DB::statement('SET FOREIGN_KEY_CHECKS=1;');
    }
}
