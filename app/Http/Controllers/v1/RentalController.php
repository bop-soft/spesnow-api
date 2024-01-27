<?php

namespace App\Http\Controllers\v1;

use App\Http\Controllers\v1\BaseController;
use App\Http\Requests\v1\RentalStoreRequest;
use App\Http\Requests\v1\RentalUpdateRequest;
use App\Http\Resources\v1\RentalResource;
use App\Models\Rental;
use Spatie\QueryBuilder\QueryBuilder;
use Illuminate\Http\Request;
class RentalController extends BaseController
{
    public function index()
    {
        $rentals = Rental::all();

        // $rentals = Rental::search(request('search'))->get();

        if ($query = request('search')) {
            $rentals = Rental::search($query, function ($meilisearch, $query, $options) {
                if($category = request('category')){
                    $options['filter'] = 'category=' . $category;
                }
                if($minPrice = request('minPrice')){
                    $options['filter'] = 'price>=' . $minPrice;
                }
                if($maxPrice = request('maxPrice')){
                    $options['filter'] = 'price<=' . $maxPrice;
                }
                if($minPrice = request('minPrice') && $maxPrice = request('maxPrice')){
                    $options['filter'] = "price>=4000000 AND price<=9000000";
                }
                if ($sortPrice = request('sortPrice')) {
                    $options['sort'] = ["price:" . $sortPrice];
                }
                return $meilisearch->search($query, $options);
            })->get();
        }

        $rentals = Rental::query()->when(request('search'), function ($query) {
            $query->where('title', 'LIKE', '%' . request('search') . '%')
                ->orWhere('category', 'LIKE', '%' . request('search') . '%')
                ->orWhere('village', 'LIKE', '%' . request('search') . '%')
                ->orWhere('parish', 'LIKE', '%' . request('search') . '%')
                ->orWhere('subcounty', 'LIKE', '%' . request('search') . '%')
                ->orWhere('county', 'LIKE', '%' . request('search') . '%')
                ->orWhere('district', 'LIKE', '%' . request('search') . '%')
                ->orWhere('country', 'LIKE', '%' . request('search') . '%');
        })->with('user')->orderby('promoted', 'desc')->get();

        $resource = RentalResource::collection($rentals);

        return $this->sendResponse($resource, 'All rentals have been fetched');
    }

    public function nearestRentals()
    {
        $userLat = request('lat');
        $userLong = request('long');
        $distance = 50;

        /* Haversine formula is a mathematical formula used to calculate the distance between two points 
        on a sphere, such as the Earth.
        */
        $rentals = Rental::selectRaw("*, (6371 * acos(cos(radians(?)) 
                * cos(radians(latitude)) 
                * cos(radians(longitude) - radians(?)) 
                + sin(radians(?)) 
                * sin(radians(latitude)))) AS distance", [$userLat, $userLong, $userLat])
            ->having("distance", "<", $distance)
            ->orderBy("distance")
            ->take(20)
            ->get();

        $resource = RentalResource::collection($rentals);

        return $this->sendResponse($resource, 'All rentals within 50km have been fetched');
    }

    public function categoryRentals($id)
    {

        $rentals = Rental::where('category_id', $id)->orderby('promoted', 'desc')->get();

        $resource = RentalResource::collection($rentals);

        return $this->sendResponse($resource, 'All rentals have been fetched');
    }

    public function latestRentals()
    {

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
            ->allowedFilters(['category', 'village', 'parish', 'subcounty', 'county', 'district', 'country'])
            ->allowedSorts('price')
            ->paginate();

        $resource = RentalResource::collection($rentals);

        return $this->sendResponse($resource, 'All rentals have been fetched');
    }
}
