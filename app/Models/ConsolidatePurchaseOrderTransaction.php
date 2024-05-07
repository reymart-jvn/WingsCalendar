<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class ConsolidatePurchaseOrderTransaction extends Model
{
    use HasFactory;

    public function consolidatePurchaseOrder()
    {
        return $this->belongsTo('App\Models\ConsolidatePurchaseOrder');
    }

    
}
