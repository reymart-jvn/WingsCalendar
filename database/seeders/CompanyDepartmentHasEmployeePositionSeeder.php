<?php

namespace Database\Seeders;

use Illuminate\Database\Console\Seeds\WithoutModelEvents;
use Illuminate\Database\Seeder;
use Illuminate\Support\Facades\DB;

class CompanyDepartmentHasEmployeePositionSeeder extends Seeder
{
    /**
     * Run the database seeds.
     *
     * @return void
     */
    public function run()
    {
        DB::table('com_dep_has_emp_pos')->insert([
      
            [
                'person_has_company_department_id' => '1',
                'employee_has_position_id' => '1',
                'status' => '1',
            ],
        ]);
    }
}
