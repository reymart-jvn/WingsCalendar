<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class PassengerHasGroupSummary extends Model
{
    use HasFactory;
    public function passengerGroup()
    {
       return $this->hasMany('App\Models\PassengersGroup','passenger_group_summary_id','id');
    }
}
