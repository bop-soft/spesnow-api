<?php

namespace App\Http\Controllers\v1;

use App\Http\Controllers\v1\BaseController;
use App\Http\Resources\v1\UnlockResource;
use App\Models\Rental;
use App\Models\Unlock;
use Illuminate\Http\Request;

class UnlockController extends BaseController
{
   
    public function index()
    {
        $resource = UnlockResource::collection(Unlock::where('user_id', auth()->id())->get());

        return $this->sendResponse($resource, "Your unlocked rentals have been fetched");
    }

    public function store(Request $request)
    {
        $fields = $request->validate([
            'user_id' => 'required|numeric',
            'rental_id' => 'required|numeric',
        ]);

        $rental = Rental::find($fields['rental_id']);
        $unlocked = Unlock::where('user_id', $fields['rental_id'])->where('rental_id', $rental->id)->first();

        if($unlocked) {
            return $this->sendError('Rental already unlocked', 403);
        }

        $resource = new UnlockResource(Unlock::create($fields));

        return $this->sendResponse($resource, "Rental's contact unlocked");

    }

}
