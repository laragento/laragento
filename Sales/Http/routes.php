<?php

Route::group(['middleware' => 'web', 'prefix' => 'sales', 'namespace' => 'Modules\Sales\Http\Controllers'], function()
{
    Route::get('/', 'SalesController@index');
});
