<?php

use Illuminate\Http\Request;
use  App\Http\Controllers\FormController;
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
Route::get('index/{id}','FormController@index')->name('index');
Route::post('add','FormController@add')->name('add');
Route::put('update','FormController@update')->name('update');
Route::delete('delete/{id}','FormController@delete')->name('delete');
Route::post('validate','FormController@validation')->name('validation');
Route::fallback(function(){
    return response()->json([
        'status'    => false,
        'message'   => 'Page Not Found.',
    ], 404);
});
Route::any('{add}', function(){
    return response()->json([
        'status'    => false,
        'message'   => 'Page Not Found.',
    ], 404);
})->where('add', '.*');