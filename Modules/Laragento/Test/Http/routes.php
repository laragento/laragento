<?php

Route::group(['middleware' => 'web', 'prefix' => 'test', 'namespace' => 'Laragento\Test\Http\Controllers'], function()
{
    Route::get('/', 'TestController@index');
});
