<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class Person extends Model
{
    // public function person_department_position()
    // {
    //     return $this->hasOne('App\Ecabs\PersonDepartmentPosition', 'person_id', 'id');
    // }

    public function user()
    {
        return $this->hasOne('App\Models\User', 'person_id', 'id');
    }

    public function personCompanyDepartment()
    {
        return $this->hasOne('App\Models\PersonHasCompanyDepartment', 'person_id', 'id');
    }
}
