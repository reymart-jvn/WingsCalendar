<?php

namespace App\Models;


use Illuminate\Database\Eloquent\Model;

class Permission extends Model
{

    // public function permissionHasAccess(){
    //     return $this->hasOne(PermissionHasAccess::class, 'permission_id');
    // }
    public function permissionHasAccess()
    {
       return $this->hasOne('App\Models\PermissionHasAccess','permission_id','id');
    }
}
