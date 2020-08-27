<?php

namespace App\Http\Requests\Listing;

use Illuminate\Foundation\Http\FormRequest;

class CreateApartmentRequest extends FormRequest
{
    /**
    * @var Validator
    */

    public $validator = null;

    /**
     * Determine if the user is authorized to make this request.
     *
     * @return bool
     */
    public function authorize()
    {
        return true;
    }

    /**
     * Get the validation rules that apply to the request.
     *
     * @return array
     */
    public function rules()
    {
        return [
            'price' => [
                'numeric',
                'required',
            ],
            'bedrooms' => [
                'in:studio,studio/1,1,2,3,4,5+',
                'required',
            ],
            'bathrooms' => [
                'in:studio,studio/1,1,2,3,4,5+',
                'nullable'
            ],
            'street' => [
                'required',
            ],
            'date' => [
                'date'
            ],
            'features' => [
                'array'
            ],
            'latitude' => [
                'numeric',
                'nullable'
            ],
            'longitude' => [
                'numeric',
                'nullable'
            ],
            'photos.*' => [
                'mimes:jpeg,bmp,png'
            ],
            'neighborhood_id' => [
                'exists:neighborhoods,id',
                'nullable'
            ]
        ];
    }


}
