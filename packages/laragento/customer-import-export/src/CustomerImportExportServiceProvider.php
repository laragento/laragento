<?php

namespace Laragento\CustomerImportExport;

use Illuminate\Support\Facades\Route;
use Illuminate\Support\ServiceProvider;

class CustomerImportExportServiceProvider extends ServiceProvider
{
    /**
     * Bootstrap the application services.
     *
     * @return void
     */
    public function boot()
    {
        //$this->loadViewsFrom(__DIR__.'/views/frontend', 'frontend_catalog');
    }

    /**
     * Register the application services.
     *
     * @return void
     */
    public function register()
    {
        $this->app->bind('Laragento\CustomerImportExport\Repositories\CustomerImportRepositoryInterface',
            'Laragento\CustomerImportExport\Repositories\CustomerImportRepository');
    }
}
