<?php

Route::get('/', function () {
    return view('welcome');
});

Route::post('/score', ['as'=>'score', 'uses' => 'ScoreController@score']);
Route::get('/test', ['as'=>'test', 'uses' => 'ScoreController@test']);

Route::group(['middleware' => 'web'], function () {
    Route::auth();

    Route::get('/home', 'HomeController@index');


});
