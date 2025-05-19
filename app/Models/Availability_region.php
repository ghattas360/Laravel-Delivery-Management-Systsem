<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;

class availability_Region extends Model
{
    //
    public function getRegionAvailability()
{
    return $this->belongsToMany(Region::class, 'availability__regions', 'availabilities_id', 'regions_id');
}

}
