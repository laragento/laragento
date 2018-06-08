<?php


Route::group(['prefix'=>'category', 'middleware' => 'storeId'], function (){
    Route::get('all', 'CatalogController@all');
    Route::get('{category_slug}', 'CatalogController@category');
});

Route::group(['middleware' => 'web', 'prefix' => 'catalog', 'namespace' => 'Laragento\Catalog\Http\Controllers'], function()
{
    Route::get('/', 'CatalogController@index');
});

Route::group(['middleware' => 'web', 'prefix' => 'product', 'namespace' => 'Laragento\Catalog\Http\Controllers'], function()
{
    Route::get('/{product_slug}', 'CatalogController@product');
});

Route::group(['middleware' => 'web', 'prefix' => 'v1/product', 'namespace' => 'Laragento\Catalog\Http\Api'], function()
{
    Route::get('/sku/{sku}/parents', 'ProductApi@parentsBySku');
    Route::get('/attribute-list/{attribute_set}', 'ProductApi@attributeList');
    Route::get('/{product_id}/attribute-list', 'ProductApi@attributeListWithValues');
    Route::get('/{product_id}/price', 'ProductApi@getRegularPrice');
    Route::get('/{product_id}/special-price', 'ProductApi@getSpecialPrice');
    Route::get('/{product_slug}', 'ProductApi@first');
});

Route::group(['middleware' => 'web', 'prefix' => 'v1/category', 'namespace' => 'Laragento\Catalog\Http\Api'], function()
{
    Route::get('/all', 'CategoryApi@all');
    Route::get('/allByLevel/{level}', 'CategoryApi@allByLevel');
    Route::get('/base/{website_id}', 'CategoryApi@getBaseCategories'); //TODO why we need this?
    Route::get('/{category_slug}', 'CategoryApi@first');
    Route::get('/{category_id}/parent', 'CategoryApi@parent');
    Route::get('/{category_id}/children', 'CategoryApi@children');
    Route::get('/{category_id}/products', 'CategoryApi@products');
});