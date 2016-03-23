<?php

Route::get('/', ['as' => 'game',  'uses' => 'GameController@index']);
Route::get('/rankings', ['as' => 'rankings', 'uses' => 'RankingController@index']);
Route::get('/cam', function(){
  return view('visuals.cam');
});

Route::group(['prefix'=>'player'], function()
{
  Route::post('/addCard', ['as' => 'addCard',  'uses' => 'CardController@addCard']);
  Route::post('/addName', ['as' => 'addName',  'uses' => 'CardController@addName']);
});

Route::group(['prefix' => 'game'], function () {
  Route::get('/',         ['as' => 'game',   'uses' => 'GameController@index']);
  Route::post('/create',  ['as' =>'create',  'uses' => 'GameController@create']);
  Route::post('/update',  ['as' =>'update',  'uses' => 'GameController@update']);
  Route::post('/score',   ['as' =>'score',   'uses' => 'GameController@score']);
  Route::get('/test',     ['as' =>'test',    'uses' => 'GameController@test']);
});

Route::group(['middleware' => 'web'], function () {
    Route::auth();
});
