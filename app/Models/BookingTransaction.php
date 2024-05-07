<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class BookingTransaction extends Model
{
    use HasFactory;
    // protected $fillable = [
    //     'id'
    // ];

    public function bookingInfo()
    {
        return $this->belongsTo('App\Models\BookingInformation');
    
    }
    public function bookingInformation()
    {
        return $this->hasOne('App\Models\BookingInformation','id','booking_info_id');
    
    }
    public function passengerInformation()
    {
        return $this->hasOne('App\Models\PassengerInformation', 'id', 'passenger_info_id');
    
    }
}
