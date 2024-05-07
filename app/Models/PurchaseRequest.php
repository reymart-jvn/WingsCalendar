<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class PurchaseRequest extends Model
{
    use HasFactory;
    
    public function purchaseRequestProgress()
    {
       return $this->hasMany('App\Models\PurchaseRequestProgress','pr_id','id');
    }

    public function purchaseOrderTransaction()
    {
        return $this->belongsTo('App\Models\PurchaseOrderTransaction');
    }

    public function purchaseOrderTransactionForDisplay()
    {
        return $this->hasOne('App\Models\PurchaseOrderTransaction','pr_id','id');
    }

    public function purchaseRequestHasVehicleAndDriver()
    {
        return $this->hasOne('App\Models\VehicleHasDriver','driver_id','driver_id');
    }   

    public function companyProfile()
    {
        return $this->hasOne('App\Models\CompanyProfile','id','company_id');
    }

    public function consolidateRequest()
    {
        return $this->hasOne('App\Models\ConsolidatePurchaseOrder','po_id','id');
    }
   
}
