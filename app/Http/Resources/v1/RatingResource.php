<?php

namespace App\Http\Resources\v1;

use Illuminate\Http\Resources\Json\JsonResource;

class RatingResource extends JsonResource
{
    /**
     * Transform the resource into an array.
     *
     * @param  \Illuminate\Http\Request  $request
     * @return array|\Illuminate\Contracts\Support\Arrayable|\JsonSerializable
     */
    public function toArray($request)
    {
        return [
            $this->mergeWhen($this->status == "active", function () {
                return [
                    'user' => new UserResource($this->user->select('name')->find($this->user_id)),
                    'title' => $this->title,
                    'desc' => $this->desc,
                    'stars' => $this->rating,
                ];
            }),
        ];
    }
}
