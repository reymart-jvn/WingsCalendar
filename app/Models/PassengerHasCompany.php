<?php

namespace App\Models;
use Illuminate\Database\Eloquent\Model;

class PassengerHasCompany extends Model
{
    public function companyProfile()
    {
       return $this->hasOne('App\Models\CompanyProfile','id','company_id');
    }
    
    public function passengerInformation()
    {
        return $this->belongsTo('App\Models\PassengerInformation');
    }

    public function bookingTransaction()
    {
       return $this->hasMany('App\Models\BookingTransaction','passenger_info_id','passenger_information_id');
    }

    

}
