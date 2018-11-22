<?php

Route::group(['middleware' => 'web', 'prefix' => 'salesrule', 'namespace' => 'Modules\SalesRule\Http\Controllers'], function()
{
    Route::get('/', 'SalesRuleController@index');
});
