<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class DriverHasRequirements extends Model
{

    public function complianceRequirements(){
        return $this->hasOne('App\Models\ComplianceRequirements','id','compliance_req_id');
    }
    public function drivers(){
        return $this->belongsTo('App\Models\DriverHasRequirements');
    }
    public function driversHasCompliance(){
        return $this->hasOne('App\Models\DriversHasCompliance','drivers_id','drivers_id');
    }

}
