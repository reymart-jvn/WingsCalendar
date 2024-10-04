<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class ActivityLocation extends Model
{
    use HasFactory;
    public function activityLocation()
    {
        return $this->belongsTo('App\Models\ActivityLocation');
    }

    public function activity()
    {
        return $this->hasOne('App\Models\Activity','id','activity_id');
    }

    public function location()
    {
        return $this->hasOne('App\Models\Locations','id','location_id');
    }
}
