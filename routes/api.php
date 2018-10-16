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

Route::middleware('auth:api')->get('/user', function (Request $request) {
    return $request->user();
});

Route::post("/authenticate",function(Request $request){
    //var_dump($request);
    if((Auth::attempt(['email' => "test@mailcatch.co", 'password' => "admin123",'user_status' => 1]) ) ) // ? "true" : "false";
    {
        return json_encode($request->all()) ;
    }
});

Route::get("property-list/{scope}","GeneralInfoController@listProperty");



