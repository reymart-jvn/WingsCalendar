<?php

namespace Database\Seeders;

use Illuminate\Database\Console\Seeds\WithoutModelEvents;
use Illuminate\Database\Seeder;
use Illuminate\Support\Facades\DB;

class EmployeeHasPositionSeeder extends Seeder
{
    /**
     * Run the database seeds.
     *
     * @return void
     */
    public function run()
    {
        DB::table('employee_has_positions')->insert([
      
            [
                'employee_id' => '1',
                'position_id' => '1',
                'status' => '1',
            ],
        ]);
    }
}
