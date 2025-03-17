<?php

namespace Database\Seeders;

use App\Models\User;
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
            'name' => 'User',
            'email' => 'user@gmail.com',
            'password' => Hash::make('user12345'),
            'is_admin' => false
        ]);

        DB::table('users')->insert([
            'name' => 'Ian',
            'email' => 'ianbom@gmail.com',
            'password' => Hash::make('ianbom123'),
            'is_admin' => false
        ]);
    }
}
