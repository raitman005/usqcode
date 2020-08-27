<?php

namespace App\Http\Requests\Listing;

use Illuminate\Foundation\Http\FormRequest;

class UpdateApartmentRequest extends FormRequest
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
            'id' => [
                'exists:apartments,id',
            ],
            'price' => [
                'numeric',
                'required',
            ],
            'bedrooms' => [
                'in:studio,1,2,3,4,5+',
                'required',
            ],
            'street' => [
                'required',
            ],
            'remarks' => [
                'max:1000',
            ],
            'date' => [
                'date'
            ],
            // 'landlord_id' => [
            //     'exists:landlords,id',
            //     'required'
            // ],
            'tag_ids' => [
                'array'
            ],
            'noFeeTag' => [
                'in:0,1'
            ],
            'exclusiveTag' => [
                'in:0,1'
            ],
        ];
    }


}
