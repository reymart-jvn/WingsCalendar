<?php

use Illuminate\Http\Request;
use Illuminate\Support\Facades\Route;

/*
|--------------------------------------------------------------------------
| API Routes
|--------------------------------------------------------------------------
|
| Here is where you can register API routes for your application. These
| routes are loaded by the RouteServiceProvider within a group which
| is assigned the "api" middleware group. Enjoy building your API!
|
*/
Route::post('/oauth/token', [
        'uses' => '\Laravel\Passport\Http\Controllers\AccessTokenController@issueToken',
        'as' => 'passport.token',
        'middleware' => 'throttle',
    ]);
Route::get('test', function(){
        return "test";
})->name('test');

Route::prefix('auth')->group(function () {
        Route::post('/app_login', 'App\Http\Controllers\API\LoginController@login')->name('app_login');
        Route::get('/get_schedule/{id}', 'App\Http\Controllers\API\DriverController@getDriverScheduleList')->name('get_schedule');
        Route::get('/get_schedule_done/{id}', 'App\Http\Controllers\API\DriverController@getDriverScheduleListDone')->name('get_schedule_done');
        Route::get('/get_schedule_today/{id}', 'App\Http\Controllers\API\DriverController@getDriverScheduleListToday')->name('get_schedule_today');
        Route::get('/get_schedule_month/{id}', 'App\Http\Controllers\API\DriverController@getDriverScheduleListMonth')->name('get_schedule_month');
        Route::get('/get_schedule_no_approval/{id}', 'App\Http\Controllers\API\DriverController@getDriverScheduleListWithoutForApproval')->name('get_schedule_no_approval');
        Route::post('/start_travel/{id}/{datetime}/{devicecode}', 'App\Http\Controllers\API\DriverController@startTravel')->name('start_travel');
        Route::post('/start_travel_code/{id}', 'App\Http\Controllers\API\DriverController@startTravelByCode')->name('start_travel_code');
        Route::post('/end_travel/{id}/{datetime}', 'App\Http\Controllers\API\DriverController@endTravel')->name('end_travel');
        Route::post('/cancel_travel/{id}/{datetime}', 'App\Http\Controllers\API\DriverController@cancelTravel')->name('cancel_travel');
        Route::post('/end_travel_code/{id}', 'App\Http\Controllers\API\DriverController@endTravelByCode')->name('end_travel_code');
        Route::post('/change_password', 'App\Http\Controllers\API\DriverController@changePassword')->name('change_password');
        Route::post('/update_attendance', 'App\Http\Controllers\API\PassengerController@updateAttendance')->name('update_attendance');
        Route::post('/check-transferee', 'App\Http\Controllers\API\PassengerController@checkIfTransfereePassenger')->name('check-transferee');
        Route::post('/save-transferee', 'App\Http\Controllers\API\PassengerController@saveTransfereePassenger')->name('save-transferee');
        Route::get('/get_driver_failed_trip/{id}', 'App\Http\Controllers\API\DriverController@getDriverFailedTrip')->name('get_driver_failed_trip');
        Route::get('/check_driver_ongoing/{id}', 'App\Http\Controllers\API\DriverController@checkIfDriverHasOngoing')->name('check_driver_ongoing');
        Route::post('/purchase_order_request/{id}/{companyid}/{category}/{amountrequested}','App\Http\Controllers\API\PurchaseOrderRequestController@storePurchaseOrderRequest')->name('purchase_order_request');
        Route::get('/get_purchase_transaction_history/{id}','App\Http\Controllers\API\PurchaseOrderRequestController@getPurchaseOrderTransaction')->name('get_purchase_transaction_history');
});
