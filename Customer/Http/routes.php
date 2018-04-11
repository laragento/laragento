<?php

Route::group(['middleware' => 'web', 'prefix' => 'checkout', 'namespace' => 'Laragento\Customer\Http\Controllers'], function()
{
    Route::get('/', 'CustomerController@index');
});
