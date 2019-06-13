<?php
declare(strict_types=1);


namespace App\Shipping;

use App\Shipping\Exception\MissingShippingRuleException;
use App\ShippingRate;

class ShippingRateCalculator
{
    /**
     * @param Order $order
     * @return int
     */
    public function calculate(Order $order): int
    {
        $shippingFee = 0;
        $rates = ShippingRate::where('country_code', $order->countryCode())->get();

        if ($rates->isEmpty()) {
            throw MissingShippingRuleException::countryCode();
        }

        // If Country code is JP
        // Apply shipping Fee only if price >  from val && price <= to val (ignore weight)
        if ($order->countryCode() === 'JP') {
            $rate = ShippingRate::where('country_code', 'JP')->first();

            if ($order->price() > $rate->from_value && $order->price() <= $rate->to_value) {
                $shippingFee = $rate->shipping_fee;
            }
        }

        // If country code is UK
        if ($order->countryCode() === 'UK') {
            $rate = ShippingRate::where('country_code', 'UK')->first();

            // Apply Shipping fee if provided weight < ShippingRate weight, price is ignored.
            if ($order->weight()> $rate->weight) {
                $shippingFee = $rate->shipping_fee;
            }
        }

        if (in_array($order->countryCode(), ['UK', 'JP']) === false && $rates->isNotEmpty()) {
            $rate = $rates->first(function (ShippingRate $rate) use ($order) {
                $priceCondition  = $order->price() > $rate->from_value && $order->price() <= $rate->to_value;
                $weightCondition = $order->weight() > $rate->weight;
                return $priceCondition === true || $weightCondition === true;
            });

            if ($rate) {
                $shippingFee = $rate->shipping_fee;
            }
        }

        return $shippingFee;
    }
}