<?php

use Illuminate\Support\Facades\Route;
use Illuminate\Support\Facades\Auth;

/*
|--------------------------------------------------------------------------
| Web Routes
|--------------------------------------------------------------------------
|
| Here is where you can register web routes for your application. These
| routes are loaded by the RouteServiceProvider within a group which
| contains the "web" middleware group. Now create something great!
|
*/

Route::get('/', function () {
    return view('auth.login');
});

Route::get('privacy-policy', 'App\Http\Controllers\User\UserController@shuttlewiser_privacy')->name('privacy-policy');

Route::middleware([
    'auth:sanctum',
    config('jetstream.auth_session'),
    'verified'
])->group(function () {
    // Route::get('/dashboard', function () {
    //     return view('dashboard');
    // })->name('dashboard');
    
    Route::group(['middleware' => 'auth:web'], function () {
        Route::get('view-calendar', 'App\Http\Controllers\Calendar\CalendarController@index')->name('view-calendar')->middleware(['permission:viewGuestCalendar']);
        Route::get('get-event-list', 'App\Http\Controllers\Calendar\CalendarController@eventActivityList')->middleware(['permission:viewGuestCalendar']);
    });

    Route::group(['middleware' => ['auth:web', 'admin']], function () {
        Route::get('/is-super-admin', function () {
            return response()->json(['isSuperAdmin' => is_super_admin()]);
        });

        Route::get('/dashboard', function () {
            return view('dashboard');
        })->name('dashboard')->middleware(['permission:viewDashboard']);
        //Drivers Route
        Route::get('driver-management', 'App\Http\Controllers\Driver\DriversController@manage_drivers')->name('driver-management');
        Route::get('add-new-driver', 'App\Http\Controllers\Driver\DriversController@add_new_driver')->name('add-new-driver');
        Route::post('save-new-driver', 'App\Http\Controllers\Driver\DriversController@saveNewDriver')->name('save-new-driver');
        Route::post('update-drivers-info', 'App\Http\Controllers\Driver\DriversController@updateDriversRecord')->name('update-drivers-info');
        Route::get('get-drivers', 'App\Http\Controllers\Driver\DriversController@findAllDrivers')->name('get-drivers');
        Route::get('get-driver-by-id/{id}', 'App\Http\Controllers\Driver\DriversController@show')->name('get-driver-by-id');
        Route::get('remove-drivers-record/{id}', 'App\Http\Controllers\Driver\DriversController@removeDriversRecord')->name('remove-drivers-record');
        Route::get('get-all-submitted-requirements/{id}', 'App\Http\Controllers\Driver\DriversController@getAllSubmittedRequirements')->name('get-all-submitted-requirements');
        Route::get('get-all-drivers', 'App\Http\Controllers\Driver\DriversController@getAllDrivers')->name('get-all-drivers');
        Route::post('upload-drivers', 'App\Http\Controllers\Driver\DriversController@uploadDrivers')->name('upload-drivers');
        Route::get('reset-driver-password/{id}', 'App\Http\Controllers\Driver\DriversController@resetDriverPassword')->name('reset-driver-password');
        //Drivers Has Requirements
        Route::post('store-drivers-requirements', 'App\Http\Controllers\Driver\DriversController@storeDriversRequirements')->name('store-drivers-requirements');
        Route::post('renew-drivers-requirements', 'App\Http\Controllers\Driver\DriversController@renewDriversRequirements')->name('renew-drivers-requirements');


        //Mapping Route
        Route::get('device-registration', 'App\Http\Controllers\Map\MapController@deviceRegistration')->name('device-registration');
        Route::get('location-mapping', 'App\Http\Controllers\Map\MapController@manage_location_mapping')->name('location-mapping');
        Route::get('get-map-object', 'App\Http\Controllers\Map\MapController@getMapObj')->name('get-map-object');
        Route::get('save-vehicle-device', 'App\Http\Controllers\Map\MapController@storeDataToFirebase')->name('save-vehicle-device');
        Route::get('get-vehicle-for-device', 'App\Http\Controllers\Map\MapController@getVehicleForDevice')->name('get-vehicle-for-device');
        Route::post('register-new-device', 'App\Http\Controllers\Map\MapController@registerNewDevice')->name('register-new-device');
        Route::get('get-all-devices', 'App\Http\Controllers\Map\MapController@findAllDevice')->name('get-all-devices');
        Route::post('vehicle-has-device', 'App\Http\Controllers\Map\MapController@checkIfDeviceIsExist')->name('vehicle-has-device');

        //travel history
        Route::get('travel-history-mngt', 'App\Http\Controllers\Map\MapController@manage_travelHistory')->name('travel-history-mngt');
        Route::get('travel-history', 'App\Http\Controllers\Map\MapController@travelHistory')->name('travel-history');
        Route::get('get-all-travel', 'App\Http\Controllers\TravelHistory\TravelHistoryController@findAllTravelHistory')->name('get-all-travel');
        Route::get('get-vehicle-information/{id}', 'App\Http\Controllers\TravelHistory\TravelHistoryController@getVehicleCodeDevice')->name('get-vehicle-information');


        Route::get('department-management', 'App\Http\Controllers\Department\DepartmentController@manage_department')->name('department-management');
        Route::get('get-department', 'App\Http\Controllers\Department\DepartmentController@findAllDepartment')->name('get-department');
        Route::get('get-all-position', 'App\Http\Controllers\Department\DepartmentController@getAllPosition')->name('get-all-position');
        Route::post('save-new-department', 'App\Http\Controllers\Department\DepartmentController@saveNewdepartment')->name('save-new-department');
        Route::get('get-department-by-id/{id}', 'App\Http\Controllers\Department\DepartmentController@show')->name('get-department-by-id');
        Route::post('update-department', 'App\Http\Controllers\Department\DepartmentController@updatedepartmentRecord')->name('update-department');
        Route::get('remove-department-record/{id}', 'App\Http\Controllers\Department\DepartmentController@removeDepartmentRecord')->name('remove-department-record');
        Route::get('restore-department-record/{id}', 'App\Http\Controllers\Department\DepartmentController@restoreDepartmentRecord')->name('restore-department-record');

        //Company
        Route::get('company-management', 'App\Http\Controllers\Company\CompanyController@manage_company')->name('company-management');
        Route::get('get-company', 'App\Http\Controllers\Company\CompanyController@findAllCompany')->name('get-company');
        Route::get('get-all-department', 'App\Http\Controllers\Company\CompanyController@getAllDepartment')->name('get-all-department');
        Route::post('save-new-company', 'App\Http\Controllers\Company\CompanyController@saveNewCompany')->name('save-new-company');
        Route::get('get-company-info-by-id/{id}', 'App\Http\Controllers\Company\CompanyController@show')->name('get-company-info-by-id');
        Route::post('update-company-info', 'App\Http\Controllers\Company\CompanyController@updateCompanyRecord')->name('update-company-info');
        Route::get('remove-company-record/{id}', 'App\Http\Controllers\Company\CompanyController@removeCompanyRecord')->name('remove-company-record');
        Route::post('reset-counter-start-date', 'App\Http\Controllers\Company\CompanyController@resetCounter')->name('reset-counter-start-date');


        //Account
        Route::get('users-management', 'App\Http\Controllers\User\UserController@manage_users')->name('users-management');
        Route::get('get-all-users', 'App\Http\Controllers\User\UserController@findAllAccount')->name('get-all-users');
        Route::get('add-new-user', 'App\Http\Controllers\User\UserController@add_new_user')->name('add-new-user');
        Route::get('get-all-company', 'App\Http\Controllers\User\UserController@getAllCompany')->name('get-all-company');
        Route::get('get-company-has-department', 'App\Http\Controllers\User\UserController@getDepartment')->name('get-company-has-department');
        Route::get('get-department-has-position', 'App\Http\Controllers\User\UserController@getPosition')->name('get-department-has-position');
        Route::get('get-position-has-access', 'App\Http\Controllers\User\UserController@getAccess')->name('get-position-has-access');
        Route::post('save-new-user', 'App\Http\Controllers\User\UserController@saveNewUser')->name('save-new-user');
        Route::get('get-users-info-by-id/{id}', 'App\Http\Controllers\User\UserController@show')->name('get-users-info-by-id');
        Route::post('update-user-info', 'App\Http\Controllers\User\UserController@updateUserRecord')->name('update-user-info');
        Route::get('remove-user-record/{id}', 'App\Http\Controllers\User\UserController@removeUserRecord')->name('remove-user-record');
        Route::get('reset-password-management', 'App\Http\Controllers\User\UserController@manage_reset_password')->name('reset-password-management');
        Route::get('get-all-users-reset', 'App\Http\Controllers\User\UserController@findAllAccountResetPassword')->name('get-all-users-reset');
        Route::get('reset-user-password/{id}', 'App\Http\Controllers\User\UserController@resetPasswordUserRecord')->name('reset-user-password');
        Route::get('restore-account-management', 'App\Http\Controllers\User\UserController@manage_restore_account')->name('restore-account-management')->middleware(['permission:restoreAccount']);
        Route::get('get-all-restoring-account', 'App\Http\Controllers\User\UserController@findAllRestoreAccount')->name('get-all-restoring-account');
        Route::get('restore-account/{id}', 'App\Http\Controllers\User\UserController@removeRestoreUserRecord')->name('restore-account');
        Route::post('update-password', 'App\Http\Controllers\User\UserController@updatePassword')->name('update-password');
        Route::get('password-change', 'App\Http\Controllers\User\UserController@passwordChange')->name('password-change');

        Route::post('check-password/{password}', 'App\Http\Controllers\User\UserController@checkPassword')->name('check-password');
        Route::get('logout-user/{id}', 'App\Http\Controllers\User\UserController@logoutUser')->name('logout-user');

        //Position
        Route::get('position-management', 'App\Http\Controllers\Position\PositionController@manage_position')->name('position-management');
        Route::get('get-position', 'App\Http\Controllers\Position\PositionController@findAllPosition')->name('get-position');
        Route::post('save-new-position', 'App\Http\Controllers\Position\PositionController@saveNewPosition')->name('save-new-position');
        Route::get('get-position-by-id/{id}', 'App\Http\Controllers\Position\PositionController@show')->name('get-position-by-id');
        Route::post('update-position', 'App\Http\Controllers\Position\PositionController@updatePositionRecord')->name('update-position');
        Route::get('remove-position-record/{id}', 'App\Http\Controllers\Position\PositionController@removePositionRecord')->name('remove-position-record');

        //Permissions
        Route::get('create-permission', 'App\Http\Controllers\Permission\PermissionController@create_permission')->name('create-permission');
        Route::get('permission-management', 'App\Http\Controllers\Permission\PermissionController@manage_permission')->name('permission-management');
        Route::post('save-new-permission', 'App\Http\Controllers\Permission\PermissionController@saveNewPermission')->name('save-new-permission');
        Route::get('get-permissions', 'App\Http\Controllers\Permission\PermissionController@findAllPermission')->name('get-permissions');
        Route::get('get-permission-by-id/{id}', 'App\Http\Controllers\Permission\PermissionController@show')->name('get-permission-by-id');
        Route::post('update-permission', 'App\Http\Controllers\Permission\PermissionController@updatePermissionRecord')->name('update-permission');
        Route::get('remove-permission-record/{id}', 'App\Http\Controllers\Permission\PermissionController@removePermissionRecord')->name('remove-permission-record');
        Route::get('restore-permission-record/{id}', 'App\Http\Controllers\Permission\PermissionController@restorePermissionRecord')->name('restore-permission-record');


        Route::get('location-management', 'App\Http\Controllers\Location\LocationController@index')->name('location-management');
        Route::get('get-location', 'App\Http\Controllers\Location\LocationController@view')->name('get-location');
        Route::post('save-new-location', 'App\Http\Controllers\Location\LocationController@store')->name('save-new-location');
        Route::get('get-location-by-id/{id}', 'App\Http\Controllers\Location\LocationController@show')->name('get-location-by-id');
        Route::post('update-location', 'App\Http\Controllers\Location\LocationController@update')->name('update-location');
        Route::get('remove-location/{id}', 'App\Http\Controllers\Location\LocationController@destroy')->name('remove-location');
        Route::get('list-location', 'App\Http\Controllers\Location\LocationController@listoflocation')->name('list-location');

        Route::get('activity-management', 'App\Http\Controllers\Activity\ActivityController@index')->name('activity-management');
        Route::get('get-activity', 'App\Http\Controllers\Activity\ActivityController@view')->name('get-activity');
        Route::post('save-new-activity', 'App\Http\Controllers\Activity\ActivityController@store')->name('save-new-activity');
        Route::get('get-activity-by-id/{id}', 'App\Http\Controllers\Activity\ActivityController@show')->name('get-activity-by-id');
        Route::post('update-activity', 'App\Http\Controllers\Activity\ActivityController@update')->name('update-activity');
        Route::get('remove-activity/{id}', 'App\Http\Controllers\Activity\ActivityController@destroy')->name('remove-activity');
        Route::get('list-activity', 'App\Http\Controllers\Activity\ActivityController@listofactivity')->name('list-activity');

        Route::get('personincharge-management', 'App\Http\Controllers\PersonInCharge\PersonInChargeController@index')->name('personincharge-management');
        Route::get('get-personincharge', 'App\Http\Controllers\PersonInCharge\PersonInChargeController@view')->name('get-personincharge');
        Route::post('save-new-person-in-charge', 'App\Http\Controllers\PersonInCharge\PersonInChargeController@store')->name('save-new-person-in-charge');
        Route::get('get-personincharge-by-id/{id}', 'App\Http\Controllers\PersonInCharge\PersonInChargeController@show')->name('get-personincharge-by-id');
        Route::post('update-person-in-charge', 'App\Http\Controllers\PersonInCharge\PersonInChargeController@update')->name('update-person-in-charge');
        Route::get('remove-personincharge/{id}', 'App\Http\Controllers\PersonInCharge\PersonInChargeController@destroy')->name('remove-personincharge');
        Route::get('get-filter-by-company', 'App\Http\Controllers\PersonInCharge\PersonInChargeController@filterByCompany')->name('get-filter-by-company');

        Route::get('events-management', 'App\Http\Controllers\Events\EventController@index')->name('events-management');
        Route::get('get-events', 'App\Http\Controllers\Events\EventController@view')->name('get-events');
        Route::get('get-event-by-id/{id}', 'App\Http\Controllers\Events\EventController@show')->name('get-event-by-id');
        Route::post('update-event-schedule', 'App\Http\Controllers\Events\EventController@update')->name('update-event-schedule');
        Route::get('remove-event/{id}', 'App\Http\Controllers\Events\EventController@destroy')->name('remove-event');
        Route::get('get-filter-event-schedule', 'App\Http\Controllers\Events\EventController@filterEventScheduleFromTo')->name('get-filter-event-schedule');
        Route::get('get-total-event-schedule', 'App\Http\Controllers\Events\EventController@getTotalEventsPerCategory')->name('get-total-event-schedule');

        Route::get('create-event-schedule', 'App\Http\Controllers\Events\EventController@create')->name('create-event-schedule');
        Route::post('save-new-event', 'App\Http\Controllers\Events\EventController@store')->name('save-new-event');
        Route::get('view-calendar-event', 'App\Http\Controllers\Events\EventController@eventActivityList')->name('view-calendar-event');

    });
});
