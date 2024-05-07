<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class PurchaseRequestProgress extends Model
{
    use HasFactory;
    public function purchaseRequest()
    {
        return $this->belongsTo('App\Models\PurchaseRequest');
    }
}
