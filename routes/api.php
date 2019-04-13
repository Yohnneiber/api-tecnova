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


//users
Route::group(['prefix'=>'users'],function (){
    Route::post('login','UserController@login');
    Route::post('upload-image/{id}','UserController@upload');
    Route::get('download-image/{filename}','UserController@download');
    Route::get('image/{filename}','UserController@getImagen');
});
Route::resource('users','UserController');


//categories
Route::resource('product/categories','CategoryController');