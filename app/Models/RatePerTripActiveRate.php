<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class RatePerTripActiveRate extends Model
{
    use HasFactory;


    public function ratePerTrip()
    {
        return $this->hasOne('App\Models\RatePerTrip','id','rate_per_trip_id');
    }

    public function bookingHasTripRate()
    {
       return $this->belongsTo('App\Models\BookingHasTripRate');
    }

}
