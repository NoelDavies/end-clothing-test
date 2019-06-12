<?php

namespace App\Http\Controllers;

use App\Http\Requests\CreateShippingRateRequest;
use App\ShippingRate;
use Illuminate\Http\JsonResponse;
use Illuminate\Http\Request;

class CreateShippingRateController extends Controller
{
    public function __invoke(CreateShippingRateRequest $request)
    {
        if ($request->validated() === false) {
            return JsonResponse::create(['error' => $request->messages()], 400);
        }
//        $requestData = $request->only(['name', 'country_code', 'from_value', 'to_value', 'weight', 'shipping_fee']);
//        dd(array_values($request->all()));
        (new ShippingRate)->fill(array_values($request->all()))->save();

        return JsonResponse::create([], 201);
    }
}
