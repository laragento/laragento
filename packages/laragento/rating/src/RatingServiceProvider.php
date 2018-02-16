<?php

namespace Laragento\Rating;

use Illuminate\Support\Facades\Route;
use Illuminate\Support\ServiceProvider;

class RatingServiceProvider extends ServiceProvider
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
        $this->app->bind('Laragento\Rating\Managers\RatingManagerInterface',
            'Laragento\Rating\Managers\RatingManager');


        $this->app->bind('Laragento\Rating\Repositories\RatingRepositoryInterface',
            'Laragento\Rating\Repositories\RatingRepository');
        $this->app->bind('Laragento\Rating\Repositories\RatingOptionRepositoryInterface',
            'Laragento\Rating\Repositories\RatingOptionRepository');

        $ratingApi = 'Laragento\Rating\Http\Api\RatingApi';

        $methods = [
            'get' => [
                'v1/rating/votes' => $ratingApi . '@get',   // all visible votes
                'v1/rating/votes/{entity_id}' => $ratingApi . '@getByEntityPkValue',    // all votes of an entity (e.g productId)
                'v1/rating/{rating_id}/options' => $ratingApi . '@options',
                'v1/rating/{rating_id}' => $ratingApi . '@first',
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
