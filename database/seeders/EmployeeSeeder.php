<?php

namespace Database\Seeders;

use Illuminate\Database\Console\Seeds\WithoutModelEvents;
use Illuminate\Database\Seeder;
use Illuminate\Support\Facades\DB;

class EmployeeSeeder extends Seeder
{
    /**
     * Run the database seeds.
     *
     * @return void
     */
    public function run()
    {
        DB::table('employees')->insert([
      
            [
                'employee_code' => 'ADMIN0001',
                'user_id' => '1',
                'person_has_company_department_id' => '1',
                'status' => '1',
            ],
        ]);
    }
}
