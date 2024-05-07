<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class VehicleHasDriver extends Model
{
    use HasFactory;

    public function vehicleInformation()
    {
        return $this->belongsTo('App\Models\VehicleInformation');
    }

    public function driver()
    {
        return $this->hasOne('App\Models\Driver','id','driver_id');
    }
    public function vehicleDevice()
    {
        return $this->hasOne('App\Models\VehicleHasDevice','vehicle_id','vehicle_id');
    }

    public function certificateOfRegistration()
    {
       return $this->hasOne('App\Models\CertificateOfRegistration','vehicle_id','vehicle_id');
    }

    public function changeUnit()
    {
        return $this->belongsTo('App\Models\ChangeServiceUnit');
    
    }

    public function purchaseRequest()
    {
        return $this->belongsTo('App\Models\PurchaseRequest');
    }

}
