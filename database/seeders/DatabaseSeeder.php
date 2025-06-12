<?php

namespace Database\Seeders;

use Illuminate\Database\Seeder;

class DatabaseSeeder extends Seeder
{
    /**
     * Run the database seeders.
     * llamando a los seeders específicos para poblar la base de datos
     */
    public function run(): void
    {
        $this->call([
            ExerciseEntitySeeder::class,
        ]);
    }
}
