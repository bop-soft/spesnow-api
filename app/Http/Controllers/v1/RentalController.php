<?php

namespace App\Http\Controllers\v1;

use App\Http\Controllers\v1\BaseController;
use App\Http\Requests\v1\RentalStoreRequest;
use App\Http\Requests\v1\RentalUpdateRequest;
use App\Http\Resources\v1\RentalResource;
use App\Models\Rental;
use Spatie\QueryBuilder\QueryBuilder;

class RentalController extends BaseController
{

    public function index()
    {
        // $rentals = Rental::search(request('search'))->get();

        $rentals = Rental::query()->when(request('search'), function ($query) {
            $query->where('title', 'LIKE', '%' . request('search') . '%')
            ->orWhere('category', 'LIKE', '%' . request('search') . '%')
            ->orWhere('village', 'LIKE', '%' . request('search') . '%')
            ->orWhere('parish', 'LIKE', '%' . request('search') . '%')
            ->orWhere('subcounty', 'LIKE', '%' . request('search') . '%')
            // ->orWhere('county', 'LIKE', '%' . request('search') . '%')
            ->orWhere('district', 'LIKE', '%' . request('search') . '%')
            ->orWhere('country', 'LIKE', '%' . request('search') . '%');
        })->with('user')->orderby('promoted','desc')->get();

        $resource = RentalResource::collection($rentals);

        return $this->sendResponse($resource, 'All rentals have been fetched');
    }

    public function categoryRentals($id) {

        $rentals = Rental::where('category_id', $id)->orderby('promoted','desc')->get();

        $resource = RentalResource::collection($rentals);

        return $this->sendResponse($resource, 'All rentals have been fetched');
    }

    public function latestRentals() {

        $rentals = Rental::latest('updated_at')->paginate(20);

        $resource = RentalResource::collection($rentals);

        return $this->sendResponse($resource, 'All rentals have been fetched');
    }

    public function store(RentalStoreRequest $request)
    {
        $resource = new RentalResource(Rental::create($request->validated()));

        return $this->sendResponse($resource, 'Rental has been created');
    }

    public function show($id)
    {
        $property = Rental::with('category')->find($id);

        $resource = new RentalResource($property);

        return $this->sendResponse($resource, 'Rental has been fetched');
    }

    public function update(RentalUpdateRequest $request, Rental $rental)
    {
        $rental->update($request->validated());

        $resource = new RentalResource($rental);

        return $this->sendResponse($resource, 'Rental has been updated');
    }

    public function destroy(Rental $rental)
    {
        $landlord = auth()->user()->tokenCan('landlord');

        if (!$landlord) {
            return $this->sendError('Unauthorized user', 401);
        }

        $resource = null;

        $rental->delete();

        return $this->sendResponse($resource, 'Rental has been deleted');
    }

    public function query()
    {
        // http://127.0.0.1:8000/api/v1/query?filter[district]=kampala&filter[category]=muzigo

        // http://127.0.0.1:8000/api/v1/query?sort=+price&filter[district]=busia

        $rentals = QueryBuilder::for(Rental::class)
            ->allowedFilters(['category','village','parish','subcounty','municipality','district','country'])
            ->allowedSorts('price')
            ->paginate();

        $resource = RentalResource::collection($rentals);

        return $this->sendResponse($resource, 'All rentals have been fetched');
    }
}
