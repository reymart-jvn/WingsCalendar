<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class BookingHasVehicleDriver extends Model
{
    use HasFactory;
    public function bookingInfo()
    {
        return $this->belongsTo('App\Models\BookingInformation');
    
    }

    public function vehicle()
    {
        return $this->hasOne('App\Models\VehicleInformation','id','vehicle_id');
    
    }

    public function appBookingInfo()
    {
        return $this->hasMany('App\Models\BookingInformation','id','booking_id');
    
    }

    public function driver()
    {
        return $this->hasOne('App\Models\Driver','id','driver_id');
    
    }

    public function rate()
    {
        return $this->hasOne('App\Models\BookingHasTripRate','booking_info_id','booking_id');
    
    }
    public function changeUnit()
    {
        return $this->hasOne('App\Models\ChangeServiceUnit','booking_id','booking_id');
    
    }
}
