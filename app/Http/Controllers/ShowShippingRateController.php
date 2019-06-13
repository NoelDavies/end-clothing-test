<?php

namespace App\Http\Controllers;

use App\ShippingRate;
use Illuminate\Http\JsonResponse;
use Illuminate\Http\Request;

class ShowShippingRateController extends Controller
{
    public function __invoke(ShippingRate $shippingRate)
    {
        return JsonResponse::create($shippingRate);
    }
}
