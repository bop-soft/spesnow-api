<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class Category extends Model
{
    use HasFactory;

    protected $fillable = [
        'name',
        'image_url',
        'desc'
    ];

    public function rentals() {
        return $this->hasMany(Rental::class);
    }
}
