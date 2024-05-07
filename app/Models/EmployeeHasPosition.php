<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class EmployeeHasPosition extends Model
{
    public function employee()
    {
       return $this->belongsTo('App\Models\Employee');
    }

    public function position()
    {
       return $this->hasOne('App\Models\Position','id','position_id');
    }

    public function employeePositionHasPermissionAccess()
    {
       return $this->hasOne('App\Models\EmpPosHasPermissionAccess','employee_has_position_id','id');
    }
}
