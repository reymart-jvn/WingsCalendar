<?php

namespace App\Http\Controllers\API;

use App\Http\Controllers\Controller;
use App\Models\BookingHasVehicleDriver;
use Illuminate\Http\Request;
use App\Models\BookingInformation;
use Illuminate\Support\Facades\DB;
use App\Models\BookingTransaction;
use App\Models\BookingTransactionHistory;
use App\Models\ChangeServiceUnit;
use App\Models\Driver;
use App\Models\TravelHistory;
use App\Models\VehicleHasDevice;
use Illuminate\Support\Facades\Hash;
use Carbon\Carbon;

class DriverController extends Controller
{
    public function getDriverScheduleList($id)
    {
        // $get_schedule = BookingHasVehicleDriver::with(
        //     'appBookingInfo.bookingTransaction.passengerInformation',
        //     'vehicle.vehicleHasDevice',
        //     'appBookingInfo.bookingGroup',
        //     'appBookingInfo'
        // )->whereHas('appBookingInfo.bookingGroup', function ($get_schedule) use ($id) {
        //     $get_schedule->where('status', '1');
        //     // $query->whereRaw("firstname", 'LIKE', "%{$search}%");
        // })->whereHas('appBookingInfo', function ($get_schedule) use ($id) {
        //     $get_schedule->where('status', '1');
        //     // $query->whereRaw("firstname", 'LIKE', "%{$search}%");
        // })->where('driver_id', $id)->where('status', '1')
        //     ->where('travel_status', '!=', 'DONE')
        //     ->where('travel_status', '!=', 'FOR APPROVAL')
        //     ->where('travel_status', '!=', 'DECLINED')
        //     ->get();

        // $check_transfered_book = ChangeServiceUnit::where('previous_driver_id',$id)->where('status','1')->get();

        $check_transfered_book = BookingInformation::with('bookingGroup', 'changeUnit')
            ->whereHas('changeUnit', function ($get_schedule_transfer) use ($id) {
                $get_schedule_transfer->where(DB::raw("previous_driver_id"), $id)->where('status', '1');
            })->whereHas('bookingGroup', function ($get_schedule_transfer) use ($id) {
                $get_schedule_transfer->where('status', '1');
            })->where('travel_status', '!=', 'DONE')
            ->where('travel_status', '!=', 'FOR APPROVAL')
            ->where('travel_status', '!=', 'DECLINED')
            ->whereDate('departure_date', '>=', Carbon::now()->format('Y-m-d'))->get();

        if (count($check_transfered_book) != 0) {
            $transferedListToRemove = array();
            foreach ($check_transfered_book as $transferedList) {
                $transferedListToRemove[] =  $transferedList->booking_code;
            }

            $get_schedule_today = BookingInformation::with('bookingHasVehicleDriver', 'company', 'bookingTransaction', 'bookingGroup')
                ->whereHas('bookingHasVehicleDriver', function ($get_schedule_today) use ($id) {
                    $get_schedule_today->where(DB::raw("driver_id"), $id)->where('status', '1');
                })->whereHas('bookingGroup', function ($get_schedule_today) use ($id) {
                    $get_schedule_today->where('status', '1');
                })->where('travel_status', '!=', 'DONE')
                ->where('travel_status', '!=', 'FOR APPROVAL')
                ->where('travel_status', '!=', 'DECLINED')
                ->whereNotIn('booking_code', $transferedListToRemove)
                ->whereDate('departure_date', '>=', Carbon::now()->format('Y-m-d'))
                ->orderBy('departure_date', 'asc')
                ->orderBy('departure_time', 'asc')->get();
        } else {
            $get_schedule_today = BookingInformation::with('bookingHasVehicleDriver', 'company', 'bookingTransaction', 'bookingGroup')
                ->whereHas('bookingHasVehicleDriver', function ($get_schedule_today) use ($id) {
                    $get_schedule_today->where(DB::raw("driver_id"), $id)->where('status', '1');
                })->whereHas('bookingGroup', function ($get_schedule_today) use ($id) {
                    $get_schedule_today->where('status', '1');
                })->where('travel_status', '!=', 'DONE')
                ->where('travel_status', '!=', 'FOR APPROVAL')
                ->where('travel_status', '!=', 'DECLINED')
                ->whereDate('departure_date', '>=', Carbon::now()->format('Y-m-d'))
                ->orderBy('departure_date', 'asc')
                ->orderBy('departure_time', 'asc')->get();
        }


        $get_schedule_transfer = BookingInformation::with('bookingHasVehicleDriver', 'company', 'bookingTransaction', 'bookingGroup', 'changeUnit')
            ->whereHas('changeUnit', function ($get_schedule_transfer) use ($id) {
                $get_schedule_transfer->where(DB::raw("backup_driver_id"), $id)->where('status', '1');
            })->whereHas('bookingGroup', function ($get_schedule_transfer) use ($id) {
                $get_schedule_transfer->where('status', '1');
            })->where('travel_status', '!=', 'DONE')
            ->where('travel_status', '!=', 'FOR APPROVAL')
            ->where('travel_status', '!=', 'DECLINED')
            ->whereDate('departure_date', '>=', Carbon::now()->format('Y-m-d'))
            ->orderBy('departure_date', 'asc')
            ->orderBy('departure_time', 'asc')->get();

        if (count($get_schedule_transfer) != 0) {
            $get_schedule_today = $get_schedule_today->concat($get_schedule_transfer);

            $now = Carbon::now()->format('Y-m-d');
            $get_schedule_today = $get_schedule_today
                ->filter(function ($result) use ($now) {
                    return $result->departure_date >= $now;
                })
                ->sortBy(function ($result) {
                    return $result->departure_date . $result->departure_time;
                })->values();
        }




        $additionalData = [
            'datenow' => Carbon::now()->format('Y-m-d')
        ];

        // Loop through each BookingInformation instance
        $get_schedule_today->transform(function ($item) use ($additionalData) {
            // Convert the instance to an array
            $itemArray = $item->toArray();

            // Merge the additional data
            return array_merge($itemArray, $additionalData);
        });

        return response()->json([
            'success'   => true,
            'data'      =>  $get_schedule_today,
            'message'   => 'Retrieved successfully'
        ], 200);
    }

