<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class Package extends Model
{
    use HasFactory;

    protected $fillable = [
        'picture',
        'height',
        'width',
        'depth',
        'weight',
        'weight_unit',
        'measurement_unit',
        'is_breakable',
        'is_flammable',
        'has_fluid',
        'client_id',
    ];


    public function client()
    {
        return $this->belongsTo(Client::class, 'client_id');
    }


    
    public function deliveries()
    {
        return $this->hasMany(Delivery::class, 'packages_id'); 
    }
}
