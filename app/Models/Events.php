<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class Events extends Model
{
    use HasFactory;

    public function eventsActivity()
    {
        return $this->belongsTo('App\Models\EventActivity');
    }

    public function eventsActivityWeb()
    {
        return $this->hasOne('App\Models\EventActivity','event_id','id');
    }

    public function company()
    {
        return $this->hasOne('App\Models\CompanyProfile','id','company_id');
    }
    
}
