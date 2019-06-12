<?php

namespace App\Http\Requests;

use Illuminate\Foundation\Http\FormRequest;

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
            'name' => 'required|string',
            'country_code' => 'required|string|size:2',
            'from_value' => 'required|integer',
            'to_value' => 'required|integer',
            'weight' => 'required|integer',
            'shipping_fee' => 'required|integer'
        ];
    }
}
