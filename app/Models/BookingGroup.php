<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class BookingGroup extends Model
{
    use HasFactory;
    public function company()
    {
       return $this->belongsTo('App\Models\CompanyProfile');
    }

    public function bookingInformation()
    {
        return $this->hasMany('App\Models\BookingInformation','booking_group_id','id')->where('status','1');
    
    }
}
