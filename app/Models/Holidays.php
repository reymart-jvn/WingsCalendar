<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class Holidays extends Model
{
    use HasFactory;
    public function companyProfiles()
    {
       return $this->hasOne('App\Models\CompanyProfile','id','company_id');
    }
}
