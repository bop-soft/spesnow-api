<?php

namespace App\Http\Requests\v1;

use Illuminate\Foundation\Http\FormRequest;
use Symfony\Component\HttpFoundation\Request;

class CategoryUpdateRequest extends FormRequest
{
    /**
     * Determine if the user is authorized to make this request.
     *
     * @return bool
     */
    public function authorize()
    {
        $user = $this->user();
        return $user->tokenCan('admin');
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
                'name' => 'sometimes|required|unique:categories,name|max:255',
                'image_url' => 'sometimes|required|string',
                'desc' => 'sometimes|nullable'
            ];
        }

        return [
            'name' => 'required|unique:categories,name|max:255',
            'image_url' => 'required|string',
            'desc' => 'nullable'
        ];
    }
}
