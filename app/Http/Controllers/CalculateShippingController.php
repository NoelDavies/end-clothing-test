<?php

namespace App\Http\Controllers;

use App\Http\Requests\CalculateShippingRequest;
use App\Shipping\Exception\MissingShippingRuleException;
use App\Shipping\Order;
use App\Shipping\ShippingRateCalculator;
use App\ShippingRate;
use Illuminate\Http\JsonResponse;
use Illuminate\Http\Request;

class CalculateShippingController extends Controller
{
    public function __invoke(CalculateShippingRequest $request)
    {
        $countryCode        = $request->input('country_code');
        $price              = $request->input('price');
        $weight             = $request->input('weight');
        $shippingCalculator = new ShippingRateCalculator();

        try {
            $shippingFee = $shippingCalculator->calculate(Order::create($price, $weight, $countryCode));
        } catch (MissingShippingRuleException $exception) {
            return JsonResponse::create([
                'errors' => ['country_code' => [$exception->getMessage()]],
            ], 501);
        }

        return JsonResponse::create([
            'price'        => $price,
            'weight'       => $weight,
            'country_code' => $countryCode,
            'shipping_fee' => $shippingFee,
            'total'        => $shippingFee + $price,
        ], 200);
    }
}
