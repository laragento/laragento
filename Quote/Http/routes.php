<?php

Route::group(['middleware' => 'web', 'prefix' => 'quote', 'namespace' => 'Laragento\Quote\Http\Controllers'], function()
{
    Route::get('/', 'QuoteController@index');
    Route::post('/', 'QuoteController@store');
    Route::get('/{cartId}', 'QuoteController@show');
    Route::patch('/{cartId}', 'QuoteController@update');
    Route::delete('/{cartId}', 'QuoteController@destroy');
});

Route::group(['middleware' => 'web', 'prefix' => 'v1/quote', 'namespace' => 'Laragento\Quote\Http\Api'], function()
{
    Route::post('/', 'QuoteApi@store');
    Route::get('/', 'QuoteApi@first');
    Route::patch('/', 'QuoteApi@update');
    Route::delete('/', 'QuoteApi@destroy');
});
