<?php

Route::get('/', function () {
    return view('welcome');
});

Route::group(['prefix' => 'game'], function () {
  Route::get('/',         ['as' => 'game',  'uses' => 'Gamecontroller@index']);
  Route::post('/create',  ['as'=>'create',  'uses' => 'GameController@create']);
  Route::post('/update',  ['as'=>'update',  'uses' => 'GameController@update']);
  Route::post('/score',   ['as'=>'score',   'uses' => 'GameController@score']);
  Route::get('/test',     ['as'=>'test',    'uses' => 'GameController@test']);
});

Route::group(['middleware' => 'web'], function () {
    Route::auth();
    Route::get('/home', 'HomeController@index');
});
