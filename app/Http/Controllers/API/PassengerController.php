<?php

namespace App\Http\Controllers\API;


use App\Http\Controllers\Controller;
use App\Models\BookingHasVehicleDriver;
use Illuminate\Http\Request;
use App\Models\BookingInformation;
use Illuminate\Support\Facades\DB;
use App\Models\BookingTransaction;
use App\Models\BookingTransactionHistory;
use App\Models\Driver;
use App\Models\PassengerInformation;
use App\Models\TravelHistory;
use Illuminate\Support\Facades\Hash;
use Carbon\Carbon;

class PassengerController extends Controller
{
    public function updateAttendance(Request $request)
    {

        try {
            DB::beginTransaction();
            $booking_id = intval($request['booking_id']);
            $getPassengerId = PassengerInformation::where('passenger_code', $request['passenger_id'])->where('status', '1')->first();

            if ($getPassengerId) {
                $passenger = BookingTransaction::where('booking_info_id',  $booking_id)->where('passenger_info_id', $getPassengerId->id)->where('travel_status','WAITING')->where('status', '1')->first();
                if($passenger)
                {
                    $passenger->travel_status = "ONGOING";
                    $passenger->transferee = "0";
                    $passenger->logs = Carbon::now();
                    $passenger->save();

                    // $transactionHistory = BookingTransactionHistory::where('booking_transaction_id', $passenger->id)->where('status', '1')->first();
                    // $transactionHistory->status = "0";
                    // $transactionHistory->save();

                    // $newTransactionHistory = new BookingTransactionHistory();
                    // $newTransactionHistory->booking_transaction_id = $passenger->id;
                    // $newTransactionHistory->travel_status = "ONGOING";
                    // $newTransactionHistory->status = "1";
                    // $newTransactionHistory->save();

                    $message = "Passenger has successfully saved";
                }
                else
                {
                    $alreadyScanned = BookingTransaction::where('booking_info_id',  $booking_id)->where('passenger_info_id', $getPassengerId->id)->where('travel_status','ONGOING')->where('logs','!=',null)->where('status', '1')->first();
                    if($alreadyScanned)
                    {
                        return response()->json(array('success' => true, 'error' => 'SQL error!', 'messages' => 'Passenger is already scanned. Please try again','type' => "2"));
                    }
                    else
                    {
                        return response()->json(array('success' => false, 'error' => 'SQL error!', 'messages' => 'Passenger is not on the booking list passenger. Please try again','type' => "3"));
                    }
                }
                    
                
            } else {
                return response()->json(array('success' => false, 'error' => 'SQL error!', 'messages' => 'Passenger is not on the system. Please try again','type' => "4"));
            }

            DB::commit();
            return response()->json(array('success' => true,'transferee' => false, 'messages' => $message, 'type' => "1"));
       
        } catch (\PDOException $e) {
            DB::rollBack();
            return response()->json(array('success' => false, 'error' => 'SQL error!', 'messages' => 'Transaction failed!','type' => "5"));
        }
    }

    public function checkIfTransfereePassenger(Request $request)
    {
        try {
            DB::beginTransaction();
            $booking_id = intval($request['booking_id']);
            $getPassengerId = PassengerInformation::where('passenger_code', $request['passenger_id'])->where('status', '1')->first();

            if ($getPassengerId) {
                $passenger = BookingTransaction::where('booking_info_id',  $booking_id)->where('passenger_info_id', $getPassengerId->id)->where('status', '1')->first();
                if ($passenger) {
                    $message = 'chech passenger';
                    return response()->json(array('transferee' => false, 'messages' => $message));
                } else {
                    $message = 'Passenger is transferee';
                    return response()->json(array('transferee' => true, 'messages' => $message));
                }
            } else {
                DB::rollBack();
                return response()->json(array('success' => false, 'error' => 'SQL error!', 'messages' => 'Passenger is not on the database. Please try again'));
            }

            DB::commit();
       
        } catch (\PDOException $e) {
            DB::rollBack();
            return response()->json(array('success' => false, 'error' => 'SQL error!', 'messages' => 'Transaction failed!'));
        }
    }

    public function saveTransfereePassenger(Request $request)
    {

        try {
            DB::beginTransaction();
            $booking_id = intval($request['booking_id']);
            $getPassengerId = PassengerInformation::where('passenger_code', $request['passenger_id'])->where('status', '1')->first();

            if ($getPassengerId) {
                    $getBookingInformation = BookingInformation::findOrFail($booking_id);
                    $passenger = new BookingTransaction();
                    $passenger->booking_info_id = $getBookingInformation->id;
                    $passenger->passenger_info_id = $getPassengerId->id;
                    $passenger->company_id = $getBookingInformation->company_id;
                    $passenger->address = "-";
                    $passenger->pick_up_point = "-";
                    $passenger->travel_status = "ONGOING";
                    $passenger->in_out =  $getBookingInformation->in_out;
                    $passenger->transferee = "1";
                    $passenger->status = "1"; 
                    $passenger->logs = Carbon::now();
                    $passenger->save();
 
                    // $newTransactionHistory = new BookingTransactionHistory();
                    // $newTransactionHistory->booking_transaction_id =  $passenger->id;
                    // $newTransactionHistory->travel_status = "ONGOING";
                    // $newTransactionHistory->status = "1";
                    // $newTransactionHistory->save();

                    $message = 'SUCCESSFULLY SAVE' ." ". $passenger;
    
            } else {
                DB::rollBack();
                return response()->json(array('success' => false, 'error' => 'SQL error!', 'messages' => 'Passenger is not on the list. Please try again'));
            }

            DB::commit();
            return response()->json(array('success' => true,'transferee' => false, 'messages' => $message));
       
        } catch (\PDOException $e) {
            DB::rollBack();
            return response()->json(array('success' => false, 'error' => 'SQL error!', 'messages' => 'Transaction failed!'));
        }
    }
}
