<?php

namespace Laragento\Catalog\Providers;

use Illuminate\Support\Facades\Route;
use Illuminate\Support\ServiceProvider;
use Laragento\Catalog\Repositories\Product\ProductRepository;

class CatalogServiceProvider extends ServiceProvider
{
    /**
     * Indicates if loading of the provider is deferred.
     *
     * @var bool
     */
    protected $defer = false;

    /**
     * Boot the application events.
     *
     * @return void
     */
    public function boot()
    {
        $this->registerTranslations();
        $this->registerConfig();
        $this->registerViews();
        $this->registerFactories();
        $this->loadMigrationsFrom(__DIR__ . '/../Database/Migrations');
        $this->loadRoutesFrom(__DIR__.'/../Http/routes.php');
        /*
        $this->publishes([
            __DIR__.'/views' => base_path('resources/views/laragento/catalog'),
        ]);*/
    }

    /**
     * Register the service provider.
     *
     * @return void
     */
    public function register()
    {
        $this->app->bind('Laragento\Catalog\Repositories\Product\ProductRepositoryInterface',
            'Laragento\Catalog\Repositories\Product\ProductRepository');
        $this->app->bind('Laragento\Catalog\Repositories\Product\ProductAttributeRepositoryInterface',
            'Laragento\Catalog\Repositories\Product\ProductAttributeRepository');
        $this->app->bind('Laragento\Catalog\Repositories\Category\CategoryRepositoryInterface',
            'Laragento\Catalog\Repositories\Category\CategoryRepository');
        $this->app->bind('Laragento\Catalog\Repositories\Category\CategoryProductRepositoryInterface',
            'Laragento\Catalog\Repositories\Category\CategoryProductRepository');
        $this->app->bind('Laragento\Catalog\Repositories\Category\CategoryAttributeRepositoryInterface',
            'Laragento\Catalog\Repositories\Category\CategoryAttributeRepository');
        $this->app->bind('Laragento\Catalog\Repositories\Catalog\CatalogAttributeRepositoryInterface',
            'Laragento\Catalog\Repositories\Catalog\CatalogAttributeRepository');
        $this->app->bind('Laragento\Catalog\Repositories\Media\ImageRepositoryInterface',
            'Laragento\Catalog\Repositories\Media\ImageRepository');
        $this->app->bind('Laragento\Catalog\Repositories\Pricing\PriceRepositoryInterface',
            'Laragento\Catalog\Repositories\Pricing\PriceRepository');
        $this->app->bind('Laragento\Eav\Repositories\AttributeRepositoryInterface',
            'Laragento\Eav\Repositories\AttributeRepository');
        $this->app->bind('Laragento\Store\Repositories\StoreRepositoryInterface',
            'Laragento\Store\Repositories\StoreRepository');

        $this->app->alias(ProductRepository::class, 'product'); // ????
        //$this->app->make($controller); // ????
    }

    /**
     * Register config.
     *
     * @return void
     */
    protected function registerConfig()
    {
        $this->publishes([
            __DIR__.'/../Config/config.php' => config_path('catalog.php'),
        ], 'config');
        $this->mergeConfigFrom(
            __DIR__.'/../Config/config.php', 'catalog'
        );
    }

    /**
     * Register views.
     *
     * @return void
     */
    public function registerViews()
    {
        //$this->loadViewsFrom(__DIR__ . '/../Resources/views/frontend', 'frontend_catalog');
        //$this->loadViewsFrom(__DIR__ . '/../Resources/views/frontend/addto', 'frontend_catalog_addto');

        $viewPath = resource_path('views/modules/catalog');

        $sourcePath = __DIR__.'/../Resources/views';

        $this->publishes([
            $sourcePath => $viewPath
        ],'views');

        $this->loadViewsFrom(array_merge(array_map(function ($path) {
            return $path . '/modules/catalog';
        }, \Config::get('view.paths')), [$sourcePath]), 'catalog');
    }


    /**
     * Register translations.
     *
     * @return void
     */
    public function registerTranslations()
    {
        $langPath = resource_path('lang/modules/catalog');

        if (is_dir($langPath)) {
            $this->loadTranslationsFrom($langPath, 'catalog');
        } else {
            $this->loadTranslationsFrom(__DIR__ . '/../Resources/lang', 'catalog');
        }
    }

    /**
     * Register an additional directory of factories.
     * @source https://github.com/sebastiaanluca/laravel-resource-flow/blob/develop/src/Modules/ModuleServiceProvider.php#L66
     */
    public function registerFactories()
    {
        if (! app()->environment('production')) {
            app(Factory::class)->load(__DIR__ . '/../Database/Factories');
        }
    }

    /**
     * Get the services provided by the provider.
     *
     * @return array
     */
    public function provides()
    {
        return [];
    }
}
