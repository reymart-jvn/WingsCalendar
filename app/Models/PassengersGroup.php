<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class PassengersGroup extends Model
{
    use HasFactory;
    public function passengerGroupSummary()
    {
       return $this->belongsTo('App\Models\PassengerHasGroupSummary');
    }

    public function passengerInformation()
    {
       return $this->hasOne('App\Models\PassengerInformation','id','passenger_id');
    }
}
