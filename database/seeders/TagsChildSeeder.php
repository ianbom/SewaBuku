<?php

namespace Database\Seeders;

use App\Models\Tags;
use Illuminate\Database\Console\Seeds\WithoutModelEvents;
use Illuminate\Database\Seeder;
use Illuminate\Support\Facades\DB;

class TagsChildSeeder extends Seeder
{
    /**
     * Run the database seeds.
     */
    public function run(): void
    {
        $tags = Tags::whereNull('id_child')->get();
        $categories = [
            "Self Improvement",
            "Productivity and Efficiency",
            "Motivation and Improvement",
            "Career and Success Growth",
            "Communication Mastery",
            "Learning and Education"
        ];

        foreach ($tags as $tag) {
            foreach ($categories as $child) {
                DB::table('tags')->insert([
                    'id_child'  => $tag->id_tags,
                    'nama_tags' => $child,
                    'created_at' => now(),
                    'updated_at' => now(),
                ]);
            }
        }
    }
}
