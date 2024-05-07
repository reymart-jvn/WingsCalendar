<?php

namespace App\Models;

// use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class VehicleType extends Model
{

    protected $hidden = ["created_at", "updated_at"];


    public function vehicleInformation()
    {
        return $this->belongsTo('App\Models\VehicleInformation');
    }

}
