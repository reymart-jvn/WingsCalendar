<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class CompanyHasPersonIncharge extends Model
{
    use HasFactory;

    public function companyProfile()
    {
       return $this->hasOne('App\Models\CompanyProfile','id','company_id');
    }

}
