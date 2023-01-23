<?php

namespace App\Http\Resources\v1;

use Illuminate\Http\Resources\Json\JsonResource;

class CategoryResource extends JsonResource
{
    /**
     * Transform the resource into an array.
     *
     * @param  \Illuminate\Http\Request  $request
     * @return array|\Illuminate\Contracts\Support\Arrayable|\JsonSerializable
     */
    public function toArray($request)
    {
        $index = $request->routeIs('categories.index');
        $show = $request->routeIs('rentals.show');
        return [
            'name' => $this->name,
            $this->mergeWhen(!$show, function () use ($index) {
                return [
                    'id' => $this->id,
                    'image' => $this->image_url,
                    $this->mergeWhen(!$index, function () {
                        return [
                            'desc' => $this->desc,
                            'rentals' => RentalResource::collection($this->rentals),
                        ];
                    }),
                ];
            }),

        ];
    }
}
