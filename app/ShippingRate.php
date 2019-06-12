<?php

namespace App;

use Illuminate\Database\Eloquent\Model;

class ShippingRate extends Model
{
    protected $fillable = ['name', 'country_code', 'from_value', 'to_value', 'weight', 'shipping_fee'];
    protected $attributes = ['name', 'country_code', 'from_value', 'to_value', 'weight', 'shipping_fee'];
}
