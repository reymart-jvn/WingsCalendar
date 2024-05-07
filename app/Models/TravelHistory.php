<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class TravelHistory extends Model
{
    use HasFactory;
    public function bookingInformation()
    {
        return $this->hasOne('App\Models\BookingInformation','id','booking_id');
    }

    public function bookingInformation2()
    {
        return $this->belongsTo('App\Models\BookingInformation','id','booking_id');
    }


}
