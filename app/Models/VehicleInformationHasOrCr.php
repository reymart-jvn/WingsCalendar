<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class VehicleInformationHasOrCr extends Model
{
    use HasFactory;

    public function officialReceipt()
    {
       return $this->hasOne('App\Models\OfficialReceipt','id','or_id');
    }

    public function certificateOfRegistration()
    {
       return $this->hasOne('App\Models\CertificateOfRegistration','id','cr_id');
    }

    public function vehicleInfo()
    {
       return $this->hasOne('App\Models\VehicleInformation','id','vehicle_info_id');
    }


}
