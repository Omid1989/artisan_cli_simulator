<?php

use Illuminate\Support\Facades\Route;

Route::group(['namespace'=>'artisan_cli\gui\Http\Controllers'],function ()
  {
    Route::get('/artisan_cli','ArtisanCliController@index');
    Route::post('/artisan-cli-runner','ArtisanCliController@runCli');
  });
