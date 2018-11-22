<?php

Route::group(['middleware' => 'web', 'prefix' => 'customerimportexport', 'namespace' => 'Laragento\CustomerImportExport\Http\Controllers'], function()
{
    Route::get('/', 'CustomerImportExportController@index');
});
