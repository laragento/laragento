<?php

Route::group(['middleware' => 'web', 'prefix' => 'directory', 'namespace' => 'Laragento\Directory\Http\Controllers'], function()
{
    Route::get('/', 'DirectoryController@index');
});
