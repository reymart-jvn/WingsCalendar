<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class RatePerTrip extends Model
{
    use HasFactory;
    public function company()
    {
       return $this->belongsTo('App\Models\CompanyProfile');
    }

    public function bookingHasRate()
    {
       return $this->belongsTo('App\Models\BookingHasTripRate');
    }

   
    public function activeRatePerTrip()
    {
       return $this->belongsTo('App\Models\RatePerTripActiveRate');
    }


}