    public function getDriverScheduleListDone($id)
    {
        // $get_schedule = BookingHasVehicleDriver::with(
        //     'appBookingInfo',
        // )->where('driver_id', $id)->where('status', '1')->where('travel_status', 'DONE')->get();

        // return response()->json([
        //     'success'   => true,
        //     'data'      => $get_schedule,
        //     'message'   => 'Retrieved successfully'
        // ], 200);
        $currentMonth = Carbon::now()->month;
        $check_transfered_book = BookingInformation::with('bookingGroup', 'changeUnit')
            ->whereHas('changeUnit', function ($get_schedule_transfer) use ($id) {
                $get_schedule_transfer->where(DB::raw("previous_driver_id"), $id)->where('status', '1');
            })->whereHas('bookingGroup', function ($get_schedule_transfer) use ($id) {
                $get_schedule_transfer->where('status', '1');
            })->where('travel_status', 'DONE')
            ->whereMonth('departure_date', $currentMonth)->whereYear('departure_date', '=', date('Y'))->get();

        if (count($check_transfered_book) != 0) {
            $transferedListToRemove = array();
            foreach ($check_transfered_book as $transferedList) {
                $transferedListToRemove[] =  $transferedList->booking_code;
            }

            $get_schedule_today = BookingInformation::with('bookingHasVehicleDriver', 'company', 'bookingTransaction', 'bookingGroup')
                ->whereHas('bookingHasVehicleDriver', function ($get_schedule_today) use ($id) {
                    $get_schedule_today->where(DB::raw("driver_id"), $id)->where('status', '1');
                })->whereHas('bookingGroup', function ($get_schedule_today) use ($id) {
                    $get_schedule_today->where('status', '1');
                })->where('travel_status', 'DONE')
                ->whereNotIn('booking_code', $transferedListToRemove)
                ->whereMonth('departure_date', $currentMonth)->whereYear('departure_date', '=', date('Y'))
                ->orderBy('departure_date', 'desc')
                ->orderBy('departure_time', 'desc')->get();
        } else {
            $get_schedule_today = BookingInformation::with('bookingHasVehicleDriver', 'company', 'bookingTransaction', 'bookingGroup')
                ->whereHas('bookingHasVehicleDriver', function ($get_schedule_today) use ($id) {
                    $get_schedule_today->where(DB::raw("driver_id"), $id)->where('status', '1');
                })->whereHas('bookingGroup', function ($get_schedule_today) use ($id) {
                    $get_schedule_today->where('status', '1');
                })->where('travel_status', 'DONE')
                ->whereMonth('departure_date', $currentMonth)->whereYear('departure_date', '=', date('Y'))
                ->orderBy('departure_date', 'desc')
                ->orderBy('departure_time', 'desc')->get();
        }


        $get_schedule_transfer = BookingInformation::with('bookingHasVehicleDriver', 'company', 'bookingTransaction', 'bookingGroup', 'changeUnit')
            ->whereHas('changeUnit', function ($get_schedule_transfer) use ($id) {
                $get_schedule_transfer->where(DB::raw("backup_driver_id"), $id)->where('status', '1');
            })->whereHas('bookingGroup', function ($get_schedule_transfer) use ($id) {
                $get_schedule_transfer->where('status', '1');
            })->where('travel_status', 'DONE')
            ->whereMonth('departure_date', $currentMonth)->whereYear('departure_date', '=', date('Y'))
            ->orderBy('departure_date', 'desc')
            ->orderBy('departure_time', 'desc')->get();

        if (count($get_schedule_transfer) != 0) {
            $get_schedule_today = $get_schedule_today->concat($get_schedule_transfer);

            $now = Carbon::now()->month;
            $get_schedule_today = $get_schedule_today
                ->filter(function ($result) use ($now) {
                    return $result->departure_date >= $now;
                })
                ->sortBy(function ($result) {
                    return $result->departure_date . $result->departure_time;
                })->values();
        }




        $additionalData = [
            'datenow' => Carbon::now()->format('Y-m-d')
        ];

        // Loop through each BookingInformation instance
        $get_schedule_today->transform(function ($item) use ($additionalData) {
            // Convert the instance to an array
            $itemArray = $item->toArray();

            // Merge the additional data
            return array_merge($itemArray, $additionalData);
        });

        return response()->json([
            'success'   => true,
            'data'      =>  $get_schedule_today,
            'message'   => 'Retrieved successfully'
        ], 200);
    }

