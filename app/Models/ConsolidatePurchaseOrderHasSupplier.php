<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class ConsolidatePurchaseOrderHasSupplier extends Model
{
    use HasFactory;
    public function consolidatePurchaseOrder()
    {
        return $this->belongsTo('App\Models\ConsolidatePurchaseOrder');
    }

    public function supplier()
    {
        return $this->hasOne('App\Models\Supplier','id','supplier_id');
    }
}
