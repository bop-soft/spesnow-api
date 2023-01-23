<?php

namespace App\Http\Resources\v1;

use App\Http\Resources\RentalCollection;
use Illuminate\Http\Resources\Json\JsonResource;

class UserResource extends JsonResource
{
    /**
     * Transform the resource into an array.
     *
     * @param  \Illuminate\Http\Request  $request
     * @return array|\Illuminate\Contracts\Support\Arrayable|\JsonSerializable
     */
    public function toArray($request)
    {
        $route = $request->routeIs('users.*');
        return  [
            'contact' => [
                'name' => $this->name,
                'telephone' => $this->telephone,
                'photo' => $this->profile_photo_url,
            ],
            $this->mergeWhen($route, function () {
                return [
                    'details' => [
                        'email' => $this->email,
                        'emailedVerified' => $this->email_verified_at,
                    ],
                    'finance' => [
                        'wallet' => $this->wallet,
                        'subscribed' => $this->subscribed,
                        'subscription' => $this->subscription_id,
                        'sMaturity' => $this->subscription_maturity
                    ],
                    'verification' => [
                        'verified' => $this->verified,
                        'idFront' => $this->id_front,
                        'idBack' => $this->id_back
                    ],
                    'company' => [
                        'name' => $this->company,
                        'Position' => $this->title,
                        'contract' => $this->contract_url,
                    ],
                ];
            }),
        ];
    }
}
