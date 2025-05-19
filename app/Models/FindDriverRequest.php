<?php

namespace App\Models;
use App\Models\DriverOffer;
use App\Models\Delivery;
use Illuminate\Http\Request;


use Illuminate\Database\Eloquent\Model;

class FindDriverRequest extends Model
{
    protected $fillable = ['package_id', 'takeof_address_id', 'dropof_address_id', 'scheduled_at'];

    public function package() {
        return $this->belongsTo(Package::class);
    }

    public function offers() {
        return $this->hasMany(DriverOffer::class);
    }
    public function takeofAddress()
{
    return $this->belongsTo(Address::class, 'takeof_address_id');
}

     public function dropoffAddress()
{
    return $this->belongsTo(Address::class, 'dropof_address_id');
}
 



}