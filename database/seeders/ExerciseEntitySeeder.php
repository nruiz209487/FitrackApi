<?php

namespace Database\Seeders;

use Illuminate\Database\Seeder;
use Illuminate\Support\Facades\DB;

class ExerciseEntitySeeder extends Seeder
{
    /**
     * Run the database seeds.
     */
    public function run(): void
    {
        DB::table('exercise_table')->insert([
            [
                'id' => 1,
                'name' => 'culo',
                'description' => '3x15 repeticiones',
                'image_uri' => 'https://tse1.mm.bing.net/th/id/OIP.uSNK5ejNHJuvUNJTZTlFxAHaE8?rs=1&pid=ImgDetMain',
                'created_at' => now(),
                'updated_at' => now(),
            ],
            [
                'id' => 2,
                'name' => 'Flexiones',
                'description' => '4x12 repeticiones',
                'image_uri' => 'https://th.bing.com/th/id/R.d859a5a197eec32024873c14eb099a7e?rik=%2bfz8ydP3serhLQ&pid=ImgRaw&r=0',
                'created_at' => now(),
                'updated_at' => now(),
            ],
            [
                'id' => 3,
                'name' => 'Planchas',
                'description' => '3x60 segundos',
                'image_uri' => 'https://hips.hearstapps.com/hmg-prod.s3.amazonaws.com/images/mid-adult-man-doing-plank-exercise-royalty-free-image-1585917009.jpg?resize=980:*',
                'created_at' => now(),
                'updated_at' => now(),
            ],
            [
                'id' => 4,
                'name' => 'Press de banca',
                'description' => '4x10 repeticiones',
                'image_uri' => 'https://i0.wp.com/www.entrenamiento.com/wp-content/uploads/2018/11/mecanica-press-banca-720x466.jpg?resize=720%2C466&ssl=1',
                'created_at' => now(),
                'updated_at' => now(),
            ],
            [
                'id' => 5,
                'name' => 'Remo con mancuernas',
                'description' => '3x12 repeticiones',
                'image_uri' => 'https://i.blogs.es/0c2131/remo-con-mancuerna/1366_2000.jpg',
                'created_at' => now(),
                'updated_at' => now(),
            ],
            [
                'id' => 6,
                'name' => 'Peso muerto',
                'description' => '4x8 repeticiones',
                'image_uri' => 'https://th.bing.com/th/id/R.68861ecb440382aff77afd38b8d15dd9?rik=ghI5SNJJE%2brIAg&pid=ImgRaw&r=0',
                'created_at' => now(),
                'updated_at' => now(),
            ],
            [
                'id' => 7,
                'name' => 'Zancadas',
                'description' => '3x12 cada pierna',
                'image_uri' => 'https://tse1.mm.bing.net/th/id/OIP.xbYcSVNrKhoRwFClup1W8wHaEo?rs=1&pid=ImgDetMain',
                'created_at' => now(),
                'updated_at' => now(),
            ],
            [
                'id' => 8,
                'name' => 'Crunch abdominal',
                'description' => '4x20 repeticiones',
                'image_uri' => 'https://www.blog.kiffemybody.com/wp-content/uploads/2018/08/Crunch-abdominal-kiffemybody.jpg',
                'created_at' => now(),
                'updated_at' => now(),
            ],
            [
                'id' => 9,
                'name' => 'Elevación de piernas',
                'description' => '3x15 repeticiones',
                'image_uri' => 'https://th.bing.com/th/id/R.f089a3607a27f827b5a2a9ed49349b25?rik=T1%2beWLLLYcYnZw&pid=ImgRaw&r=0',
                'created_at' => now(),
                'updated_at' => now(),
            ],
            [
                'id' => 10,
                'name' => 'Oblicuos',
                'description' => '3x20 repeticiones',
                'image_uri' => 'https://tse2.mm.bing.net/th/id/OIP.nVRIybSfE2_2NJhlcz4HJwHaE8?rs=1&pid=ImgDetMain',
                'created_at' => now(),
                'updated_at' => now(),
            ],
        ]);
    }
}
