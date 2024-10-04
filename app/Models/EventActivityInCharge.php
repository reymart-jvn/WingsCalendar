<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class EventActivityInCharge extends Model
{
    use HasFactory;

    public function eventsActivity()
    {
        return $this->belongsTo('App\Models\EventActivity');
    }

    public function personIncharge()
    {
        return $this->hasOne('App\Models\PersonInCharge','id','personincharge_id');
    }

    public function personIncharge2()
    {
        return $this->belongsTo('App\Models\PersonInCharge');
    }

    public function eventsActivity2()
    {
        return $this->hasOne('App\Models\EventActivity','id','event_activity_id');
    }




}
