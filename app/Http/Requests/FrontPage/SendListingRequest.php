<?php

namespace App\Http\Requests\FrontPage;

use Illuminate\Foundation\Http\FormRequest;

class SendListingRequest extends FormRequest
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
            'company' => [
                'required',
                'string',
            ],
            'email' => [
                'required',
                'string',
                'email',
            ],
            'phone' => [
                'required',
                'string',
            ],
            'comment' => [
                'required',
                'string',
            ],
            'addresses' => [
                'required',
                'string',
            ],
        ];
    }
}
