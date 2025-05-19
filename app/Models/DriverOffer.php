<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;
class DriverOffer extends Model
{
    protected $fillable = ['driver_id', 'find_driver_request_id', 'price', 'currency', 'payment_method'];

    public function request() {
        return $this->belongsTo(FindDriverRequest::class, 'find_driver_request_id');
    }

    public function driver() {
        return $this->belongsTo(Driver::class);
    }
}
