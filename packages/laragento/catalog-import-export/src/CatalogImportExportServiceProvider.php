<?php

namespace Laragento\CatalogImportExport;

use Illuminate\Support\Facades\Route;
use Illuminate\Support\ServiceProvider;

class CatalogImportExportServiceProvider extends ServiceProvider
{
    /**
     * Bootstrap the application services.
     *
     * @return void
     */
    public function boot()
    {

    }

    /**
     * Register the application services.
     *
     * @return void
     */
    public function register()
    {

        $this->app->bind('Laragento\CatalogImportExport\Repositories\ProductImportRepositoryInterface',
            'Laragento\CatalogImportExport\Repositories\ProductImportRepository');
    }
}
