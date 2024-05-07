<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class VehiclHasDriver extends Model
{
    use HasFactory;
    public function vehicleInformation()
    {
        return $this->belongsTo('App\Models\VehicleInformation');
    }

    public function driver()
    {
        return $this->belongsTo('App\Models\Driver');
    }

    public function vehicleInformation2()
    {
        return $this->hasOne('App\Models\VehicleInformation','id','vehicle_id');
    }

    public function vehicleHasDevice()
    {
       return $this->hasOne('App\Models\VehicleHasDevice','vehicle_id','vehicle_id');
    }

    
}
