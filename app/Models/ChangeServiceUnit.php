<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class ChangeServiceUnit extends Model
{
    use HasFactory;

    public function bookingInfo()
    {
        return $this->belongsTo('App\Models\BookingInformation');
    
    }

    public function backupdriver()
    {
        return $this->hasOne('App\Models\Driver','id','backup_driver_id');
    }

    public function previousdriver()
    {
        return $this->hasOne('App\Models\Driver','id','previous_driver_id');
    }

    public function bookingInfoV2()
    {
        return $this->hasOne('App\Models\BookingInformation','id','booking_id');
    }

    public function bookingHasDriver()
    {
        return $this->belongsTo('App\Models\BookingHasVehicleDriver');
    
    }

    public function vehicleHasDriver()
    {
        return $this->hasOne('App\Models\VehicleHasDriver','driver_id','backup_driver_id');
    }




}
