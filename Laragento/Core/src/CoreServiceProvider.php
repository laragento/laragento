<?php

namespace Laragento\Core;

use Illuminate\Routing\Router;
use Illuminate\Support\ServiceProvider;
use Laragento\Core\Http\Middleware\ApiStoreIdMiddleware;

class CoreServiceProvider extends ServiceProvider
{
    /**
     * Bootstrap the application services.
     *
     * @return void
     */
    public function boot(Router $router)
    {
        $router->aliasMiddleware('storeId', ApiStoreIdMiddleware::class);
    }

    /**
     * Register the application services.
     *
     * @return void
     */
    public function register()
    {

    }
}
