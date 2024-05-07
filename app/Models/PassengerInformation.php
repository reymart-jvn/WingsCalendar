<?php

namespace App\Models;


use Illuminate\Database\Eloquent\Model;

class PassengerInformation extends Model
{
    public function passengerHasCompany()
    {
       return $this->hasOne('App\Models\PassengerHasCompany','passenger_information_id','id');
    }

    public function section()
    {
       return $this->hasOne('App\Models\Section','id','section_id');
    }

    public function passengerGroup()
    {
       return $this->belongsTo('App\Models\PassengersGroup');
    }

    public function bookingTransaction()
    {
       return $this->belongsTo('App\Models\BookingTransaction');
    }
}
