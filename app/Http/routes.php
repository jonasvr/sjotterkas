<?php

Route::get('/test', function(){
  $game = \App\Games::orderby('id','desc')->first();
  var_dump($game);
  var_dump($game->users());
});

 Route::get('/', ['as' => 'home',  'uses' => 'HomeController@index']);
Route::get('/rankings', ['as' => 'rankings', 'uses' => 'RankingController@index']);
// Route::get('/home', function(){
//   return view('home');
// });

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
