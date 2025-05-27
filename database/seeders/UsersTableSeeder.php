<?php

namespace Database\Seeders;

use Illuminate\Database\Seeder;
use Illuminate\Support\Facades\DB;
use Illuminate\Support\Facades\Hash;
use Illuminate\Support\Str;

class UsersTableSeeder extends Seeder
{
    public function run(): void
    {
        DB::table('users')->insert([
            'name' => 'Android User',
            'email' => 'android@example.com',
            'password' => Hash::make('password123'),
            'email_verified_at' => now(),
            'remember_token' => Str::random(10),
            'streak_days' => 5,
            'profile_image' => 'https://example.com/profile.jpg',
            'created_at' => now(),
            'updated_at' => now(),
        ]);
    }
}