    public function getDriverScheduleListToday($id)
    {
        $dateNow = Carbon::now()->format('Y-m-d');
        $get_schedule_today = BookingInformation::with('bookingHasVehicleDriver', 'company', 'bookingTransaction', 'bookingGroup')->where('departure_date', $dateNow)->where('status', '1')->where('travel_status', '!=', 'DONE')->where('travel_status', '!=', 'FOR APPROVAL')
            ->whereHas('bookingHasVehicleDriver', function ($get_schedule_today) use ($id) {
                $get_schedule_today->where(DB::raw("driver_id"), $id)->where('status', '1');
                // $query->whereRaw("firstname", 'LIKE', "%{$search}%");
            })->whereHas('bookingGroup', function ($get_schedule_today) use ($id) {
                $get_schedule_today->where('status', '1');
                // $query->whereRaw("firstname", 'LIKE', "%{$search}%");
            })->get();

        return response()->json([
            'success'   => true,
            'data'      => $get_schedule_today,
            'message'   => 'Retrieved successfully'
        ], 200);
    }

    public function getDriverScheduleListMonth($id)
    {

        $departureMonth = Carbon::now()->month;

        $get_schedule_today = BookingInformation::with('bookingHasVehicleDriver', 'company', 'bookingGroup')->whereMonth('departure_date', $departureMonth)->where('travel_status', "!=", "DONE")->where('status', '1')
            ->whereHas('bookingHasVehicleDriver', function ($get_schedule_today) use ($id) {
                $get_schedule_today->where(DB::raw("driver_id"), $id)->where('status', '1');
                // $query->whereRaw("firstname", 'LIKE', "%{$search}%");
            })->whereHas('bookingGroup', function ($get_schedule_today) use ($id) {
                $get_schedule_today->where('status', '1');
                // $query->whereRaw("firstname", 'LIKE', "%{$search}%");
            })->get();

        return response()->json([
            'success'   => true,
            'data'      => $get_schedule_today,
            'message'   => 'Retrieved successfully'
        ], 200);
    }

