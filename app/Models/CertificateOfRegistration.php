<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class CertificateOfRegistration extends Model
{
    use HasFactory;
    
    public function vehicleInformationHasCR()
    {
        return $this->belongsTo('App\Models\VehicleInformationHasOrCr');
    }

    public function vehicleInformation()
    {
        return $this->belongsTo('App\Models\VehicleInformation');
    }
    public function vehicleHasDriver()
    {
       return $this->belongsTo('App\Models\VehicleHasDriver');
    }
}
