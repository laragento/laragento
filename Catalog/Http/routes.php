<?php

Route::group(['middleware' => 'web', 'prefix' => 'checkout', 'namespace' => 'Laragento\Catalog\Http\Controllers'], function()
{
    Route::get('/', 'CatalogController@index');
});

Route::group(['middleware' => 'web', 'prefix' => 'product', 'namespace' => 'Laragento\Catalog\Http\Controllers'], function()
{
    Route::get('/{product_slug}', 'CatalogController@product');
});


