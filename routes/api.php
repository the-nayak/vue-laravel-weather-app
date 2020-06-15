<?php

use Zttp\Zttp;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Route;

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

Route::middleware('auth:api')->get('/user', function (Request $request) {
    return $request->user();
});

Route::get('/weather', function () {
    $apikey = config('services.weatherbit.key');
    $city_name = request('city_name');
    $country_code = request('country_code');
    $response = Zttp::get("https://api.weatherbit.io/v2.0/current?city=$city_name,$country_code&key=$apikey");

    return $response->json();
});