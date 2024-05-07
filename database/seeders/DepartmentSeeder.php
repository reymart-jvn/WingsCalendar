<?php

namespace Database\Seeders;

use Illuminate\Database\Console\Seeds\WithoutModelEvents;
use Illuminate\Database\Seeder;
use Illuminate\Support\Facades\DB;

class DepartmentSeeder extends Seeder
{
    /**
     * Run the database seeds.
     *
     * @return void
     */
    public function run()
    {
        DB::table('departments')->insert([
            [
                'name' => 'INFORMATION TECHNOLOGY',
                'acronym' => 'IT',
                'description' => 'INFORMATION TECHNOLOGY',
                'status' => '1',
            ],
            [
                'name' => 'HUMAN RESOURCES',
                'acronym' => 'HR',
                'description' => 'HUMAN RESOURCES',
                'status' => '1',
            ],
        ]);
    }
}
