<?php

namespace Database\Seeders;

use Illuminate\Database\Seeder;
use Illuminate\Support\Facades\DB;
use App\Models\User;

class ExerciseLogEntitySeeder extends Seeder
{
    public function run(): void
    {
        DB::table('exercise_log_table')->insert([
            [
                'exerciseId' => 1,
                'date' => '2025-05-20',
                'weight' => 50.0,
                'reps' => 15,
                'user_id' => User::first()->id,
            ],
            [
                'exerciseId' => 2,
                'date' => '2025-05-20',
                'weight' => 0.0,
                'reps' => 12,
                'user_id' => User::first()->id,
            ],
            [
                'exerciseId' => 3,
                'date' => '2025-05-20',
                'weight' => 0.0,
                'reps' => 1,
                'user_id' => User::first()->id,
            ]
        ]);
    }
}
