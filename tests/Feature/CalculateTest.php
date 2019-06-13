<?php

namespace Tests\Feature;

use Illuminate\Support\Str;
use Tests\CreatesApplication;
use Tests\TestCase;
use Illuminate\Foundation\Testing\RefreshDatabase;

class CalculateTest extends TestCase
{
    use RefreshDatabase;

    public function testItCanCalculateJPRatesInsideBounds()
    {
        collect($this->shippingRates())->each(function ($rate) {
            $this->put('/api/v1/shipping-rates/' . Str::slug($rate['name']), $rate);
        });

        $requestData = [
            'price'        => 40,
            'weight'       => 50,
            'country_code' => 'JP',
        ];

        $expectedResponse = [
            'price'        => 40,
            'weight'       => 50,
            'country_code' => 'JP',
            'shipping_fee' => 70,
            'total'        => 110,
        ];

        $response = $this->post('/api/v1/calculate', $requestData);
        $response->assertExactJson($expectedResponse);
    }

    public function testItCanCalculateJPRatesOutsideOfBounds()
    {
        collect($this->shippingRates())->each(function ($rate) {
            $this->put('/api/v1/shipping-rates/' . Str::slug($rate['name']), $rate);
        });

        $requestData = [
            'price'        => 60,
            'weight'       => 50,
            'country_code' => 'JP',
        ];

        $expectedResponse = [
            'price'        => 60,
            'weight'       => 50,
            'country_code' => 'JP',
            'shipping_fee' => 0,
            'total'        => 60,
        ];

        $response = $this->post('/api/v1/calculate', $requestData);
        $response->assertExactJson($expectedResponse);
    }

    public function testItCanCalculateUKRatesWhenWeightExceedsAllowedWeight()
    {
        collect($this->shippingRates())->each(function ($rate) {
            $this->put('/api/v1/shipping-rates/' . Str::slug($rate['name']), $rate);
        });

        $requestData = [
            'price'        => 60,
            'weight'       => 50,
            'country_code' => 'UK',
        ];

        $expectedResponse = [
            'price'        => 60,
            'weight'       => 50,
            'country_code' => 'UK',
            'shipping_fee' => 56,
            'total'        => 116,
        ];

        $response = $this->post('/api/v1/calculate', $requestData);
        $response->assertExactJson($expectedResponse);
    }

    public function testItCanCalculateUKRatesWhenWeightFallswithinAllowedWeight()
    {
        collect($this->shippingRates())->each(function ($rate) {
            $this->put('/api/v1/shipping-rates/' . Str::slug($rate['name']), $rate);
        });

        $requestData = [
            'price'        => 60,
            'weight'       => 12,
            'country_code' => 'UK',
        ];

        $expectedResponse = [
            'price'        => 60,
            'weight'       => 12,
            'country_code' => 'UK',
            'shipping_fee' => 0,
            'total'        => 60,
        ];

        $response = $this->post('/api/v1/calculate', $requestData);
        $response->assertExactJson($expectedResponse);
    }

    public function testMXShippingRateWhereShippingIsAppliedDueToPrice()
    {
        collect($this->shippingRates())->each(function ($rate) {
            $this->put('/api/v1/shipping-rates/' . Str::slug($rate['name']), $rate);
        });

        $requestData = [
            'price'        => 60,
            'weight'       => 12,
            'country_code' => 'MX',
        ];

        $expectedResponse = [
            'price'        => 60,
            'weight'       => 12,
            'country_code' => 'MX',
            'shipping_fee' => 40,
            'total'        => 100,
        ];

        $response = $this->post('/api/v1/calculate', $requestData);
        $response->assertExactJson($expectedResponse);
    }

    public function testMXShippingRateWhereShippingIsAppliedDueToWeight()
    {
        collect($this->shippingRates())->each(function ($rate) {
            $this->put('/api/v1/shipping-rates/' . Str::slug($rate['name']), $rate);
        });

        $requestData = [
            'price'        => 100,
            'weight'       => 56,
            'country_code' => 'MX',
        ];

        $expectedResponse = [
            'price'        => 100,
            'weight'       => 56,
            'country_code' => 'MX',
            'shipping_fee' => 40,
            'total'        => 140,
        ];

        $response = $this->post('/api/v1/calculate', $requestData);
        $response->assertExactJson($expectedResponse);
    }

    public function testPLShippingRateWhereShippingRateDoesntExist()
    {
        collect($this->shippingRates())->each(function ($rate) {
            $this->put('/api/v1/shipping-rates/' . Str::slug($rate['name']), $rate);
        });

        $requestData = [
            'price'        => 100,
            'weight'       => 56,
            'country_code' => 'PL',
        ];

        $expectedResponse = [
            'errors' => [
                'country_code' => [
                    'Country Code has no valid rule to apply'
                ]
            ]
        ];

        $response = $this->post('/api/v1/calculate', $requestData);
        $response->assertExactJson($expectedResponse);
        $response->assertStatus(501);
    }

    public function shippingRates()
    {
        return [
            [
                'name'         => 'JP Shipping Rate',
                'country_code' => 'JP',
                'from_value'   => 0,
                'to_value'     => 50,
                'weight'       => 20,
                'shipping_fee' => 70,
            ],
            [
                'name'         => 'UK Shipping Rate',
                'country_code' => 'UK',
                'from_value'   => 0,
                'to_value'     => 60,
                'weight'       => 45,
                'shipping_fee' => 56,
            ],
            [
                'name'         => 'FR Shipping Rate',
                'country_code' => 'FR',
                'from_value'   => 0,
                'to_value'     => 50,
                'weight'       => 40,
                'shipping_fee' => 30,
            ],
            [
                'name'         => 'MX Shipping Rate',
                'country_code' => 'MX',
                'from_value'   => 0,
                'to_value'     => 70,
                'weight'       => 55,
                'shipping_fee' => 40,
            ],
            [
                'name'         => 'US Shipping Rate',
                'country_code' => 'US',
                'from_value'   => 0,
                'to_value'     => 100,
                'weight'       => 60,
                'shipping_fee' => 26,
            ],
        ];
    }
}