    public function getDriverFailedTrip($id)
    {
        $get_schedule_today = BookingInformation::with('bookingHasVehicleDriver', 'company', 'bookingGroup')
            ->where('travel_status', '==', 'ONGOING')
            ->orWhere('travel_status', '==', 'WAITING')
            ->where('status', '1')
            ->whereDate('departure_date', '<=', Carbon::now()->format('Y-m-d')) // Compare departure date with current date
            ->whereHas('bookingHasVehicleDriver', function ($query) use ($id) {
                $query->where('driver_id', $id)->where('status', '1');
            })
            ->whereHas('bookingGroup', function ($query) {
                $query->where('status', '1');
            })
            ->get();

        return response()->json([
            'success'   => true,
            'data'      => $get_schedule_today,
            'message'   => 'Retrieved successfully'
        ], 200);
    }

    public function getDriverScheduleListWithoutForApproval($id)
    {
        $get_schedule = BookingHasVehicleDriver::with(
            'appBookingInfo.bookingTransaction.passengerInformation',
            'vehicle.vehicleHasDevice',
        )->where('driver_id', $id)->where('status', '1')->where('travel_status', '!=', 'DONE')->where('travel_status', '!=', 'FOR APPROVAL')->get();

        return response()->json([
            'success'   => true,
            'data'      => $get_schedule,
            'message'   => 'Retrieved successfully'
        ], 200);
    }

    public function startTravel($id, $dateTime,$device_code)
    {
        // $booking_transaction = BookingTransaction::where('booking_info_id', $id)->where('status', '1')->get();

        try {
            DB::beginTransaction();

            $booking = BookingInformation::with('bookingHasVehicleDriver.vehicle.vehicleHasDevice')->findOrFail($id);
            $booking->travel_status = "ONGOING";
            $booking->save();

            // foreach( $booking_transaction as  $booking_transaction)
            // {
            //     // $booking_transaction->travel_status = "ONGOING";
            //     // $booking_transaction->save();
            //     $booking_history = BookingTransactionHistory::where('booking_transaction_id',$booking_transaction->id)->where('status','1')->first();
            //     $booking_history->status = "0";
            //     $booking_history->save();
            //     $booking_history_add = new BookingTransactionHistory();
            //     $booking_history_add->booking_transaction_id = $booking_transaction->id;
            //     $booking_history_add->travel_status = "ONGOING";
            //     $booking_history_add->status = "1";
            //     $booking_history_add->save();
            // }

            $vehicle_device = VehicleHasDevice::where('firebase_key',$device_code)->where('status','1')->first();

            $travel_history = new TravelHistory();
            $travel_history->booking_id = $booking->id;
            $travel_history->vehicle_device_id = $vehicle_device->id;
            // $travel_history->start_at = Carbon::now()->format('Y-m-d H:i:s');
            $travel_history->start_at = $dateTime;
            $travel_history->status = "1";
            $travel_history->save();

            $vehicle_driver =  BookingHasVehicleDriver::where('booking_id', $id)->where('status', '1')->first();
            $vehicle_driver->travel_status = "ONGOING";
            $vehicle_driver->save();

            $message = 'Record successfully Added!';
            DB::commit();

            return response()->json(array('success' => true, 'messages' => $message));
        } catch (\PDOException $e) {
            DB::rollBack();
            return response()->json(array('success' => false, 'error' => 'SQL error!', 'messages' => 'Transaction failed!'));
        }
    }

