<?php

namespace Laragento\Eav;

use Illuminate\Support\ServiceProvider;

class EavServiceProvider extends ServiceProvider
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
        $this->app->bind('Laragento\Eav\Repositories\AttributeRepositoryInterface',
            'Laragento\Eav\Repositories\AttributeRepository');
    }
}
