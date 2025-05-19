<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Factories\HasFactory;

class Delivery extends Model
{
    use HasFactory;

    public function driver()
    {
        return $this->belongsTo(Driver::class, 'drivers_id');
    }

    public function takeOffAddress()
    {
        return $this->belongsTo(Address::class, 'takeOf_Address_id');
    }

    public function dropOffAddress()
    {
        return $this->belongsTo(Address::class, 'dropOf_Address_id');
    }
    public function package()
    {
        return $this->belongsTo(Package::class, 'packages_id');
    }

    public function reviews()
    {
        return $this->hasMany(Review::class, 'deliveries_id');
    }



    public function payments()
    {
        return $this->hasMany(Payment::class, 'deliveries_id');
    }
      public function takeOfAddress()
    {
        return $this->belongsTo(Address::class, 'takeOf_Address_id', 'id');
    }

    public function dropOfAddress()
    {
        return $this->belongsTo(Address::class, 'dropOf_Address_id', 'id');
    }



    

}
