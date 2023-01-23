<?php

namespace App\Http\Controllers\v1;

use App\Http\Controllers\v1\BaseController;
use App\Http\Resources\v1\FavoriteResource;
use App\Http\Resources\v1\RentalResource;
use App\Models\Favorite;
use App\Models\Rental;
use App\Models\User;
use Illuminate\Http\Request;

class FavoriteController extends BaseController
{

    public function index()
    {
        $rentals = User::find(auth()->id())->favorites()->get();

        $resource = RentalResource::collection($rentals);

        return $this->sendResponse($resource, 'All your favorites have been fetched');
    }

    public function store(Request $request)
    {
        $fields = $request->validate([
            'rental_id' => 'required|numeric',
        ]);

        $user = auth()->user();

        $rental = Rental::find($fields['rental_id']);

        // $user->favorites()->attach($rental);

        // $user->favorites()->toggle($rental);

        // $user->favorites->contains($rental->id);

        // A save method does exist as well

        // $rentals = $user->favorites()->wherePivot('status', 'active')->get();

        $user->favorites()->syncWithoutDetaching([$rental->id]);

        $resource = new RentalResource($rental);

        return $this->sendResponse($resource, 'Rental added to favorites');
    }

    public function checkFavorite(Request $request)
    {
        $user = auth()->user();

        $rental = Rental::find($request->rental_id);

        if ($user->favorites->contains($rental->id)) {
            $resource = null;

            return $this->sendResponse($resource, 'User has favorited this rental');
        }

        return $this->sendError('Not favorited', 401);
    }

    public function destroy(Request $request)
    {
        $fields = $request->validate([
            'rental_id' => 'required|numeric',
        ]);

        $user = auth()->user();

        $rental = Rental::find($fields['rental_id']);

        $user->favorites()->detach($rental);

        // $user->favorites()->detach();

        $resource = null;

        return $this->sendResponse($resource, 'Favorite has been removed');
    }
}
