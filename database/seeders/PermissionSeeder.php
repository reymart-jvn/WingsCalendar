<?php

namespace Database\Seeders;

use Illuminate\Database\Console\Seeds\WithoutModelEvents;
use Illuminate\Database\Seeder;
use Illuminate\Support\Facades\DB;

class PermissionSeeder extends Seeder
{
    /**
     * Run the database seeds.
     *
     * @return void
     */
    public function run()
    {
        DB::table('permissions')->insert([
            [
                'permission_code' => 'JPADPERMISSION0001',
                'permission_description' => 'JPAD_SUPER_ADMIN',
                'status' => '1',
            ],
            [
                'permission_code' => 'JPADPERMISSION0002',
                'permission_description' => 'JPAD_USER',
                'status' => '1',
            ],
            [
                'permission_code' => 'JPADPERMISSION0003',
                'permission_description' => 'EVENT_STAFF',
                'status' => '1',
            ],
            [
                'permission_code' => 'JPADPERMISSION0004',
                'permission_description' => 'EVENT_SUPER_ADMIN',
                'status' => '1',
            ],
            [
                'permission_code' => 'JPADPERMISSION0004',
                'permission_description' => 'EVENT_ADMIN',
                'status' => '1',
            ],
        ]);
    }
}
