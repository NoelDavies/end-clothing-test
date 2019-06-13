<?php

namespace App\Http\Controllers;

use App\Http\Requests\CreateShippingRateRequest;
use App\ShippingRate;
use Illuminate\Http\JsonResponse;
use Illuminate\Http\Request;

class DeleteShippingRateController extends Controller
{
    public function __invoke(ShippingRate $rate)
    {
        try {
            $rate->delete();
        } catch (\Exception $exception) {
            return JsonResponse::create([
                'errors' => [
                    'other' => sprintf('Rate could not be deleted due to %s', $exception->getMessage()),
                ],
            ], 401);
        }
        #
        return JsonResponse::create([], 200);
    }
}
