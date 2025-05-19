<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Factories\HasFactory;

class Payment extends Model
{
    use HasFactory;

    public function getSubjectDeliveryPayement(){
        return $this->belongsTo(Delivery::class, 'delivery_id', 'id');
    }

}
