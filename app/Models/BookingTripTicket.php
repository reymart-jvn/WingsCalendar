<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class BookingTripTicket extends Model
{
    use HasFactory;
    public function bookingInfo()
    {
        return $this->belongsTo('App\Models\BookingInformation');
    
    }
}
