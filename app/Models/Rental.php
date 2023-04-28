<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;
use Laravel\Scout\Searchable;

class Rental extends Model
{
    use HasFactory, Searchable;

    protected $fillable = [
        'title',
        'user_id',
        'category_id',
        'village_id',
        'price',
        'timeframe',
        'size',
        'bedrooms',
        'bathrooms',
        'kitchens',
        'pets',
        'parties',
        'smoking',
        'furnished',
        'renovated',
        'guard',
        'vacant',
        'promoted',
        'advert_maturity',
        'category',
        'village',
        'parish',
        'subcounty',
        'county',
        'district',
        'uganda',
    ];

    public function user()
    {
        return $this->belongsTo(User::class);
    }

    public function category()
    {
        return $this->belongsTo(Category::class);
    }

    public function village()
    {
        return $this->belongsTo(Village::class, 'village_id');
    }

    public function images()
    {
        return $this->hasMany(Image::class);
    }

    public function amenities()
    {
        return $this->hasMany(Amenity::class);
    }

    public function ratings()
    {
        return $this->hasMany(Rating::class);
    }

    public function favorites()
    {
        return $this->belongsToMany(User::class, 'favorites', 'rental_id', 'user_id');
    }

    public function unlocks()
    {
        return $this->hasMany(Unlock::class);
    }

    /**
     * Get the indexable data array for the model.
     *
     * @return array
     */
    // public function toSearchableArray()
    // {
    //     return [
    //         'title' => $this->title,
    //         'category' => $this->category,
    //         'village' => $this->village,
    //         'parish' => $this->parish,
    //         'subcounty' => $this->subcounty,
    //         'county' => $this->county,
    //         'district' => $this->district,
    //         'country' => $this->country,
    //     ];
    // }

    public function searchableAs()
    {
        return 'rentals';
    }
}
