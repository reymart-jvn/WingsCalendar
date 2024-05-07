<?php

namespace Database\Seeders;

use Illuminate\Database\Console\Seeds\WithoutModelEvents;
use Illuminate\Database\Seeder;
use Illuminate\Support\Facades\DB;

class DepartmentHasPositionSeeder extends Seeder
{
    /**
     * Run the database seeds.
     *
     * @return void
     */
    public function run()
    {
        DB::table('department_has_positions')->insert([
            [
                'department_id' => '1',
                'position_id' => '1',
                'status' => '1',
            ],
            [
                'department_id' => '2',
                'position_id' => '2',
                'status' => '1',
            ],
        ]);
    }
}
