<?php

namespace Laragento\Indexer;

use Illuminate\Support\Facades\Route;
use Illuminate\Support\ServiceProvider;
use Modules\BachmannkartenImport\Console\IndexerUpdateProducts;

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
            IndexerUpdateProducts::class
        ]);
    }
}
