<?php

namespace App\Http\Controllers\v1;

use App\Http\Controllers\v1\BaseController;
use App\Http\Requests\v1\AdvertStoreRequest;
use App\Http\Requests\v1\AdvertUpdateRequest;
use App\Http\Resources\v1\AdvertResource;
use App\Models\Advert;

class AdvertController extends BaseController
{
    public function index()
    {
        $landlord = auth()->user()->tokenCan('landlord');

        if (!$landlord) {
            return $this->sendError('Unauthorized user', 401);
        }

        $resource = AdvertResource::collection(Advert::all());

        return $this->sendResponse($resource, 'All advert packages have been fetched');
    }

    public function store(AdvertStoreRequest $request)
    {
        $resource = new AdvertResource(Advert::create($request->validated()));

        return $this->sendResponse($resource, 'Advert package has been created');
    }

    public function show(Advert $advert)
    {
        $landlord = auth()->user()->tokenCan('landlord');

        if (!$landlord) {
            return $this->sendError('Unauthorized user', 401);
        }

        $resource = new AdvertResource($advert);

        return $this->sendResponse($resource, 'Advert package has been fetched');
    }

    public function update(AdvertUpdateRequest $request, Advert $advert)
    {
        $advert->update($request->validated());

        $resource = new AdvertResource($advert);

        return $this->sendResponse($resource, 'Advert package has been updated');
    }

    public function destroy(Advert $advert)
    {
        $admin = auth()->user()->tokenCan('admin');

        if (!$admin) {
            return $this->sendError('Unauthorized user', 401);
        }

        $resource = null;

        $advert->delete();
        
        return $this->sendResponse($resource, 'Advert package has been deleted');
    }
}
