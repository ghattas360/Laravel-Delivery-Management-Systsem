<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;

class Social_Media_Account extends Model
{
    public function getClientSocialMediaAccounts()
    {
        return $this->belongsTo(Client::class, 'clients_id', 'id');
    }

    public function getSocialMediaProvider(){
        return $this->belongsTo(Social_Media_Provider::class, 'social_media_provider_id', 'id');
    }
}
