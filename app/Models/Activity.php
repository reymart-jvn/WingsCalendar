<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class Activity extends Model
{
    use HasFactory;

    public function activityLocation()
    {
        return $this->belongsTo('App\Models\ActivityLocation');
    }

    public function company()
    {
        return $this->hasOne('App\Models\CompanyProfile','id','company_id');
    }
}
