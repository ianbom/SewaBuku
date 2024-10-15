<?php

namespace Database\Seeders;

use Illuminate\Database\Console\Seeds\WithoutModelEvents;
use Illuminate\Database\Seeder;
use Illuminate\Support\Facades\DB;

class BukuSeeder extends Seeder
{
    /**
     * Run the database seeds.
     */
    public function run(): void
    {
        DB::table('buku')->insert([
            [
                'nama_buku' => 'Naruto',
                'harga' => 500000,
                'trailer_voice' => 'trailer_naruto.mp3',
                'sinopsis' => 'Naruto adalah seorang ninja muda yang bercita-cita menjadi Hokage.',
                'full_cerita' => 'Naruto Uzumaki, seorang ninja yang nakal dan penuh semangat, lahir dengan takdir yang berat di pundaknya...',
                'full_voice' => 'full_voice_naruto.mp3',
            ],
            [
                'nama_buku' => 'One Piece',
                'harga' => 600000,
                'trailer_voice' => 'trailer_one_piece.mp3',
                'sinopsis' => 'Mencari harta karun legendaris, Luffy dan krunya berpetualang di lautan.',
                'full_cerita' => 'Monkey D. Luffy, seorang pemuda yang memiliki kekuatan untuk meregangkan tubuhnya, bercita-cita menjadi Raja Bajak Laut dengan menemukan One Piece...',
                'full_voice' => 'full_voice_one_piece.mp3',
            ],
            [
                'nama_buku' => 'Attack on Titan',
                'harga' => 550000,
                'trailer_voice' => 'trailer_attack_on_titan.mp3',
                'sinopsis' => 'Perjuangan manusia melawan raksasa yang mengancam keberadaan mereka.',
                'full_cerita' => 'Di dunia di mana umat manusia hidup di balik tembok besar untuk melindungi diri dari Titans, Eren Yeager bersama teman-temannya berjuang untuk membebaskan dunia...',
                'full_voice' => 'full_voice_attack_on_titan.mp3',
            ],
            [
                'nama_buku' => 'Death Note',
                'harga' => 450000,
                'trailer_voice' => 'trailer_death_note.mp3',
                'sinopsis' => 'Seorang siswa menemukan buku yang bisa membunuh siapapun dengan nama yang ditulis.',
                'full_cerita' => 'Light Yagami, seorang siswa jenius, menemukan Death Note dan mulai menggunakan buku tersebut untuk menghilangkan para penjahat dari dunia...',
                'full_voice' => 'full_voice_death_note.mp3',
            ],
            [
                'nama_buku' => 'Sword Art Online',
                'harga' => 480000,
                'trailer_voice' => 'trailer_sword_art_online.mp3',
                'sinopsis' => 'Pemain terjebak dalam dunia game virtual dan harus berjuang untuk bertahan hidup.',
                'full_cerita' => 'Setelah terjebak dalam permainan virtual, Kirito dan pemain lainnya harus menyelesaikan permainan untuk bisa keluar dan menghadapi berbagai tantangan...',
                'full_voice' => 'full_voice_sword_art_online.mp3',
            ],
            [
                'nama_buku' => 'My Hero Academia',
                'harga' => 500000,
                'trailer_voice' => 'trailer_my_hero_academia.mp3',
                'sinopsis' => 'Di dunia di mana kebanyakan orang memiliki kekuatan super, Izuku Midoriya berjuang untuk menjadi pahlawan.',
                'full_cerita' => 'Izuku Midoriya, seorang anak tanpa kekuatan super, bercita-cita menjadi pahlawan dan mendaftar di U.A. High School untuk mengejar impiannya...',
                'full_voice' => 'full_voice_my_hero_academia.mp3',
            ],
            [
                'nama_buku' => 'Fullmetal Alchemist',
                'harga' => 520000,
                'trailer_voice' => 'trailer_fullmetal_alchemist.mp3',
                'sinopsis' => 'Dua saudara mencari cara untuk mengembalikan tubuh mereka setelah ritual alkimia yang gagal.',
                'full_cerita' => 'Edward dan Alphonse Elric, setelah kehilangan tubuh mereka dalam upaya menghidupkan kembali ibu mereka, berpetualang mencari Philosopher\'s Stone untuk memperbaiki kesalahan mereka...',
                'full_voice' => 'full_voice_fullmetal_alchemist.mp3',
            ],
            [
                'nama_buku' => 'Demon Slayer',
                'harga' => 530000,
                'trailer_voice' => 'trailer_demon_slayer.mp3',
                'sinopsis' => 'Seorang pemuda berjuang untuk menyelamatkan saudarinya dari kutukan iblis.',
                'full_cerita' => 'Tanjiro Kamado, seorang pemuda yang menghidupi keluarganya dengan menjual arang, menjadi pemburu iblis setelah keluarganya diserang oleh iblis, dan ia berjuang untuk menyelamatkan saudarinya, Nezuko...',
                'full_voice' => 'full_voice_demon_slayer.mp3',
            ],
        ]);
    }
}
