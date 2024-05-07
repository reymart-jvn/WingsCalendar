<?php

namespace Database\Seeders;

use Illuminate\Database\Console\Seeds\WithoutModelEvents;
use Illuminate\Database\Seeder;
use Illuminate\Support\Facades\DB;

class PersonSeeder extends Seeder
{
    /**
     * Run the database seeds.
     *
     * @return void
     */
    public function run()
    {
        DB::table('people')->insert([
            [
                'first_name' => 'SUPER',
                'middle_name' => 'ADMIN',
                'last_name' => 'ADMIN',
                'status' => '1',
            ],
        ]);
    }
}
