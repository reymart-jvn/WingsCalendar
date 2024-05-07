<?php

namespace Database\Seeders;

use Illuminate\Database\Console\Seeds\WithoutModelEvents;
use Illuminate\Database\Seeder;
use Illuminate\Support\Facades\DB;

class CompanyProfileSeeder extends Seeder
{
    /**
     * Run the database seeds.
     *
     * @return void
     */
    public function run()
    {
        DB::table('company_profiles')->insert([
            [
                'company_code' => 'JPAD0001',
                'company_name' => 'JAPAN PHILIPPINES APPLICATION DEVELOPERS',
                'acronym' => 'JPAD',
                'vat_no' => '12121212',
                'email' => 'jpad@gmail.com',
                'address' => 'Bay, Laguna',
                'contact_number' => '09000000000',
                'tel_number' => '010101',
                'description' => '',
                'status' => '1',
            ],
        ]);
    }
}
