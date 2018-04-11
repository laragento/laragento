<?php

Route::group(['middleware' => 'web', 'prefix' => 'rating', 'namespace' => 'Laragento\Rating\Http\Controllers'], function()
{
    Route::get('/', 'RatingController@index');
});
