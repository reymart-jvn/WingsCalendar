<?php

namespace Database\Seeders;

use Illuminate\Database\Console\Seeds\WithoutModelEvents;
use Illuminate\Database\Seeder;
use Illuminate\Support\Facades\DB;
class PositionSeeder extends Seeder
{
    /**
     * Run the database seeds.
     *
     * @return void
     */
    public function run()
    {
        DB::table('positions')->insert([
            [
                'name' => 'SOFTWARE ENGINEER',
                'description' => 'SOFTWARE ENGINEER',
                'status' => '1',
            ],
            [
                'name' => 'HUMAN RESOURCES ADMIN',
                'description' => 'HUMAN RESOURCES ADMIN',
                'status' => '1',
            ],
        ]);
    }
}
