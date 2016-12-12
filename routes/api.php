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
    Route::get('/reset',[
        'uses'=>'ItemController@resetItems'
    ]);
    Route::get('/check',[
        'uses'=>'ItemController@checkItem'
    ]);
});

Route::group(['prefix' => 'system'],function () {
    Route::post('/minus',[
        'uses'=>'SystemController@getItemByWeight'
    ]);
    Route::post('/plus',[
        'uses'=>'SystemController@handleWeight'
    ]);
    Route::get('/active',[
        'uses'=>'SystemController@getActive'
    ]);
    Route::get('/null',[
        'uses'=>'SystemController@setActiveToNull'
    ]);
    Route::get('/new',[
        'uses'=>'SystemController@addActive'
    ]);
    Route::get('/get',[
        'uses'=>'SystemController@showAllActive'
    ]);
    Route::get('/delete',[
        'uses'=>'SystemController@deleteActive'
    ]);

    //Related to zou's testing
    Route::get('/contain',[
        'uses'=>'SystemController@transmitSignal'
    ]);
    Route::post('/test',[
        'uses'=>'SystemController@checkPost'
    ]);
});

Route::group(['prefix' => 'door'],function () {
    Route::post('/change',[
        'uses'=>'doorController@handleDoorChange'
    ]);
    Route::get('/status',[
        'uses'=>'doorController@getDoorStatus'
    ]);
    Route::get('/add',[
        'uses'=>'doorController@addDoorEntry'
    ]);
    Route::get('/get',[
        'uses'=>'doorController@getDoorEntry'
    ]);
    Route::get('/reset',[
        'uses'=>'doorController@resetEntry'
    ]);
});




