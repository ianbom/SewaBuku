<?php

namespace Database\Seeders;

use Illuminate\Database\Console\Seeds\WithoutModelEvents;
use Illuminate\Database\Seeder;
use Illuminate\Support\Facades\DB;
use Illuminate\Support\Facades\Hash;

class UserSeeder extends Seeder
{
    /**
     * Run the database seeds.
     */
    public function run(): void
    {
        DB::table('users')->insert([
            'name' => 'Admin',
            'email' => 'admin@gmail.com',
            'password' => Hash::make('admin123'),
            'is_admin' => true
        ]);

        DB::table('users')->insert([
            'name' => 'Ian',
            'email' => 'ian@gmail.com',
            'password' => Hash::make('ianian123'),
            'is_admin' => false
        ]);

        DB::table('users')->insert([
            'name' => 'IanBom',
            'email' => 'ianbom@gmail.com',
            'password' => Hash::make('ianbom123'),
            'is_admin' => false
        ]);

        DB::table('users')->insert([
            'name' => 'Ale',
            'email' => 'ale@gmail.com',
            'password' => Hash::make('aleale123'),
            'is_admin' => false
        ]);
    }
}
