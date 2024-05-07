<?php

namespace Database\Seeders;

use Illuminate\Database\Console\Seeds\WithoutModelEvents;
use Illuminate\Database\Seeder;
use Illuminate\Support\Facades\DB;

class PersonHasCompanyDepartmentSeeder extends Seeder
{
    /**
     * Run the database seeds.
     *
     * @return void
     */
    public function run()
    {
        DB::table('person_has_company_departments')->insert([
      
            [
                'person_id' => '1',
                'company_id' => '1',
                'department_id' => '1',
                'status' => '1',
            ],
        ]);
    }
}
