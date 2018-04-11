<?php

Route::group(['middleware' => 'web', 'prefix' => 'core', 'namespace' => 'Laragento\Core\Http\Controllers'], function()
{
    Route::get('/', 'CoreController@index');
});
