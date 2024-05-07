<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class Position extends Model
{
    use HasFactory;

    public function departmentHasPosition()
    {
        return $this->belongsTo('App\Models\DepartmentHasPosition');
    }

    public function permissionHasAccess()
    {
        return $this->belongsTo('App\Models\PermissionHasAccess');
    }

    public function employeeHasPosition()
    {
       return $this->belongsTo('App\Models\EmployeeHasPosition');
    }

}
