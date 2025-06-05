<?php

namespace Database\Seeders;

use Illuminate\Database\Console\Seeds\WithoutModelEvents;
use Illuminate\Database\Seeder;
use Illuminate\Support\Facades\DB;

class BlockSeeder extends Seeder
{
    /**
     * Run the database seeds.
     */
    public function run(): void
    {
        DB::table('blocks')->insert([
            ['id' => '130-1110', 'name' => '1110', 'project_id' => 'bicm'],
            ['id' => '135-1110', 'name' => '2210', 'project_id' => 'balc'],
            ['id' => '130-3510', 'name' => '3510', 'project_id' => 'bicm'],
            ['id' => '130-3610', 'name' => '3610', 'project_id' => 'bicm'],
            ['id' => '135-3310', 'name' => '3310', 'project_id' => 'balc'],
            ['id' => '100-2210', 'name' => '2210', 'project_id' => 'opv'],
        ]);
    }
}
