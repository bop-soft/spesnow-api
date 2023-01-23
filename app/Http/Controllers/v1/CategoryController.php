<?php

namespace App\Http\Controllers\v1;

use App\Http\Controllers\v1\BaseController;
use App\Http\Requests\v1\CategoryStoreRequest;
use App\Http\Requests\v1\CategoryUpdateRequest;
use App\Http\Resources\v1\CategoryResource;
use App\Models\Category;
use Illuminate\Http\Request;

class CategoryController extends BaseController
{

    public function index()
    {
        $resource = CategoryResource::collection(Category::all());

        return $this->sendResponse($resource, 'All categories have been fetched');
    }

    public function store(CategoryStoreRequest $request)
    {
        $resource = new CategoryResource(Category::create($request->validated()));

        return $this->sendResponse($resource, 'Category has been created');
    }

    public function show(Category $category)
    {
        $resource = new CategoryResource($category);

        return $this->sendResponse($resource, 'Category has been fetched');
    }

    public function update(CategoryUpdateRequest $request, Category $category)
    {
        //
    }

    public function destroy(Category $category)
    {
        $admin = auth()->user()->tokenCan('admin');

        if (!$admin) {
            return $this->sendError('Unauthorized user', 401);
        }

        $resource = null;

        $category->delete();
        
        return $this->sendResponse($resource, 'Category has been deleted');
    }
}
