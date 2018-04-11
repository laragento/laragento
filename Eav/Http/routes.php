<?php

Route::group(['middleware' => 'web', 'prefix' => 'eav', 'namespace' => 'Laragento\Eav\Http\Controllers'], function()
{
    Route::get('/', 'EavController@index');
});
