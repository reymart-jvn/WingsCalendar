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
    return redirect('login');
});

Route::get('privacy-policy', 'App\Http\Controllers\User\UserController@shuttlewiser_privacy')->name('privacy-policy');

Route::middleware([
    'auth:sanctum',
    config('jetstream.auth_session'),
    'verified'
])->group(function () {
    Route::get('/dashboard', function () {
        return view('dashboard');
    })->name('dashboard');



    Route::group(['middleware' => 'auth:web'], function () {
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

        //Requirements Route
        Route::get('requirements-management', 'App\Http\Controllers\Requirements\RequirementsController@manage_requirements')->name('requirements-management');
        Route::post('save-new-requirements', 'App\Http\Controllers\Requirements\RequirementsController@saveNewRequirements')->name('save-new-requirements');
        Route::post('update-requirements', 'App\Http\Controllers\Requirements\RequirementsController@updateRequirementsRecord')->name('update-requirements');
        Route::get('get-requirements', 'App\Http\Controllers\Requirements\RequirementsController@findAllRequirements')->name('get-requirements');
        Route::get('get-requirements-by-id/{id}', 'App\Http\Controllers\Requirements\RequirementsController@show')->name('get-requirements-by-id');
        Route::get('remove-requirements-record/{id}', 'App\Http\Controllers\Requirements\RequirementsController@removeRequirementsRecord')->name('remove-requirements-record');

        //Compliance Requirements Route
        Route::get('compliance-requirements-management', 'App\Http\Controllers\Requirements\ComplianceRequirementsController@manage_compliance_requirements')->name('compliance-requirements-management');
        Route::post('save-new-compliance-requirements-summary', 'App\Http\Controllers\Requirements\ComplianceRequirementsController@saveNewComplianceRequirementsSummary')->name('save-new-compliance-requirements-summary');
        Route::post('update-compliance-requirements-summary', 'App\Http\Controllers\Requirements\ComplianceRequirementsController@updateComplianceRequirementsSummaryRecord')->name('update-compliance-requirements-summary');
        Route::get('get-compliance-requirements', 'App\Http\Controllers\Requirements\ComplianceRequirementsController@findAllComplianceRequirements')->name('get-compliance-requirements');
        Route::get('get-all-requirements', 'App\Http\Controllers\Requirements\ComplianceRequirementsController@getAllRequirements')->name('get-all-requirements');
        Route::get('get-compliance-requirements-summary-by-id/{id}', 'App\Http\Controllers\Requirements\ComplianceRequirementsController@show')->name('get-compliance-requirements-summary-by-id');
        Route::get('remove-compliance-requirements-summary-record/{id}', 'App\Http\Controllers\Requirements\ComplianceRequirementsController@removeComplianceRequirementsSummaryRecord')->name('remove-compliance-requirements-summary-record');
        Route::get('get-all-compliance-requirements-summary', 'App\Http\Controllers\Requirements\ComplianceRequirementsController@getAllComplianceRequirementsSummary')->name('get-all-compliance-requirements-summary');

        // Route::get('get-driver-by-id/{id}', 'App\Http\Controllers\Driver\DriversController@show')->name('get-driver-by-id');
        // Route::get('remove-drivers-record/{id}', 'App\Http\Controllers\Driver\DriversController@removeDriversRecord')->name('remove-drivers-record');

        //Vehicle Route
        //Vehicle Type
        Route::get('vehicle-type-management', 'App\Http\Controllers\Vehicle\VehicleType\VehicleTypeController@manage_vehicle_type')->name('vehicle-type-management');
        Route::get('get-vehicle-type', 'App\Http\Controllers\Vehicle\VehicleType\VehicleTypeController@findAllVehicleType')->name('get-vehicle-type');
        Route::post('save-new-vehicle-type', 'App\Http\Controllers\Vehicle\VehicleType\VehicleTypeController@saveNewVehicleType')->name('save-new-vehicle-type');
        Route::get('get-vehicle-type-by-id/{id}', 'App\Http\Controllers\Vehicle\VehicleType\VehicleTypeController@show')->name('get-vehicle-type-by-id');
        Route::post('update-vehicle-type-info', 'App\Http\Controllers\Vehicle\VehicleType\VehicleTypeController@updateVehicleTypeRecord')->name('update-vehicle-type-info');
        Route::get('remove-vehicle-type-record/{id}', 'App\Http\Controllers\Vehicle\VehicleType\VehicleTypeController@removeVehicleTypeRecord')->name('remove-vehicle-type-record');

        // Vehicle Information
        Route::get('vehicle-info-management', 'App\Http\Controllers\Vehicle\VehicleInfo\VehicleInfoController@manage_vehicle')->name('vehicle-info-management');
        Route::get('get-vehicle', 'App\Http\Controllers\Vehicle\VehicleInfo\VehicleInfoController@findAllVehicle')->name('get-vehicle');
        Route::get('get-vehicle-all-type', 'App\Http\Controllers\Vehicle\VehicleInfo\VehicleInfoController@getAllVehicleType')->name('get-vehicle-all-type');
        Route::get('get-vehicle-with-driver/{departureDate}', 'App\Http\Controllers\Vehicle\VehicleInfo\VehicleInfoController@getAllVehicleWithDriver')->name('get-vehicle-with-driver');
        Route::get('get-all-vehicle-with-driver', 'App\Http\Controllers\Vehicle\VehicleInfo\VehicleInfoController@getAllVehicle')->name('get-all-vehicle-with-driver');
        Route::post('save-new-vehicle', 'App\Http\Controllers\Vehicle\VehicleInfo\VehicleInfoController@saveNewVehicle')->name('save-new-vehicle');
        Route::get('get-vehicle-info-by-id/{id}', 'App\Http\Controllers\Vehicle\VehicleInfo\VehicleInfoController@show')->name('get-vehicle-info-by-id');
        Route::post('update-vehicle-info', 'App\Http\Controllers\Vehicle\VehicleInfo\VehicleInfoController@updateVehicleRecord')->name('update-vehicle-info');
        Route::get('remove-vehicle-record/{id}', 'App\Http\Controllers\Vehicle\VehicleInfo\VehicleInfoController@removeVehicleRecord')->name('remove-vehicle-record');
        Route::get('get-all-vehicle-has-or-cr/{id}', 'App\Http\Controllers\Vehicle\VehicleInfo\VehicleInfoController@getVehicleHasOrCr')->name('get-all-vehicle-has-or-cr');
        Route::post('save-vehicle-requirements', 'App\Http\Controllers\Vehicle\VehicleInfo\VehicleInfoController@saveVehicleRequirements')->name('save-vehicle-requirements');
        Route::post('renew-vehicle-requirements', 'App\Http\Controllers\Vehicle\VehicleInfo\VehicleInfoController@renewVehicleRequirements')->name('renew-vehicle-requirements');
        Route::post('upload-vehicles', 'App\Http\Controllers\Vehicle\VehicleInfo\VehicleInfoController@uploadVehicles')->name('upload-vehicles');
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
        //  Route::post('update-compliance-requirements-summary', 'App\Http\Controllers\Requirements\ComplianceRequirementsController@updateComplianceRequirementsSummaryRecord')->name('update-compliance-requirements-summary');
        //  Route::get('get-compliance-requirements', 'App\Http\Controllers\Requirements\ComplianceRequirementsController@findAllComplianceRequirements')->name('get-compliance-requirements');
        //  Route::get('get-all-requirements', 'App\Http\Controllers\Requirements\ComplianceRequirementsController@getAllRequirements')->name('get-all-requirements');
        //  Route::get('get-compliance-requirements-summary-by-id/{id}', 'App\Http\Controllers\Requirements\ComplianceRequirementsController@show')->name('get-compliance-requirements-summary-by-id');
        //  Route::get('remove-compliance-requirements-summary-record/{id}', 'App\Http\Controllers\Requirements\ComplianceRequirementsController@removeComplianceRequirementsSummaryRecord')->name('remove-compliance-requirements-summary-record');
        // Route::get('get-driver-by-id/{id}', 'App\Http\Controllers\Driver\DriversController@show')->name('get-driver-by-id');
        // Route::get('remove-drivers-record/{id}', 'App\Http\Controllers\Driver\DriversController@removeDriversRecord')->name('remove-drivers-record');
        //Department 


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


        //Booking Type
        Route::get('booking-type-management', 'App\Http\Controllers\Booking\BookingType\BookingTypeController@manage_booking_type')->name('booking-type-management');
        Route::get('get-booking-type', 'App\Http\Controllers\Booking\BookingType\BookingTypeController@findAllBookingType')->name('get-booking-type');
        Route::post('save-new-booking-type', 'App\Http\Controllers\Booking\BookingType\BookingTypeController@saveNewBookingType')->name('save-new-booking-type');
        Route::get('get-booking-type-by-id/{id}', 'App\Http\Controllers\Booking\BookingType\BookingTypeController@show')->name('get-booking-type-by-id');
        Route::post('update-booking-type-info', 'App\Http\Controllers\Booking\BookingType\BookingTypeController@updateBookingTypeRecord')->name('update-booking-type-info');
        Route::get('remove-booking-type-record/{id}', 'App\Http\Controllers\Booking\BookingType\BookingTypeController@removeBookingTypeRecord')->name('remove-booking-type-record');

        //Booking Category
        Route::get('booking-category-management', 'App\Http\Controllers\Booking\BookingCategory\BookingCategoryController@index')->name('booking-category-management');
        Route::get('get-booking-category', 'App\Http\Controllers\Booking\BookingCategory\BookingCategoryController@findAllBookingCategory')->name('get-booking-category');
        Route::post('save-new-booking-category', 'App\Http\Controllers\Booking\BookingCategory\BookingCategoryController@store')->name('save-new-booking-category');
        Route::get('get-booking-category-by-id/{id}', 'App\Http\Controllers\Booking\BookingCategory\BookingCategoryController@show')->name('get-booking-category-by-id');
        Route::post('update-booking-category-info', 'App\Http\Controllers\Booking\BookingCategory\BookingCategoryController@update')->name('update-booking-category-info');
        Route::get('remove-booking-category-record/{id}', 'App\Http\Controllers\Booking\BookingCategory\BookingCategoryController@destroy')->name('remove-booking-category-record');
        Route::get('restore-booking-category-record/{id}', 'App\Http\Controllers\Booking\BookingCategory\BookingCategoryController@edit')->name('restore-booking-category-record');
        Route::get('get-all-booking-category', 'App\Http\Controllers\Booking\BookingCategory\BookingCategoryController@getbookingcategory')->name('get-all-booking-category');
        //Booking
        Route::get('booking-management', 'App\Http\Controllers\Booking\BookingInfo\BookingInfoController@manage_booking')->name('booking-management');
        Route::get('get-booking', 'App\Http\Controllers\Booking\BookingInfo\BookingInfoController@findAllBooking')->name('get-booking');
        Route::get('get-booking-ongoing', 'App\Http\Controllers\Booking\BookingInfo\BookingInfoController@findAllBookingOngoing')->name('get-booking-ongoing');
        Route::get('get-booking-done', 'App\Http\Controllers\Booking\BookingInfo\BookingInfoController@findAllBookingDone')->name('get-booking-done');
        Route::get('get-booking-all-type', 'App\Http\Controllers\Booking\BookingInfo\BookingInfoController@getAllBookingType')->name('get-booking-all-type');
        Route::post('save-new-booking', 'App\Http\Controllers\Booking\BookingInfo\BookingInfoController@saveNewBooking')->name('save-new-booking');
        Route::get('get-booking-info-by-id/{id}', 'App\Http\Controllers\Booking\BookingInfo\BookingInfoController@show')->name('get-booking-info-by-id');
        Route::post('update-booking-info', 'App\Http\Controllers\Booking\BookingInfo\BookingInfoController@updateBookingRecord')->name('update-booking-info');
        Route::get('add-new-booking', 'App\Http\Controllers\Booking\BookingInfo\BookingInfoController@add_new_booking')->name('add-new-booking');
        Route::get('get-passenger-booking-transaction', 'App\Http\Controllers\Booking\BookingInfo\BookingInfoController@findAllPassengerBookingTransaction')->name('get-passenger-booking-transaction');
        Route::get('get-passenger-group-booking-transaction', 'App\Http\Controllers\Booking\BookingInfo\BookingInfoController@findAllPassengerGroupBookingTransaction')->name('get-passenger-group-booking-transaction');
        Route::get('get-passenger-company-booking-by-id/{id}', 'App\Http\Controllers\Booking\BookingInfo\BookingInfoController@findAllPassengerInBooking')->name('get-passenger-company-booking-by-id');
        Route::get('get-passenger-booking-transaction-by-id/{id}/{id2}', 'App\Http\Controllers\Booking\BookingInfo\BookingInfoController@findAllPassengerInBookingTransaction')->name('get-passenger-booking-transaction-by-id');
        Route::get('remove-booking-record/{id}', 'App\Http\Controllers\Booking\BookingInfo\BookingInfoController@removeBookingRecord')->name('remove-booking-record');
        Route::get('get-passenger-company-new-booking/{id}', 'App\Http\Controllers\Booking\BookingInfo\BookingInfoController@findAllPassengerForNewBooking')->name('get-passenger-company-new-booking');
        Route::post('save-replicate-booking', 'App\Http\Controllers\Booking\BookingInfo\BookingInfoController@saveReplicateBooking')->name('save-replicate-booking');
        Route::post('tag-as-ongoing', 'App\Http\Controllers\Booking\BookingInfo\BookingInfoController@tagAsOngoingBypass')->name('tag-as-ongoing');
        Route::post('tag-as-done', 'App\Http\Controllers\Booking\BookingInfo\BookingInfoController@tagAsDoneBypass')->name('tag-as-done');

        Route::post('revert-booking-record/{id}', 'App\Http\Controllers\Booking\BookingInfo\BookingInfoController@revertBookingRecord')->name('revert-booking-record');

        Route::get('import-booking', 'App\Http\Controllers\Booking\BookingInfo\ImportBookingController@import_booking')->name('import-booking');
        Route::get('get-filter-booking', 'App\Http\Controllers\Booking\BookingInfo\BookingInfoController@filterFromTo')->name('get-filter-booking');
        //Passenger
        Route::get('passenger-management', 'App\Http\Controllers\Passenger\PassengerController@manage_passenger')->name('passenger-management');
        Route::get('get-passenger', 'App\Http\Controllers\Passenger\PassengerController@findAllPassenger')->name('get-passenger');
        Route::post('save-new-passenger', 'App\Http\Controllers\Passenger\PassengerController@saveNewPassenger')->name('save-new-passenger');
        Route::get('get-passenger-by-id/{id}', 'App\Http\Controllers\Passenger\PassengerController@show')->name('get-passenger-by-id');
        Route::post('update-passenger', 'App\Http\Controllers\Passenger\PassengerController@updatePassengerRecord')->name('update-passenger');
        Route::get('remove-passenger-record/{id}', 'App\Http\Controllers\Passenger\PassengerController@removePassengerRecord')->name('remove-passenger-record');
        Route::post('upload-passengers', 'App\Http\Controllers\Passenger\PassengerController@uploadPassengers')->name('upload-passengers');

        Route::get('get-passenger-by-company/{id}/{section}', 'App\Http\Controllers\Passenger\PassengerController@getPassengersByCompany')->name('get-passenger-by-company');
        //PassengerGroup
        Route::get('passenger-group-management', 'App\Http\Controllers\Passenger\PassengerGroupController@manage_passenger_group')->name('passenger-group-management');
        Route::get('get-passenger-group', 'App\Http\Controllers\Passenger\PassengerGroupController@findAllPassengerGroup')->name('get-passenger-group');
        Route::get('get-passenger-company', 'App\Http\Controllers\Passenger\PassengerGroupController@findAllPassenger')->name('get-passenger-company');
        Route::post('save-new-passenger-group', 'App\Http\Controllers\Passenger\PassengerGroupController@saveNewPassengerGroup')->name('save-new-passenger-group');
        Route::get('get-passenger-group-by-id/{id}', 'App\Http\Controllers\Passenger\PassengerGroupController@show')->name('get-passenger-group-by-id');
        Route::post('get-passenger-wherein', 'App\Http\Controllers\Passenger\PassengerGroupController@findAllPassengerWhereIn')->name('get-passenger-wherein');
        Route::get('remove-passenger/{id}', 'App\Http\Controllers\Passenger\PassengerGroupController@removePassenger')->name('remove-passenger');
        Route::post('save-new-update-passenger', 'App\Http\Controllers\Passenger\PassengerGroupController@saveNewUpdatePassenger')->name('save-new-update-passenger');
        Route::post('update-passenger-group', 'App\Http\Controllers\Passenger\PassengerGroupController@updatePassengerGroupRecord')->name('update-passenger-group');
        Route::get('remove-passenger-group/{id}', 'App\Http\Controllers\Passenger\PassengerGroupController@removePassengerGroup')->name('remove-passenger-group');

        //Rate Per Trip
        Route::get('rate-per-trip-management', 'App\Http\Controllers\RatePerTrip\RatePerTripController@manage_rate_per_trip')->name('rate-per-trip-management');
        Route::get('get-rate-per-trip', 'App\Http\Controllers\RatePerTrip\RatePerTripController@findAllRatePerTrip')->name('get-rate-per-trip');
        Route::post('save-new-rate', 'App\Http\Controllers\RatePerTrip\RatePerTripController@saveNewRatePerTrip')->name('save-new-rate');
        Route::get('get-rate-by-id/{id}', 'App\Http\Controllers\RatePerTrip\RatePerTripController@show')->name('get-rate-by-id');
        Route::post('update-rate', 'App\Http\Controllers\RatePerTrip\RatePerTripController@updateRatePerTripRecord')->name('update-rate');
        Route::get('remove-rate-record/{id}', 'App\Http\Controllers\RatePerTrip\RatePerTripController@removeRatePerTripRecord')->name('remove-rate-record');
        Route::get('get-all-rate-per-trip/{id}', 'App\Http\Controllers\RatePerTrip\RatePerTripController@getAllRatePerTrip')->name('get-all-rate-per-trip');
        Route::get('activate-rate-record/{id}/{price}', 'App\Http\Controllers\RatePerTrip\RatePerTripController@activateRatePerTrip')->name('activate-rate-record');
        Route::get('get-filter-rate-by-company', 'App\Http\Controllers\RatePerTrip\RatePerTripController@filterRateByCompany')->name('get-filter-rate-by-company');

        //Booking Approval
        Route::get('booking-approval-management', 'App\Http\Controllers\Booking\BookingApproval\BookingApprovalController@manage_booking_approval')->name('booking-approval-management');
        Route::get('get-booking-approval', 'App\Http\Controllers\Booking\BookingApproval\BookingApprovalController@findAllBooking')->name('get-booking-approval');
        Route::get('get-booking-approval-by-id/{id}', 'App\Http\Controllers\Booking\BookingApproval\BookingApprovalController@show')->name('get-booking-approval-by-id');
        Route::post('save-booking-rate', 'App\Http\Controllers\Booking\BookingApproval\BookingApprovalController@saveBookingRate')->name('save-booking-rate');
        Route::post('update-booking-rate', 'App\Http\Controllers\Booking\BookingApproval\BookingApprovalController@updateBookingRate')->name('update-booking-rate');
        Route::get('declined-booking-record/{id}', 'App\Http\Controllers\Booking\BookingApproval\BookingApprovalController@declinedBookingRecord')->name('declined-booking-record');
        Route::post('save-trip-ticket', 'App\Http\Controllers\Booking\BookingApproval\BookingApprovalController@saveTripTicket')->name('save-trip-ticket');
        Route::get('ongoing-booking-record/{id}', 'App\Http\Controllers\Booking\BookingApproval\BookingApprovalController@bypassOngoing')->name('ongoing-booking-record');
        Route::get('done-booking-record/{id}', 'App\Http\Controllers\Booking\BookingApproval\BookingApprovalController@bypassDone')->name('done-booking-record');
        Route::get('get-filter-booking-approval', 'App\Http\Controllers\Booking\BookingApproval\BookingApprovalController@filterFromToForApproval')->name('get-filter-booking-approval');

    
    //Booking Group Approval
    Route::get('booking-group-approval-management', 'App\Http\Controllers\Booking\BookingGroupApproval\BookingGroupApprovalController@index')->name('booking-group-approval-management');
    Route::get('findall-booking-group-approval', 'App\Http\Controllers\Booking\BookingGroupApproval\BookingGroupApprovalController@findAllBookingGroup')->name('findall-booking-group-approval');
    Route::get('approve-booking-group/{id}', 'App\Http\Controllers\Booking\BookingGroupApproval\BookingGroupApprovalController@approveBookingGroup')->name('approve-booking-group');
    Route::get('cancel-booking-group/{id}', 'App\Http\Controllers\Booking\BookingGroupApproval\BookingGroupApprovalController@cancelBookingGroup')->name('cancel-booking-group');
    Route::get('findall-booking-group-approval-client', 'App\Http\Controllers\Booking\BookingGroupApproval\BookingGroupApprovalController@findAllBookingGroupClientSide')->name('findall-booking-group-approval-client');
    Route::get('cancel-booking-group-client/{id}', 'App\Http\Controllers\Booking\BookingGroupApproval\BookingGroupApprovalController@cancelBookingGroupClient')->name('cancel-booking-group-client');
    Route::get('cancel-booking/{id}', 'App\Http\Controllers\Booking\BookingGroupApproval\BookingGroupApprovalController@cancelBooking')->name('cancel-booking');
    Route::get('get-booking-group-by-id/{id}', 'App\Http\Controllers\Booking\BookingGroupApproval\BookingGroupApprovalController@show')->name('get-booking-group-by-id');

    Route::get('deploy', 'App\Http\Controllers\Deployment\DeployController@deploy')->name('deploy');
    Route::get('remove-booking-group/{id}', 'App\Http\Controllers\Booking\BookingGroupApproval\BookingGroupApprovalController@removeBookingGroup')->name('remove-booking-group');
    Route::get('get-filter-booking-group', 'App\Http\Controllers\Booking\BookingGroupApproval\BookingGroupApprovalController@filterBookingGroupBy')->name('get-filter-booking-group');
    Route::post('new-book-in-group', 'App\Http\Controllers\Booking\BookingGroupApproval\BookingGroupApprovalController@newBookInGroup')->name('new-book-in-group');
    Route::post('approve-selected-booking-group', 'App\Http\Controllers\Booking\BookingGroupApproval\BookingGroupApprovalController@approveSelectedBookingGroup')->name('approve-selected-booking-group');
    //Financial Summary Reports
    Route::get('manage-financial-summary-reports', 'App\Http\Controllers\Reports\FinancialSummaryController@index')->name('manage-financial-summary-reports');
    Route::get('get-financial-summary/{companyID}/{from}/{to}', 'App\Http\Controllers\Reports\FinancialSummaryController@financialComputation')->name('get-financial-summary');
    Route::get('get-driver-summary', 'App\Http\Controllers\Reports\FinancialSummaryController@driverSummary')->name('get-driver-summary');
        //Billing Management
        Route::get('billing-management', 'App\Http\Controllers\Billing\BillingController@manage_billing')->name('billing-management');
        Route::get('get-billing', 'App\Http\Controllers\Billing\BillingController@findAllBilling')->name('get-billing');
        Route::get('get-booking-from-to', 'App\Http\Controllers\Billing\BillingController@findAllBookingFromTo')->name('get-booking-from-to');
        Route::post('save-billing', 'App\Http\Controllers\Billing\BillingController@saveBilling')->name('save-billing');
        Route::get('get-booking-between-dates/{companyID}/{from}/{to}', 'App\Http\Controllers\Billing\BillingController@getBookingBetweenDates')->name('get-booking-between-dates');
        Route::get('void-billing-record/{id}/{reasons}', 'App\Http\Controllers\Billing\BillingController@voidBillingRecord')->name('void-billing-record');
        Route::get('get-booking-trip-driver/{companyID}/{from}/{to}/{driver}', 'App\Http\Controllers\Billing\BillingController@getBookingTripDriver')->name('get-booking-trip-driver');

        //Billing Summary
        Route::get('billing-summary', 'App\Http\Controllers\Billing\BillingController@manage_billing_summary')->name('billing-summary');

        //Section
        Route::get('get-all-section', 'App\Http\Controllers\Section\SectionController@getAllSection')->name('get-all-section');

        //ImportBooking
        Route::post('/import-new-booking', 'App\Http\Controllers\Booking\BookingInfo\ImportBookingController@store')->name('import-new-booking.store');

        //PassengerReports
        Route::get('passenger-reports-management', 'App\Http\Controllers\Reports\PassengerReportsController@manage_passenger_reports')->name('passenger-reports-management');
        Route::get('get-passenger-reports', 'App\Http\Controllers\Reports\PassengerReportsController@findAllPassengerReports')->name('get-passenger-reports');
        Route::get('get-attendance-by-passenger-id/{id}/{from}/{to}', 'App\Http\Controllers\Reports\PassengerReportsController@getAttendanceReport')->name('get-attendance-by-passenger-id');
        Route::get('get-logs-report-per-section/{id}/{company}/{from}/{to}', 'App\Http\Controllers\Reports\PassengerReportsController@getLogsReportPerSection')->name('get-logs-report-per-section');
        //Holiday
        Route::get('holiday-management', 'App\Http\Controllers\Holiday\HolidayController@manage_holiday')->name('holiday-management');
        Route::get('get-holiday', 'App\Http\Controllers\Holiday\HolidayController@findAllholiday')->name('get-holiday');
        Route::post('save-new-holiday', 'App\Http\Controllers\Holiday\HolidayController@saveNewholiday')->name('save-new-holiday');
        Route::get('get-holiday-by-id/{id}', 'App\Http\Controllers\Holiday\HolidayController@show')->name('get-holiday-by-id');
        Route::post('update-holiday', 'App\Http\Controllers\Holiday\HolidayController@updateHolidayRecord')->name('update-holiday');
        Route::get('remove-holiday-record/{id}', 'App\Http\Controllers\Holiday\HolidayController@removeHolidayRecord')->name('remove-holiday-record');


        //Booking Group Approval
        Route::get('booking-group-approval-management', 'App\Http\Controllers\Booking\BookingGroupApproval\BookingGroupApprovalController@index')->name('booking-group-approval-management');
        Route::get('findall-booking-group-approval', 'App\Http\Controllers\Booking\BookingGroupApproval\BookingGroupApprovalController@findAllBookingGroup')->name('findall-booking-group-approval');
        Route::get('approve-booking-group/{id}', 'App\Http\Controllers\Booking\BookingGroupApproval\BookingGroupApprovalController@approveBookingGroup')->name('approve-booking-group');
        Route::get('cancel-booking-group/{id}', 'App\Http\Controllers\Booking\BookingGroupApproval\BookingGroupApprovalController@cancelBookingGroup')->name('cancel-booking-group');
        Route::get('findall-booking-group-approval-client', 'App\Http\Controllers\Booking\BookingGroupApproval\BookingGroupApprovalController@findAllBookingGroupClientSide')->name('findall-booking-group-approval-client');
        Route::get('cancel-booking-group-client/{id}', 'App\Http\Controllers\Booking\BookingGroupApproval\BookingGroupApprovalController@cancelBookingGroupClient')->name('cancel-booking-group-client');
        Route::get('cancel-booking/{id}', 'App\Http\Controllers\Booking\BookingGroupApproval\BookingGroupApprovalController@cancelBooking')->name('cancel-booking');
        Route::get('get-booking-group-by-id/{id}', 'App\Http\Controllers\Booking\BookingGroupApproval\BookingGroupApprovalController@show')->name('get-booking-group-by-id');
        Route::get('remove-booking-group/{id}', 'App\Http\Controllers\Booking\BookingGroupApproval\BookingGroupApprovalController@removeBookingGroup')->name('remove-booking-group');
        Route::get('get-filter-booking-group', 'App\Http\Controllers\Booking\BookingGroupApproval\BookingGroupApprovalController@filterBookingGroupBy')->name('get-filter-booking-group');
        Route::post('new-book-in-group', 'App\Http\Controllers\Booking\BookingGroupApproval\BookingGroupApprovalController@newBookInGroup')->name('new-book-in-group');
        Route::post('approve-selected-booking-group', 'App\Http\Controllers\Booking\BookingGroupApproval\BookingGroupApprovalController@approveSelectedBookingGroup')->name('approve-selected-booking-group');
        Route::post('update-booking-group', 'App\Http\Controllers\Booking\BookingGroupApproval\BookingGroupApprovalController@updateBookingGroupInfo')->name('update-booking-group');
        //Financial Summary Reports
        Route::get('manage-financial-summary-reports', 'App\Http\Controllers\Reports\FinancialSummaryController@index')->name('manage-financial-summary-reports');
        Route::get('get-financial-summary/{companyID}/{from}/{to}', 'App\Http\Controllers\Reports\FinancialSummaryController@financialComputation')->name('get-financial-summary');
        Route::get('get-driver-summary', 'App\Http\Controllers\Reports\FinancialSummaryController@driverSummary')->name('get-driver-summary');

        //Booking For Approval/Cancelation
        Route::get('booking-approve-cancellation', 'App\Http\Controllers\Booking\BookingInfo\CancelBookingController@index')->name('booking-approve-cancellation');
        Route::get('get-approved-booking', 'App\Http\Controllers\Booking\BookingInfo\CancelBookingController@findAllApprovedBooking')->name('get-approved-booking');
        Route::get('get-done-booking', 'App\Http\Controllers\Booking\BookingInfo\CancelBookingController@findAllDoneBooking')->name('get-done-booking');
        Route::get('get-for-approval-booking', 'App\Http\Controllers\Booking\BookingInfo\CancelBookingController@findAllForApprovalBooking')->name('get-for-approval-booking');
        Route::post('cancel-selected-booking', 'App\Http\Controllers\Booking\BookingInfo\CancelBookingController@cancelSelectedBooking')->name('cancel-selected-booking');
        Route::post('delete-selected-booking', 'App\Http\Controllers\Booking\BookingInfo\CancelBookingController@deleteSelectedBooking')->name('delete-selected-booking');
        Route::post('delete-selected-booking-for-approval', 'App\Http\Controllers\Booking\BookingInfo\CancelBookingController@deleteSelectedBookingForApproval')->name('delete-selected-booking-for-approval');
        Route::post('cancel-selected-booking-done', 'App\Http\Controllers\Booking\BookingInfo\CancelBookingController@cancelSelectedBookingDone')->name('cancel-selected-booking-done');
        Route::post('approve-selected-booking', 'App\Http\Controllers\Booking\BookingInfo\CancelBookingController@approveSelectedBooking')->name('approve-selected-booking');
        Route::get('get-filter-booking-cancel', 'App\Http\Controllers\Booking\BookingInfo\CancelBookingController@filterFromToApprovedBooking')->name('get-filter-booking-cancel');
        Route::get('get-filter-booking-done', 'App\Http\Controllers\Booking\BookingInfo\CancelBookingController@filterFromToDoneBooking')->name('get-filter-booking-done');
        Route::get('get-filter-booking-for-approval', 'App\Http\Controllers\Booking\BookingInfo\CancelBookingController@filterFromToForApprovalBooking')->name('get-filter-booking-for-approval');
        
        //Shift
        Route::get('shifting-management', 'App\Http\Controllers\Shifting\ShiftingController@index')->name('shifting-management');
        Route::get('get-shifting', 'App\Http\Controllers\Shifting\ShiftingController@findAllShifting')->name('get-shifting');
        Route::post('save-new-shifting', 'App\Http\Controllers\Shifting\ShiftingController@store')->name('save-new-shifting');
        Route::get('get-shifting-by-id/{id}', 'App\Http\Controllers\Shifting\ShiftingController@show')->name('get-shifting-by-id');
        Route::post('update-shifting-info', 'App\Http\Controllers\Shifting\ShiftingController@update')->name('update-shifting-info');
        Route::get('remove-shifting-record/{id}', 'App\Http\Controllers\Shifting\ShiftingController@destroy')->name('remove-shifting-record');
        Route::get('restore-shifting-record/{id}', 'App\Http\Controllers\Shifting\ShiftingController@edit')->name('restore-shifting-record');
        Route::get('get-all-shifting/{id}', 'App\Http\Controllers\Shifting\ShiftingController@getshifting')->name('get-all-shifting');
        Route::get('get-shift/{id}', 'App\Http\Controllers\Shifting\ShiftingController@getshiftbyid')->name('get-shift');

        //Change Unit
        Route::get('change-service-unit-management', 'App\Http\Controllers\Booking\BookingChangeUnit\BookingChangeUnitContoller@index')->name('change-service-unit-management');
        Route::get('get-booking-change-unit', 'App\Http\Controllers\Booking\BookingChangeUnit\BookingChangeUnitContoller@findAllChangeUnit')->name('get-booking-change-unit');

        //Deductions
        Route::get('get-all-deductions/{id}', 'App\Http\Controllers\Deductions\DeductionsController@getdeductionspercompany')->name('get-all-deductions');

        //Purchasing
        Route::get('purchase-request-management', 'App\Http\Controllers\Purchasing\PurchaseRequestController@index')->name('purchase-request-management');
        Route::get('get-purchase-request', 'App\Http\Controllers\Purchasing\PurchaseRequestController@findAllPurchaseRequest')->name('get-purchase-request');
        Route::post('save-new-purchase-request', 'App\Http\Controllers\Purchasing\PurchaseRequestController@store')->name('save-new-purchase-request');
        Route::get('get-purchase-request-by-id/{id}', 'App\Http\Controllers\Purchasing\PurchaseRequestController@show')->name('get-purchase-request-by-id');
        Route::post('approve-purchase-request', 'App\Http\Controllers\Purchasing\PurchaseRequestController@approve')->name('approve-purchase-request');
        Route::get('reject-purchase-request/{id}', 'App\Http\Controllers\Purchasing\PurchaseRequestController@reject')->name('reject-purchase-request');
        Route::get('get-filter-purchase-request', 'App\Http\Controllers\Purchasing\PurchaseRequestController@filterPurchaseRequestBy')->name('get-filter-purchase-request');

        //PO Transaction
        Route::get('get-po-transaction-by-id/{id}', 'App\Http\Controllers\Purchasing\PurchaseOrderTransactionController@show')->name('get-po-transaction-by-id');
        Route::post('update-amount-granted', 'App\Http\Controllers\Purchasing\PurchaseOrderTransactionController@update')->name('update-amount-granted');


        //PO Categories
        Route::get('get-all-po-categories', 'App\Http\Controllers\Purchasing\PoCategoryController@getpocategory')->name('get-all-po-categories');

        //Consolidate
        Route::get('consolidate-request-management', 'App\Http\Controllers\Purchasing\ConsolidateRequestController@index')->name('consolidate-request-management');
        Route::get('get-consolidate-request', 'App\Http\Controllers\Purchasing\ConsolidateRequestController@findAllConsolidateRequest')->name('get-consolidate-request');
        Route::post('save-new-consolidate-request', 'App\Http\Controllers\Purchasing\ConsolidateRequestController@store')->name('save-new-consolidate-request');
        Route::get('get-consolidate-request-by-id/{id}', 'App\Http\Controllers\Purchasing\ConsolidateRequestController@show')->name('get-consolidate-request-by-id');
        Route::post('update-consolidate-request', 'App\Http\Controllers\Purchasing\ConsolidateRequestController@update')->name('update-consolidate-request');
        // Route::get('get-po-transaction-by-id/{id}', 'App\Http\Controllers\Purchasing\ConsolidateRequestController@show')->name('get-po-transaction-by-id');
        Route::get('get-filter-consolidate-request', 'App\Http\Controllers\Purchasing\ConsolidateRequestController@filterConsolidateRequestBy')->name('get-filter-consolidate-request');

        Route::get('approve-consolidate-request-management', 'App\Http\Controllers\Purchasing\ApproveConsolidateRequestController@index')->name('approve-consolidate-request-management');
        Route::get('get-for-review-consolidate-request', 'App\Http\Controllers\Purchasing\ApproveConsolidateRequestController@findAllForReviewConsolidateRequest')->name('get-for-review-consolidate-request');
        Route::get('get-consolidate-image/{reference_no}', 'App\Http\Controllers\Purchasing\ApproveConsolidateRequestController@reviewConsolidateRequestReceipt')->name('get-consolidate-image');
        Route::post('approve-consolidate-receipt', 'App\Http\Controllers\Purchasing\ApproveConsolidateRequestController@approveConsolidateRequestReceipt')->name('approve-consolidate-receipt');
        Route::get('get-filter-review-consolidate-request', 'App\Http\Controllers\Purchasing\ApproveConsolidateRequestController@filterReviewConsolidateRequestBy')->name('get-filter-review-consolidate-request');
        //Supplier
        Route::get('get-all-po-suppliers', 'App\Http\Controllers\Purchasing\SupplierController@getsupplier')->name('get-all-po-suppliers');
    });
});
