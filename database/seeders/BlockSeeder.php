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

        $bicm = DB::table('projects')->where('project_id', 'BICM')->first()->id;
        $balc = DB::table('projects')->where('project_id', 'BALC')->first()->id;
        $opv = DB::table('projects')->where('project_id', 'OPV')->first()->id;

        DB::table('blocks')->insert([
            [
                'block_id' => '130-1110',
                'name' => '1110',
                'project_id' => $bicm,
                'created_at' => now(),
                'updated_at' => now(),
            ],
            [
                'block_id' => '135-1110',
                'name' => '1110',
                'project_id' => $balc,
                'created_at' => now(),
                'updated_at' => now(),
            ],
            [
                'block_id' => '130-3510',
                'name' => '3510',
                'project_id' => $bicm,
                'created_at' => now(),
                'updated_at' => now(),
            ],
            [
                'block_id' => '130-3610',
                'name' => '3610',
                'project_id' => $bicm,
                'created_at' => now(),
                'updated_at' => now(),
            ],
            [
                'block_id' => '135-3310',
                'name' => '3310',
                'project_id' => $balc,
                'created_at' => now(),
                'updated_at' => now(),
            ],
            [
                'block_id' => '100-2210',
                'name' => '2210',
                'project_id' => $opv,
                'created_at' => now(),
                'updated_at' => now(),
            ],
            [
                'block_id' => '135-2210',
                'name' => '2210',
                'project_id' => $balc,
                'created_at' => now(),
                'updated_at' => now(),
            ],
        ]);
    }
}