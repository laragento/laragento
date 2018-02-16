<?php

namespace Laragento\Review;

use Illuminate\Support\Facades\Route;
use Illuminate\Support\ServiceProvider;

class ReviewServiceProvider extends ServiceProvider
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
        /* Managers */
        $this->app->bind('Laragento\Review\Managers\ReviewManagerInterface',
            'Laragento\Review\Managers\ReviewManager');

        /* Repositories */
        $this->app->bind('Laragento\Review\Repositories\ReviewRepositoryInterface',
            'Laragento\Review\Repositories\ReviewRepository');

        /* APIs */
        $reviewApi = 'Laragento\Review\Http\Api\ReviewApi';

        /* Routes */
        $methods = [
            'get' => [
                'v1/reviews/{entity_id}' => $reviewApi . '@getByEntity',
                'v1/reviews' => $reviewApi . '@get',
            ],
            'post' => [

            ],
            'delete' => [

            ]
        ];

        foreach ($methods as $method => $routes) {
            foreach ($routes AS $route => $controller) {
                Route::$method($route, $controller);
            }
        }
    }
}
