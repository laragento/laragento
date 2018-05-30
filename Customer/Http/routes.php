<?php

Route::group(['middleware' => 'web', 'prefix' => 'customer', 'namespace' => 'Laragento\Customer\Http\Controllers'],
    function () {
        Route::get('/', 'CustomerController@index');
    });

Route::group(['middleware' => 'web', 'prefix' => 'v1/customer', 'namespace' => 'Laragento\Customer\Http\Api'],
    function () {
        Route::get('/get', 'CustomerApi@get');
        Route::get('/all', 'CustomerApi@all');
        Route::get('/{customer_id}', 'CustomerApi@first');
        Route::get('/{customer_id}/addresses', 'CustomerApi@addresses');
        Route::get('/addresses/{address_id}', 'CustomerApi@address');
        Route::get('/{customer_id}/group', 'CustomerApi@group');
        Route::get('/{customer_id}/shipping', 'CustomerApi@defaultShipping');
        Route::get('/{customer_id}/billing', 'CustomerApi@defaultBilling');
        Route::post('/store', 'CustomerApi@store');
        Route::post('/address/store', 'CustomerApi@store');
        Route::delete('/{customer_id}', 'CustomerApi@destroy');
    });
