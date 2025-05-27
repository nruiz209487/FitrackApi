<?php

namespace Database\Seeders;

use Illuminate\Database\Seeder;
use Illuminate\Support\Facades\DB;
use App\Models\User;

class NoteEntitySeeder extends Seeder
{
    public function run(): void
    {
        DB::table('note_table')->insert([
            [
                'header' => 'Recordatorio de piernas',
                'text' => 'No olvidar estirar antes de entrenar piernas.',
                'timestamp' => now()->toDateString(),
                'user_id' => User::first()->id,
            ],
            [
                'header' => 'Revisión médica',
                'text' => 'Cita médica el viernes a las 10am.',
                'timestamp' => now()->toDateString(),
                'user_id' => User::first()->id,
            ],
        ]);
    }
}
