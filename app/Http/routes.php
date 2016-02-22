<?php

Route::get('/', function () {
    return view('welcome');
});

Route::group(['middleware' => ['web']], function () {
    Route::get('/',['as'=>'home.index','uses'=>'HomeController@index']);
    Route::post('/',['as'=>'raffle.create','uses'=>'RaffleController@create']);
    // 1de9b7
    Route::get('/{hash}',['as'=>'raffle.show','uses'=>'RaffleController@show']);
});
