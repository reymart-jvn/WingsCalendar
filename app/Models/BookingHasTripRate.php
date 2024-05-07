<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class BookingHasTripRate extends Model
{
    use HasFactory;
    public function bookingInfo()
    {
        return $this->belongsTo('App\Models\BookingInformation');
    }
    // public function bookingHasTripRate()
    // {
    //     return $this->belongsTo('App\Models\BookingHasTripRate');
    // }
    public function tripRate()
    {
        return $this->hasOne('App\Models\RatePerTrip','id','rate_id');
    
    }

    public function activeTripRate()
    {
        return $this->hasOne('App\Models\RatePerTripActiveRate','id','active_rate_id');
    
    }
   
}
