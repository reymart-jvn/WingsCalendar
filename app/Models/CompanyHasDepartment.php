<?php

namespace App\Models;

// use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class CompanyHasDepartment extends Model
{
   //  use HasFactory;

    public function departmentsInfo()
    {
       return $this->hasOne('App\Models\Department','id','department_id');
    }

    public function companyProfile()
    {
       return $this->hasOne('App\Models\CompanyProfile','id','company_id');
    }
}
