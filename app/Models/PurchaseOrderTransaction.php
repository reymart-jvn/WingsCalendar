<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class PurchaseOrderTransaction extends Model
{
    use HasFactory;
    public function purchaseRequest()
    {
       return $this->hasOne('App\Models\PurchaseRequest','id','pr_id');
    }

    public function consolidatePurchaseOrders()
    {
       return $this->hasOne('App\Models\ConsolidatePurchaseOrder','po_id','id');
    }

    public function consolidatePurchaseOrdersVesionOne()
    {
       return $this->belongsTo('App\Models\ConsolidatePurchaseOrder');
    }

    public function purchaseRequestForDisplay()
    {
        return $this->belongsTo('App\Models\PurchaseRequest');
    }
}
