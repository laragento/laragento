<?php

Route::group(['middleware' => 'web', 'prefix' => 'quote', 'namespace' => 'Laragento\Quote\Http\Controllers'], function()
{
    Route::post('{storeId}/', 'QuoteController@store')->name('quote.store');
    Route::get('/{cartId?}', 'QuoteController@show')->name('quote.show');
    Route::patch('{storeId}/{cartId?}', 'QuoteController@update')->name('quote.update');
    Route::delete('/{cartId?}', 'QuoteController@destroy')->name('quote.destroy');

    Route::post('{storeId}/item', 'QuoteItemController@store')->name('quote.item.store');
    Route::patch('{storeId}/item/{itemId}', 'QuoteItemController@update')->name('quote.item.update');
    Route::delete('/item/{itemId}', 'QuoteItemController@destroy')->name('quote.item.destroy');
});

Route::group(['middleware' => 'web', 'prefix' => 'v1/quote', 'namespace' => 'Laragento\Quote\Http\Api'], function()
{
    Route::post('{storeId}/item', 'QuoteItemApi@store');
    Route::get('/item', 'QuoteItemApi@get');
    Route::get('/item/{itemId}', 'QuoteItemApi@find');
    Route::get('/item/product/{productId}', 'QuoteItemApi@byProduct');
    Route::get('/item/{itemId}/product', 'QuoteItemApi@productByItem');
    Route::patch('{storeId}/item/{itemId}', 'QuoteItemApi@update');
    Route::delete('/item/{itemId}', 'QuoteItemApi@destroy');

    Route::post('{storeId}/', 'QuoteApi@store');
    Route::get('/', 'QuoteApi@first');
    Route::patch('{storeId}/', 'QuoteApi@update');
    Route::delete('/', 'QuoteApi@destroy');


});
