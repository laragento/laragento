<?php

Route::group(['middleware' => 'web', 'prefix' => 'checkout', 'namespace' => 'Laragento\Checkout\Http\Controllers'], function()
{
    Route::get('/', 'CheckoutController@index');
});
