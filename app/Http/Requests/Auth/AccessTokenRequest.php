<?php

namespace App\Http\Requests\Auth;

use Illuminate\Foundation\Http\FormRequest;
use Illuminate\Http\Response;

class AccessTokenRequest extends FormRequest
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
            'uid' => [
                'required',
                'string',
            ],
            'access_token' => [
                'required',
                'string',
            ],
        ];
    }



    /**
     * Override method to get the validator instead of redirecting it
     *
     * @return void
     */
    protected function failedValidation(\Illuminate\Contracts\Validation\Validator $validator)
    {
        abort(403);
    }
}
