<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class EventActivity extends Model
{
    use HasFactory;
    public function events()
    {
        return $this->hasOne('App\Models\Events','id','event_id');
    }

    public function eventActivityInCharge()
    {
        return $this->hasMany('App\Models\EventActivityInCharge','event_activity_id','id');
    }

    public function activity_location()
    {
        return $this->hasOne('App\Models\ActivityLocation','id','activity_location_id');
    }

    public function eventActivityInCharge2()
    {
        return $this->belongsTo('App\Models\EventActivityInCharge');
    }

    public function eventsWeb()
    {
        return $this->belongsTo('App\Models\Events');
    }
}
