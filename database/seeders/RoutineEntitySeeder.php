<?php

namespace Database\Seeders;

use Illuminate\Database\Seeder;
use Illuminate\Support\Facades\DB;
use App\Models\User;
class RoutineEntitySeeder extends Seeder
{
    public function run(): void
    {
        DB::table('routine_table')->insert([
            [
                'name' => 'Full Body Blast',
                'description' => 'Rutina completa de cuerpo',
                'imageUri' => 'https://www.nutrides.com/wp-content/uploads/2023/04/rutinas-full-body-para-entrenar-tu-cuerpo-entero-actualizadas.jpg',
                'exerciseIds' => '1,2,3',
                'user_id' => User::first()->id,
            ],
            [
                'name' => 'Upper Body Strength',
                'description' => 'Pecho, espalda y hombros',
                'imageUri' => 'https://www.cortaporlosano.com/pics/2025/01/work-every-muscle-with-this-complete-full-body-dumbbell-workout-no-gym-needed.jpg',
                'exerciseIds' => '4,5',
                'user_id' => User::first()->id,
            ],
            [
                'name' => 'Lower Body Power',
                'description' => 'Piernas y glúteos',
                'imageUri' => 'https://tse3.mm.bing.net/th/id/OIP.rn7uUSyMHDgkHepEGND-aQHaFA?rs=1&pid=ImgDetMain',
                'exerciseIds' => '6,7',
                'user_id' => User::first()->id,
            ],
            [
                'name' => 'Core Crusher',
                'description' => 'Abdominales intensivos',
                'imageUri' => 'https://th.bing.com/th/id/OIP.wDRCPU8Cuxw9tKZT4mtVvQHaE8?w=303&h=202&c=7&r=0&o=5&dpr=1.1&pid=1.7',
                'exerciseIds' => '8,9,10',
                'user_id' => User::first()->id,
            ]
        ]);
    }
}
