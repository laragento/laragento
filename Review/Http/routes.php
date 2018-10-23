<?php

Route::group(['middleware' => 'web', 'prefix' => 'review', 'namespace' => 'Laragento\Review\Http\Controllers'], function()
{
    Route::get('/', 'ReviewController@index');
});
