<?php

namespace App\Http\Requests;

use Illuminate\Contracts\Validation\Validator;
use Illuminate\Foundation\Http\FormRequest;
use Illuminate\Http\Exceptions\HttpResponseException;

class CreateShippingRateRequest extends FormRequest
{
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
            'name' => 'required|string|unique:shipping_rates,name',
            'country_code' => 'required|string|size:2',
            'from_value' => 'required|integer',
            'to_value' => 'required|integer',
            'weight' => 'required|integer',
            'shipping_fee' => 'required|integer'
        ];
    }

    public function messages()
    {
        return [
            'name.unique' => 'Shipping rate with that name already exists'
        ];
    }

    protected function failedValidation(Validator $validator)
    {
        throw new HttpResponseException(response()->json(['errors' => $validator->errors()], 422));
    }
}
