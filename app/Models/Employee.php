<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class Employee extends Model
{
    public function user()
    {
       return $this->belongsTo('App\Models\User');
    }
    public function employeeHasPosition()
    {
       return $this->hasOne('App\Models\EmployeeHasPosition','employee_id','id');
    }
    
}
