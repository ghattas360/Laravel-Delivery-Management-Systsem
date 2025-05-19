<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Factories\HasFactory;

class Employee extends Model
{
    use HasFactory;

    public function getEmployeeAddress(){
        return $this->belongsTo(Address::class, 'address_id', 'id');
    }
}
