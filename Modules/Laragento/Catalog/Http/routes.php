<?php

Route::group(['middleware' => 'web', 'prefix' => 'checkout', 'namespace' => 'Laragento\Catalog\Http\Controllers'], function()
{
    Route::get('/', 'CatalogController@index');
});
