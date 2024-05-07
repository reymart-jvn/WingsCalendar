<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class Requirements extends Model
{
    use HasFactory;
    public function complianceRequirements(){
        $this->hasMany(ComplianceRequirements::class, 'requirements_id');
    }
}
