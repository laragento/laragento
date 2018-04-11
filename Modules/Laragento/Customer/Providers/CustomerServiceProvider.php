<?php

namespace Laragento\Customer;

use Illuminate\Support\Facades\Route;
use Illuminate\Support\ServiceProvider;

class CustomerServiceProvider extends ServiceProvider
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

        $this->app->bind('Laragento\Customer\Repositories\CustomerRepositoryInterface',
            'Laragento\Customer\Repositories\CustomerRepository');
        $this->app->bind('Laragento\Customer\Repositories\AddressRepositoryInterface',
            'Laragento\Customer\Repositories\AddressRepository');

        $customerApi = 'Laragento\Customer\Http\Api\CustomerApi';

        $this->app->make($customerApi);

        $methods = [
            'get' => [
                'v1/customer/get' => $customerApi . '@get',
                'v1/customer/all' => $customerApi . '@all',
                'v1/customer/{customer_id}' => $customerApi . '@first',
                'v1/customer/{customer_id}/addresses' => $customerApi . '@addresses',
                'v1/customer/addresses/{address_id}' => $customerApi . '@address',
                'v1/customer/{customer_id}/group/' => $customerApi . '@group',
                'v1/customer/{customer_id}/shipping/' => $customerApi . '@defaultShipping',
                'v1/customer/{customer_id}/billing/' => $customerApi . '@defaultBilling',
            ],
            'post' => [
                'v1/customer/store' => $customerApi . '@store',
                'v1/customer/address/store' => $customerApi . '@store',
            ],
            'delete' => [
                'v1/customers{customer_id}' => $customerApi . '@destroy',
            ]
        ];

        foreach ($methods as $method => $routes) {
            foreach ($routes AS $route => $controller) {
                Route::$method($route, $controller);
            }
        }
    }
}
