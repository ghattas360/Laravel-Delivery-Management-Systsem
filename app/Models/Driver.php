<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Notifications\Notifiable;
class Driver extends Model
{
    use HasFactory;
    use Notifiable;

    protected $fillable = [
        'username',
        'password',
        'first_name',
        'last_name',
        'age',
        'phone',
        'email',
        'driving_license',
        'path1',
        'national_id',
        'path2',
        'plate_number',
        'pricing_model',
        'is_active',
        'user_id',
        'latitude',
        'longitude',
    ];

    public function user()
    {
        return $this->belongsTo(User::class);
    }
    public function address()
    {
        return $this->belongsTo(Address::class, 'address_id');
    }

    public function availabilities()
    {
        return $this->hasMany(Availability::class, 'drivers_id', 'id');
    }



    public function deliveries()
    {
        return $this->hasMany(Delivery::class, 'drivers_id');
    }
    public function getDeliveries()
    {
        return $this->hasMany(Delivery::class, 'drivers_id', 'id');
    }

    public function messages()
    {
        return $this->hasMany(Message::class);
    }


    public function reviews()
    {
        return $this->hasManyThrough(
            Review::class,
            Delivery::class,
            'drivers_id', // FK on Delivery
            'deliveries_id' // FK on Review
        );
    }
    public function shift()
    {
        return $this->belongsTo(Shift::class, 'shifts_id');
    }
}
