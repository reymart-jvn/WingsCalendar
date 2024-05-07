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
                'access_list' => 'a:111:{i:0;s:20:"viewMainSystemHeader";i:1;s:13:"createAccount";i:2;s:13:"updateAccount";i:3;s:11:"viewAccount";i:4;s:13:"deleteAccount";i:5;s:14:"restoreAccount";i:6;s:12:"resetAccount";i:7;s:16:"createPermission";i:8;s:16:"updatePermission";i:9;s:14:"viewPermission";i:10;s:16:"deletePermission";i:11;s:17:"restorePermission";i:12;s:15:"resetPermission";i:13;s:17:"viewShuttleHeader";i:14;s:12:"createDriver";i:15;s:12:"updateDriver";i:16;s:10:"viewDriver";i:17;s:12:"deleteDriver";i:18;s:13:"restoreDriver";i:19;s:17:"createRequirement";i:20;s:17:"updateRequirement";i:21;s:15:"viewRequirement";i:22;s:17:"deleteRequirement";i:23;s:18:"restoreRequirement";i:24;s:20:"createComRequirement";i:25;s:20:"updateComRequirement";i:26;s:18:"viewComRequirement";i:27;s:20:"deleteComRequirement";i:28;s:21:"restoreComRequirement";i:29;s:17:"viewVehicleHeader";i:30;s:17:"createVehicleType";i:31;s:17:"updateVehicleType";i:32;s:15:"viewVehicleType";i:33;s:17:"deleteVehicleType";i:34;s:18:"restoreVehicleType";i:35;s:13:"createVehicle";i:36;s:13:"updateVehicle";i:37;s:11:"viewVehicle";i:38;s:13:"deleteVehicle";i:39;s:14:"restoreVehicle";i:40;s:25:"viewShuttleLocationHeader";i:41;s:9:"createMap";i:42;s:9:"updateMap";i:43;s:7:"viewMap";i:44;s:9:"deleteMap";i:45;s:10:"restoreMap";i:46;s:17:"viewCompanyHeader";i:47;s:13:"createHoliday";i:48;s:13:"updateHoliday";i:49;s:11:"viewHoliday";i:50;s:13:"deleteHoliday";i:51;s:14:"restoreHoliday";i:52;s:13:"createCompany";i:53;s:13:"updateCompany";i:54;s:11:"viewCompany";i:55;s:13:"deleteCompany";i:56;s:14:"restoreCompany";i:57;s:16:"createDepartment";i:58;s:16:"updateDepartment";i:59;s:14:"viewDepartment";i:60;s:16:"deleteDepartment";i:61;s:17:"restoreDepartment";i:62;s:14:"createPosition";i:63;s:14:"updatePosition";i:64;s:12:"viewPosition";i:65;s:14:"deletePosition";i:66;s:15:"restorePosition";i:67;s:17:"viewBookingHeader";i:68;s:17:"createBookingType";i:69;s:17:"updateBookingType";i:70;s:15:"viewBookingType";i:71;s:17:"deleteBookingType";i:72;s:18:"restoreBookingType";i:73;s:13:"createBooking";i:74;s:13:"updateBooking";i:75;s:11:"viewBooking";i:76;s:13:"deleteBooking";i:77;s:14:"restoreBooking";i:78;s:21:"createBookingApproval";i:79;s:21:"updateBookingApproval";i:80;s:19:"viewBookingApproval";i:81;s:21:"deleteBookingApproval";i:82;s:22:"restoreBookingApproval";i:83;s:14:"createTripRate";i:84;s:14:"updateTripRate";i:85;s:12:"viewTripRate";i:86;s:14:"deleteTripRate";i:87;s:15:"restoreTripRate";i:88;s:19:"viewPassengerHeader";i:89;s:15:"createPassenger";i:90;s:15:"updatePassenger";i:91;s:13:"viewPassenger";i:92;s:15:"deletePassenger";i:93;s:16:"restorePassenger";i:94;s:20:"createPassengerGroup";i:95;s:20:"updatePassengerGroup";i:96;s:18:"viewPassengerGroup";i:97;s:20:"deletePassengerGroup";i:98;s:21:"restorePassengerGroup";i:99;s:17:"viewBillingHeader";i:100;s:13:"createBilling";i:101;s:13:"updateBilling";i:102;s:11:"viewBilling";i:103;s:13:"deleteBilling";i:104;s:14:"restoreBilling";i:105;s:17:"viewReportsHeader";i:106;s:32:"createPassengersAttendanceReport";i:107;s:32:"updatePassengersAttendanceReport";i:108;s:30:"viewPassengersAttendanceReport";i:109;s:32:"deletePassengersAttendanceReport";i:110;s:33:"restorePassengersAttendanceReport";}',
                'status' => '1',
            ],
            [
                'access_code' => 'ACC000001',
                'access_list' => 'a:5:{i:0;s:20:"viewMainSystemHeader";i:1;s:17:"viewShuttleHeader";i:2;s:17:"viewVehicleHeader";i:3;s:25:"viewShuttleLocationHeader";i:4;s:17:"viewCompanyHeader";}',
                'status' => '1',
            ],
        ]);
    }
}
