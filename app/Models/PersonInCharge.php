<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class PersonInCharge extends Model
{
    use HasFactory;

    public function eventActivityInCharge()
    {
        return $this->hasMany('App\Models\EventActivityInCharge','personincharge_id','id');
    }

    public function company()
    {
        return $this->hasOne('App\Models\CompanyProfile','id','company_id');
    }

}
