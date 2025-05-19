<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Factories\HasFactory;

class Availability extends Model
{
    use HasFactory;

    public function getSubjectDriverAvailability()
    {
        return $this->belongsTo(Driver::class, 'drivers_id','id');
    }

    public function shift()
    {
        return $this->belongsTo(Shift::class, 'shifts_id');
    }


    public function getRegionAvailability()
    {
        return $this->belongsToMany(Region::class,
                                    'availability__regions',
                            'availabilities_id',
                            'regions_id');
    }
    public function driver()
{
    return $this->belongsTo(Driver::class, 'drivers_id');
}

public function shift()
{
    return $this->belongsTo(Shift::class, 'shifts_id');
}

public function regions()
{
    return $this->belongsToMany(Region::class, 'availability__regions', 'availabilities_id', 'regions_id');
}


}
