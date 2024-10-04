<?php

namespace Database\Seeders;

use Illuminate\Database\Console\Seeds\WithoutModelEvents;
use Illuminate\Database\Seeder;
use Illuminate\Support\Facades\DB;
use Illuminate\Support\Facades\Hash;

class UserSeeder extends Seeder
{
    /**
     * Run the database seeds.
     *
     * @return void
     */
    public function run()
    {
        // DB::table('users')->insert([
        //     [
        //         'name' => 'SUPER ADMIN',
        //         'person_id' => '1',
        //         'email' => 'admin@admin.com',
        //         'password' => Hash::make('admin123'),
        //         'status' => '1',
        //     ],
          
        // ]);
        DB::table('users')->insert([
            [
                'name' => 'SUPER ADMIN',
                'person_id' => '1',
                'user_code' => 'FV694CBf',
                'email' => 'admin@admin.com',
                'password' => Hash::make('admin123'),
                'is_admin' => '1',
                'status' => '1',
                'is_admin' => 1,
            ],

        ]);
    }
}
