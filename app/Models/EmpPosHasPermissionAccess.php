<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class EmpPosHasPermissionAccess extends Model
{
    public function employeeHasPosition()
    {
       return $this->belongsTo('App\Models\EmployeeHasPosition');
    }
    
    public function permissionHasAccess()
    {
       return $this->hasOne('App\Models\PermissionHasAccess','id','permission_has_access_id');
    }
}
