<?php

namespace Laragento\Customer;

use Illuminate\Support\Facades\Route;
use Illuminate\Support\ServiceProvider;
use Laragento\Customer\Models\Customer;

class CustomerServiceProvider extends ServiceProvider
{
    /**
     * Bootstrap the application services.
     *
     * @return void
     */
    public function boot()
    {
        $this->loadMigrationsFrom(__DIR__.'/../Database/Migrations');
        $this->loadRoutesFrom(__DIR__.'/../Http/routes.php');
        //config(['auth.providers.users.model' => Customer::class ]);
    }

    /**
     * Register the application services.
     *
     * @return void
     */
    public function register()
    {

        $this->app->bind('Laragento\Customer\Repositories\CustomerRepositoryInterface',
            'Laragento\Customer\Repositories\CustomerRepository');
        $this->app->bind('Laragento\Customer\Repositories\AddressRepositoryInterface',
            'Laragento\Customer\Repositories\AddressRepository');


    }
}
