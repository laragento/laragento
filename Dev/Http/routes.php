<?php

Route::group(['middleware' => 'web', 'prefix' => 'dev', 'namespace' => 'Laragento\Dev\Http\Controllers'], function()
{
    Route::get('/', 'DevController@index');
});
