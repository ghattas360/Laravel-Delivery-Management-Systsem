<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;

class Message extends Model
{
    protected $fillable = [
        'driver_id',
        'admin_id',
        'client_id',
        'message',
        'is_from_admin',
    ];


    public function messages()
    {
        return $this->hasMany(Message::class);
    }

    public function client()
    {
        return $this->belongsTo(Client::class);
    }


}
