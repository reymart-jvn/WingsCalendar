<?php

namespace App\Models;

// use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class VehicleInformation extends Model
{
    // use HasFactory;
    public function certificateOfRegistration()
    {
      //edited to hasOne
       return $this->hasOne('App\Models\CertificateOfRegistration','vehicle_id','id');
    }
    public function officialReceipt()
    {
       return $this->hasMany('App\Models\OfficialReceipt','vehicle_id','id');
    }
    public function vehicleType()
    {
       return $this->hasOne('App\Models\VehicleType','id','vehicle_types_id');
    }   
    public function vehicleHasOrCr()
    {
       return $this->belongsTo('App\Models\VehicleInformationHasOrCr');
    }

    public function vehicleHasDriver()
    {
       return $this->hasOne('App\Models\VehicleHasDriver','vehicle_id','id');
    }

    public function bookingHasVehicleDriver()
    {
        return $this->belongsTo('App\Models\BookingHasVehicleDriver');
    
    }

    public function vehicleHasDevice()
    {
       return $this->hasOne('App\Models\VehicleHasDevice','vehicle_id','id');
    }

    public function vehicleDriver()
    {
        return $this->belongsTo('App\Models\VehicleHasDriver');
    }



}
