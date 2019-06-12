<?php

namespace Tests\Feature;

use Illuminate\Support\Str;
use Tests\CreatesApplication;
use Tests\TestCase;
use Illuminate\Foundation\Testing\RefreshDatabase;

class ExampleTest extends TestCase
{
    use RefreshDatabase;

    public function testItCanCreateAJPShippingRate()
    {
        $requestData = [
            'name' => 'JP Shipping Rate',
            'country_code' => 'JP',
            'from_value' => 0,
            'to_value'  => 50,
            'weight' => 20,
            'shipping_fee' => 70
        ];

        $response = $this->put('/api/v1/shipping-rates/' . Str::slug($requestData['name']), $requestData);
        $response->assertStatus(201);

        $this->assertDatabaseHas('shipping_rates', $requestData);
    }
}
