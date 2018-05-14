<?php

namespace Laragento\Catalog\Providers;

use Illuminate\Support\Facades\Route;
use Illuminate\Support\ServiceProvider;
use Laragento\Catalog\Repositories\Product\ProductRepository;

class CatalogServiceProvider extends ServiceProvider
{
    /**
     * Bootstrap the application services.
     *
     * @return void
     */
    public function boot()
    {

        $this->loadViewsFrom(__DIR__ . '/../Resources/views/frontend', 'frontend_catalog');
        $this->loadViewsFrom(__DIR__ . '/../Resources/views/frontend/addto', 'frontend_catalog_addto');
        $this->loadRoutesFrom(__DIR__.'/../Http/routes.php');
        /*
        $this->publishes([
            __DIR__.'/views' => base_path('resources/views/laragento/catalog'),
        ]);*/
    }

    /**
     * Register the application services.
     *
     * @return void
     */
    public function register()
    {
        $this->app->bind('Laragento\Catalog\Repositories\Product\ProductRepositoryInterface',
            'Laragento\Catalog\Repositories\Product\ProductRepository');
        $this->app->bind('Laragento\Catalog\Repositories\Category\CategoryRepositoryInterface',
            'Laragento\Catalog\Repositories\Category\CategoryRepository');
        $this->app->bind('Laragento\Catalog\Repositories\Category\CategoryProductRepositoryInterface',
            'Laragento\Catalog\Repositories\Category\CategoryProductRepository');
        $this->app->bind('Laragento\Catalog\Repositories\Catalog\CatalogAttributeRepositoryInterface',
            'Laragento\Catalog\Repositories\Catalog\CatalogAttributeRepository');

        $this->app->bind('Laragento\Catalog\Repositories\Product\ProductAttributeRepositoryInterface',
            'Laragento\Catalog\Repositories\Product\ProductAttributeRepository');
        $this->app->bind('Laragento\Catalog\Repositories\Category\CategoryAttributeRepositoryInterface',
            'Laragento\Catalog\Repositories\Category\CategoryAttributeRepository');

        $this->app->bind('Laragento\Catalog\Repositories\Media\ImageRepositoryInterface',
            'Laragento\Catalog\Repositories\Media\ImageRepository');

        $this->app->bind('Laragento\Catalog\Repositories\Pricing\PriceRepositoryInterface',
            'Laragento\Catalog\Repositories\Pricing\PriceRepository');

        $this->app->bind('Laragento\Eav\Repositories\AttributeRepositoryInterface',
            'Laragento\Eav\Repositories\AttributeRepository');

        $this->app->bind('Laragento\Store\Repositories\StoreRepositoryInterface',
            'Laragento\Store\Repositories\StoreRepository');
        $this->app->alias(ProductRepository::class, 'product');
        //Evtl. Facade?
//        $controller = config(env('APP_CLIENT') .  '.extensions.catalog.overrides.Laragento\Timezones\TimezonesController');
//        if(!$controller) {
        $controller = 'Laragento\Catalog\Http\Controllers\CatalogController';
        $productApi = 'Laragento\Catalog\Http\Api\ProductApi';
        $priceApi = 'Laragento\Catalog\Http\Api\PriceApi';
        $categoryApi = 'Laragento\Catalog\Http\Api\CategoryApi';
//        }
        $this->app->make($controller);

        $methods = [
            'get' => [
                //ToDo can these routes be removed??
                /*'categories' => $controller . '@categories',
                'category/{category_id}' => $controller . '@category',
                'product/sku/{sku}' => $controller . '@productBySku',
                'product/{product_slug}' => $controller . '@product',*/

                'product/sku/{sku}/parents' => $productApi . '@parentsBySku',
                'product/attribute-list/{attribute_set}' => $productApi . '@attributeList',
                'product/{product_id}/attribute-list' => $productApi . '@attributeListWithValues',
                'product/{product_id}/price' => $priceApi . '@getRegularPrice',
                'product/{product_id}/special-price' => $priceApi . '@getSpecialPrice',
                'product/{product_slug}' => $productApi . '@first',

                'category/all' => $categoryApi . '@all',
                'category/allByLevel/{level}' => $categoryApi . '@allByLevel',
                'category/base/{website_id}' => $categoryApi . '@getBaseCategories', //TODO why we need this?
                'category/{category_slug}' => $categoryApi . '@first',
                'category/{category_id}/parent' => $categoryApi . '@parent',
                'category/{category_id}/children' => $categoryApi . '@children',
                'category/{category_id}/products' => $categoryApi . '@products',
            ],
            'post' => [

            ],
            'delete' => [

            ]
        ];

        Route::group(['prefix'=>'v1', 'middleware' => 'storeId'], function () use ($methods) {
            foreach ($methods as $method => $routes) {
                foreach ($routes AS $route => $controller) {
                    // Create default routes without StoreCode
                    Route::$method($route, $controller);
                }
            }
        });

        $methods = [
            'get' => [
                'category/all' => $controller . '@all',
                'category/{category_slug}' => $controller . '@category',
            ],
            'post' => [

            ],
            'delete' => [

            ]
        ];

        Route::group(['prefix'=>'', 'middleware' => 'storeId'], function () use ($methods) {
            foreach ($methods as $method => $routes) {
                foreach ($routes AS $route => $controller) {
                    // Create default routes without StoreCode
                    Route::$method($route, $controller);
                }
            }
        });

    }
}
