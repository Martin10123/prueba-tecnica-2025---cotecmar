<?php

namespace Database\Seeders;

use Illuminate\Database\Console\Seeds\WithoutModelEvents;
use Illuminate\Database\Seeder;
use Illuminate\Support\Facades\DB;

class ProjectSeeder extends Seeder
{
    /**
     * Run the database seeds.
     */
    public function run(): void
    {
        DB::table('projects')->insert([
            [
                'project_id' => 'BICM',
                'name' => 'Oceanográfico',
                'created_at' => now(),
                'updated_at' => now(),
            ],
            [
                'project_id' => 'BALC',
                'name' => 'Bloque DA',
                'created_at' => now(),
                'updated_at' => now(),
            ],
            [
                'project_id' => 'OPV',
                'name' => 'Offshore',
                'created_at' => now(),
                'updated_at' => now(),
            ],
            [
                'project_id' => 'BRF',
                'name' => 'Recifluvial',
                'created_at' => now(),
                'updated_at' => now(),
            ],
        ]);
    }
}