<?php

Route::group(['middleware' => 'web', 'prefix' => 'importexport', 'namespace' => 'Laragento\ImportExport\Http\Controllers'], function()
{
    Route::get('/', 'ImportExportController@index');
});
