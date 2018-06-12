<?php

namespace Laragento\Indexer\Providers;

use Illuminate\Support\Facades\Route;
use Illuminate\Support\ServiceProvider;
use Laragento\Indexer\Console\IndexerUpdateCategories;
use Laragento\Indexer\Console\IndexerUpdateProducts;

class IndexerServiceProvider extends ServiceProvider
{
    /**
     * Bootstrap the application services.
     *
     * @return void
     */
    public function boot()
    {
        $this->loadMigrationsFrom(__DIR__.'/../Database/Migrations');
    }

    /**
     * Register the application services.
     *
     * @return void
     */
    public function register()
    {
        $this->commands([
            IndexerUpdateProducts::class,
            IndexerUpdateCategories::class
        ]);
    }
}
