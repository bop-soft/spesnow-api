<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class Village extends Model
{
    use HasFactory;

    public function parish(){
        return $this->belongsTo(Parish::class);
    }

    public function rentals() {
        return $this->hasMany(Rental::class,'village_id');
    }
}
