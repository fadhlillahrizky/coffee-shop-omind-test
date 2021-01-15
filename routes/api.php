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
    Route::get('user' , 'AuthorizationController@getUserLogin')->middleware('jwt.verify');
    Route::post('login' , 'AuthorizationController@login');
    Route::post('register' , 'AuthorizationController@register');
    Route::get('user-list' , 'AuthorizationController@getUserLogin')->middleware('jwt.verify');
});

Route::group(['prefix' => 'product'] , function () {
    Route::get('' , 'ProductController@getProductList');
    Route::get('/{product_id}' , 'ProductController@getProduct');
    Route::post('add' , 'ProductController@addProduct')->middleware('jwt.verify');
    Route::post('edit/{product_id}' , 'ProductController@editProduct')->middleware('jwt.verify');
    Route::delete('/{product_id}' , 'ProductController@deleteProduct')->middleware('jwt.verify');
});

Route::group(['prefix' => 'order'] , function () {
    Route::get('' , 'OrderController@getOrderList');
    Route::get('/{order_id}' , 'OrderController@getOrder');
    Route::post('checkout' , 'OrderController@checkout');
    Route::delete('/{order_id}' , 'OrderController@deleteOrder')->middleware('jwt');
});
Route::get('storage/{filename}', function ($filename)
{
    $path = storage_path('public/' . $filename);

    if (!File::exists($path)) {
        abort(404);
    }

    $file = File::get($path);
    $type = File::mimeType($path);

    $response = Response::make($file, 200);
    $response->header("Content-Type", $type);

    return $response;
});
