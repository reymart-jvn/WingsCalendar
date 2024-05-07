<?php

namespace Database\Seeders;

use Illuminate\Database\Console\Seeds\WithoutModelEvents;
use Illuminate\Database\Seeder;
use Illuminate\Support\Facades\DB;

class CompanyHasPersonInchargeSeeder extends Seeder
{
    /**
     * Run the database seeds.
     *
     * @return void
     */
    public function run()
    {
        DB::table('company_has_person_incharges')->insert([
            [
                'company_id' => '1',
                'employee_no' => '12345',
                'first_name' => '-',
                'middle_name' => '-',
                'last_name' => '-',
                'contact_number' => '-',
                'home_address' => '-',
                'email' => '-',
                'status' => '1',
            ],
        ]);
    }
}
