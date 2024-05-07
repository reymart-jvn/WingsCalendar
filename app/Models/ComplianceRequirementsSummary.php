<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class ComplianceRequirementsSummary extends Model
{
    use HasFactory;

    public function complianceRequirementsList(){
        return $this->hasMany('App\Models\ComplianceRequirements','com_req_summary_id','id');
    }

    public function driversCompliance(){
        return $this->belongsTo('App\Models\DriverHasComplinace');
    }
}
