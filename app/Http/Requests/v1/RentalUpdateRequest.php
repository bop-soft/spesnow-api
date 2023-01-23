<?php

namespace App\Http\Requests\v1;

use Illuminate\Foundation\Http\FormRequest;
use Illuminate\Validation\Rule;
use Symfony\Component\HttpFoundation\Request;

class RentalUpdateRequest extends FormRequest
{
    /**
     * Determine if the user is authorized to make this request.
     *
     * @return bool
     */
    public function authorize()
    {
        $user = $this->user();
        return $user->tokenCan('landlord');
    }

    /**
     * Get the validation rules that apply to the request.
     *
     * @return array<string, mixed>
     */
    public function rules()
    {
        if (Request::isMethod('patch')) {
            return [
                'title' => 'sometimes|required|string',
                'user_id' => 'sometimes|required|numeric',
                'category_id' => 'sometimes|required|numeric',
                'village_id' => 'sometimes|required|numeric',
                'price' => 'sometimes|required|numeric',
                'timeframe' => ['sometimes', 'required', Rule::in(['day','night','month'])],
                'size' => 'sometimes|nullable|numeric',
                'bedrooms' => 'sometimes|required|numeric',
                'bathrooms' => 'sometimes|required|numeric',
                'kitchens' => 'sometimes|required|numeric',
                'pets' => 'sometimes|boolean|nullable',
                'parties' => 'sometimes|boolean|nullable',
                'smoking' => 'sometimes|boolean|nullable',
                'furnished' => 'sometimes|boolean|nullable',
                'renovated' => 'sometimes|boolean|nullable',
                'guard' => 'sometimes|boolean|nullable',
                'status' => 'sometimes|boolean|nullable',
                'promoted' => 'sometimes|boolean|nullable',
                'advert_maturity' => 'sometimes|nullable|date'
            ];
        }

        return [
            'title' => 'required|string',
            'user_id' => 'required|numeric',
            'category_id' => 'required|numeric',
            'village_id' => 'required|numeric',
            'price' => 'required|numeric',
            'timeframe' => ['required', Rule::in(['day','night','month'])],
            'size' => 'nullable|numeric',
            'bedrooms' => 'required|numeric',
            'bathrooms' => 'required|numeric',
            'kitchens' => 'required|numeric',
            'pets' => 'boolean|nullable',
            'parties' => 'boolean|nullable',
            'smoking' => 'boolean|nullable',
            'furnished' => 'boolean|nullable',
            'renovated' => 'boolean|nullable',
            'guard' => 'boolean|nullable',
            'status' => 'boolean|nullable',
            'promoted' => 'boolean|nullable',
            'advert_maturity' => 'nullable|date'
        ];
    }
}
