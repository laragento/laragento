<?php

Route::group(['middleware' => 'web', 'prefix' => 'quote', 'namespace' => 'Laragento\Quote\Http\Controllers'], function()
{
    Route::get('/', 'QuoteController@index')->name('quote.index');
    Route::post('/', 'QuoteController@store')->name('quote.store');
    Route::get('/{cartId?}', 'QuoteController@show')->name('quote.show');
    Route::patch('/{cartId?}', 'QuoteController@update')->name('quote.update');
    Route::delete('/{cartId?}', 'QuoteController@destroy')->name('quote.destroy');
});

Route::group(['middleware' => 'web', 'prefix' => 'v1/quote', 'namespace' => 'Laragento\Quote\Http\Api'], function()
{
    Route::post('/', 'QuoteApi@store');
    Route::get('/', 'QuoteApi@first');
    Route::patch('/', 'QuoteApi@update');
    Route::delete('/', 'QuoteApi@destroy');
});
