<?php

namespace App\Http\Controllers\v1;

use App\Http\Controllers\v1\BaseController;
use App\Http\Requests\v1\SubscriptionStoreRequest;
use App\Http\Requests\v1\SubscriptionUpdateRequest;
use App\Http\Resources\v1\SubscriptionResource;
use App\Models\Subscription;
use Illuminate\Http\Request;

class SubscriptionController extends BaseController
{
    
    public function index()
    {
        $resource = SubscriptionResource::collection(Subscription::all());

        return $this->sendResponse($resource, 'All subscription packages have been fetched');
    }
    
    public function store(SubscriptionStoreRequest $request)
    {
        $resource = new SubscriptionResource(Subscription::create($request->validated()));

        return $this->sendResponse($resource, 'Subscription package has been created');
    }
   
    public function show(Subscription $subscription)
    {
        $resource = new SubscriptionResource($subscription);

        return $this->sendResponse($resource, 'Subscription package has been fetched');
    }

    public function update(SubscriptionUpdateRequest $request, Subscription $subscription)
    {
        $subscription->update($request->validated());

        $resource = new SubscriptionResource($subscription);

        return $this->sendResponse($resource, 'Subscription package has been updated');
    }

    public function destroy(Subscription $subscription)
    {
        $admin = auth()->user()->tokenCan('admin');

        if (!$admin) {
            return $this->sendError('Unauthorized user', 401);
        }

        $resource = null;

        $subscription->delete();
        
        return $this->sendResponse($resource, 'Subscription package has been deleted');
    }
}
