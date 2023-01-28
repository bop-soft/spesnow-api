<?php

namespace App\Http\Resources\v1;

use App\Models\Rental;
use App\Models\Unlock;
use Illuminate\Http\Resources\Json\JsonResource;

class RentalResource extends JsonResource
{
    /**
     * Transform the resource into an array.
     *
     * @param  \Illuminate\Http\Request  $request
     * @return array|\Illuminate\Contracts\Support\Arrayable|\JsonSerializable
     */
    public function toArray($request)
    {
        $route = $request->routeIs('rentals.show') || $request->routeIs('unlocks.*');
        return [
            'id' => $this->id,
            'title' => $this->title,
            'category' => $this->category,
            'bedrooms' => $this->bedrooms,
            'bathrooms' => $this->bathrooms,
            'kitchens' => $this->kitchens,
            'price' => number_format($this->price),
            'timeframe' => $this->timeframe,
            'promoted' => $this->promoted,
            'village' => $this->village,
            'parish' => $this->parish,
            'subcounty' => $this->subcounty,
            'county' => $this->county,
            'district' => $this->district,
            'country' => $this->country,
            'updatedAt' => $this->updated_at->diffForHumans(),
            'landlord' => $this->user->name,
            'landlordPhoto' => $this->user->profile_photo_url,
            'landlordTel' => $this->user->telephone,
            'rating' => count($this->ratings) != 0 ? number_format($this->ratings->sum('rating')/count($this->ratings),2) : "0.00",
            'images' => ImageResource::collection($this->images),
            $this->mergeWhen($route, function () {
                $logged = auth()->check();
                $unlocked = Unlock::where('user_id', auth()->id())->where('rental_id', $this->id)->exists();
                // $unlocked = Rental::find($this->id)->unlocks()->where('user_id',auth()->id())->exists();
                if ($logged && $unlocked) {
                    return [
                        'size' => $this->size,
                        'pets' => $this->pets,
                        'parties' => $this->parties,
                        'smoking' => $this->smoking,
                        'furnished' => $this->furnished,
                        'renovated' => $this->renovated,
                        'guard' => $this->guard,
                        'advert_maturity' => $this->advert_maturity,
                        'category' => new CategoryResource($this->whenLoaded('category')),
                        // 'landlord' => new UserResource($this->user->select('name','telephone','profile_photo_url')->find($this->user_id)),
                        'amenities' => AmenityResource::collection($this->amenities),
                        'ratings' => RatingResource::collection($this->ratings),
                    ];
                }
                return [
                    'size' => $this->size,
                    'pets' => $this->pets,
                    'parties' => $this->parties,
                    'smoking' => $this->smoking,
                    'furnished' => $this->furnished,
                    'renovated' => $this->renovated,
                    'guard' => $this->guard,
                    'advert_maturity' => $this->advert_maturity,
                    // 'category' => new CategoryResource($this->whenLoaded('category')),
                    // 'landlord' => new UserResource($this->user->select('name','profile_photo_url')->find($this->user_id)),
                    'amenities' => AmenityResource::collection($this->amenities),
                    'ratings' => RatingResource::collection($this->ratings),
                ];
            }),

        ];
    }
}
