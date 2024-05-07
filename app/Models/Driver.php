<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Foundation\Auth\User as Authenticatable;
use Laravel\Passport\HasApiTokens;

class Driver extends Authenticatable
{
    // use HasFactory;
    use HasApiTokens;

    /**
     * Find the driver instance for the given username.
     *
     * @param  string  $username
     * @return \App\Models\Driver|null
     */
    public function findForPassport($username)
    {
        return $this->where('code', $username)->first();
    }

    public function driverHasCompliance()
    {
        return $this->hasOne('App\Models\DriversHasCompliance','drivers_id','id');
    }
    // public function driverHasCompliance(){
    //     return $this->hasOne(DriversHasCompliance::class, 'drivers_id');
    // }
    // public function driversHasRequirements(){
    //     return $this->hasOne(DriverHasRequirements::class, 'drivers_id');
    // }

    public function driversHasRequirements()
    {
        return $this->hasMany('App\Models\DriverHasRequirements','drivers_id','id');
    }

    public function vehicleHasDriver()
    {
       return $this->belongsTo('App\Models\VehicleHasDriver');
    }

    public function vehicleHasDriver2()
    {
       return $this->hasOne('App\Models\VehicleHasDriver','driver_id','id');
    }

    public function bookingHasVehicleDriver()
    {
        return $this->belongsTo('App\Models\BookingHasVehicleDriver');
    
    }

    public function changeUnit()
    {
       return $this->belongsTo('App\Models\ChangeServiceUnit');
    }

    
}
