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
Route::get('test', function () {
        return "test";
})->name('test');

Route::prefix('auth')->group(function () {
        Route::post('/app_login', 'App\Http\Controllers\API\LoginController@login')->name('app_login');
        Route::get('/get-all-event-activity', 'App\Http\Controllers\API\EventActivityController@index');
        Route::get('/get-incharge/{event_activiti_id}/{availability}', 'App\Http\Controllers\API\EventActivityController@assignPersonsInCharge');
        Route::post('/app-registration', 'App\Http\Controllers\API\RegistrationController@store')->name('app-registration');
        Route::post('/app-registration-admin', 'App\Http\Controllers\API\RegistrationAdminController@store')->name('app-registration-admin');
        Route::post('/check-email-if-exist', 'App\Http\Controllers\API\RegistrationController@checkemail');
        Route::post('/check-company-if-exist', 'App\Http\Controllers\API\RegistrationController@checkcompanypasscode');
});

Route::group(['middleware' => ['jwt.auth']], function () {
        Route::namespace('App\Http\Controllers\API')->group(function () {


                Route::prefix('company')->group(function () {
                        Route::get('/get-all-company/{issuperadmin}/{company}', 'CompanyController@index');
                });

                Route::prefix('locations')->group(function () {
                        Route::get('/get-all-locations/{issuperadmin}/{company}', 'LocationsController@index');
                        Route::get('/get-all-locations-by-company/{company}', 'LocationsController@getLocationsByCompany');
                        Route::get('/get-latest-locations/{issuperadmin}/{company}', 'LocationsController@getLatestLocationsData');
                        Route::post('/save-new-location', 'LocationsController@store');
                        Route::post('/update-location', 'LocationsController@update');
                        Route::post('/delete-location', 'LocationsController@destroy');
                });

                Route::prefix('activity')->group(function () {
                        Route::get('/get-all-activity/{issuperadmin}/{company}', 'ActivityController@index');
                        Route::get('/get-all-activity-by-company/{company}', 'ActivityController@getActivityByCompany');
                        Route::get('/get-latest-activity/{issuperadmin}/{company}', 'ActivityController@getLatestActivityData');
                        Route::post('/save-new-activity', 'ActivityController@store');
                        Route::post('/update-activity', 'ActivityController@update');
                        Route::post('/delete-activity', 'ActivityController@destroy');
                });

                Route::prefix('personincharge')->group(function () {
                        Route::get('/get-all-personincharge/{issuperadmin}/{company}', 'PersonInChargeController@index');
                        Route::get('/get-latest-personincharge/{issuperadmin}/{company}', 'PersonInChargeController@getLatestPersonInChargeData');
                        Route::post('/save-new-personincharge', 'PersonInChargeController@store');
                        Route::post('/update-personincharge', 'PersonInChargeController@update');
                        Route::post('/delete-personincharge', 'PersonInChargeController@destroy');
                });

                Route::prefix('eventsactivity')->group(function () {
                        Route::get('/get-all-event-activity/{issuperadmin}/{company}', 'EventActivityController@index');
                        Route::get('/get-today-event-activity/{issuperadmin}/{company}', 'EventActivityController@getTodayEventsActivity');
                        Route::get('/get-today-event-activity-by-user', 'EventActivityController@getTodayEventsActivityByUser');
                        Route::get('/get-month-event-activity/{issuperadmin}/{company}', 'EventActivityController@getMonthEventsActivity');
                        Route::get('/get-month-event-activity-by-company/{id}', 'EventActivityController@getMonthEventsActivityByCompany');
                        Route::post('/save-new-events-activity', 'EventActivityController@store');
                        Route::post('/cancel-events-activity', 'EventActivityController@cancelEventActivity');
                        Route::get('/get-daterange-event-activity/{from}/{to}', 'EventActivityController@getEventsActivityDateRange');
                });
        });
});
