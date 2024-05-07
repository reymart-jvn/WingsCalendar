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
                'department_id' => '1',
                'position_id' => '1',
                'access_id' => '2',
                'status' => '1',
            ],
        ]);
    }
}
