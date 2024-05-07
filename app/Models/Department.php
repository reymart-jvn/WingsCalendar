<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class Department extends Model
{
    use HasFactory;
    public function companyProfile()
    {
        return $this->belongsTo('App\Models\CompanyProfile');
    }

    public function companyHasDepartment()
    {
        return $this->belongsTo('App\Models\CompanyHasDepartment');
    }

    public function personHasDepartment()
    {
        return $this->belongsTo('App\Models\PersonHasCompanyDepartment');
    }

    public function departmentHasPosition()
    {
        return $this->hasMany('App\Models\DepartmentHasPosition','department_id','id');
    }

    public function permissionHasAccess()
    {
        return $this->belongsTo('App\Models\PermissionHasAccess');
    }

    // public function permissionHasAccess(){
    //     return $this->hasOne(PermissionHasAccess::class, 'permission_id');
    // }
}
