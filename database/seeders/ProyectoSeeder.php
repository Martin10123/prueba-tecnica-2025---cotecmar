<?php

namespace Database\Seeders;

use Illuminate\Database\Console\Seeds\WithoutModelEvents;
use Illuminate\Database\Seeder;
use Illuminate\Support\Facades\DB;

class ProyectoSeeder extends Seeder
{
    /**
     * Run the database seeds.
     */
    public function run(): void
    {
        DB::table('projects')->insert([
            ['id' => 'bicm', 'name' => 'Oceanografico'],
            ['id' => 'balc', 'name' => 'Buque DA'],
            ['id' => 'opv',  'name' => 'Offshore'],
            ['id' => 'brf',  'name' => 'Recfluvial'],
        ]);
    }
}
