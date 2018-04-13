<?php

namespace Laragento\CatalogUrlRewrite\Providers;

use Illuminate\Support\ServiceProvider;

class CatalogUrlRewriteServiceProvider extends ServiceProvider
{
    protected $commands = [
        'Laragento\CatalogUrlRewrite\Commands\GenerateCategoryRedirects'
    ];

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
        $this->commands($this->commands);
    }
}
