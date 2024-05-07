<?php

namespace Database\Seeders;

// use Illuminate\Database\Console\Seeds\WithoutModelEvents;

use App\Models\ComplianceRequirements;
use App\Models\ComplianceRequirementsSummary;
use App\Models\EmployeeHasPosition;
use Illuminate\Database\Seeder;

class DatabaseSeeder extends Seeder
{
    /**
     * Seed the application's database.
     *
     * @return void
     */
    public function run()
    {
        // \App\Models\User::factory(10)->create();

        // \App\Models\User::factory()->create([
        //     'name' => 'Test User',
        //     'email' => 'test@example.com',
        // ]);
       
        $this->call(DepartmentSeeder::class);
        $this->call(CompanyProfileSeeder::class);
        $this->call(CompanyHasDepartmentSeeder::class);
        $this->call(CompanyHasPersonInchargeSeeder::class);
        $this->call(PositionSeeder::class);
        $this->call(DepartmentHasPositionSeeder::class);
        $this->call(PermissionSeeder::class);
        $this->call(AccessSeeder::class);
        $this->call(PermissionHasAccessSeeder::class);
        $this->call(PersonSeeder::class);
        $this->call(PersonHasCompanyDepartmentSeeder::class);
        $this->call(UserSeeder::class);
        $this->call(EmployeeSeeder::class);
        $this->call(EmployeeHasPositionSeeder::class);
        $this->call(CompanyDepartmentHasEmployeePositionSeeder::class);
        $this->call(EmployeePositionHasPermissionAccessSeeder::class);
    }
}
