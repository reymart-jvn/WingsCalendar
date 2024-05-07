<?php

namespace Database\Seeders;

use Illuminate\Database\Console\Seeds\WithoutModelEvents;
use Illuminate\Database\Seeder;
use Illuminate\Support\Facades\DB;

class VehicleHasDriverSeeder extends Seeder
{
    /**
     * Run the database seeds.
     *
     * @return void
     */
    public function run()
    {
        DB::table('vehicle_has_drivers')->insert([
            [
                'vehicle_id' => '1',
                'driver_id' => '1',
                'status' => '1',
            ],
        ]);
    }
}
