<?php

namespace Database\Seeders;

use Illuminate\Database\Seeder;
use Illuminate\Support\Facades\DB;

class TargetLocationEntitySeeder extends Seeder
{
    /**
     * Run the database seeds.
     */
    public function run(): void
    {
        DB::table('target_location_table')->insert([
            'id' => 1,
            'name' => 'C. Pirotecnia, Sevilla',
            'position' => '37.370192,-5.987736',
            'radiusMeters' => 100, 
        ]);
    }
}
