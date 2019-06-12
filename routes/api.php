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
        Route::prefix('{name}')->where(['name' => '[A-Za-z\-_]+'])->group(function () {
            // SRP controllers Invoke was causing laravel to throw a hissy fit
            Route::put('/', 'CreateShippingRateController');
            Route::get('/', 'ShowShippingRateController');
        });
        Route::get('/', function () {
            return 'LIST';
        });
    });
});
//});
