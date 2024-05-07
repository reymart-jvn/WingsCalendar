<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class ComplianceRequirements extends Model
{

    public function requirements(){
        return $this->hasOne('App\Models\Requirements','id','requirements_id');
    }
    public function complianceRequirementsSummary(){
        return $this->belongsTo('App\Models\ComplianceRequirementsSummary');
    }
    public function driversHasRequirements(){
        return $this->belongsTo('App\Models\DriversHasRequirements');
    }


}
