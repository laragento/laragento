<?php

Route::group(['middleware' => 'web', 'prefix' => 'customer', 'namespace' => 'Laragento\Customer\Http\Controllers'], function()
{
    Route::get('/', 'CustomerController@index');
});
