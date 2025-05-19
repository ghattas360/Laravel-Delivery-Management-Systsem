<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Factories\HasFactory;

class Review extends Model
{
    use HasFactory;

    protected $fillable = [
        'rating',
        'review',
        'deliveries_id', // Consider renaming to 'delivery_id' for consistency
        'clients_id',    // Consider renaming to 'client_id' for consistency
    ];

    /**
     * Relationship to the Client model
     */
    public function client()
    {
        return $this->belongsTo(Client::class, 'clients_id');
    }

    /**
     * Relationship to the Delivery model
     */
    public function delivery()
    {
        return $this->belongsTo(Delivery::class, 'deliveries_id');
    }
}