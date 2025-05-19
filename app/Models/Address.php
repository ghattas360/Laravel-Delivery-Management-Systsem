<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Factories\HasFactory;

class Address extends Model
{
    use HasFactory;
    protected $fillable = [
    'street',
    'house_number',
    'zip_code',
    'type',
    'floor',
    'region_id',
];

    public function clients()
    {
        return $this->belongsToMany(Client::class, 'client_address', 'address_id', 'client_id');
    }

    public function region()
    {
        return $this->belongsTo(Region::class, 'region_id');
    }

    public function drivers()
    {
        return $this->hasMany(Driver::class, 'address_id');
    }

    public function employees()
    {
        return $this->hasMany(Employee::class, 'address_id');
    }

    public function deliveriesAsPickup()
    {
        return $this->hasMany(Delivery::class, 'takeOf_Address_id');
    }

    public function deliveriesAsDropoff()
    {
        return $this->hasMany(Delivery::class, 'dropOf_Address_id');
    }
}