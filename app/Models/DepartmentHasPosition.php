<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class DepartmentHasPosition extends Model
{
    use HasFactory;
    public function department()
    {
       return $this->belongsTo('App\Models\Department');
    }

    public function position()
    {
       return $this->hasOne('App\Models\Position','id','position_id');
    }
}
