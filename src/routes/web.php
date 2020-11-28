<?php

use Illuminate\Support\Facades\Route;

Route::group(['namespace' => 'artisan_cli\gui\Http\Controllers', 'middleware' => config('artisan_cli.middleware')], function () {
    Route::get(config('artisan_cli.route'), 'ArtisanCliController@index');
    Route::post('/artisan-cli-runner', 'ArtisanCliController@runCli');
});
