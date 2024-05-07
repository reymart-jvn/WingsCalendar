<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class BookingType extends Model
{
    use HasFactory;
    public function bookingInformation()
    {
        return $this->belongsTo('App\Models\BookingInformation');
    }
}
