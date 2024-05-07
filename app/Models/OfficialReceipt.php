<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class OfficialReceipt extends Model
{
    use HasFactory;

    public function vehicleInformationHasOR()
    {
        return $this->belongsTo('App\Models\VehicleInformationHasOrCr');
    }

     public function vehicleInformation()
    {
        return $this->belongsTo('App\Models\VehicleInformation');
    }
}
