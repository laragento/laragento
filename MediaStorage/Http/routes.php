<?php

Route::group(['middleware' => 'web', 'prefix' => 'mediastorage', 'namespace' => 'Laragento\MediaStorage\Http\Controllers'], function()
{
    Route::get('/', 'MediaStorageController@index');
});
