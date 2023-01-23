<?php

namespace App\Http\Requests\v1;

use Illuminate\Foundation\Http\FormRequest;
use Illuminate\Validation\Rule;

class RentalStoreRequest extends FormRequest
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
