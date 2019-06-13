<?php

namespace App\Http\Controllers;

use App\Http\Requests\CreateShippingRateRequest;
use App\ShippingRate;
use Illuminate\Http\JsonResponse;
use Illuminate\Http\Request;

class CreateShippingRateController extends Controller
{
    public function __invoke(string $rateName, CreateShippingRateRequest $request)
    {
        if ($request->validated() === false) {
            return JsonResponse::create(['error' => $request->messages()], 400);
        }

        $requestData = $request->only(['name', 'country_code', 'from_value', 'to_value', 'weight', 'shipping_fee']);
        ShippingRate::create($requestData)->save();

        return JsonResponse::create([], 201);
    }
}
