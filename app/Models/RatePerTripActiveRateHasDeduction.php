<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class RatePerTripActiveRateHasDeduction extends Model
{
    use HasFactory;

    public function deductions()
    {
        return $this->hasOne('App\Models\Deduction','id','deduction_id');
    }

}

