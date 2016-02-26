<?php

Route::group(['middleware' => ['web']], function () {
    Route::get('/', ['as' => 'home.index', 'uses' => 'HomeController@index']);
    Route::group(['middleware' => 'throttle:10'], function () { //10 in 60 seconds
        Route::post('/', ['as' => 'raffle.create', 'uses' => 'RaffleController@create']);
    });
    Route::get('/{hash}', ['as' => 'raffle.show', 'uses' => 'RaffleController@show']);
//    Route::get('/w/{hash}', ['as' => 'raffle.show.image', 'uses' => 'RaffleController@show_image']);
    Route::get('/{hash}/image', ['as' => 'raffle.image', 'uses' => 'RaffleController@widget']);
    Route::get('/user/{hash2}', ['as' => 'user.raffle.list', 'uses' => 'RaffleController@raffles_by_ip']);
});

Route::group(['prefix'=> 'admin','middleware' => ['web']], function () {
//    Route::auth();
    Route::get('/list', ['as' => 'raffle.admin.list', 'uses' => 'RaffleController@admin_list']);
});
