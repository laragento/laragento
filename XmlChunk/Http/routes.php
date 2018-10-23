<?php

Route::group(['middleware' => 'web', 'prefix' => 'xmlchunk', 'namespace' => 'Laragento\XmlChunk\Http\Controllers'], function()
{
    Route::get('/', 'XmlChunkController@index');
});