    public function endTravel($id, $dateTime)
    {

        try {
            DB::beginTransaction();

            $booking = BookingInformation::with('bookingHasVehicleDriver.vehicle.vehicleHasDevice')->findOrFail($id);
            $booking->travel_status = "DONE";
            $booking->save();

            $booking_transaction = BookingTransaction::where('booking_info_id', $id)->where('travel_status', 'ONGOING')->where('status', '1')->get();


            foreach ($booking_transaction as  $booking_transaction) {

                $booking_transaction->travel_status = "DONE";
                $booking_transaction->save();

                // $booking_history = BookingTransactionHistory::where('booking_transaction_id', $booking_transaction->id)->where('status', '1')->first();
                // $booking_history->status = "0";
                // $booking_history->save();

                // $booking_history_add = new BookingTransactionHistory();
                // $booking_history_add->booking_transaction_id = $booking_transaction->id;
                // $booking_history_add->travel_status = "DONE";
                // $booking_history_add->status = "1";
                // $booking_history_add->save();
            }

            $vehicle_driver =  BookingHasVehicleDriver::where('booking_id', $id)->where('status', '1')->first();
            $vehicle_driver->travel_status = "DONE";
            $vehicle_driver->status = "1";
            $vehicle_driver->save();

            $travel_history = TravelHistory::where('booking_id', $booking->id)->where('status','1')->where('ends_at',null)->first();
            $travel_history->ends_at = $dateTime;
            $travel_history->status = "0";
            $travel_history->save();

            $message = 'Record successfully Added!';
            DB::commit();

            return response()->json(array('success' => true, 'messages' => $message));
        } catch (\PDOException $e) {
            DB::rollBack();
            return response()->json(array('success' => false, 'error' => 'SQL error!', 'messages' => 'Transaction failed!'));
        }
    }

    public function cancelTravel($id, $dateTime)
    {

        try {
            DB::beginTransaction();

            $booking = BookingInformation::with('bookingHasVehicleDriver.vehicle.vehicleHasDevice')->findOrFail($id);
            $booking->travel_status = "WAITING";
            $booking->save();

            $booking_transaction = BookingTransaction::where('booking_info_id', $id)->where('travel_status', 'ONGOING')->where('status', '1')->get();

            foreach ($booking_transaction as  $booking_transaction) {

                if ($booking_transaction->transferee == null || $booking_transaction->transferee == "0") {
                    $booking_transaction->travel_status = "WAITING";
                    $booking_transaction->transferee = null;
                    $booking_transaction->logs = null;
                    $booking_transaction->save();
                } else {
                    $booking_transaction->travel_status = "WAITING";
                    $booking_transaction->logs = null;
                    $booking_transaction->status = "0";
                    $booking_transaction->save();
                }


                // $booking_history = BookingTransactionHistory::where('booking_transaction_id', $booking_transaction->id)->where('status', '1')->first();
                // $booking_history->status = "0";
                // $booking_history->save();

                // $booking_history_add = new BookingTransactionHistory();
                // $booking_history_add->booking_transaction_id = $booking_transaction->id;
                // $booking_history_add->travel_status = "WAITING";
                // $booking_history_add->status = "1";
                // $booking_history_add->save();
            }

            $vehicle_driver =  BookingHasVehicleDriver::where('booking_id', $id)->where('status', '1')->first();
            $vehicle_driver->travel_status = "WAITING";
            $vehicle_driver->status = "1";
            $vehicle_driver->save();

            $travel_history = TravelHistory::where('booking_id', $booking->id)->where('status','1')->where('ends_at',null)->first();
            $travel_history->ends_at = $dateTime;
            $travel_history->status = "CANCELED";
            $travel_history->save();

            $message = 'Record successfully Cancel!';
            DB::commit();

            return response()->json(array('success' => true, 'messages' => $message));
        } catch (\PDOException $e) {
            DB::rollBack();
            return response()->json(array('success' => false, 'error' => 'SQL error!', 'messages' => 'Transaction failed!'));
        }
    }


