<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class VehicleHasDevice extends Model
{
    use HasFactory;
    public function vehicleInfo()
    {
       return $this->belongsTo('App\Models\VehicleInformation');
    }
    public function vehicleDriver()
    {
        return $this->belongsTo('App\Models\VehicleHasDriver');
    }
    
    public function travelHistory()
    {
        return $this->hasMany('App\Models\TravelHistory','vehicle_device_id','id');
    }

    public function vehicleCR()
    {
        return $this->hasOne('App\Models\VehicleInformationHasOrCr','vehicle_info_id','vehicle_id');
    }



}
