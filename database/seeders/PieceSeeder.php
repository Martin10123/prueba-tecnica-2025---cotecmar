<?php

namespace Database\Seeders;

use Illuminate\Database\Seeder;
use Illuminate\Support\Facades\DB;

class PieceSeeder extends Seeder
{
    /**
     * Run the database seeds.
     */
    public function run(): void
    {

        $blocks = DB::table('blocks')->pluck('id', 'block_id');

        $users = DB::table('users')->pluck('id', 'email');



        DB::table('pieces')->insert([
            [
                'code' => 'B01',
                'theoretical_weight' => 4,
                'real_weight' => 4.5,
                'status' => 'Fabricado',
                'block_id' => $blocks['135-2210'],
                'registration_date' => '2020-09-11 00:00:00',
                'registered_by' => $users['Gabriel@gmail.com'],
                'created_at' => now(),
                'updated_at' => now(),
            ],
            [
                'code' => 'A02',
                'theoretical_weight' => 20,
                'real_weight' => null,
                'status' => 'Pendiente',
                'block_id' => $blocks['135-3310'],
                'registration_date' => $users[''],
                'registered_by' => null,
                'created_at' => now(),
                'updated_at' => now(),
            ],
            [
                'code' => 'H12',
                'theoretical_weight' => 16,
                'real_weight' => 16.6,
                'status' => 'Fabricado',
                'block_id' => $blocks['100-2210'],
                'registration_date' => '2020-09-11 00:00:00',
                'registered_by' => $users['Sergio@gmail.com'],
                'created_at' => now(),
                'updated_at' => now(),
            ],
            [
                'code' => 'R23',
                'theoretical_weight' => 8,
                'real_weight' => null,
                'status' => 'Pendiente',
                'block_id' => $blocks['130-1110'],
                'registration_date' => $users[''],
                'registered_by' => null,
                'created_at' => now(),
                'updated_at' => now(),
            ],
            [
                'code' => 'J25',
                'theoretical_weight' => 11,
                'real_weight' => null,
                'status' => 'Pendiente',
                'block_id' => $blocks['130-1110'],
                'registration_date' => $users[''],
                'registered_by' => null,
                'created_at' => now(),
                'updated_at' => now(),
            ],
            [
                'code' => 'U23',
                'theoretical_weight' => 5,
                'real_weight' => 4,
                'status' => 'Fabricado',
                'block_id' => $blocks['130-1110'],
                'registration_date' => '2020-09-11 00:00:00',
                'registered_by' => $users['Sergio@gmail.com'],
                'created_at' => now(),
                'updated_at' => now(),
            ],
            [
                'code' => 'E29',
                'theoretical_weight' => 8,
                'real_weight' => 7.2,
                'status' => 'Fabricado',
                'block_id' => $blocks['130-1110'],
                'registration_date' => '2020-09-11 00:00:00',
                'registered_by' => $users['Luis@gmail.com'],
                'created_at' => now(),
                'updated_at' => now(),
            ],
            [
                'code' => 'E21',
                'theoretical_weight' => 18,
                'real_weight' => null,
                'status' => 'Pendiente',
                'block_id' => $blocks['130-3510'],
                'registration_date' => $users[''],
                'registered_by' => null,
                'created_at' => now(),
                'updated_at' => now(),
            ],
        ]);
    }
}
