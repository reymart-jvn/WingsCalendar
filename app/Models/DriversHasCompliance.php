<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class DriversHasCompliance extends Model
{

    public function drivers(){
        return $this->belongsTo('App\Models\Drivers');
    }

    public function complianceRequirementsSummary(){
        return $this->hasOne('App\Models\ComplianceRequirementsSummary', 'id','compliance_id');
    }
    public function driverHasRequirements(){
        return $this->belongsTo('App\Models\DriverHasRequirements');
    }
}
