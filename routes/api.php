<?php

use Illuminate\Http\Request;

/*
|--------------------------------------------------------------------------
| API Routes
|--------------------------------------------------------------------------
|
| Here is where you can register API routes for your application. These
| routes are loaded by the RouteServiceProvider within a group which
| is assigned the "api" middleware group. Enjoy building your API!
|
*/

//Route::middleware('auth:api')->group(function () {
Route::prefix('v1')->group(function () {

    Route::prefix('shipping-rates')->group(function () {
        Route::put('{rate_name}', 'CreateShippingRateController')->where(['rate_name' => '[A-Za-z\-_]+']);
        Route::get('{rate}', 'ShowShippingRateController');
        Route::delete('{rate}', 'ShowShippingRateController');
    });
    Route::post('calculate', 'CalculateShippingController');
});
//});
