<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class Client extends Model
{
    use HasFactory;

    const CREATED_AT = 'created_on';
    const UPDATED_AT = 'updated_on';

    protected $fillable = [
        'first_name', 
        'last_name', 
        'age', 
        'phone', 
        'email',
        'premium_level', 
        'user_name', 
        'password', 
        'user_id'
    ];

    /**
     * Relationship to the User model
     */
    public function user()
    {
        return $this->belongsTo(User::class);
    }

    /**
     * Relationship to the Package model
     */
    public function packages()
    {
        return $this->hasMany(Package::class);
    }

    /**
     * Relationship to the SocialMediaAccount model
     */
    public function socialMediaAccounts()
    {
        return $this->hasMany(SocialMediaAccount::class, 'clients_id');
    }
    public function messages()
    {
        return $this->hasMany(Message::class);
    }


    /**
     * Relationship to the Address model through pivot table
     */
    public function addresses()
    {
        return $this->belongsToMany(
            Address::class,
            'client__addresses', // Recommended: use snake_case for table names
            'clients_id',
            'addresses_id'
        );
    }

    /**
     * Relationship to the Review model
     */
    public function reviews()
    {
        return $this->hasMany(Review::class, 'clients_id');
    }
}