<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class PersonHasCompanyDepartment extends Model
{

   public function personsInfo()
    {
       return $this->belongsToMany('App\Models\Person');
    }

    public function departmentsInfo()
    {
       return $this->hasOne('App\Models\Department','id','department_id');
    }

    public function companyProfile()
    {
       return $this->hasOne('App\Models\CompanyProfile','id','company_id');
    }

    public function usersInfo()
    {
       return $this->hasOne('App\Models\User','person_id','person_id');
    }
}