    public function startTravelByCode($code)
    {


        try {
            DB::beginTransaction();

            $booking = BookingInformation::with('bookingHasVehicleDriver.vehicle.vehicleHasDevice')->where('booking_code', $code)->where('status', '1')->first();
            $booking->travel_status = "ONGOING";
            $booking->save();

            // $booking_transaction = BookingTransaction::where('booking_info_id',$booking->id)->where('status', '1')->get();

            // foreach( $booking_transaction as  $booking_transaction)
            // {
            //     // $booking_transaction->travel_status = "ONGOING";
            //     // $booking_transaction->save();

            //     $booking_history = BookingTransactionHistory::where('booking_transaction_id',$booking_transaction->id)->where('status','1')->first();
            //     $booking_history->status = "0";
            //     $booking_history->save();

            //     $booking_history_add = new BookingTransactionHistory();
            //     $booking_history_add->booking_transaction_id = $booking_transaction->id;
            //     $booking_history_add->travel_status = "ONGOING";
            //     $booking_history_add->status = "1";
            //     $booking_history_add->save();

            // }

            $vehicle_driver =  BookingHasVehicleDriver::where('booking_id', $booking->id)->where('status', '1')->first();
            $vehicle_driver->travel_status = "ONGOING";
            $vehicle_driver->save();

            $travel_history = new TravelHistory();
            $travel_history->booking_id = $booking->id;
            $travel_history->vehicle_device_id = $booking->bookingHasVehicleDriver->vehicle->vehicleHasDevice->id;
            $travel_history->start_at = Carbon::now()->format('Y-m-d H:i:s');
            $travel_history->status = "1";
            $travel_history->save();

            $message = 'Record successfully Added!';
            DB::commit();

            return response()->json(array('success' => true, 'messages' => $message));
        } catch (\PDOException $e) {
            DB::rollBack();
            return response()->json(array('success' => false, 'error' => 'SQL error!', 'messages' => 'Transaction failed!'));
        }
    }

    public function endTravelByCode($code)
    {


        try {
            DB::beginTransaction();

            $booking = BookingInformation::with('bookingHasVehicleDriver.vehicle.vehicleHasDevice')->where('booking_code', $code)->where('status', '1')->first();
            $booking->travel_status = "DONE";
            $booking->save();

            $booking_transaction = BookingTransaction::where('booking_info_id', $booking->id)->where('travel_status', 'ONGOING')->where('status', '1')->get();

            foreach ($booking_transaction as  $booking_transaction) {

                $booking_transaction->travel_status = "DONE";
                $booking_transaction->save();

                // $booking_history = BookingTransactionHistory::where('booking_transaction_id', $booking_transaction->id)->where('status', '1')->first();
                // $booking_history->status = "0";
                // $booking_history->save();

                // $booking_history_add = new BookingTransactionHistory();
                // $booking_history_add->booking_transaction_id = $booking_transaction->id;
                // $booking_history_add->travel_status = "DONE";
                // $booking_history_add->status = "1";
                // $booking_history_add->save();
            }

            $vehicle_driver =  BookingHasVehicleDriver::where('booking_id', $booking->id)->where('status', '1')->first();
            $vehicle_driver->travel_status = "DONE";
            $vehicle_driver->status = "1";
            $vehicle_driver->save();

            $travel_history = TravelHistory::where('booking_id', $booking->id)->first();
            $travel_history->ends_at = Carbon::now()->format('Y-m-d H:i:s');
            $travel_history->status = "0";
            $travel_history->save();


            $message = 'Record successfully Added!';
            DB::commit();

            return response()->json(array('success' => true, 'messages' => $message));
        } catch (\PDOException $e) {
            DB::rollBack();
            return response()->json(array('success' => false, 'error' => 'SQL error!', 'messages' => 'Transaction failed!'));
        }
    }

    public function changePassword(Request $request)
    {
        $driver = Driver::where('code', $request['code'])->where('status', '1')->first();

        try {
            DB::beginTransaction();
            $driver->password = Hash::make($request['new_password']);
            $driver->save();

            $message = 'Record successfully Updated!';
            DB::commit();

            return response()->json(array('success' => true, 'messages' => $message));
        } catch (\PDOException $e) {
            DB::rollBack();
            return response()->json(array('success' => false, 'error' => 'SQL error!', 'messages' => 'Transaction failed!'));
        }
    }

    public function checkIfDriverHasOngoing($id)
    {
        $isHaveOngoingTrip = false;
        $check_driver = BookingHasVehicleDriver::where('driver_id',$id)->where('travel_status','ONGOING')->where('status','1')->get();

        if(count($check_driver) == 0)
        {
            $isHaveOngoingTrip = false;
        }
        else{
            $isHaveOngoingTrip = true;
        }

        return response()->json([
            'success'   => $isHaveOngoingTrip,
            'data'      => $isHaveOngoingTrip,
            'message'   => 'Retrieved successfully'
        ], 200);
    }
}
