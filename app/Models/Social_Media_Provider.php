<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Factories\HasFactory;

class Social_Media_Provider extends Model
{
    use HasFactory;

    public function getClientSocialMedia()
    {
        return $this->hasMany(Social_Media_Account::class);
    }
}
