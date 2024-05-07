<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class ConsolidatePurchaseOrder extends Model
{
    use HasFactory;
    public function purchaseOrderTransaction()
    {
        return $this->belongsTo('App\Models\PurchaseOrderTransaction');
    }

    public function consolidatePurchaseTransactions()
    {
        return $this->hasOne('App\Models\ConsolidatePurchaseOrderTransaction','consolidate_id','id');
    }

    public function purchaseOrderTransactionVersionOne()
    {
       return $this->hasOne('App\Models\PurchaseOrderTransaction','id','po_id');
    }

    public function consolidatePurchaseOrderImage()
    {
        return $this->hasOne('App\Models\ConsolidatePOImage','consolidate_id','id');
    }

    public function consolidatePurchaseOrderHasSupplier()
    {
       return $this->hasOne('App\Models\ConsolidatePurchaseOrderHasSupplier','consolidate_id','id');
    }

    public function purchaseRequest()
    {
        return $this->belongsTo('App\Models\PurchaseRequest');
    }

    
}
