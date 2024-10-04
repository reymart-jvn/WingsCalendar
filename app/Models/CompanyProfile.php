<?php

namespace App\Models;
use Illuminate\Database\Eloquent\Model;

class CompanyProfile extends Model
{

    public function departments()
    {
        return $this->hasMany('App\Models\Department');
    }

    public function personHasCompany()
    {
        return $this->belongsTo('App\Models\PersonHasCompanyDepartment');
    }

    public function permissionHasAccess()
    {
        return $this->belongsTo('App\Models\PermissionHasAccess');
    }

    public function activity()
    {
       return $this->belongsTo('App\Models\Activity');
    }

    public function events()
    {
        return $this->belongsTo('App\Models\Events');
    }

    public function locations()
    {
        return $this->belongsTo('App\Models\Locations');
    }

    public function eventActivityInCharge()
    {
        return $this->belongsTo('App\Models\EventActivityInCharge');
    }

    public function personincharge()
    {
        return $this->belongsTo('App\Models\PersonInCharge');
    }




 

 


  

  
  



    // public function companyHasDepartment()
    // {
    //     return $this->belongsTo('App\Models\CompanyHasDepartment');
    // }
}
