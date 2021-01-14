<?php

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

//Route::middleware('auth:api')->get('/user', function (Request $request) {
//    return $request->user();
//});

Route::group(['prefix' => 'auth'] , function () {
    Route::get('user' , 'AuthorizationController@getUserLogin')->middleware('jwt');
    Route::post('login' , 'AuthorizationController@login');
    Route::post('register' , 'AuthorizationController@register');
    Route::get('user-list' , 'AuthorizationController@getUserLogin')->middleware('jwt');
});

Route::group(['prefix' => 'product'] , function () {
    Route::get('' , 'AuthorizationController@getUserLogin');
    Route::get('/:product_id' , 'AuthorizationController@getUserLogin');
    Route::post('add' , 'AuthorizationController@login');
    Route::post('edit/:product_id' , 'AuthorizationController@register');
    Route::delete('/:product_id' , 'AuthorizationController@getUserLogin')->middleware('jwt');
});

Route::group(['prefix' => 'order'] , function () {
    Route::get('' , 'AuthorizationController@getUserLogin');
    Route::get('/:order_id' , 'AuthorizationController@getUserLogin');
    Route::post('checkout' , 'AuthorizationController@login');
    Route::delete('/:order_id' , 'AuthorizationController@getUserLogin')->middleware('jwt');
});
