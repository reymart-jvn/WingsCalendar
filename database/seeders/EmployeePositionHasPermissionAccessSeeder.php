<?php

namespace Database\Seeders;

use Illuminate\Database\Console\Seeds\WithoutModelEvents;
use Illuminate\Database\Seeder;
use Illuminate\Support\Facades\DB;

class EmployeePositionHasPermissionAccessSeeder extends Seeder
{
    /**
     * Run the database seeds.
     *
     * @return void
     */
    public function run()
    {
        DB::table('emp_pos_has_permission_accesses')->insert([
            [
                'employee_has_position_id' => '1',
                'permission_has_access_id' => '1',
                'status' => '1',
            ],
        ]);
    }
}
