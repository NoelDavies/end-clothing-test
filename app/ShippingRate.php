<?php

namespace App;

use Illuminate\Database\Eloquent\Model;
use Illuminate\Support\Str;

class ShippingRate extends Model
{
    protected $fillable = ['slug', 'name', 'country_code', 'from_value', 'to_value', 'weight', 'shipping_fee'];

    protected $hidden = ['slug', 'created_at', 'updated_at'];

    protected $casts = [
        'from_value' => 'integer',
        'to_value' => 'integer',
        'weight' => 'integer',
        'shipping_fee' => 'integer',
    ];

    public function getRouteKeyName()
    {
        return 'slug';
    }

    public static function boot()
    {
        parent::boot();

        static::saving(function ($model) {
            $model->slug = Str::slug($model->name);
        });
    }

    /**
     * Retrieve the model for a bound value.
     *
     * @param  mixed  $value
     * @return \Illuminate\Database\Eloquent\Model|null
     */
    public function resolveRouteBinding($value)
    {
        return $this->where('slug', $value)->first() ?? abort(404, []);
    }
}
