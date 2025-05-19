<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Factories\HasFactory;

class Region extends Model
{
    use HasFactory;

    protected $fillable = [
        'country', 'state', 'city', 'region_name', 'created_on'
    ];

    // Relationship to addresses in the region
    public function getRegionAddress()
    {
        return $this->hasMany(Address::class);
    }

    // Relationship to availabilities in the region
    public function getAvailabilities()
    {
        return $this->belongsToMany(Availability::class, 'availability__regions', 'regions_id', 'availabilities_id');
    }
}
