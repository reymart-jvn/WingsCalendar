<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class BookingInformation extends Model
{
    use HasFactory;

    public function bookingType()
    {
        return $this->hasOne('App\Models\BookingType', 'id', 'booking_type_id');
    }
    public function bookingTransaction()
    {
        return $this->hasMany('App\Models\BookingTransaction','booking_info_id','id')->where('status','1');
    
    }
    public function tripDestinations()
    {
        return $this->hasMany('App\Models\TripDestination','booking_info_id','id')->where('status','1');
    
    }
    public function company()
    {
        return $this->belongsTo('App\Models\CompanyProfile');
    }

    public function bookingHasRate()
    {
        return $this->hasOne('App\Models\BookingHasTripRate','booking_info_id','id');
    
    }
    
    public function bookingHasVehicleDriver()
    {
        return $this->hasOne('App\Models\BookingHasVehicleDriver','booking_id','id');
    
    }

    public function bookingTripTickets()
    {
        return $this->hasOne('App\Models\BookingTripTicket','booking_info_id','id');
    
    }

    public function appbookingHasDriver()
    {
        return $this->belongsTo('App\Models\BookingHasVehicleDriver');
    
    }

    public function bookingTransactionForReports()
    {
        return $this->belongsTo('App\Models\BookingTransaction');
    
    }

    public function bookingGroup()
    {
        return $this->belongsTo('App\Models\BookingGroup');
    
    }

    public function changeUnit()
    {
        return $this->hasOne('App\Models\ChangeServiceUnit','booking_id','id');
    }

    public function changeUnitV2()
    {
        return $this->belongsTo('App\Models\ChangeServiceUnit');
    }

    public function travelHistory()
    {
        return $this->hasOne('App\Models\TravelHistory','booking_id','id');
    }


}
