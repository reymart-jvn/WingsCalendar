<?php

namespace Database\Seeders;

use Illuminate\Database\Console\Seeds\WithoutModelEvents;
use Illuminate\Database\Seeder;
use Illuminate\Support\Facades\DB;

class CompanyHasDepartmentSeeder extends Seeder
{
    /**
     * Run the database seeds.
     *
     * @return void
     */
    public function run()
    {
        DB::table('company_has_departments')->insert([
            [
                'company_id' => '1',
                'department_id' => '1',
                'status' => '1',
            ],
            [
                'company_id' => '1',
                'department_id' => '2',
                'status' => '1',
            ],
        ]);
    }
}
