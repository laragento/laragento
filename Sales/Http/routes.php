<?php

Route::group(['middleware' => 'web', 'prefix' => 'sales', 'namespace' => 'Laragento\Sales\Http\Controllers'], function()
{
    Route::get('/', 'SalesController@index');
});
