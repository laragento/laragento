<?php

namespace Laragento;

use Illuminate\Support\Facades\Route;
use Illuminate\Support\ServiceProvider;
use Laragento\Catalog\Repositories\Product\ProductRepository;
use Laragento\CatalogImportExport\CatalogImportExportServiceProvider;
use Laragento\Checkout\Providers\CheckoutServiceProvider;
use Laragento\Catalog\Providers\CatalogServiceProvider;

class LaragentoServiceProvider extends ServiceProvider
{
    /**
     * Bootstrap the application services.
     *
     * @return void
     */
    public function boot()
    {
        //dd("die already");
    }

    /**
     * Register the application services.
     *
     * @return void
     */
    public function register()
    {
        $this->app->register(CatalogServiceProvider::class);
        $this->app->register(CheckoutServiceProvider::class);
        $this->app->register(CatalogImportExportServiceProvider::class);

    }
}
