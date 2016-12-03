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

Route::get('/user', function (Request $request) {
    return $request->user();
})->middleware('auth:api');

Route::get('/test',[
	'uses'=>'randomTests@speechClientTest'
]);

//Routes related to maintainence of items
Route::group(['prefix' => 'item'], function () {
    Route::post('/add',[
        'uses'=>'ItemController@handleItem'
    ]);

    Route::post('/delete',[
        'uses'=>'ItemController@removeItem'
    ]);

    Route::get('/fetch',[
        'uses'=>'ItemController@getItems'
    ]);

    Route::post('/complete',[
        'uses'=>'ItemController@completeItems'
    ]);
});

Route::group(['prefix' => 'system'],function () {
    Route::post('/get',[
        'uses'=>'SystemController@getItemByWeight'
    ]);
    Route::post('/weight',[
        'uses'=>'SystemController@handleWeight'
    ]);
    Route::post('/close',[
        'uses'=>'SystemController@completeItem'
    ]);
    Route::get('/contain',[
        'uses'=>'SystemController@transmitSignal'
    ]);
});




