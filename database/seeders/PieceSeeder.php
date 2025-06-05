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
        DB::table('pieces')->insert([
            [
                'code' => 'B01',
                'theoretical_weight' => 4.00,
                'real_weight' => null,
                'status' => 'Pendiente',
                'block_id' => '135-1110', // balc
                'registration_date' => null,
                'registered_by' => 4,
            ],
            [
                'code' => 'A02',
                'theoretical_weight' => 20.00,
                'real_weight' => null,
                'status' => 'Pendiente',
                'block_id' => '135-3310', // balc
                'registration_date' => null,
                'registered_by' => 2,
            ],
            [
                'code' => 'H12',
                'theoretical_weight' => 16.00,
                'real_weight' => null,
                'status' => 'Pendiente',
                'block_id' => '100-2210', // opv
                'registration_date' => null,
                'registered_by' => 3,
            ],
            [
                'code' => 'R23',
                'theoretical_weight' => 8.00,
                'real_weight' => null,
                'status' => 'Pendiente',
                'block_id' => '130-1110', // bicm
                'registration_date' => null,
                'registered_by' => 1,
            ],
            [
                'code' => 'J25',
                'theoretical_weight' => 11.00,
                'real_weight' => null,
                'status' => 'Pendiente',
                'block_id' => '130-1110', // bicm
                'registration_date' => null,
                'registered_by' => 5,
            ],
            [
                'code' => 'U23',
                'theoretical_weight' => 5.00,
                'real_weight' => null,
                'status' => 'Pendiente',
                'block_id' => '130-1110', // bicm
                'registration_date' => null,
                'registered_by' => 2,
            ],
            [
                'code' => 'E29',
                'theoretical_weight' => 8.00,
                'real_weight' => null,
                'status' => 'Pendiente',
                'block_id' => '130-1110', // bicm
                'registration_date' => null,
                'registered_by' => 5,
            ],
            [
                'code' => 'C11',
                'theoretical_weight' => 9.50,
                'real_weight' => null,
                'status' => 'Pendiente',
                'block_id' => '135-1110',
                'registration_date' => null,
                'registered_by' => 1,
            ],
            [
                'code' => 'D22',
                'theoretical_weight' => 13.75,
                'real_weight' => null,
                'status' => 'Pendiente',
                'block_id' => '135-3310',
                'registration_date' => null,
                'registered_by' => 3,
            ],
            [
                'code' => 'F34',
                'theoretical_weight' => 7.25,
                'real_weight' => null,
                'status' => 'Pendiente',
                'block_id' => '100-2210',
                'registration_date' => null,
                'registered_by' => 4,
            ],
            [
                'code' => 'G45',
                'theoretical_weight' => 15.00,
                'real_weight' => null,
                'status' => 'Pendiente',
                'block_id' => '130-1110',
                'registration_date' => null,
                'registered_by' => 2,
            ],
        ]);
    }
}
