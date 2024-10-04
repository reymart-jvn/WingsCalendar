<?php

namespace Database\Seeders;

use Illuminate\Database\Console\Seeds\WithoutModelEvents;
use Illuminate\Database\Seeder;
use Illuminate\Support\Facades\DB;

class AccessSeeder extends Seeder
{
    /**
     * Run the database seeds.
     *
     * @return void
     */
    public function run()
    {
        DB::table('accesses')->insert([
            [
                'access_code' => 'ACC000000',
                'access_list' => 'a:52:{i:0;s:20:"viewMainSystemHeader";i:1;s:13:"viewDashboard";i:2;s:13:"createAccount";i:3;s:13:"updateAccount";i:4;s:11:"viewAccount";i:5;s:13:"deleteAccount";i:6;s:14:"restoreAccount";i:7;s:12:"resetAccount";i:8;s:16:"createPermission";i:9;s:16:"updatePermission";i:10;s:14:"viewPermission";i:11;s:16:"deletePermission";i:12;s:17:"restorePermission";i:13;s:15:"resetPermission";i:14;s:17:"viewCompanyHeader";i:15;s:13:"createCompany";i:16;s:13:"updateCompany";i:17;s:11:"viewCompany";i:18;s:13:"deleteCompany";i:19;s:14:"restoreCompany";i:20;s:16:"createDepartment";i:21;s:16:"updateDepartment";i:22;s:14:"viewDepartment";i:23;s:16:"deleteDepartment";i:24;s:17:"restoreDepartment";i:25;s:14:"createPosition";i:26;s:14:"updatePosition";i:27;s:12:"viewPosition";i:28;s:14:"deletePosition";i:29;s:15:"restorePosition";i:30;s:15:"viewEventHeader";i:31;s:11:"createEvent";i:32;s:11:"updateEvent";i:33;s:9:"viewEvent";i:34;s:11:"deleteEvent";i:35;s:12:"restoreEvent";i:36;s:23:"viewEventSettingsHeader";i:37;s:14:"createLocation";i:38;s:14:"updateLocation";i:39;s:12:"viewLocation";i:40;s:14:"deleteLocation";i:41;s:15:"restoreLocation";i:42;s:16:"createActivities";i:43;s:16:"updateActivities";i:44;s:14:"viewActivities";i:45;s:16:"deleteActivities";i:46;s:17:"restoreActivities";i:47;s:20:"createPersonInCharge";i:48;s:20:"updatePersonInCharge";i:49;s:18:"viewPersonInCharge";i:50;s:20:"deletePersonInCharge";i:51;s:21:"restorePersonInCharge";}',
                'status' => '1',
            ],
            [
                'access_code' => 'ACC000001',
                'access_list' => 'a:3:{i:0;s:13:"viewDashboard";i:1;s:15:"viewEventHeader";i:2;s:9:"viewEvent";}',
                'status' => '1',
            ],
            [
                'access_code' => 'ACC000002',
                'access_list' => 'a:1:{i:0;s:17:"viewGuestCalendar";}',
                'status' => '1',
            ],
            [
                'access_code' => 'ACC000003',
                'access_list' => 'a:34:{i:0;s:20:"viewMainSystemHeader";i:1;s:13:"viewDashboard";i:2;s:13:"createAccount";i:3;s:13:"updateAccount";i:4;s:11:"viewAccount";i:5;s:13:"deleteAccount";i:6;s:14:"restoreAccount";i:7;s:16:"createPermission";i:8;s:16:"updatePermission";i:9;s:14:"viewPermission";i:10;s:16:"deletePermission";i:11;s:17:"restorePermission";i:12;s:15:"viewEventHeader";i:13;s:11:"createEvent";i:14;s:11:"updateEvent";i:15;s:9:"viewEvent";i:16;s:11:"deleteEvent";i:17;s:12:"restoreEvent";i:18;s:23:"viewEventSettingsHeader";i:19;s:14:"createLocation";i:20;s:14:"updateLocation";i:21;s:12:"viewLocation";i:22;s:14:"deleteLocation";i:23;s:15:"restoreLocation";i:24;s:16:"createActivities";i:25;s:16:"updateActivities";i:26;s:14:"viewActivities";i:27;s:16:"deleteActivities";i:28;s:17:"restoreActivities";i:29;s:20:"createPersonInCharge";i:30;s:20:"updatePersonInCharge";i:31;s:18:"viewPersonInCharge";i:32;s:20:"deletePersonInCharge";i:33;s:21:"restorePersonInCharge";}',
                'status' => '1',
            ],
            [
                'access_code' => 'ACC000004',
                'access_list' => 'a:3:{i:0;s:13:"viewDashboard";i:1;s:15:"viewEventHeader";i:2;s:9:"viewEvent";}',
                'status' => '1',
            ],
            
        ]);
    }
}
