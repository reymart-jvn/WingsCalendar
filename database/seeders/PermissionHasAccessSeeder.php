<?php

namespace Database\Seeders;

use Illuminate\Database\Console\Seeds\WithoutModelEvents;
use Illuminate\Database\Seeder;
use Illuminate\Support\Facades\DB;

class PermissionHasAccessSeeder extends Seeder
{
    /**
     * Run the database seeds.
     *
     * @return void
     */
    public function run()
    {
        DB::table('permission_has_accesses')->insert([
            [
                'permission_id' => '1',
                'company_id' => '1',
                'department_id' => '1',
                'position_id' => '1',
                'access_id' => '1',
                'status' => '1',
            ],
            [
                'permission_id' => '2',
                'company_id' => '1',
                'department_id' => '2',
                'position_id' => '2',
                'access_id' => '2',
                'status' => '1',
            ],
            [
                'permission_id' => '3',
                'company_id' => '1',
                'department_id' => '3',
                'position_id' => '3',
                'access_id' => '3',
                'status' => '1',
            ],
            [
                'permission_id' => '4',
                'company_id' => '1',
                'department_id' => '3',
                'position_id' => '3',
                'access_id' => '4',
                'status' => '1',
            ],
            [
                'permission_id' => '5',
                'company_id' => '1',
                'department_id' => '3',
                'position_id' => '3',
                'access_id' => '5',
                'status' => '1',
            ],
        ]);
    }
}
