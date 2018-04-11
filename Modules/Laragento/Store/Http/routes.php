<?php

Route::group(['middleware' => 'web', 'prefix' => 'store', 'namespace' => 'Laragento\Store\Http\Controllers'], function()
{
    Route::get('/', 'StoreController@index');
});
