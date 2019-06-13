<?php

namespace Tests\Feature;

use Illuminate\Support\Str;
use Tests\CreatesApplication;
use Tests\TestCase;
use Illuminate\Foundation\Testing\RefreshDatabase;

class ShippingRateTest extends TestCase
{
    use RefreshDatabase;

    public function testItCanCreateAJPShippingRate()
    {
        $requestData = collect($this->shippingRates())->firstWhere('country_code', '===', 'FR');

        $response = $this->put('/api/v1/shipping-rates/' . Str::slug($requestData['name']), $requestData);
        $response->assertStatus(201);

        $this->assertDatabaseHas('shipping_rates', $requestData);
    }

    public function testItCanCreateAFRShippingRate()
    {
        $requestData = collect($this->shippingRates())->firstWhere('country_code', '===', 'FR');

        $response = $this->put('/api/v1/shipping-rates/' . Str::slug($requestData['name']), $requestData);
        $response->assertStatus(201);

        $this->assertDatabaseHas('shipping_rates', $requestData);
    }

    public function testItCanCreateAUKShippingRate()
    {
        $requestData = collect($this->shippingRates())->firstWhere('country_code', '===', 'UK');

        $response = $this->put('/api/v1/shipping-rates/' . Str::slug($requestData['name']), $requestData);
        $response->assertStatus(201);

        $this->assertDatabaseHas('shipping_rates', $requestData);
    }

    public function testItCanCreateAMXShippingRate()
    {
        $requestData = collect($this->shippingRates())->firstWhere('country_code', '===', 'MX');

        $response = $this->put('/api/v1/shipping-rates/' . Str::slug($requestData['name']), $requestData);
        $response->assertStatus(201);

        $this->assertDatabaseHas('shipping_rates', $requestData);
    }

    public function testItCanCreateAUSShippingRate()
    {
        $requestData = collect($this->shippingRates())->firstWhere('country_code', '===', 'US');

        $response = $this->put('/api/v1/shipping-rates/' . Str::slug($requestData['name']), $requestData);
        $response->assertStatus(201);

        $this->assertDatabaseHas('shipping_rates', $requestData);
    }

    public function testItReturnsAnErrorForADuplicateName()
    {
        $requestData = collect($this->shippingRates())->firstWhere('country_code', '===', 'US');

        $initialResponse = $this->put('/api/v1/shipping-rates/' . Str::slug($requestData['name']), $requestData);
        $secondResponse = $this->put('/api/v1/shipping-rates/' . Str::slug($requestData['name']), $requestData);

        $initialResponse->assertStatus(201);

        // Second response should say that the request is unprocessable due to the duplication (Names cannot be duplicates)
        $secondResponse->assertStatus(422);
        $secondResponse->assertExactJson(['errors' => ['name' => ['Shipping rate with that name already exists']]]);

        $this->assertDatabaseHas('shipping_rates', $requestData);
    }

    public function testAShippingRateCanBeFetchedAterCreation()
    {
        $requestData = collect($this->shippingRates())->firstWhere('country_code', '===', 'US');

        $this->put('/api/v1/shipping-rates/' . Str::slug($requestData['name']), $requestData);
        $response = $this->get('/api/v1/shipping-rates/' . Str::slug($requestData['name']), $requestData);

        $response->assertExactJson($requestData);
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
