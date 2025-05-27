<?php

namespace Database\Seeders;

use Illuminate\Database\Seeder;

class DatabaseSeeder extends Seeder
{
    /**
     * Run the database seeders.
     */
    public function run(): void
    {
        $this->call([
            UsersTableSeeder::class,
            ExerciseEntitySeeder::class,
            ExerciseLogEntitySeeder::class,
            NoteEntitySeeder::class,
            RoutineEntitySeeder::class,
        ]);
    }
}
