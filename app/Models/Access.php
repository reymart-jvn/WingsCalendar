<?php

namespace App\Models;


use Illuminate\Database\Eloquent\Model;

class Access extends Model
{
    public function permissionHasAccess()
    {
        return $this->belongsTo('App\Models\PermissionHasAccess');
    }
    // public function permissionHasAccess(){
    //     return $this->hasOne(PermissionHasAccess::class, 'access_id');
    // }
}
