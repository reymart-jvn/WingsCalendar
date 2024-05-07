<?php

namespace App\Models;
use Illuminate\Database\Eloquent\Model;

class PermissionHasAccess extends Model
{
    public function permission(){
        return $this->belongsTo(Permission::class, 'id');
    }

    
    // public function access(){
    //     return $this->belongsTo(Access::class, 'id');
    // }
    public function access()
    {
       return $this->hasOne('App\Models\Access','id','access_id');
    }

    public function companyProfile()
    {
       return $this->hasOne('App\Models\CompanyProfile','id','company_id');
    }

    public function department()
    {
       return $this->hasOne('App\Models\Department','id','department_id');
    }

    public function position()
    {
       return $this->hasOne('App\Models\Position','id','position_id');
    }

    public function employeePositionHasPermissionAccess()
    {
       return $this->belongsTo('App\Models\EmpPosHasPermissionAccess');
    }

    

}
