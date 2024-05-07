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

    public function passengerHasCompany()
    {
       return $this->belongsTo('App\Models\PassengerHasCompany');
    }

    public function ratePerTrip()
    {
        return $this->hasMany('App\Models\RatePerTrip','company_id','id');
    }
    public function bookingInfo()
    {
        return $this->hasMany('App\Models\BookingInformation','company_id','id');
    
    }

    public function billing()
    {
        return $this->hasMany('App\Models\Billing','company_id','id');
    
    }

    public function holidays()
    {
        return $this->belongsTo('App\Models\Holidays');
    }


    public function bookingGroup()
    {
        return $this->hasMany('App\Models\BookingGroup','company_id','id');
    }

    public function shifting()
    {
        return $this->hasMany('App\Models\Shifting','company_id','id');
    
    }

    public function purchaseRequest()
    {
        return $this->belongsTo('App\Models\PurchaseRequest');
    }

    // public function companyHasDepartment()
    // {
    //     return $this->belongsTo('App\Models\CompanyHasDepartment');
    // }
}
