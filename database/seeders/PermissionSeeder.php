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
                'permission_description' => 'JPAD SUPER ADMIN',
                'status' => '1',
            ],
            [
                'permission_code' => 'JPADPERMISSION0002',
                'permission_description' => 'JPAD USER',
                'status' => '1',
            ],
        ]);
    }
}
